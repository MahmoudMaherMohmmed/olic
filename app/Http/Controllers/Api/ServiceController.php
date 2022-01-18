<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\FreeService;
use App\Models\AdditionalService;
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
}