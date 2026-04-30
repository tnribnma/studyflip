<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'StudyFlip') — StudyFlip</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:   #4f46e5;
            --primary-dark: #3730a3;
            --accent:    #f59e0b;
            --surface:   #f8fafc;
            --card-bg:   #ffffff;
            --text:      #1e293b;
            --muted:     #64748b;
            --border:    #e2e8f0;
            --success:   #10b981;
            --danger:    #ef4444;
            --radius:    14px;
            --shadow:    0 4px 24px rgba(79,70,229,.10);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--surface);
            color: var(--text);
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, .brand {
            font-family: 'Syne', sans-serif;
        }

        .navbar {
            background: #fff;
            border-bottom: 1px solid var(--border);
            padding: .9rem 0;
            position: sticky; top: 0; z-index: 100;
        }
        .navbar-brand {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--primary) !important;
            letter-spacing: -0.5px;
        }
        .navbar-brand span { color: var(--accent); }
        .nav-link {
            font-weight: 500;
            color: var(--muted) !important;
            transition: color .2s;
        }
        .nav-link:hover, .nav-link.active { color: var(--primary) !important; }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            font-weight: 600;
            border-radius: 10px;
            padding: .5rem 1.25rem;
            transition: all .2s;
        }
        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }
        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
            font-weight: 600;
            border-radius: 10px;
        }
        .btn-outline-primary:hover {
            background: var(--primary);
            transform: translateY(-1px);
        }

        .card {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            background: var(--card-bg);
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            font-weight: 700;
            font-family: 'Syne', sans-serif;
            padding: 1rem 1.25rem;
        }

        .alert {
            border-radius: var(--radius);
            border: none;
            font-weight: 500;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid var(--border);
            padding: .6rem 1rem;
            transition: border .2s, box-shadow .2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79,70,229,.12);
        }
        .form-label { font-weight: 600; font-size: .9rem; margin-bottom: .35rem; }

        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: #fff;
            padding: 2.5rem 0;
            margin-bottom: 2rem;
        }
        .page-header h1 { font-size: 2rem; margin: 0; }
        .page-header p  { opacity: .85; margin: .4rem 0 0; }

        .badge-blue   { background:#dbeafe; color:#1d4ed8; }
        .badge-green  { background:#d1fae5; color:#065f46; }
        .badge-purple { background:#ede9fe; color:#5b21b6; }
        .badge-orange { background:#fed7aa; color:#92400e; }
        .badge-red    { background:#fee2e2; color:#991b1b; }
        .badge-teal   { background:#ccfbf1; color:#134e4a; }

        footer {
            background: #fff;
            border-top: 1px solid var(--border);
            padding: 1.25rem 0;
            margin-top: 4rem;
            font-size: .88rem;
            color: var(--muted);
        }
    </style>

    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            Study<span>Flip</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                @if(session('user_id'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('decks.*') ? 'active' : '' }}"
                           href="{{ route('decks.index') }}">
                            <i class="bi bi-collection me-1"></i>My Decks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                           href="{{ route('profile.show') }}">
                            <i class="bi bi-person-circle me-1"></i>{{ session('user_name') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-outline-primary btn-sm ms-2">
                                <i class="bi bi-box-arrow-right me-1"></i>Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm ms-2" href="{{ route('register') }}">Get Started</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('error') }}
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<main>
    @yield('content')
</main>

<footer>
    <div class="container text-center">
        <span>StudyFlip &copy; {{ date('Y') }} — Made with for learning</span>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
