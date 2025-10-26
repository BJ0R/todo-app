{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
  {{-- Bootstrap CSS --}}
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">

  <style>
    :root{
      --brand-accent: #60a5fa; /* soft blue */
    }
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

  </style>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-9">
        <div class="card auth-card">
          <div class="row g-0">
            {{-- Brand / Welcome Side --}}
            <div class="col-md-5 d-none d-md-flex align-items-center justify-content-center p-4 brand-side">
              <div class="text-center px-3">
                {{-- Optional: your logo --}}
                    <a class="navbar-brand nav-brand" href="{{ route('tasks.index') }}">Manager</a>



                <p class="mb-0 text-muted" style="color:#9ca3af !important;">
                  Welcome back! Sign in to manage your tasks.
                </p>
              </div>
            </div>

            {{-- Form Side --}}
            <div class="col-md-7 bg-white">
              <div class="p-4 p-md-5">
                {{-- Session Status --}}
                @if (session('status'))
                  <div class="alert alert-success mb-4">
                    {{ session('status') }}
                  </div>
                @endif

                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h2 class="h4 mb-0">Sign in</h2>
  
                </div>

                <form method="POST" action="{{ route('login') }}" novalidate>
                  @csrf

                  {{-- Email --}}
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input
                      id="email"
                      type="email"
                      name="email"
                      value="{{ old('email') }}"
                      class="form-control @error('email') is-invalid @enderror"
                      required
                      autofocus
                      autocomplete="username"
                      placeholder="you@example.com"
                    >
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- Password --}}
                  <div class="mb-3">
                    <div class="d-flex justify-content-between">
                      <label for="password" class="form-label mb-0">Password</label>
                      @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="small text-decoration-none">
                          Forgot password?
                        </a>
                      @endif
                    </div>
                    <input
                      id="password"
                      type="password"
                      name="password"
                      class="form-control @error('password') is-invalid @enderror"
                      required
                      autocomplete="current-password"
                      placeholder="••••••••"
                    >
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- Remember Me --}}
                  <div class="mb-3 form-check">
                    <input
                      type="checkbox"
                      id="remember_me"
                      name="remember"
                      class="form-check-input"
                    >
                    <label for="remember_me" class="form-check-label">Remember me</label>
                  </div>

                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                      Log in
                    </button>
                  </div>

                  <div class="text-center mt-3">
                    <span class="text-muted">Don’t have an account?</span>
                    <a href="{{ route('register') }}" class="ms-1 text-decoration-none">Register</a>
                  </div>
                </form>

                {{-- Optional: SSO / divider --}}
                {{-- <div class="text-center my-3">
                  <span class="text-muted small">or</span>
                </div>
                <div class="d-grid gap-2">
                  <a class="btn btn-outline-secondary" href="#">Continue with Google</a>
                </div> --}}
              </div>
            </div>
          </div> {{-- row --}}
        </div> {{-- card --}}
      </div>
    </div>
  </div>
</x-guest-layout>
