<?php

namespace App\Http\Controllers;

use App\Models\AdditionalService;
use App\Models\CarModel;
use App\Models\CarCylinder;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;
use Validator;

class AdditionalServiceController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'additional_services';
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
        $additional_services = AdditionalService::latest()->get();
        $languages = $this->languageRepository->all();
        return view('additional_service.index', compact('additional_services', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $additional_service = null;
        $languages = $this->languageRepository->all();
        $models = CarModel::all();
        $cylinders = CarCylinder::all();

        return view('additional_service.form', compact('additional_service', 'languages', 'models', 'cylinders'));
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
            'price' => 'required|numeric',
            'model_id' => 'required',
            'cylinder_id' => 'required',
            'manufacture_year' => 'required',
            'image' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $additional_service = new AdditionalService();
        $additional_service->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            $additional_service->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $additional_service->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $additional_service->setTranslation('description', $key, $value) : null;
        }
        
        $additional_service->save();
        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/additional_service');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $additional_service = AdditionalService::findOrFail($id);
        return view('additional_service.index', compact('additional_service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $additional_service = AdditionalService::findOrFail($id);
        $languages = $this->languageRepository->all();
        $models = CarModel::all();
        $cylinders = CarCylinder::all();
        return view('additional_service.form', compact('additional_service', 'languages', 'models', 'cylinders'));
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
            'price' => 'required|numeric',
            'model_id' => 'required',
            'cylinder_id' => 'required',
            'manufacture_year' => 'required',
            'image' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $additional_service = AdditionalService::findOrFail($id);

        $additional_service->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            if ($additional_service->image) {
                $this->delete_image_if_exists(base_path('/uploads/additional_service/' . basename($additional_service->image)));
            }

            $additional_service->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $additional_service->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $additional_service->setTranslation('description', $key, $value) : null;
        }
        
        $additional_service->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/additional_service');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $additional_service = AdditionalService::find($id);
        $additional_service->delete();

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
