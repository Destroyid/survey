<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use App\Models\Poll;               

class UserController extends Controller
{
    public function ListSurvey()
    {
        $data = Poll::get();
        return response()->json($data, 200);
    }

    public function Answer(Request $request, $id)
    {
        $answer = Answer::create([
            'user_id' => $request->user_id,
            'text_answer' => $request->text_answer,
            'position_answer' => $request->position_answer,
            'num_survey' => $id
        ]);
        return response()->json($answer, 200);
    }

    public function GetPassedSurvey($id)
    {
        $answers = Answer::where(['user_id' => $id])->get();
        return response()->json($answers, 200);
    }
}
