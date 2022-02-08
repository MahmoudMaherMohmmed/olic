<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OilType;
use App\Models\Oil;
use Illuminate\Http\Request;

class OilController extends Controller
{
    public function oils($type_id)
    {
        $oils = [];
        $type = OilType::where('id', $type_id)->first();

        if(isset($type) && $type!=null){
            $oils = $this->formatOils(Oil::where('type_id', $type_id)->orderBy('id', 'DESC')->get(), app()->getLocale());
        }

        return response()->json(['oils' => $oils], 200);
    }

    private function formatOils($oils, $lang){
        $oils_array = [];

        foreach($oils as $oil){
            array_push($oils_array, [
                'id' => $oil->id,
                'brand' => $oil->brand->getTranslation('name', $lang),
                'name' => $oil->getTranslation('name', $lang),
                'serial_number' => $oil->serial_number,
                'price' => $oil->price,
                'quantity' => $oil->quantity,
                'description' => $oil->getTranslation('description', $lang),
                'image' => url($oil->image),
            ]);
        }

        return $oils_array;
    }

    public function oilTypes(){
        $oil_types = $this->formatOilTypes(OilType::orderBy('id', 'DESC')->get(), app()->getLocale());

        return response()->json(['oil_types' => $oil_types], 200);
    }

    private function formatOilTypes($oil_types, $lang){
        $oil_types_array = [];

        foreach($oil_types as $type){
            array_push($oil_types_array, [
                'id' => $type->id,
                'name' => $type->getTranslation('name', $lang),
                'description' => $type->getTranslation('description', $lang),
                'service_id' => $type->service->id,
                'service_price' => $type->service->price,
            ]);
        }

        return $oil_types_array;
    }
}