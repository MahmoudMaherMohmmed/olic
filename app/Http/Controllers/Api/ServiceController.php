<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\FreeService;
use App\Models\AdditionalService;
use App\Models\City;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = $this->formatServices(Service::orderBy('id', 'DESC')->get(), app()->getLocale());

        return response()->json(['services' => $services], 200);
    }

    public function freeServices(){
        $free_services = $this->formatServices(FreeService::orderBy('id', 'DESC')->get(), app()->getLocale());

        return response()->json(['free_services' => $free_services], 200);
    }

    public function additionalServices(){
        $additional_services = $this->formatServices(AdditionalService::orderBy('id', 'DESC')->get(), app()->getLocale(), true);

        return response()->json(['additional_services' => $additional_services], 200);
    }

    private function formatServices($services, $lang, $additional = false){
        $services_array = [];

        foreach($services as $service){
            $service_array = [
                'id' => $service->id,
                'name' => $service->getTranslation('name', $lang),
                'description' => $service->getTranslation('description', $lang),
                'image' => url($service->image),
            ];

            $additional==true ? $service_array = array_merge(array_slice($service_array, 0, 3), array('price' => $service->price), array_slice($service_array, 3)) : null;

            array_push($services_array, $service_array);
        }

        return $services_array;
    }

    public function checkLocation(Request $request){
        $client_address = $this->getLocation($request->lat, $request->lng);

        $service_cities = City::where('status', 1)->get(['lat', 'lng']);
        foreach($service_cities as $city){
            $city_address = $this->getLocation($city->lat, $city->lng);

            if(($client_address[0] == $city_address[0]) && ($client_address[1] == $city_address[1])){
                return response()->json(['messaage' => trans('api.service_location_available')], 200);
            }
        }

        return response()->json(['messaage' => trans('api.service_location_not_available')], 403);
    }

    private function getLocation($lat, $lng){
        $address = array();

        $geolocation = $lat.','.$lng;
        $response = \Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => $geolocation,
            'key' => 'AIzaSyA4lIndWVJTXYLEgRwBQ4g3BXmAEHQup44',
            'sensor'    =>  false
        ]);
        $json_decode = json_decode($response);
        if(isset($json_decode->results[0])) {
            foreach($json_decode->results[0]->address_components as $addressComponet) {
                $address[] = $addressComponet->long_name;
            }
        }

        return array_reverse($address);
    }
}