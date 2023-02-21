<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use App\Models\Question;
use Illuminate\Http\Request;

/*
{ Rules for method Change and Add 
    0 - text position input
    1 - radio input
    2 - checkBox input
}
*/

class AdminController extends Controller
{
    public function SurveyAll()
    {
        // try{
        //     $user = Auth::userOrFail();
        //     throw new Exception($user);
        // } catch (Exception $e){
        //     return response()->json(['error' => true, 'message' => $e->getMessage()],401);
        // }
        $data = Poll::with('question')->get();
        return response()->json($data, 200);
    }

    public function SurveyAdd(Request $request)
    {
        //dd($request->all());
        $survey = Poll::create([
            'name_polls' => $request->name_survey,
            'describe' => $request->descrbe,
            'date_start' => $request->created_at,
            'date_end' => $request->date_end,
        ]);
        
        $arr = [];

        // foreach((array)$request->data as $val){
        //     $arr[] = ["poll_id" => $survey->id, "question" => $val->question];
        // }

        foreach((array)$request->poll as $var)
        {
            foreach($var as $val)
            {
                $arr[] = ["question" => $val['question'], "poll_id" => $survey->id, "type_q" => $val['type_q']];
            }
        }

        //print_r($arr);

        Question::insert($arr);
        
        //return response()->json($survey, 201);
    }

    public function SurveyChange(Request $request, Poll $change)
    {
        $change->update([
            'name_polls' => $request->name_survey,
            'describe' => $request->descrbe,
            'date_start' => $request->created_at,
            'date_end' => $request->date_end
        ]);
        return response()->json($change, 200);
    }

    public function SurveyDelete($id)
    {
        //'date_start', '==', NULL],
        Question::where([['poll_id', $id]])->delete();
        Poll::find($id)->delete();
        return response()->json('', 204);
    }

    /*--------------------------------------------------------------------------------------------------------*/

    /*public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|exists:User,email',
            'password' => Hash::make($request->password)
        ]);

        $admin = User::find(1);

        if ($data && Auth::check($request->password, $admin->password)) {
            $token = $admin->createToken('Token Name')->accessToken;
            return $token;
        }

        return response()->json([], 404);

        //return redirect(route('login'))->withErrors(['email']);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:User,email',
            'password' => 'required'
        ]);

        $admin = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        if ($admin) {
            auth()->login($admin);
        }

        //return redirect(route('all'));
    }*/
    
    /*--------------------------------------------------------------------------------------------------------*/

    public function QuestionAdd(Request $request, $id)
    {
        $poll = Poll::find($id);

        $arr = [];

        // foreach($request->question as $var)
        // {
        //     dd($var);
        //     // $i = 0;
        //     // $arr = [$i => $var];
        //     // $i++;
        // }
        //$check = $admin->where('created_at','<>', NULL)->first()->get();
        if($poll->date_start != NULL)
        {
            return response()->json(['You can\'t change because of the field: date_start.', $poll], 401);
        }
        else
        {
            $data = Question::create([
                'poll_id' => $id,
                'question' => implode(", ", $request->question),
                'type_q' => $request->type_q
            ]);
            
            return response()->json([$data], 200);
        }

    }

    public function QuestionChange(Request $request, $id, $poll_id)
    {
        $poll = Poll::find($id);

        //dd(implode(", ", $request->question));

        //$check = $admin->where('created_at','<>', NULL)->first()->get();
        if($poll->date_start != NULL)
        {
            return response()->json(['You can\'t change because of the field: date_start.', $poll], 401);
        }
        else
        {
            $data = Question::where('id', $poll_id)->update([
                'question' => implode(", ", $request->question),
                'type_q' => $request->type_q
            ]);
            
            return response()->json([$data], 200);
        }

    }

    public function QuestionDelete($id, $q_id)
    {
        $poll = Poll::find($id);
        //$check = $admin->where('created_at','<>', NULL)->first()->get();
        if($poll->date_start != NULL)
        {
            return response()->json(['You can\'t change because of the field: date_start.', $poll], 401);
        }
        else
        {
            Question::where('id', $q_id)->delete();

            $poll->delete();
            
            return response()->json('delete', 200);
        }

    }
}
