@extends('layouts.hrm')

@section('title', '403 Forbidden')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-1 text-danger">403</h1>
        <h3 class="mb-3">Access Forbidden</h3>
        <p class="text-muted">You don’t have permission to access this page.</p>

        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Back to Home</a>
    </div>
@endsection
