@use('App\Helpers\Helper')
@use('Illuminate\Support\Facades\View')
<!DOCTYPE html>
<html>

<head>
  <title>{{ Helper::fullTitleHelper(View::getSection('title')) }}</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  {{-- <%= csp_meta_tag %> --}}
</head>

<body>
  @include('sub.header')
  <div class="max-w-4xl mx-auto mt-10">
    {{ $slot }}
    @include('sub.footer')
  </div>
</body>

</html>
