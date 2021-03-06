<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Massara;
use App\Models\Term;
use App\Models\Center;
use App\Models\Country;
use App\Models\Trip;
use App\Models\Slider;
use App\Models\Question;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Validator;
use Mail;
use App;

class AppController extends Controller
{
    public function olic(Request $request){
        $center = Center::first();
        $center_info = [];

        if(isset($center) && $center!=null){
            $center_info = [
                'description' => $center->getTranslation('description', app()->getLocale()),
                'email' => $center->email,
                'contact_email' => $center->contact_email,
                "phone_1" => $center->phone_1,
                "phone_2" => $center->phone_2,
                "facebook_link" => $center->facebook_link,
                "whatsapp_link" => $center->whatsapp_link,
                "instagram_link" => $center->instagram_link,
                "lat" => $center->lat,
                "lng" => $center->lng,
                "logo" => url($center->logo),
            ];
        }

        return response()->json(['center' => $center_info], 200);
    }

    public function TermsAndConditions(Request $request){
        $term = Term::first();
        $terms_and_conditions = [];

        if(isset($term) && $term!=null){
            $terms_and_conditions = [
                'description' => $term->getTranslation('description', app()->getLocale()),
            ];
        }

        return response()->json(['terms_and_conditions' => $terms_and_conditions], 200);
    }

    public function contactMail(Request $request){
        $Validated = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        $center = Center::first();
        if(isset($center) && $center!=null){
            $data = ['name'=>$request->name, 'subject'=>$request->subject, 'message_body'=>$request->message];
            $message = $request->message;
            Mail::send('mail', $data, function($message) use ($center, $request) {
                $message->to($center->contact_email, 'Safer')
                ->subject($request->subject)
                ->from('info@safer.com','Safer Contact Us');
             });
    
             return response()->json(['message' => trans('api.send_successfully')], 200);
        }else{
            return response()->json(['message' => trans('api.miss_configration')], 403);
        }
        
    }

    public function countries(Request $request)
    {
        $countries = Country::all();

        return response()->json(['countries' => $this->formatCountries($countries, $request->lang)], 200);
    }

    private function formatCountries($countries, $lang)
    {
        $countries_array = [];

        foreach($countries as $country){
            array_push($countries_array,[
                'id' => $country->id,
                'title' => isset($lang) && $lang!=null ? $country->getTranslation('title', $lang) : $country->title,
            ]);
        }

        return $countries_array;
    }

    public function search($key, Request $request){
        $trips = [];

        $countries = Country::join('translatables', 'translatables.record_id','=', 'countries.id')
                        ->join('tans_bodies', 'tans_bodies.translatable_id', '=', 'translatables.id')
                        ->where('translatables.table_name', 'countries')
                        ->where('tans_bodies.body', 'Like', '%'.$key.'%')
                        ->orWhere('countries.title', 'Like', '%'.$key.'%')
                        ->groupBy(['countries.id'])
                        ->latest()
                        ->get(['countries.id']);

        if(isset($countries) && $countries!=null && count($countries)>0){
            foreach($countries as $country){
                $trips = $this->formatTrips($country->trips, $request->lang);
            }
        }else{
            $trips = Trip::join('translatables', 'translatables.record_id','=', 'trips.id')
                        ->join('tans_bodies', 'tans_bodies.translatable_id', '=', 'translatables.id')
                        ->where('translatables.table_name', 'trips')
                        ->where('tans_bodies.body', 'Like', '%'.$key.'%')
                        ->orWhere('trips.name', 'Like', '%'.$key.'%')
                        ->groupBy(['trips.id'])
                        ->latest()
                        ->get(['trips.id']);

            if(isset($trips) && $trips!=null && count($trips)>0){
                foreach($trips as $trip_id){
                    $trips = $this->formatTrips(Trip::find($trip_id), $request->lang);
                }
            }
        }

        
        return response()->json(['trips' => $trips]);
    }

    private function formatTrips($trips, $lang)
    {
        $trips_array = [];
 
        foreach($trips as $trip){
            array_push($trips_array, [
                'trip_id' => $trip->id,
                'trip_title' => isset($lang) && $lang!=null ? $trip->getTranslation('name', $lang) : $trip->name,
                'trip_description' => isset($lang) && $lang!=null ? $trip->getTranslation('description', $lang) : $trip->description,
                'trip_price' => $trip->price,
                'trip_start_date' => $trip->from,
                'trip_end_date' => $trip->to,
                'trip_duration' => $this->getTripDuration($trip->from, $trip->to),
                'trip_persons_count' => $trip->persons_count,
                'trip_image' => url($trip->image),
                'trip_images' => $this->tripImages($trip),
            ]);
        }

        return $trips_array;
    }

    private function getTripDuration($start_date, $end_date)
    {
        return CarbonPeriod::create($start_date, $end_date)->count();
    }

    private function tripImages($trip){
        $trip_images_array = [];
        $trip_images = $trip->images;

        if(isset($trip_images) && count($trip_images)>0){
            foreach($trip_images as $image){
                array_push($trip_images_array, url($image->image));
            }
        }

        return $trip_images_array;
    }

    public function changeLanguage(Request $request){
        $Validated = Validator::make($request->all(), [
            'language' => 'required',
        ]);

        if($Validated->fails())
            return response()->json($Validated->messages(), 403);

        App::setLocale($request->language);

        return response()->json(['message' => 'language changed successfully.'], 200);
    }

    public function sliders(Request $request)
    {
        $sliders = $this->formateSliders(Slider::get(), $request->lang);

        return response()->json(['sliders' => $sliders]);
    }

    private function formateSliders($sliders, $lang){
        $sliders_array = [];

        foreach($sliders as $slider){
            array_push($sliders_array, [
                'id' => $slider->id,
                'title' => isset($lang) && $lang!=null ? $slider->getTranslation('title', $lang) : $slider->title,
                'image' => url($slider->image)
            ]);
        }

        return $sliders_array;
    }

    public function commonQuestions()
    {
        $common_questions = $this->formatCommonQuestions(Question::orderBy('id', 'DESC')->get(), app()->getLocale());

        return response()->json(['common_questions' => $common_questions], 200);
    }

    private function formatCommonQuestions($common_questions, $lang){
        $common_questions_array = [];

        foreach($common_questions as $question){
            array_push($common_questions_array, [
                'id' => $question->id,
                'question' => $question->getTranslation('question', $lang),
                'answer' => $question->getTranslation('answer', $lang),
            ]);
        }

        return $common_questions_array;
    }
    
}
