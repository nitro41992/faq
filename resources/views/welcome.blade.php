@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Votes</th>
                {{-- <th scope="col">Question ID</th> --}}
                <th scope="col">Question</th>
                <th scope="col">Answers</th>
                <th scope="col">Actions</th>

            </tr>
        </thead>
        <tbody>
            @foreach($obj['questions'] as $question)
            <tr>
                <td>
                    <div class="row text-center">
                        @guest
                        <button class="col-md-12 btn btn-xs fas fa-arrow-up" style="color:gray" disabled></button>
                        <div class="col-md-12 font-weight-bold text-secondary">
                            {{$question->vote_count}}</div>
                        <button class="col-md-12 btn btn-xs fas fa-arrow-down" style="color:gray" disabled></button>
                        @else
                        <form class="col-md-12" id="upvote" method="POST" action="{{ route('welcome.upvote', 
                        [
                            'qid' => $question->id,
                            'uid' => $user->id
                        ]
                        ) }}">
                            @csrf
                            <button class="btn btn-xs fas fa-arrow-up" 
                            style="{{ in_array($question->id, $upvotes) ? 'color:gray' : 'color:orange' }}" 
                            {{ in_array($question->id, $upvotes) ? 'disabled' : null }}></button>
                        </form>
                        <div class="col-md-12 font-weight-bold text-secondary">
                            {{$question->vote_count}}</div>
                        <form class="col-md-12" id="downvote" method="POST" action="{{ route('welcome.downvote', 
                        [
                            'qid' => $question->id,
                            'uid' => $user->id
                        ]
                        ) }}">
                            @csrf
                            <button class="btn btn-xs fas fa-arrow-down" 
                            style="{{ in_array($question->id, $downvotes) ? 'color:gray' : 'color:orange' }}" 
                            {{ in_array($question->id, $downvotes) ? 'disabled' : null }}></button>
                        </form>
                        @endguest
                    </div>
                </td>
                {{-- <td class="font-weight-bold">{{$question->id}}</td> --}}
                <td class="font-weight-bold">{{$question->body}}</td>
                <td class="text-center">{{$question->answer_count}}</td>
                <td> <a name="doc_select" href="{{ route('questions.show', ['id' => $question->id]) }}"
                        class="btn btn-primary btn-sm">Select</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $obj['questions']->links() }}
</div>

@endsection