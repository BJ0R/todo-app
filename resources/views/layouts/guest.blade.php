{{-- resources/views/layouts/guest.blade.php --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Bootstrap CSS --}}
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    >

    {{-- You can keep Vite if you still use Breeze assets elsewhere --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
      body { background: #0f172a; /* slate-900 */ }
      .auth-wrapper {
        min-height: 100vh;
        display: grid;
        place-items: center;
        padding: 2rem 1rem;
      }
      .auth-card {
        border: 0;
        border-radius: 1rem;
        box-shadow: 0 20px 45px rgba(0,0,0,.25);
        overflow: hidden;
      }
      .brand-side {
        background: linear-gradient(135deg, #111827, #1f2937);
        color: #e5e7eb;
      }
      .brand-side h1 { letter-spacing: .5px; }
    </style>
  </head>
  <body>
    <div class="auth-wrapper">
      {{ $slot }}
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>
