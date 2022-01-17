<?php

namespace App\Http\Controllers;

use App\Models\Oil;
use App\Models\OilType;
use App\Models\OilBrand;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;
use Validator;

class OilController extends Controller
{
   /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'oils';
    /**
     * @var UploaderService
     */
    private $uploaderService;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(LanguageRepository $languageRepository, UploaderService $uploaderService)
    {
        $this->get_privilege();
        $this->languageRepository    = $languageRepository;
        $this->uploaderService = $uploaderService;
    }

    public function index()
    {
        $oils = Oil::latest()->get();
        $languages = $this->languageRepository->all();
        return view('oil.index', compact('oils', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $oil = null;
        $types = OilType::all();
        $brands = OilBrand::all();
        $languages = $this->languageRepository->all();

        return view('oil.form', compact('oil', 'types', 'brands', 'languages'));
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
            'type_id' => 'required',
            'name' => 'required|array',
            'name.*' => 'required|string',
            'serial_number' => 'required',
            'price' => 'required | numeric',
            'quantity' => 'required | numeric',
            'description' => 'array',
            'image' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $oil = new Oil();
        $oil->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            $oil->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $oil->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $oil->setTranslation('description', $key, $value) : null;
        }
        
        $oil->save();
        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/oil');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oil = Oil::findOrFail($id);
        return view('oil.index', compact('oil'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $oil = Oil::findOrFail($id);
        $types = OilType::all();
        $brands = OilBrand::all();
        $languages = $this->languageRepository->all();
        return view('oil.form', compact('oil', 'types', 'brands', 'languages'));
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
            'type_id' => 'required',
            'name' => 'required|array',
            'name.*' => 'required|string',
            'serial_number' => 'required',
            'price' => 'required | numeric',
            'quantity' => 'required | numeric',
            'description' => 'array',
            'image' => '',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $oil = Oil::findOrFail($id);

        $oil->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            if ($oil->image) {
                $this->delete_image_if_exists(base_path('/uploads/oils/' . basename($oil->image)));
            }

            $oil->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $oil->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $oil->setTranslation('description', $key, $value) : null;
        }
        
        $oil->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/oil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oil = Oil::find($id);
        $oil->delete();

        return redirect()->back();
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
