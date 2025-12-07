@extends('layouts.hrm')

@section('title', '404 Not Found')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-1 text-danger">404</h1>
        <h3 class="mb-3">Page Not Found</h3>
        <p class="text-muted">The page you requested was not found.</p>

        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Back to Home</a>
    </div>
@endsection
