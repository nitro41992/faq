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
            @foreach($obj['questions'] as $question)
                <tr>
                    <td>{{$question->id}}</td>
                    <td>{{$question->body}}</td>
                    <td>{{$question->answer_count}}</td>
                    <td> <a name="doc_select" href="{{ route('questions.show', ['id' => $question->id]) }}" class="btn btn-primary btn-sm">Select</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection