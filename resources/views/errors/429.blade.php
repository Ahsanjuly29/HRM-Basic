@extends('layouts.hrm')

@section('title', '429 Too Many Requests')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-1 text-info">429</h1>
        <h3 class="mb-3">Too Many Requests</h3>
        <p class="text-muted">Please wait before making another request.</p>

        <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Try Again</a>
    </div>
@endsection
