<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <link rel="shortcut icon" href="/img/time.png" type="image/x-icon" />
    <title>Straube Time Tracking</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('head')
</head>
<body>
    @php
    $user = Illuminate\Support\Facades\Auth::user();
    @endphp
    @if ($user)
        <nav class="navbar navigation bg-dark fixed-top">
            <a href="{{ route('time.index') }}">Time Tracking</a>
            <a href="{{ route('my.index') }}">My Activities</a>
            <a href="{{ route('report.index') }}">Reports</a>
            <div class="dropdown drop">
                <button class="btn btn-secondary btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Menu
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                    <a class="dropdown-item" href="{{ route('activity.index') }}">Type of activities</a>
                    <a class="dropdown-item" href="{{ route('import.index') }}">Time import</a>
                    <a class="dropdown-item" href="{{ route('user.index') }}">Users</a>
                    <a class="dropdown-item" href="{{ route('out') }}">Logging Out</a>
                </div>
            </div>
        </nav>
    @endif
    <div id="app" class="container-fluid mt-3">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('foot')
</body>
</html>
