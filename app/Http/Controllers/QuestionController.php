<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Repository\LanguageRepository;
use Validator;

class QuestionController extends Controller
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
        $questions = Question::latest()->get();
        $languages = $this->languageRepository->all();
        return view('question.index', compact('questions', 'languages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = null;
        $languages = $this->languageRepository->all();

        return view('question.form', compact('question', 'languages'));
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
            'question' => 'required|array',
            'question.*' => 'required|string',
            'answer' => 'required|array',
            'answer.*' => 'required|string',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $question = new Question();
        $question->fill($request->except('question', 'answer'));

        foreach ($request->question as $key => $value) {
            $question->setTranslation('question', $key, $value);
        }
    
        foreach ($request->answer as $key => $value) {
            $question->setTranslation('answer', $key, $value);
        }
        
        $question->save();
        \Session::flash('success', trans('messages.Added Successfully'));
        return redirect('/question');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        return view('question.index', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        $languages = $this->languageRepository->all();
        return view('question.form', compact('question', 'languages'));
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
            'question' => 'required|array',
            'question.*' => 'required|string',
            'answer' => 'required|array',
            'answer.*' => 'required|string',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $question = Question::findOrFail($id);

        $question->fill($request->except('question', 'answer'));

        foreach ($request->question as $key => $value) {
            $question->setTranslation('question', $key, $value);
        }
    
        foreach ($request->answer as $key => $value) {
            $question->setTranslation('answer', $key, $value);
        }
        
        $question->save();

        \Session::flash('success', trans('messages.updated successfully'));
        return redirect('/question');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete();

        return redirect()->back();
    }
}
