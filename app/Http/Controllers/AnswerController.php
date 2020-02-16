<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\Question;
use Auth;
class AnswerController extends Controller
{
    public function store(Question $question , Request $request){
           
        $question->answers()->create(['body'=>$request->body,'user_id'=>Auth::user()->id]);

        return back()->with('success','Answer created successfully');
    }

    public function edit(Question $question, Answer $answer)
    {
        //
        $this->authorize('update', $answer);

        return view('answers.edit', compact('question', 'answer'));
    }

    public function update(Request $request, Question $question, Answer $answer)
    {
        //
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required',
        ]));

        return redirect()->route('questions.show', $question->id)->with('success', 'Your answer has been updated');
    }

    public function destroy(Question $question, Answer $answer)
    {
        //
        $this->authorize('delete', $answer);

        $answer->delete();


        return back()->with('success', "Your answer has been removed");
    }

    public function accept( Answer $answer){
        $this->authorize('accept', $answer);

        $answer->question->acceptBestAnswer($answer);

        return back();

    }
}
