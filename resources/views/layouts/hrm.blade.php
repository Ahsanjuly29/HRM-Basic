<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>HRM System</title>

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <style>
        body {
            background: #f4f6f9;
        }

        .sidebar {
            width: 240px;
            background: #343a40;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            color: white;
        }

        .sidebar a {
            color: #ddd;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #495057;
            color: #fff;
        }

        .content-wrapper {
            margin-left: 240px;
            padding: 20px;
        }

        .topbar {
            background: white;
            padding: 10px 20px;
            border-bottom: 1px solid #e3e3e3;
        }
    </style>

    @yield('styles')
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h4 class="text-center py-3">HRM System</h4>

        <a href="{{ route('/') }}">
            <i class="fas fa-home mr-2"></i> Welcome
        </a>

        <a href="{{ route('dashboard') }}">
            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
        </a>

        @if (auth()->user()->isRole(['admin', 'developer']))
            <a href="{{ route('employees.index') }}">
                <i class="fas fa-users mr-2"></i> Employees
            </a>

            <a href="{{ route('departments.index') }}">
                <i class="fas fa-building mr-2"></i> Departments
            </a>

            <a href="{{ route('skills.index') }}">
                <i class="fas fa-lightbulb mr-2"></i> Skills
            </a>
        @endif

        <hr class="bg-secondary">

        <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
            @csrf
        </form>

    </div>

    <!-- CONTENT AREA -->
    <div class="content-wrapper">

        <!-- TOP BAR -->
        <div class="topbar d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@yield('title')</h5>

            <div>
                Logged in as:
                <strong>{{ Auth::user()->name }}</strong>
                (<span class="text-primary">{{ Auth::user()->role }}</span>)
            </div>
        </div>

        <!-- MAIN PAGE CONTENT -->
        <div class="mt-4">
            @yield('content')
        </div>

    </div>

    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @yield('scripts')

</body>

</html>
