<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{asset('css/sanitize.css')}}?v={{ time() }}">
  <link rel="stylesheet" href="{{asset('css/guest.css')}}?v={{ time() }}">
  @yield('css')
</head>
<body>
  <div class="bg-gradient">
    <div class="auth-card">
      @yield('content')
    </div>
  </div>
</body>
</html>