<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;
use App\Http\Services\UploaderService;
use Illuminate\Http\UploadedFile;
use Validator;

class TechnicianController extends Controller
{
    /**
     * @var IMAGE_PATH
     */
    const IMAGE_PATH = 'technicians';

    /**
     * @var UploaderService
     */
    private $uploaderService;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct(UploaderService $uploaderService)
    {
        $this->get_privilege();
        $this->uploaderService = $uploaderService;
    }

    public function index()
    {
        $technicians = Technician::all();
        return view('technician.index', compact('technicians'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $technician = null;

        return view('technician.form', compact('technician'));
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
            'name'      => 'required|min:3',
            'email'     => 'required|email|unique:technicians',
            'password'  => 'required|confirmed|min:6',
            'phone'     => 'required|unique:technicians',
            'phone_2'     => 'required|unique:technicians',
            'image' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $technician = new Technician();
        $technician->fill($request->except('ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            $technician->image = $this->handleFile($request['image']);
        }
        
        $technician->save();

        \Session::flash('success', trans('messages.Added Successfully'));

        return redirect('/technician');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $technician = Technician::findOrFail($id);
        return view('technician.index', compact('technician'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $technician = Technician::findOrFail($id);
        return view('technician.form', compact('technician'));
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
            'name'      => 'required|min:3',
            'email'     => 'required|email',
            'phone'     => 'required',
            'phone_2'     => 'required',
            'image' => ''
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $technician = Technician::findOrFail($id);

        $technician->fill($request->except('ímage'));

        if ($request->image) {
            $imgExtensions = array("png", "jpeg", "jpg");
            $file = $request->image;
            if (!in_array($file->getClientOriginalExtension(), $imgExtensions)) {
                \Session::flash('failed', trans('messages.Image must be jpg, png, or jpeg only !! No updates takes place, try again with that extensions please..'));
                return back();
            }

            if ($technician->image) {
                $this->delete_image_if_exists(base_path('/uploads/technicians/' . basename($technician->image)));
            }

            $technician->image = $this->handleFile($request['image']);
        }

        $technician->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/technician');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $technician = Technician::find($id);
        $technician->delete();

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
