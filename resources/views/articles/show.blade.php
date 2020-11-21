@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{ route('articles.index') }}" class="btn btn-primary btn-sm">
            Back
        </a>
        <div>
            <h3>{{ $article->title }}</h3>
            <p>{{ $article->content }}</p>
        </div>
    </div>
@endsection