{{-- resources/views/components/layout.blade.php --}}
@props(['title' => 'To-Do'])

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>{{ $title }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Bootstrap CSS --}}
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">

  <style>
    :root{
      --brand-accent: #60a5fa; /* soft blue */
      --nav-hover: #f3f4f6;    /* light hover bg for links (on light text use underline) */
    }
    body { background: #f8fafc; }

    /* Brand */
    .nav-brand{
      font-weight: 800;
      letter-spacing: .3px;
      position: relative;
      transition: transform .2s ease, color .2s ease;
    }
    .nav-brand:hover{
      color: var(--brand-accent) !important;
      transform: translateY(-1px);
      text-shadow: 0 2px 8px rgba(96,165,250,.35);
    }
    /* Fancy underline for nav links */
    .nav-link{
      position: relative;
      transition: color .15s ease-in-out;
    }
    .nav-link::after{
      content:"";
      position:absolute;
      left:0; bottom:-6px;
      width:0; height:2px;
      background: linear-gradient(90deg, var(--brand-accent), #34d399);
      transition: width .2s ease;
      border-radius: 2px;
    }
    .nav-link:hover::after{ width:100%; }
    .nav-link.active{
      color:#fff !important;
    }
    .nav-link.active::after{ width:100%; }

    /* Avatar (initials fallback) */
    .avatar{
      width: 36px; height: 36px;
      border-radius: 50%;
      display:inline-flex; align-items:center; justify-content:center;
      font-weight: 700; font-size: .9rem;
      color:#1f2937; background:#e5e7eb; border:1px solid #d1d5db;
      text-decoration: none;
      transition: transform .15s ease, box-shadow .15s ease;
    }
    .avatar:hover{
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(0,0,0,.12);
    }

    /* Improve navbar spacing */
    .navbar{ --bs-navbar-nav-link-padding-x: .75rem; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container">
    {{-- Brand --}}
    <a class="navbar-brand nav-brand" href="{{ route('tasks.index') }}">Manager</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div id="navMain" class="collapse navbar-collapse">
      {{-- Left nav --}}
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}" href="{{ route('tasks.index') }}">Tasks</a>
        </li>
      </ul>

      {{-- Right nav --}}
      <ul class="navbar-nav ms-auto align-items-center gap-2">
        @auth
          {{-- Greeting (optional, can remove for minimal) --}}
          <li class="nav-item d-none d-lg-block">
            <span class="navbar-text me-1">Hi, {{ auth()->user()->name }}</span>
          </li>

          {{-- Avatar → Profile (edit) --}}
          <li class="nav-item">
            @php
              $name = auth()->user()->name ?? 'User';
              $initials = collect(preg_split('/\s+/', trim($name)))
                ->filter()
                ->map(fn($w) => mb_substr($w, 0, 1))
                ->join('');
              // If you later add an avatar path on the user model (e.g., 'avatar'), you can swap the <a> for an <img>.
              $avatarUrl = null; // e.g., auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : null;
            @endphp

            @if($avatarUrl)
              <a href="{{ route('profile.edit') }}" class="d-inline-flex">
                <img src="{{ $avatarUrl }}" alt="Profile" class="rounded-circle border" style="width:36px;height:36px;object-fit:cover;">
              </a>
            @else
              <a href="{{ route('profile.edit') }}" class="avatar" title="Profile">{{ $initials }}</a>
            @endif
          </li>

          {{-- Logout --}}
          <li class="nav-item ms-1">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-outline-light btn-sm">Logout</button>
            </form>
          </li>
        @else
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

<main class="container">
  {{ $slot }}
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
