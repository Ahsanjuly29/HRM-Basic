@extends('layouts.hrm')

@section('title', '500 Server Error')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-1 text-danger">500</h1>
        <h3 class="mb-3">Something Went Wrong</h3>
        <p class="text-muted">An internal server error occurred.</p>

        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Home</a>
    </div>
@endsection
