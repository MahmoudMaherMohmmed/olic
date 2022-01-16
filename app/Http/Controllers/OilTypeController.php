<?php

namespace App\Http\Controllers;

use App\Models\OilType;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use Validator;

class OilTypeController extends Controller
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
        $oil_types = OilType::latest()->get();
        $languages = $this->languageRepository->all();
        return view('oil_type.index', compact('oil_types', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $oil_type = null;
        $services = Service::all();
        $languages = $this->languageRepository->all();

        return view('oil_type.form', compact('oil_type', 'services', 'languages'));
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
            'service_id' => 'required',
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $oil_type = new OilType();
        $oil_type->fill($request->except('name', 'description'));

        foreach ($request->name as $key => $value) {
            $oil_type->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $oil_type->setTranslation('description', $key, $value) : null;
        }
        
        $oil_type->save();
        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/oil_type');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oil_type = OilType::findOrFail($id);
        return view('oil_type.index', compact('oil_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $oil_type = OilType::findOrFail($id);
        $services = Service::all();
        $languages = $this->languageRepository->all();
        return view('oil_type.form', compact('oil_type', 'services', 'languages'));
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
            'service_id' => 'required',
            'name' => 'required|array',
            'name.*' => 'required|string',
            'description' => 'array',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $oil_type = OilType::findOrFail($id);

        $oil_type->fill($request->except('name', 'description'));

        foreach ($request->name as $key => $value) {
            $oil_type->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $oil_type->setTranslation('description', $key, $value) : null;
        }
        
        $oil_type->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/oil_type');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oil_type = OilType::find($id);
        $oil_type->delete();

        return redirect()->back();
    }
}
