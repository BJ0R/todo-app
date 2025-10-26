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
    :root {
      --brand-accent: #60a5fa;  /* soft blue */
      --brand-accent-2: #34d399; /* soft green */
      --nav-hover-bg: rgba(255,255,255,0.05);
      --glow: 0 0 12px rgba(96,165,250,0.45);
    }

    body { background: #f8fafc; font-family: 'Inter', system-ui, sans-serif; }

    /* NAVBAR */
    .navbar {
      backdrop-filter: blur(10px);
      background: rgba(0,0,0,0.9) !important;
      transition: background .3s ease;
    }

    /* Brand (Logo) */
    .nav-brand {
      font-weight: 800;
      letter-spacing: .4px;
      position: relative;
      transition: color .3s ease, transform .3s ease;
    }
    .nav-brand:hover {
      color: var(--brand-accent) !important;
      transform: translateY(-2px) scale(1.02);
      text-shadow: var(--glow);
    }

    /* NAV LINK MICROINTERACTIONS */
    .nav-link {
      position: relative;
      font-weight: 500;
      letter-spacing: .3px;
      color: #d1d5db !important;
      padding: .5rem .85rem;
      border-radius: 6px;
      overflow: hidden;
      transition: color .25s ease, background .25s ease, transform .2s ease;
    }

    /* Gradient bar under links */
    .nav-link::after {
      content: "";
      position: absolute;
      left: 50%;
      bottom: 0;
      width: 0%;
      height: 2px;
      background: linear-gradient(90deg, var(--brand-accent), var(--brand-accent-2));
      border-radius: 2px;
      transition: all .25s ease-in-out;
      transform: translateX(-50%);
    }

    .nav-link:hover {
      color: #fff !important;
      background: var(--nav-hover-bg);
      transform: translateY(-1px);
    }

    .nav-link:hover::after {
      width: 100%;
      box-shadow: 0 0 8px rgba(96,165,250,0.4);
    }

    /* Active link */
    .nav-link.active {
      color: #fff !important;
      background: rgba(96,165,250,0.15);
    }
    .nav-link.active::after {
      width: 100%;
    }

    /* Avatar */
    .avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: .9rem;
      color: #111827;
      background: linear-gradient(145deg, #e5e7eb, #f9fafb);
      border: 1px solid #d1d5db;
      text-decoration: none;
      transition: all .25s ease;
      box-shadow: 0 1px 4px rgba(0,0,0,0.1);
    }
    .avatar:hover {
      transform: translateY(-2px) scale(1.05);
      box-shadow: 0 4px 14px rgba(96,165,250,0.35);
    }

    /* Logout button microinteraction */
    .btn-outline-light {
      border-color: rgba(255,255,255,0.5);
      transition: all .25s ease;
    }
    .btn-outline-light:hover {
      background: linear-gradient(90deg, var(--brand-accent), var(--brand-accent-2));
      border: none;
      box-shadow: 0 0 10px rgba(96,165,250,0.5);
      transform: translateY(-1px);
    }

    /* Subtle floating nav shadow */
    .navbar-dark {
      box-shadow: 0 2px 10px rgba(0,0,0,0.25);
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm sticky-top">
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
          <a class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}" href="{{ route('tasks.index') }}">To Do</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('students.*') ? 'active' : '' }}" href="{{ route('students.index') }}">Students</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('inventory.*') ? 'active' : '' }}" href="{{ route('inventory.index') }}">Inventory</a>
        </li>
      </ul>

      {{-- Right nav --}}
      <ul class="navbar-nav ms-auto align-items-center gap-2">
        @auth
          <li class="nav-item d-none d-lg-block">
            <span class="navbar-text me-1 text-light opacity-75">Hi, {{ auth()->user()->name }}</span>
          </li>

          {{-- Avatar --}}
          <li class="nav-item">
            @php
              $name = auth()->user()->name ?? 'User';
              $initials = collect(preg_split('/\s+/', trim($name)))
                ->filter()
                ->map(fn($w) => mb_substr($w, 0, 1))
                ->join('');
              $avatarUrl = null;
            @endphp

            @if($avatarUrl)
              <a href="{{ route('profile.edit') }}" class="d-inline-flex">
                <img src="{{ $avatarUrl }}" alt="Profile" class="rounded-circle border" style="width:38px;height:38px;object-fit:cover;">
              </a>
            @else
              <a href="{{ route('profile.edit') }}" class="avatar" title="Profile">{{ $initials }}</a>
            @endif
          </li>

          {{-- Logout --}}
          <li class="nav-item ms-1">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="btn btn-outline-light btn-sm px-3">Logout</button>
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

<main class="container fade-in">
  {{ $slot }}
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<script>
  // Subtle fade-in for page transitions
  document.addEventListener("DOMContentLoaded", () => {
    document.body.style.opacity = 0;
    setTimeout(() => document.body.style.transition = "opacity .5s ease", 50);
    setTimeout(() => document.body.style.opacity = 1, 100);
  });
</script>

</body>
</html>
