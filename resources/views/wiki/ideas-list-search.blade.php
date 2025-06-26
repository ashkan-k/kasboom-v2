<div class="idea-list">
  @foreach($ideas as $idea)
  <div class="card-idea type-2">
    <div class="card-inner">
      <a href="{{url('wikiidea/details/' . $idea->id)}}" title="{{$idea->abstractMemo}}">
        <figure class="idea-pic">
          <div class="img-inner">
            <img src="_upload_/_wikiideas_/{{$idea->code}}/medium_{{$idea->image}}" alt="{{$idea->title}}" class="cover-image" style="width: 100%;height: 100%;">
          </div>
        </figure>
        <div class="card-b">
          <h2 class="name">{{$idea->title}}</h2>
          <ul class="idea-property">
            <li><i class="mdi mdi-shape"></i><span>{{$idea->category?->title}}</span></li>
            <li><i class="mdi mdi-wallet"></i><span>ریسک: {{$idea->risk}}</span></li>
            <li><i class="mdi mdi-clock"></i><span>سودآوری: {{$idea->profitability}}</span></li>
            <li><i class="mdi mdi-account-multiple"></i><span>نیروی انسانی: {{$idea->manpower}}</span></li>
          </ul>
          <p class="desc">
            {{$idea->abstractMemo}}
          </p>
          <div class="price">
            <h6>کف سرمایه : </h6>
            <div class="number">{{number_format($idea->minimal_fund)}}</div>
            <div class="toman">تومان</div>
          </div>
          <div class="other-info">
            <ul class="status-list">
              <li><i class="mdi mdi-eye-outline"></i>{{$idea->view_count != null ? $idea->view_count : 0}}</li>
              <li><i class="mdi mdi-heart-outline"></i>{{$idea->like_count != null ? $idea->like_count : 0}}</li>
              <li><i class="mdi mdi-star-outline"></i>{{$idea->score != null ? $idea->score : 0}}</li>
            </ul>
          </div>
        </div>
      </a>
    </div>
  </div>
  @endforeach

  @if(count($ideas) < 1) <div class="card-idea p-0 mt-4 mb-4">
    <div class="card-inner text-center" style="padding: 30px 10px;font-size:14px;font-weight:400;color:grey">
      چیزی یافت نشد
    </div>
</div>
@endif
</div>

<div class="my-pagination">
  <nav aria-label="Page navigation">
    <?php $link_limit = 7; ?>
    @if($ideas->lastPage() >= 1)
    <ul class="pagination">
      <li class="{{ ($ideas->currentPage() == 1) ? ' disabled page-item' : 'page-item' }}">
        <a id="paginationBtnPage" class="page-link" data-id="1" href="javascript:void(0);">
          <i class="mdi mdi-arrow-right"></i>
          <span>بعدی</span>
        </a>
      </li>
      @for($i = 1; $i <= $ideas->lastPage(); $i++)
        <?php
        $half_total_links = floor($link_limit / 2);
        $from = $ideas->currentPage() - $half_total_links;
        $to = $ideas->currentPage() + $half_total_links;
        if ($ideas->currentPage() < $half_total_links) {
          $to += $half_total_links - $ideas->currentPage();
        }
        if ($ideas->lastPage() - $ideas->currentPage() < $half_total_links) {
          $from -= $half_total_links - ($ideas->lastPage() - $ideas->currentPage()) - 1;
        }
        ?>
        @if($from < $i && $i < $to) <li class="{{ ($ideas->currentPage() == $i) ? 'page-item active' : 'page-item' }}">
          <a id="paginationBtnPage" class="page-link" data-id="{{ $i }}" href="javascript:void(0);">{{ $i }}</a>
          </li>
          @endif
          @endfor
          <li class="{{ ($ideas->currentPage() == $ideas->lastPage()) ? 'page-item disabled' : 'page-item' }}">
            <a id="paginationBtnPage" class="page-link" data-id="{{$ideas->lastPage()}}" href="javascript:void(0);">
              <span>قبلی</span>
              <i class="mdi mdi-arrow-left"></i>
            </a>
          </li>
    </ul>
    @endif
  </nav>
</div>
