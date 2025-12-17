@if ($paginator->hasPages())
  <nav class="pager">
    {{-- 前へ --}}
    @if ($paginator->onFirstPage())
      <span class="pager-arrow disabled">&lt;</span>
    @else
      <a href="{{ $paginator->previousPageUrl() }}" class="pager-arrow">&lt;</a>
    @endif

    {{-- ページ番号 --}}
    @foreach ($elements as $element)
      {{-- "..." --}}
      @if (is_string($element))
        <span class="pager-dots">{{ $element }}</span>
      @endif

      {{-- ページリンク --}}
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <span class="pager-number active">{{ $page }}</span>
          @else
            <a href="{{ $url }}" class="pager-number">{{ $page }}</a>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- 次へ --}}
    @if ($paginator->hasMorePages())
      <a href="{{ $paginator->nextPageUrl() }}" class="pager-arrow">&gt;</a>
    @else
      <span class="pager-arrow disabled">&gt;</span>
    @endif
  </nav>
@endif
