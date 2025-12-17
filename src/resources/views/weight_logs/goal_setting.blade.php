@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/goal_setting.css') }}?v={{ time() }}">
@endsection

@section('content')

<div class="goal_setting-overlay">
  <div class="goal_setting">
    <h2 class="goal_setting-title">目標体重設定</h2>
    <form action="{{ route('goal.setting.update') }}"  method="POST">
      @csrf
      <div class="form-group">
        <div class="input-unit">
          <input type="text" step="0.1" name="target_weight" value="{{ old('target_weight', $targetWeight ?? '') }}">
          <span>kg</span>
        </div>
        @error('target_weight')
          <p class="error-text">{{ $message }}</p>
        @enderror
      </div>
      <div class="goal_setting-actions">
        <a href="{{ url('/weight_logs') }}" class="btn goal_setting-btn-back">戻る</a>
        <button type="submit" class="btn goal_setting-btn-primary">更新</button>
      </div>
    </form>
  </div>
</div>


@endsection