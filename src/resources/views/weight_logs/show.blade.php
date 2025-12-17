@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}?v={{ time() }}">
@endsection

@section('content')
  

<div class="show-overlay">
  <div  class="show">

    <h2 class="show-title">Weight Log</h2>

    <form action="{{ route('weight_logs.update', $weightLog->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label>日付 </label>
        <div class="input-unit">
        <input type="date" name="date" value="{{ old('date', $weightLog->date) }}"">
        </div>
        @error('date')
          <p class="error-text">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label>体重 </label>
        <div class="input-unit">
          <input type="text" step="0.1" name="weight" value="{{ old('weight', $weightLog->weight) }}">
          <span>kg</span>
        </div>
        @error('weight')
          <p class="error-text">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label>摂取カロリー</label>
        <div class="input-unit">
          <input type="text" name="calories" value="{{ old('calories', $weightLog->calories) }}">
          <span>cal</span>
        </div>
        @error('calories')
          <p class="error-text">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label>運動時間</label>
        <div class="input-unit">
          <input type="time"
       name="exercise_time"
       step="60"
       value="{{ old('exercise_time', optional($weightLog->exercise_time) ? substr($weightLog->exercise_time, 0, 5) : '') }}">
        </div>
        @error('exercise_time')
          <p class="error-text">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label>運動内容</label>
        <textarea name="exercise_content">{{ old('exercise_content', $weightLog->exercise_content) }}</textarea>
        @error('exercise_content')
        <p class="error-text">{{ $message }}</p>
        @enderror
      </div>

      <div class="show-actions">
        <div class="edit-buttons">
          <a href="{{ url('/weight_logs') }}" class="btn show-btn-back">戻る</a>
          <button type="submit" class="btn show-btn-primary">更新</button>
        </div>
        <span data-id="{{ $weightLog->id }}" class="btn-delete">🗑</span>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const deleteBtn = document.querySelector('.btn-delete');
  if (!deleteBtn) return;

  deleteBtn.addEventListener('click', async () => {
    const id = deleteBtn.dataset.id;

    if (!confirm('本当に削除しますか？')) return;

    try {
      const response = await fetch(`/weight_logs/${id}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Accept': 'application/json',
        }
      });

      if (!response.ok) {
        throw new Error('削除に失敗しました');
      }
      
      window.location.href = '/weight_logs';

    } catch (error) {
      alert(error.message);
    }
  });
});
</script>


@endsection