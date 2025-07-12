@if ($paginator->hasPages())
    <div class="my-pagination">
        <nav aria-label="Page navigation">
            <!-- فایل قالب پیجینیشن سفارشی: resources/views/vendor/pagination/custom.blade.php -->
            <ul class="pagination">
                <!-- لینک قبلی -->
                @if ($paginator->onFirstPage())
                    <li class="page-item prev disabled">
            <span class="page-link" aria-label="Previous">
                <span>قبلی</span>
                <i class="mdi mdi-arrow-left"></i>
            </span>
                    </li>
                @else
                    <li class="page-item prev">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                            <span>قبلی</span>
                            <i class="mdi mdi-arrow-left"></i>
                        </a>
                    </li>
                @endif

            <!-- شماره صفحات -->
                @foreach ($elements as $element)
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

            <!-- لینک بعدی -->
                @if ($paginator->hasMorePages())
                    <li class="page-item next">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                            <i class="mdi mdi-arrow-right"></i>
                            <span>بعدی</span>
                        </a>
                    </li>
                @else
                    <li class="page-item next disabled">
            <span class="page-link" aria-label="Next">
                <i class="mdi mdi-arrow-right"></i>
                <span>بعدی</span>
            </span>
                    </li>
                @endif

            </ul>
        </nav>
    </div>
@endif
