@extends('layouts.hrm')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">

            <!-- Employees Card -->
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-primary h-100">
                    <div class="card-body">
                        <div class="card-title">
                            <i class="fas fa-users fa-2x float-right"></i>
                            <h5>Employees</h5>
                        </div>
                        <h2 class="card-text mt-3">{{ $employeeCount }}</h2>
                    </div>
                    @if (auth()->user()->isRole(['admin', 'developer']))
                        <div class="card-footer">
                            <a href="{{ route('employees.index') }}" class="text-white">View Employees <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Departments Card -->
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-success h-100">
                    <div class="card-body">
                        <div class="card-title">
                            <i class="fas fa-building fa-2x float-right"></i>
                            <h5>Departments</h5>
                        </div>
                        <h2 class="card-text mt-3">{{ $departmentCount }}</h2>
                    </div>
                    @if (auth()->user()->isRole(['admin', 'developer']))
                        <div class="card-footer">
                            <a href="{{ route('departments.index') }}" class="text-white">View Departments <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Skills Card -->
            <div class="col-md-4 mb-4">
                <div class="card text-white bg-warning h-100">
                    <div class="card-body">
                        <div class="card-title">
                            <i class="fas fa-lightbulb fa-2x float-right"></i>
                            <h5>Skills</h5>
                        </div>
                        <h2 class="card-text mt-3">{{ $skillCount }}</h2>
                    </div>
                    @if (auth()->user()->isRole(['admin', 'developer']))
                        <div class="card-footer">
                            <a href="{{ route('skills.index') }}" class="text-white">View Skills <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('employeeChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($departmentLabels),
                datasets: [{
                    label: 'Employees per Department',
                    data: @json($departmentCounts),
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                }]
            }
        });
    </script>
@endpush
