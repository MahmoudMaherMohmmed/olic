<?php

namespace App\Http\Controllers;

use App\Models\OilBrand;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;
use Validator;

class OilBrandController extends Controller
{
     /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'oil_brands';
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
        $oil_brands = OilBrand::latest()->get();
        $languages = $this->languageRepository->all();
        return view('oil_brand.index', compact('oil_brands', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $oil_brand = null;
        $languages = $this->languageRepository->all();

        return view('oil_brand.form', compact('oil_brand', 'languages'));
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
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $oil_brand = new OilBrand();
        $oil_brand->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            $oil_brand->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $oil_brand->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $oil_brand->setTranslation('description', $key, $value) : null;
        }
        
        $oil_brand->save();
        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/oil_brand');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oil_brand = OilBrand::findOrFail($id);
        return view('oil_brand.index', compact('oil_brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $oil_brand = OilBrand::findOrFail($id);
        $languages = $this->languageRepository->all();
        return view('oil_brand.form', compact('oil_brand', 'languages'));
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
            'image' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $oil_brand = OilBrand::findOrFail($id);

        $oil_brand->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            if ($oil_brand->image) {
                $this->delete_image_if_exists(base_path('/uploads/oil_brands/' . basename($oil_brand->image)));
            }

            $oil_brand->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $oil_brand->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $oil_brand->setTranslation('description', $key, $value) : null;
        }
        
        $oil_brand->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/oil_brand');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oil_brand = OilBrand::find($id);
        $oil_brand->delete();

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
