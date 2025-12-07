@extends('layouts.hrm')

@section('title', '419 Page Expired')

@section('content')
    <div class="text-center mt-5">
        <h1 class="display-1 text-warning">419</h1>
        <h3 class="mb-3">Page Expired</h3>
        <p class="text-muted">Your session expired. Please refresh or login again.</p>

        <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Go Back</a>
    </div>
@endsection
