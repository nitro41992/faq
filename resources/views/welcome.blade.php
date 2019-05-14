@extends('layouts.app')

@section('content')
<div id="question-list">
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

                            <form class="col-md-12" id="upvote">
                                <input class="form-control question_id" type="hidden" value="{{$question->id}}"
                                    id="question_id" data-id="{{$question->id}}">
                                <input class="form-control user_id" type="hidden" value="{{$user->id}}" id="user_id"
                                    data-id="{{$user->id}}">
                                <button class="btn btn-xs fas fa-arrow-up btn-upvote"
                                    style="{{ in_array($question->id, $upvotes) ? 'color:gray' : 'color:orange' }}"
                                    {{ in_array($question->id, $upvotes) ? 'disabled' : null }}></button>
                            </form>

                            <div class="col-md-12 font-weight-bold text-secondary">
                                {{$question->vote_count}}
                            </div>

                            <form class="col-md-12" id="downvote">
                                <input class="form-control question_id" type="hidden" value="{{$question->id}}"
                                    id="question_id" data-id="{{$question->id}}">
                                <input class="form-control user_id" type="hidden" value="{{$user->id}}" id="user_id"
                                    data-id="{{$user->id}}">
                                <button class="btn btn-xs fas fa-arrow-down btn-downvote"
                                    style="{{ in_array($question->id, $downvotes) ? 'color:gray' : 'color:orange' }}"
                                    {{ in_array($question->id, $downvotes) ? 'disabled' : null }}></button>
                            </form>

                            @endguest
                        </div>
                    </td>
                    <td class="font-weight-bold">{{$question->body}}</td>
                    <td class="font-weight-bold text-center text-secondary">{{$question->answer_count}}</td>
                    <td> <a name="doc_select" href="{{ route('questions.show', ['id' => $question->id]) }}"
                            class="btn btn-primary btn-sm">Select</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $obj['questions']->links() }}

        <script type="text/javascript">
            $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click','.btn-upvote',function (e) {
            e.preventDefault(); 
            var question_id = $(this).parent().find('.question_id').val();
            var user_id = $(this).parent().find('.user_id').val();
                $.ajax({
                    url: "{{ route('welcome.upvoteAjax') }}",
                    type: 'POST',
                    data: {question_id:question_id, user_id:user_id},
                    dataType: 'json',
                    success: function (data) {
                        $("#question-list").load(" #question-list");
                    }
                });
            });

            $(document).on('click','.btn-downvote',function (e) {
            e.preventDefault(); 
            var question_id = $(this).parent().find('.question_id').val();
            var user_id = $(this).parent().find('.user_id').val();
                $.ajax({
                    url: "{{ route('welcome.downvoteAjax') }}",
                    type: 'POST',
                    data: {question_id:question_id, user_id:user_id},
                    dataType: 'json',
                    success: function (data) {
                        $("#question-list").load(" #question-list");
                    }
                });
            });
        });
        </script>
    </div>
</div>

@endsection