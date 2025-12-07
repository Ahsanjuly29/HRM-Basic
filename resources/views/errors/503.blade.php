@extends('layouts.hrm')

@section('title', '503 Service Unavailable')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-1 text-dark">503</h1>
        <h3 class="mb-3">Service Unavailable</h3>
        <p class="text-muted">The system is temporarily down for maintenance.</p>

        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Return Home</a>
    </div>
@endsection
