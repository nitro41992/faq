@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Question ID</th>
                <th scope="col">Question</th>
                <th scope="col">Answer Count</th>
                <th scope="col">Actions</th>

            </tr>
            </thead>
            <tbody>
            @foreach($obj['answers'] as $answer)
                <tr>
                    <td>{{$answer->id}}</td>
                    <td>{{$answer->body}}</td>
                    <td>{{$answer->answer_count}}</td>
                    <td> <a name="doc_select" href="{{ route('answers.create', ['question_id'=> $answer->id])}}" class="btn btn-primary btn-sm">Answer</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection