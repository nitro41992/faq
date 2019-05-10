<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = DB::table('questions')
            ->leftJoin('answers', 'questions.id', '=', 'answers.question_id')
            ->leftJoin('users', 'users.id', '=', 'questions.user_id')
            ->leftJoin('votes as upv', function ($join) {
                $join->on('questions.id', '=', 'upv.question_id')
                    ->where('upv.status', '=', 'up');
            })
            ->leftJoin('votes as downv', function ($join) {
                $join->on('downv.question_id', '=', 'questions.id')
                    ->where('downv.status', '=', 'down');
            })
            ->select('questions.id', 'questions.body', DB::raw('count(distinct(answers.id)) as answer_count'), DB::raw('count(distinct(upv.id)) - count(distinct(downv.id)) as vote_count'))
            ->groupBy('questions.id', 'questions.body')
            ->orderBy('vote_count', 'desc')
            ->orderBy('answer_count', 'desc')
            //->get();
            ->paginate(15);

        $user = Auth::user();

        $upvotes = DB::table('votes')
            ->where('user_id', '=', $user->id)
            ->whereIn('question_id', $questions->pluck('id'))
            ->where('status', '=', 'up')
            ->pluck('question_id')
            ->toArray();

        $downvotes = DB::table('votes')
        ->where('user_id', '=', $user->id)
        ->whereIn('question_id', $questions->pluck('id'))
        ->where('status', '=', 'down')
        ->pluck('question_id')
        ->toArray();

        $obj['questions'] = $questions;

        //dd($questions);
        return view('welcome')
            ->with(compact('obj', 'user', 'upvotes', 'downvotes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upvote(Request $request)
    {
        DB::table('votes')
            ->where('question_id', '=', $request->qid)
            ->where('user_id', '=', $request->uid)
            ->where('status', '=', 'down')
            ->delete();

        DB::table('votes')
            ->insert([
                'question_id' => $request->qid,
                'user_id' => $request->uid,
                'status' => 'up'
            ]);


        return redirect()->action('WelcomeController@index');
    }

    public function downvote(Request $request)
    {
        DB::table('votes')
            ->where('question_id', '=', $request->qid)
            ->where('user_id', '=', $request->uid)
            ->where('status', '=', 'up')
            ->delete();
        
        DB::table('votes')
        ->insert([
            'question_id' => $request->qid,
            'user_id' => $request->uid,
            'status' => 'down'
        ]);

        return redirect()->action('WelcomeController@index');
    }
}
