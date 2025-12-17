@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/weight_logs.css') }}?v={{ time() }}">
@endsection

@section('content')
  
<div class="page">

  {{-- 上部サマリー --}}
  <section class="summary">
    <div class="summary-card">
      <p class="summary-label">目標体重</p>
      <p class="summary-value">
        {{ $targetWeight ?? '---.-' }}<span class="unit">kg</span>
      </p>
    </div>

    <div class="summary-card">
      <p class="summary-label">目標まで</p>
      <p class="summary-value accent">
        {{ $diffToTarget ?? '--.-' }}<span class="unit">kg</span>
      </p>
    </div>

    <div class="summary-card">
      <p class="summary-label">最新体重</p>
      <p class="summary-value">
        {{ $latestWeight ?? '---.-' }}<span class="unit">kg</span>
      </p>
    </div>
  </section>

  {{-- 検索＋追加 --}}
  <section class="toolbar">
    <form class="search" action="/weight_logs/search" method="get">
      <div class="search-group">
        <input class="date-input" type="date" name="from" value="{{ request('from') }}">

        <span class="range">〜</span>
        
        <input class="date-input" type="date" name="to" value="{{ request('to') }}">
      </div>

      <div class="serach-btn-area">
        <button class="btn btn-gray" type="submit">検索</button>

        {{-- 検索中のみ表示 --}}
        @if(request('from') || request('to'))
          <a href="{{ route('weight_logs.index') }}" class="btn btn-reset">リセット</a>
        @endif
      </div>
      
    </form>
    
    <button type="button" id="openModal" class="btn btn-primary" id="openModal">
      データ追加
    </button>
  </section>

  @if(isset($count))
    <p class="search-result">
      {{ $from ?? '—' }} 〜 {{ $to ?? '—' }} の検索結果 <span>{{ $count }}件</span>
    </p>
  @endif

  {{-- 一覧 --}}
  <section class="table-wrap">
    <table class="logs-table">
      <thead>
        <tr>
          <th class="col-date">日付</th>
          <th class="col-weight">体重</th>
          <th class="col-cal">摂取カロリー</th>
          <th class="col-ex">運動時間</th>
          <th class="col-act"></th>
        </tr>
      </thead>

      <tbody>
        @forelse($weightLogs ?? [] as $log)
          <tr>
            <td>{{ \Carbon\Carbon::parse($log->date)->format('Y/m/d') }}</td>
            <td>{{ number_format($log->weight, 1) }}kg</td>
            <td>{{ $log->calories ? $log->calories.'cal' : '-' }}</td>
            <td>{{ $log->exercise_time ? \Carbon\Carbon::parse($log->exercise_time)->format('H:i') : '-' }}</td>
            <td class="actions">
              <a class="icon-btn" href="{{ route('weight_logs.show', $log->id) }}">詳細</a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="empty">まだデータがありません。右上の「データ追加」から登録してください。</td>
          </tr>
        @endforelse
      </tbody>
    </table>
    @if(isset($weightLogs) && method_exists($weightLogs, 'links'))
      <div class="pager">
        {{ $weightLogs->appends(request()->query())->links('vendor.pagination.simple') }}
      </div>
    @endif
  </section>

</div>

{{-- ===== モーダル ===== --}}
<div class="modal-overlay" id="modalOverlay">
  <div id="weightLogModal" class="modal">

    <h2 class="modal-title">Weight Log を追加</h2>

    <form id="weightLogForm" action="/weight_logs" method="POST">
      @csrf

      <div class="form-group">
        <label>日付 <span class="required">必須</span></label>
        <div class="input-unit">
        <input type="date" name="date" value="{{ old('date', now()->toDateString()) }}">
        </div>
        @error('date')
          <p class="error-text">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label>体重 <span class="required">必須</span></label>
        <div class="input-unit">
          <input type="text" step="0.1" name="weight" placeholder="50.0" value="{{ old('weight') }}">
          <span>kg</span>
        </div>
        @error('weight')
          <p class="error-text">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label>摂取カロリー <span class="required">必須</span></label>
        <div class="input-unit">
          <input type="text" name="calories" placeholder="1200" value="{{ old('calories') }}">
          <span>cal</span>
        </div>
        @error('calories')
          <p class="error-text">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label>運動時間 <span class="required">必須</span></label>
        <div class="input-unit">
          <input type="time"
       name="exercise_time"
       step="60"
       value="{{ old('exercise_time') ? substr(old('exercise_time'), 0, 5) : '' }}">
        </div>
        @error('exercise_time')
          <p class="error-text">{{ $message }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label>運動内容</label>
        <textarea name="exercise_content" placeholder="運動内容を追加">{{ old('exercise_content') }}</textarea>
        @error('exercise_content')
        <p class="error-text">{{ $message }}</p>
        @enderror
      </div>

      <div class="modal-actions">
        <button type="button" class="btn modal-btn-back" id="closeModal">戻る</button>
        <button type="submit" class="btn modal-btn-primary">登録</button>
      </div>
      
    </form>

  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

  const openBtn  = document.getElementById('openModal');
  const closeBtn = document.getElementById('closeModal');
  const overlay  = document.getElementById('modalOverlay');
  const form     = document.getElementById('weightLogForm');

  // 追加ボタンを押したとき（＝新規入力）
  openBtn.addEventListener('click', () => {

    // フォームをリセット（前回入力を消す）
    if (form) {
      form.reset();
    }

    // バリデーションエラーメッセージを消す
    const errors = overlay.querySelectorAll('.error-text');
    errors.forEach(error => error.remove());

    // モーダル表示
    overlay.classList.add('active');
  });

  // 閉じるボタン
  closeBtn.addEventListener('click', () => {
    overlay.classList.remove('active');
  });

  // 背景クリックで閉じる
  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) {
      overlay.classList.remove('active');
    }
  });

});
</script>

@if ($errors->any())
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const overlay = document.getElementById('modalOverlay');
    if (overlay && !overlay.classList.contains('active')) {
      overlay.classList.add('active');
    }
  });
</script>
@endif

@endsection