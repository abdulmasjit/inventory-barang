<ul class="pagination">
  @if ($paginator->hasPages())
    {{-- Prevoius Page Link --}}
    @if ($paginator->onFirstPage())
      <li class="page-item disabled"><a class="page-link"><span>&laquo;</span></a></li>
    @else
      <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
    @endif

    {{-- Pagination Element Here --}}
    @foreach ($elements as $element)
      {{-- Make Three Dots --}}
      @if (is_string($element))
        <li class="page-item disabled"><a class="page-link"><span>{{ $element }}</span></a></li>
      @endif

      {{-- Link Array Here --}}
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <li class="page-item active"><a class="page-link"><span>{{ $page }}</span></a></li>
          @else
            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
      <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><span>&raquo;</span></a></li>
    @else
      <li class="page-item disabled"><a class="page-link"><span>&raquo;</span></a></li>
    @endif
  @else
    {{-- Not Has Page --}}
    <li class="page-item disabled"><a class="page-link"><span>&laquo;</span></a></li>
    <li class="page-item active"><a class="page-link"><span>1</span></a></li>
    <li class="page-item disabled"><a class="page-link"><span>&raquo;</span></a></li>
  @endif
</ul>    
