<?php

namespace App\Http\Controllers;

use App\Models\FreeService;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;
use Validator;

class FreeServiceController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'free_services';
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
        $free_services = FreeService::latest()->get();
        $languages = $this->languageRepository->all();
        return view('free_service.index', compact('free_services', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $free_service = null;
        $languages = $this->languageRepository->all();

        return view('free_service.form', compact('free_service', 'languages'));
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

        $free_service = new FreeService();
        $free_service->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            $free_service->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $free_service->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $free_service->setTranslation('description', $key, $value) : null;
        }
        
        $free_service->save();
        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/free_service');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $free_services = FreeService::findOrFail($id);
        return view('free_service.index', compact('free_services'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $free_service = FreeService::findOrFail($id);
        $languages = $this->languageRepository->all();
        return view('free_service.form', compact('free_service', 'languages'));
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

        $free_service = FreeService::findOrFail($id);

        $free_service->fill($request->except('name', 'description', 'ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            if ($free_service->image) {
                $this->delete_image_if_exists(base_path('/uploads/free_services/' . basename($free_service->image)));
            }

            $free_service->image = $this->handleFile($request['image']);
        }

        foreach ($request->name as $key => $value) {
            $free_service->setTranslation('name', $key, $value);
        }
    
        foreach ($request->description as $key => $value) {
            $value!=null ? $free_service->setTranslation('description', $key, $value) : null;
        }
        
        $free_service->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/free_service');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $free_service = FreeService::find($id);
        $free_service->delete();

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
