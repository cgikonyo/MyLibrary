<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Library</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">My Library</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">All Books</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/books/create">New Book</a>
                    </li>

                </ul>
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <span class="navbar-text me-3">
                                @php
                                    $hour = now()->hour;
                                    if ($hour < 12) {
                                        $greeting = 'Good morning';
                                    } elseif ($hour < 18) {
                                        $greeting = 'Good afternoon';
                                    } else {
                                        $greeting = 'Good evening';
                                    }
                                @endphp
                                {{ $greeting }}, {{ Auth::user()->first_name }}
                            </span>
                        </li>
                        <li class="nav-item">
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to log out?');">
                                @csrf
                                <button class="btn btn-link nav-link" type="submit">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/register">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>
</body>

</html>