<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
use App\Models\CarModel;
use App\Models\ClientCar;
use App\Models\CarCylinder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function carsBrands()
    {
        $cars_brands = $this->formatBrands(CarBrand::orderBy('id', 'DESC')->get(), app()->getLocale());

        return response()->json(['cars_brands' => $cars_brands], 200);
    }

    private function formatBrands($cars_brands, $lang){
        $cars_brands_array = [];

        foreach($cars_brands as $brand){
            array_push($cars_brands_array, [
                'id' => $brand->id,
                'name' => $brand->getTranslation('name', $lang),
                'description' => $brand->getTranslation('description', $lang),
                'image' => url($brand->image),
            ]);
        }

        return $cars_brands_array;
    }

    public function carsModels($brand_id)
    {
        $cars_models = [];
        $car_brand = CarBrand::where('id', $brand_id)->first();

        if(isset($car_brand) && $car_brand!=null)
            $cars_models = $this->formatModels(CarModel::where('brand_id', $car_brand->id)->orderBy('id', 'DESC')->get(), app()->getLocale());

        return response()->json(['cars_models' => $cars_models], 200);
    }

    private function formatModels($cars_models, $lang){
        $cars_models_array = [];

        foreach($cars_models as $model){
            array_push($cars_models_array, [
                'id' => $model->id,
                'name' => $model->getTranslation('name', $lang),
                'description' => $model->getTranslation('description', $lang),
            ]);
        }

        return $cars_models_array;
    }

    public function carsCylinders()
    {
        $cars_cylinders = $this->formatCylinders(CarCylinder::orderBy('id', 'DESC')->get(), app()->getLocale());

        return response()->json(['cars_cylinders' => $cars_cylinders], 200);
    }

    private function formatCylinders($cars_cylinders, $lang){
        $cars_cylinders_array = [];

        foreach($cars_cylinders as $cylinder){
            array_push($cars_cylinders_array, [
                'id' => $cylinder->id,
                'name' => $cylinder->getTranslation('name', $lang),
                'description' => $cylinder->getTranslation('description', $lang),
            ]);
        }

        return $cars_cylinders_array;
    }

    public function clientCars(Request $request)
    {
        $client = $request->user();

        $client_cars = $this->formatClientCars(ClientCar::where('client_id', $client->id)->orderBy('id', 'DESC')->get(), app()->getLocale());

        return response()->json(['client_cars' => $client_cars], 200);
    }

    private function formatClientCars($client_cars, $lang){
        $client_cars_array = [];

        foreach($client_cars as $car){
            array_push($client_cars_array, [
                'id' => $car->id,
                'brand' => $car->model->brand->getTranslation('name', $lang),
                'model' => $car->model->getTranslation('name', $lang),
                'cylinder' => $car->cylinder->getTranslation('name', $lang),
                'manufacture_year' => $car->manufacture_year,
                'status' => $car->status,
            ]);
        }

        return $client_cars_array;
    }

    public function createClientCars(Request $request){
        $client = $request->user();

        $Validated = Validator::make($request->all(), [
            'model_id'      => 'required',
            'cylinder_id'     => 'required',
            'manufacture_year'     => 'required|numeric',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        ClientCar::create(array_merge($request->all(), ['client_id' => $client->id]));
        
        return response()->json(['messaage' => trans('api.add_new_car')], 200);
    }

    public function deleteClientCars(Request $request){
        $client = $request->user();

        $Validated = Validator::make($request->all(), [
            'id'      => 'required',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $client_car = ClientCar::where('id', $request->id)->first();
        if(isset($client_car) && $client_car!=null){
            $client_car->delete();

            return response()->json(['messaage' => trans('api.delete_car')], 200);
        }else{
            return response()->json(['messaage' => trans('api.not_found_car')], 403);
        }

    }
}