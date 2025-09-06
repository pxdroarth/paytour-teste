<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','App')</title>

    {{-- usa public/app.css --}}
    <link rel="stylesheet" href="{{ asset('app.css') }}">
  </head>
  <body>
    @yield('content')
  </body>
</html>
