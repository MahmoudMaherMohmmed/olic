<?php

namespace App\Http\Controllers;

use App\Models\CarBrand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use Validator;

class CarModelController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->get_privilege();
        $this->languageRepository    = $languageRepository;
    }

    public function index()
    {
        $car_models = CarModel::latest()->get();
        $languages = $this->languageRepository->all();
        return view('car_model.index', compact('car_models', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $car_model = null;
        $car_brands = CarBrand::all();
        $languages = $this->languageRepository->all();

        return view('car_model.form', compact('car_model', 'car_brands', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required',
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $car_model = new CarModel();
        $car_model->fill($request->except('name', 'description'));

        foreach ($request->name as $key => $value) {
            $car_model->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $car_model->setTranslation('description', $key, $value) : null;
        }
        
        $car_model->save();
        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/car_model');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car_model = CarModel::findOrFail($id);
        return view('car_model.index', compact('car_model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car_model = CarModel::findOrFail($id);
        $car_brands = CarBrand::all();
        $languages = $this->languageRepository->all();
        return view('car_model.form', compact('car_model', 'car_brands', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required',
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $car_model = CarModel::findOrFail($id);

        $car_model->fill($request->except('name', 'description'));

        foreach ($request->name as $key => $value) {
            $car_model->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $car_model->setTranslation('description', $key, $value) : null;
        }
        
        $car_model->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/car_model');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car_model = CarModel::find($id);
        $car_model->delete();

        return redirect()->back();
    }
}
