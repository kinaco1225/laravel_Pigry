@extends('layouts.guest')

@section('title','新規会員登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ time() }}">
@endsection

@section('content')

  {{-- ロゴ　タイトル --}}
  <h1 class="logo">PiGLy</h1>
  <h2 class="subtitle">新規会員登録</h2>
  <p class="step">step2 体重データの入力</p>

  {{-- フォーム --}}
  <form action="/weight_targets" method="post" novalidate>
    @csrf
    
    <div class="form-group">
      <label>現在の体重</label>
      <div class="input-area">
        <input type="text" step="0.1" name="weight" placeholder="現在の体重を入力" value="{{ old('weight')}}">
        <p>kg</p>
      </div>
      {{-- エラーメッセージ --}}
      @error('weight')
        <p class="error-text">{{ $message }}</p>
      @enderror

    </div>

    <div class="form-group">
      <label>目標の体重</label>
      <div class="input-area">
        <input type="text" step="0.1" name="target_weight" placeholder="目標の体重を入力" value="{{ old('target_weight')}}">
        <p>kg</p>
      </div>

      {{-- エラーメッセージ --}}
      @error('target_weight')
        <p class="error-text">{{ $message }}</p>
      @enderror

    </div>

    {{-- ボタン --}}
    <button type="submit" class="btn-primary">アカウント作成</button>

  </form>

@endsection