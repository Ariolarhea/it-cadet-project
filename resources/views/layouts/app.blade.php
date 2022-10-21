<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>{{ config('app.name', 'LFUGGOC') }}</title>

      <!-- Scripts -->
      <script src="{{ asset('js/app.js') }}" defer></script>
      <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>

      <!-- Styles -->
      <link href="{{ asset('css/app.css') }}" rel="stylesheet">

      <style>
        
        .topnav {
        overflow: hidden;
        background-color: #005d61;
        }
          
      </style>
      
  </head>

  <body>
    <div  id="app">
      <header>
            <nav class="navbar navbar-dark bg-success">
              <div class="container d-flex flex-column flex-md-row justify-content-between">
                  <img src="/images/logo.PNG" alt="Cover Image" height="50px" width="50px"/>
                  <a class="py-2 d-none d-md-inline-block navbar-brand">MANCOM PORTAL</a>
                  <a class="py-2 d-none d-md-inline-block navbar-brand" href="reports">Reports</a>
              </div>
            </nav>
        </header>

        @yield('content')
      </div>
  </body>
</html>
