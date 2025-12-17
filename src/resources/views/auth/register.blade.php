@extends('layouts.guest')

@section('title','新規会員登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
@endsection

@section('content')

  {{-- ロゴ　タイトル --}}
  <h1 class="logo">PiGLy</h1>
  <h2 class="subtitle">新規会員登録</h2>
  <p class="step">step1 アカウント情報の登録</p>

  {{-- フォーム --}}
  <form action="/register" method="post" novalidate>
    @csrf
    
    <div class="form-group">
      <label>お名前</label>
      <div class="input-area">
        <input type="text" name="name" placeholder="お名前を入力" value="{{ old('name')}}">
      </div>
      {{-- エラーメッセージ --}}
      @error('name')
        <p class="error-text">{{ $message }}</p>
      @enderror

    </div>

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
        <input type="password" name="password" placeholder="パスワードを入力" value="{{ old('password')}}">
      </div>
      {{-- エラーメッセージ --}}
      @error('password')
        <p class="error-text">{{ $message }}</p>
      @enderror

    </div>


    {{-- ボタン --}}
    <button type="submit" class="btn-primary">次に進む</button>

    {{-- リンク --}}
    <div class="link">
        <a href="/login">ログインはこちら</a>
    </div>

  </form>

@endsection