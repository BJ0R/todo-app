{{-- resources/views/auth/forgot-password.blade.php --}}
<x-guest-layout>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-9">
        <div class="card auth-card">
          <div class="row g-0">
            {{-- Brand / Info Side --}}
            <div class="col-md-5 d-none d-md-flex align-items-center justify-content-center p-4 brand-side">
              <div class="text-center px-3">
                {{-- Optional: your logo --}}
                {{-- <img src="{{ asset('logo.svg') }}" alt="Logo" class="mb-3" style="height:48px"> --}}
                <h1 class="h4 mb-2">{{ config('app.name', 'Laravel') }}</h1>
                <p class="mb-0" style="color:#9ca3af;">
                  Forgot your password? Enter your email and we’ll send a reset link.
                </p>
              </div>
            </div>

            {{-- Form Side --}}
            <div class="col-md-7 bg-white">
              <div class="p-4 p-md-5">
                <div class="d-flex align-items-center justify-content-between mb-3">
                  <h2 class="h4 mb-0">Reset your password</h2>
                  <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">Sign in</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm">Create account</a>
                  </div>
                </div>

                {{-- Session Status --}}
                @if (session('status'))
                  <div class="alert alert-success mb-4">
                    {{ session('status') }}
                  </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" novalidate>
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
                      placeholder="you@example.com"
                    >
                    @error('email')
                      <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                      Email Password Reset Link
                    </button>
                  </div>
                </form>

                {{-- Help text --}}
                <div class="text-muted small mt-3">
                  If the email is registered, you’ll receive a message with instructions to reset your password.
                  Be sure to check your spam folder.
                </div>
              </div>
            </div>
          </div> {{-- row --}}
        </div> {{-- card --}}
      </div>
    </div>
  </div>
</x-guest-layout>
