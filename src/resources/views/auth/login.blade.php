@extends('layouts.guest')

@section('title','ログイン')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
@endsection

@section('content')

  {{-- ロゴ　タイトル --}}
  <h1 class="logo">PiGLy</h1>
  <h2 class="subtitle">ログイン</h2>

  {{-- フォーム --}}
  <form action="/login" method="post" novalidate>
    @csrf
    
    <div class="form-group">
      <label>メールアドレス</label>
      <div class="input-area">
        <input type="email" name="email" placeholder="メールアドレスを入力" value="{{ old('email')}}">
      </div>

      {{-- エラーメッセージ --}}
      @error('email')
        <p class="error-text">{{ $message }}</p>
      @enderror

    </div>

    <div class="form-group">
      <label>パスワード</label>
      <div class="input-area">
        <input type="password" name="password" placeholder="パスワードを入力">
      </div>

      {{-- エラーメッセージ --}}
      @error('password')
        <p class="error-text">{{ $message }}</p>
      @enderror

    </div>


    {{-- ボタン --}}
    <button type="submit" class="btn-primary">ログイン</button>

    {{-- リンク --}}
    <div class="link">
        <a href="/register">アカウント作成はこちら</a>
    </div>

  </form>

@endsection