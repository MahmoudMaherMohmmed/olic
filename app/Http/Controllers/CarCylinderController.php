<?php

namespace App\Http\Controllers;

use App\Models\CarCylinder;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use Validator;

class CarCylinderController extends Controller
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
        $car_cylinders = CarCylinder::latest()->get();
        $languages = $this->languageRepository->all();
        return view('car_cylinder.index', compact('car_cylinders', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $car_cylinder = null;
        $languages = $this->languageRepository->all();

        return view('car_cylinder.form', compact('car_cylinder', 'languages'));
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
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $car_cylinder = new CarCylinder();
        $car_cylinder->fill($request->except('name', 'description'));

        foreach ($request->name as $key => $value) {
            $car_cylinder->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $car_cylinder->setTranslation('description', $key, $value) : null;
        }
        
        $car_cylinder->save();
        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/car_cylinder');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car_cylinder = CarCylinder::findOrFail($id);
        return view('car_cylinder.index', compact('car_cylinder'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car_cylinder = CarCylinder::findOrFail($id);
        $languages = $this->languageRepository->all();
        return view('car_cylinder.form', compact('car_cylinder', 'languages'));
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
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $car_cylinder = CarCylinder::findOrFail($id);

        $car_cylinder->fill($request->except('name', 'description'));

        foreach ($request->name as $key => $value) {
            $car_cylinder->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $car_cylinder->setTranslation('description', $key, $value) : null;
        }
        
        $car_cylinder->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/car_cylinder');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car_cylinder = CarCylinder::find($id);
        $car_cylinder->delete();

        return redirect()->back();
    }
}
