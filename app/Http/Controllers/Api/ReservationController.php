<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationItem;
use App\Models\Bank;
use App\Models\BankTransfer;
use App\Models\Oil;
use App\Models\FreeService;
use App\Models\AdditionalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;

class ReservationController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'bank_transfers';
    
    public function __construct(UploaderService $uploaderService)
    {
        $this->uploaderService = $uploaderService;
    }

    public function makeReservation(Request $request){
        $Validated = Validator::make($request->all(), [
            'technician_id' => 'required',
            'car_id' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'date' => 'required',
            'time' => 'required',
            'total_price' => 'required',
            'services' => 'required',
            'payment_type' => 'required',
            'image'      => 'max:65536'
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $reservation = new Reservation();
        $reservation->client_id = $request->user()->id;
        $reservation->fill($request->only('technician_id', 'car_id', 'lat', 'lng', 'total_price', 'age', 'payment_type'));
        $reservation->date = $this->formatDate($request->date);
        $reservation->from = $request->time;
        $reservation->to = date('H:i A', (strtotime($request->time) + 60*60) );
        if($reservation->save()){
            $this->saveServices($request->services, $reservation->id);

            if($reservation->payment_type == 1){
                $this->saveBankTransfer($request, $reservation->id);
            }

            return response()->json(['message' => trans('api.appointment_reserved')], 200);
        }else{
            return response()->json(['message' => trans('api.error_occurred')], 403);
        }  
    }

    private function formatDate($date){
        return Carbon::createFromFormat('Y M d', $date)->format('Y-m-d');
    }

    private function saveServices($services, $reservation_id){
        $services_array = explode(', ', $services);

        if(count($services_array) > 0){
            foreach($services_array as $service){
                $service_item = new ReservationItem();
                $service_item->reservation_id = $reservation_id;
                $service_item->service_id = explode('_', $service)[0];
                $service_item->type = explode('_', $service)[1];
                $service_item->save();
            }
        }

        return true;
    }

    private function saveBankTransfer($request, $reservation_id){
        $bank = Bank::where('id', $request->bank_id)->first();

        if(isset($bank) && $bank!=null){
            $bank_transfer = New BankTransfer();
            $bank_transfer->reservation_id = $reservation_id;
            $bank_transfer->bank_name = $bank->name;
            $bank_transfer->bank_account_name = $bank->account_name;
            $bank_transfer->bank_account_number = $bank->account_number;
            $bank_transfer->IBAN = $bank->IBAN;
            $bank_transfer->image = $this->handleFile($request['image']);
            $bank_transfer->save();
        }

        return true;
    }

    public function clientReservations(Request $request){
        $client_id = $request->user()->id;
        $reservations_array = [];

        $reservations = Reservation::where('client_id', $client_id)->get();
        if(isset($reservations) && $reservations!=null){
            foreach($reservations as $reservation){
                array_push($reservations_array, $this->formatReservation($reservation, app()->getLocale()));
            }
        }

        return response()->json(['reservations' => $reservations_array], 200);
    }

    public function show($id){
        $reservation_details = [];
        $reservation = Reservation::where('id', $id)->first();

        if(isset($reservation) && $reservation!=null){
            $reservation_details = $this->formatReservation($reservation, app()->getLocale());
        }

        return response()->json(['reservation' => $reservation_details], 200);
    }

    private function formatReservation($reservation, $lang){
        $reservation = [
            'order_id' => $reservation->id,
            'technician' => $reservation->technician->name,
            'date' => $reservation->date,
            'time' => $reservation->from,
            'total_price' => $reservation->total_price,
            'technician_phone' => $reservation->technician->phone,
            'coupon' => $reservation->coupon,
            'status' => $reservation->status,
            'car' => $this->reservationCar($reservation->car()->withTrashed()->first(), $lang),
            'services' => $this->reservationServices($reservation->items, $lang),
        ];

        return $reservation;
    }

    private function reservationCar($car, $lang){
        return [
            'id' => $car->id,
            'brand' => $car->model->brand->getTranslation('name', $lang),
            'model' => $car->model->getTranslation('name', $lang),
            'cylinder' => $car->cylinder->getTranslation('name', $lang),
            'manufacture_year' => $car->manufacture_year,
        ];
    }

    private function reservationServices($services, $lang){
        $services_array = [];

        foreach($services as $service){
            if($service->type == 'service'){
                $service = Oil::where('id', $service->service_id)->first();
                if(isset($service) && $service!=null){
                    array_push($services_array, [
                        'name' => $service->getTranslation('name', $lang),
                        'price' => $service->price,
                    ]);
                }
            }elseif($service->type == 'additional'){
                $service = AdditionalService::where('id', $service->service_id)->first();
                if(isset($service) && $service!=null){
                    array_push($services_array, [
                        'name' => $service->getTranslation('name', $lang),
                        'price' => $service->price,
                    ]);
                }
            }elseif($service->type == 'free'){
                $service = FreeService::where('id', $service->service_id)->first();
                if(isset($service) && $service!=null){
                    array_push($services_array, [
                        'name' => $service->getTranslation('name', $lang),
                        'price' => 0,
                    ]);
                }
            }
        }

        return $services_array;
    }

    /**
     * handle image file that return file path
     * @param File $file
     * @return string
     */
    public function handleFile(UploadedFile $file)
    {
        return $this->uploaderService->upload($file, self::IMAGE_PATH);
    }
}