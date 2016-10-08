@extends('main')

@section('title', '| DELETE Comment')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>DELETE this comment?</h1>
            <p>
                <strong>Name:</strong> {{ $comment->name }}<br>
                <strong>Email:</strong> {{ $comment->email  }}<br>
                <p>{{ $comment->comment }}</p>
            </p>

            {{ Form::open(['route' => ['comments.destroy', $comment->id], 'method' => 'DELETE']) }}

            {{ Form::submit('DELETE Comment', ['class' => 'btn btn-block btn-danger btn-h1-spacing']) }}

            {{ Form::close() }}
        </div>
    </div>
@stop