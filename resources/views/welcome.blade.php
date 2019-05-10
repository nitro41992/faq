@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Votes</th>
                <th scope="col">Question</th>
                <th scope="col">Answer Count</th>
                <th scope="col">Actions</th>

            </tr>
        </thead>
        <tbody>
            @foreach($obj['questions'] as $question)
            <tr>
                <td>
                    <div class="row text-center">
                        <form class="col-md-12" id="upvote" method="POST" action=" {{ route('welcome.upvote', 
                        [
                            'qid' => $question->id,
                            'uid' => $user->id
                        ]
                        ) }}">
                            @csrf
                            <button class="fas fa-arrow-up" style="color:gray"></button>
                        </form>
                        <div
                            class="col-md-12 font-weight-bold {{$question->vote_count >= 0 ? 'text-success' : 'text-danger'}}">
                            {{$question->vote_count}}</div>
                        <form class="col-md-12" id="downvote" method="POST" action=" {{ route('welcome.downvote', 
                        [
                            'qid' => $question->id,
                            'uid' => $user->id
                        ]
                        ) }}">
                            @csrf
                            <button class="fas fa-arrow-down" style="color:gray"></button>
                        </form>
                    </div>
                </td>
                <td class="font-weight-bold">{{$question->body}}</td>
                <td class="text-center">{{$question->answer_count}}</td>
                <td> <a name="doc_select" href="{{ route('questions.show', ['id' => $question->id]) }}"
                        class="btn btn-primary btn-sm">Select</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <script type="text/javascript">
        $('upvote').submit(function( event ) {
            event.preventDefault();
            $.ajax({
                url: 'http://myserver.dev/myAjaxCallURI',
                type: 'post',
                data: $('form').serialize(), // Remember that you need to have your csrf token included
                dataType: 'json',
                success: function( _response ){
                    // Handle your response..
                },
                error: function( _response ){
                    // Handle error
                }
            });
        });
    </script>

</div>
@endsection