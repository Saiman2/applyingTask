@if ($paginator->lastPage() > 1)
    <div class="text-center">
        <ul class="pagination">
            <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} waves-effect">
                <a href="{{ $paginator->url(1) }}">
                    <i class="bx bx-chevron-left"></i>
                </a>
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    <a href="{{ $paginator->url($i) }}" class="waves-effect">{{ $i }}</a>
                </li>
            @endfor
            <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} waves-effect">
                <a href="{{ $paginator->url($paginator->currentPage()+1) }}">
                    <i class="bx bx-chevron-right"></i>
                </a>
            </li>
        </ul>
    </div>
@endif

