@extends('layouts.hrm')

@section('title', '401 Unauthorized')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-1 text-warning">401</h1>
        <h3 class="mb-3">Unauthorized</h3>
        <p class="text-muted">You need to log in to view this page.</p>

        <a href="{{ route('login') }}" class="btn btn-primary mt-3">Login</a>
    </div>
@endsection
