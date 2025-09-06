<!DOCTYPE html>
<html>

<head>
  <title>@yield('title') | Laravel Tutorial Sample App</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  {{-- <%= csp_meta_tag %> --}}
</head>

<body>
  {{ $slot }}
</body>

</html>
