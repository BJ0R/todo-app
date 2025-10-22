{{-- resources/views/auth/register.blade.php --}}
<x-guest-layout>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-9">
        <div class="card auth-card">
          <div class="row g-0">
            {{-- Brand / Welcome Side --}}
            <div class="col-md-5 d-none d-md-flex align-items-center justify-content-center p-4 brand-side">
              <div class="text-center px-3">
                {{-- Optional: your logo --}}
                {{-- <img src="{{ asset('logo.svg') }}" alt="Logo" class="mb-3" style="height:48px"> --}}
                <h1 class="h3 mb-2">{{ config('app.name', 'Laravel') }}</h1>
                <p class="mb-0" style="color:#9ca3af;">
                  Create an account to start organizing your tasks.
                </p>
              </div>
            </div>

            {{-- Form Side --}}
            <div class="col-md-7 bg-white">
              <div class="p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h2 class="h4 mb-0">Create your account</h2>

                </div>

                <form method="POST" action="{{ route('register') }}" novalidate>
                  @csrf

                  {{-- Name --}}
                  <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input
                      id="name"
                      type="text"
                      name="name"
                      value="{{ old('name') }}"
                      class="form-control @error('name') is-invalid @enderror"
                      required
                      autofocus
                      autocomplete="name"
                      placeholder="Jane Doe"
                    >
                    @error('name')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

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
                      autocomplete="username"
                      placeholder="you@example.com"
                    >
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  {{-- Password --}}
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input
                      id="password"
                      type="password"
                      name="password"
                      class="form-control @error('password') is-invalid @enderror"
                      required
                      autocomplete="new-password"
                      placeholder="••••••••"
                    >
                    @error('password')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                      Use at least 8 characters, including a number and a symbol.
                    </div>
                  </div>

                  {{-- Confirm Password --}}
                  <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input
                      id="password_confirmation"
                      type="password"
                      name="password_confirmation"
                      class="form-control @error('password_confirmation') is-invalid @enderror"
                      required
                      autocomplete="new-password"
                      placeholder="••••••••"
                    >
                    @error('password_confirmation')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                      Register
                    </button>
                  </div>

                  <div class="text-center mt-3">
                    <span class="text-muted">Already have an account?</span>
                    <a href="{{ route('login') }}" class="ms-1 text-decoration-none">Log in</a>
                  </div>
                </form>
              </div>
            </div>
          </div> {{-- row --}}
        </div> {{-- card --}}
      </div>
    </div>
  </div>
</x-guest-layout>
