<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Bank;
use App\Models\BankTransfer;
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
            'date' => 'required',
            'time' => 'required',
            'total_price' => 'required',
            'payment_type' => 'required',
            'image'      => 'max:65536'
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $reservation = new Reservation();
        $reservation->client_id = $request->user()->id;
        $reservation->fill($request->only('technician_id', 'total_price', 'age', 'payment_type'));
        $reservation->date = $this->formatDate($request->date);
        $reservation->from = $request->time;
        $reservation->to = date('H:i A', (strtotime($request->time) + 60*60) );
        if($reservation->save()){

            if($reservation->payment_type == 1){
                $this->saveBankTransfer($request, $reservation->id);
            }

            return response()->json(['message' => 'api.appointment_reserved'], 200);
        }else{
            return response()->json(['message' => 'error_occurred'], 200);
        }  
    }

    private function formatDate($date){
        return Carbon::createFromFormat('Y M d', $date)->format('Y-m-d');
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