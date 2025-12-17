<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>体重管理画面</title>
  <link rel="stylesheet" href="{{asset('css/sanitize.css')}}?v={{ time() }}">
  <link rel="stylesheet" href="{{asset('css/app.css')}}?v={{ time() }}">
  @yield('css')
</head>
<body>
  <header class="header">
    <a href="{{ url('/weight_logs')}}" class="header-logo">PiGLy</a>
    <div class="header-actions">
      <a href="{{route('goal.setting')}}" class="header-btn weight-desing">
      ⚙ 目標体重設定
      </a>
      <form action="/logout" method="post">
        @csrf
        <button type="submit" class="header-btn logout">⎋ ログアウト</button>
      </form>
    </div>
  </header>
  <main>
    @yield('content')
  </main>

</body>
</html>