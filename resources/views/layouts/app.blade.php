<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="@yield('description', setting('seo_description', 'LaraBBS 爱好者乐园。'))">
  <meta name="keyword" content="@yield('keyword', setting('seo_keyword', 'LaraBBS,社区,论坛,开发者论坛'))">

  <!-- CSRF TOKEN -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'LaraBBS') - {{ setting('site_name', 'Laravel 进阶教程') }}</title>

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  @yield('styles')
</head>

<body>
  <div class="{{ route_class() }}-page" id="app">
    @include('layouts._header')
    <div class="container">
      @include('shared._messages')
      @yield('content')
    </div>
    @include('layouts._footer')
  </div>
  @includeWhen(app()->isLocal(), 'sudosu::user-selector')
  <!-- Script -->
  <script src="{{ mix('js/app.js') }}"></script>
  @yield('scripts')

</body>

</html>
