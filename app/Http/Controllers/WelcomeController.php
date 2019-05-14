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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $questions = self::getQuestions(20);

        $user = Auth::user();
        $upvotes = self::getVotes($questions->getCollection(), $user, 'up');
        $downvotes = self::getVotes($questions->getCollection(), $user, 'down');

        return view('welcome')
            ->with(compact(['questions', 'user', 'upvotes', 'downvotes']));
    }

    private function getQuestions($pg, $questionText=null) {

        //->where('documents.document_id','LIKE','%'.$request->get('doc_id_search').'%')

        if (is_null($questionText)){
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
                ->select('questions.id', 'questions.body', DB::raw('count(distinct(answers.id)) as answer_count'), 
                DB::raw('count(distinct(upv.id)) - count(distinct(downv.id)) as vote_count'))
                ->groupBy('questions.id', 'questions.body')
                ->orderBy('vote_count', 'desc')
                ->orderBy('answer_count', 'desc')
                ->paginate($pg);
        }else{
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
                ->where('questions.body','LIKE','%'.$questionText.'%')
                ->select('questions.id', 'questions.body', DB::raw('count(distinct(answers.id)) as answer_count'), 
                DB::raw('count(distinct(upv.id)) - count(distinct(downv.id)) as vote_count'))
                ->groupBy('questions.id', 'questions.body')
                ->orderBy('vote_count', 'desc')
                ->orderBy('answer_count', 'desc')
                ->paginate($pg);
        }

        return $questions;

    }

    private function getVotes($questions, $user, $status) {

        $votes = null;
        if (Auth::check()) {
            $votes = DB::table('votes')
                ->where('user_id', '=', $user->id)
                ->whereIn('question_id', $questions->pluck('id'))
                ->where('status', '=', $status)
                ->pluck('question_id')
                ->toArray();
        }

        return $votes;

    }

    public function upvoteAjax(Request $request)
    {

        if ($request->ajax()) {
            $downvoted =  DB::table('votes')
                ->where('question_id', '=', $request->question_id)
                ->where('user_id', '=', $request->user_id)
                ->where('status', '=', 'down')
                ->first();

            if (!empty($downvoted)) {
                DB::table('votes')
                    ->where('question_id', '=', $request->question_id)
                    ->where('user_id', '=', $request->user_id)
                    ->where('status', '=', 'down')
                    ->delete();
                return response()->json($request);
            } else {
                DB::table('votes')
                    ->insert([
                        'question_id' => $request->question_id,
                        'user_id' => $request->user_id,
                        'status' => 'up'
                    ]);
                return response()->json($request);
            }
        }
    }

    public function downvoteAjax(Request $request)
    {

        if ($request->ajax()) {

            $upvoted =  DB::table('votes')
                ->where('question_id', '=', $request->question_id)
                ->where('user_id', '=', $request->user_id)
                ->where('status', '=', 'up')
                ->first();

            if (!empty($upvoted)) {

                DB::table('votes')
                    ->where('question_id', '=', $request->question_id)
                    ->where('user_id', '=', $request->user_id)
                    ->where('status', '=', 'up')
                    ->delete();

                return response()->json($request);
            } else {
                DB::table('votes')
                    ->insert([
                        'question_id' => $request->question_id,
                        'user_id' => $request->user_id,
                        'status' => 'down'
                    ]);

                return response()->json($request);
            }
        }
    }

    public function filterQuestion(Request $request) {
        
        
        $questions = self::getQuestions(20, $request->get('question_search'));

        $user = Auth::user();
        $upvotes = self::getVotes($questions->getCollection(), $user, 'up');
        $downvotes = self::getVotes($questions->getCollection(), $user, 'down');

        

        if(count($questions->getCollection()) > 0){
            return view('welcome')
            ->with(compact(['questions', 'user', 'upvotes', 'downvotes']));
        }else{           
            return $this->index();
        }

    }

}
