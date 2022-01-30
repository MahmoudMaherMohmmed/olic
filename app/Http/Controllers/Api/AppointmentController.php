<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AppointmentController extends Controller
{
    public function dayAppointments(Request $request){
        $appointments = [];

        if(isset($request->date) && $request->date!=null){
            if( in_array($this->formatDate($request->date), $this->workDays()) ){
                $appointments = $this->workHours();
            }
        }

        return response()->json(['appointments' => $appointments], 200);
    }

    private function formatDate($date){
        return strtolower( Carbon::createFromFormat('Y M d', $date)->format('D') );
    }

    private function workDays(){
        $days = [];
        $center = Center::first();

        if(isset($center->working_days) && $center->working_days!=null){
            $days = explode(', ',$center->working_days);
        }

        return $days;
    }

    private function workHours(){
        $hours = [];
        $center = Center::first();

        if((isset($center->from) && $center->from!=null) && (isset($center->to) && $center->to!=null)){
            $tStart = strtotime( substr($center->from, 0, strpos($center->from, " ")) );
            $tEnd = strtotime( substr($center->to, 0, strpos($center->to, " ")) );
            $tNow = $tStart;

            while($tNow <= $tEnd){
                array_push($hours, [date('H:i A',$tNow)=>1, 'technician_id'=>1]);
                $tNow = strtotime('+60 minutes',$tNow);
            }
        }

        return $hours;
    }
}
