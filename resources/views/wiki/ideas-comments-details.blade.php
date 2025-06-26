<div class="blog-comments">
  <div class="send-comment">
    <h2>نظرات کاربران</h2>
    @if(auth()->check())
    <a href="#" class="btn btn-green icon-right" data-bs-toggle="modal" data-bs-target="#modal-sendcomments">
      <i class="mdi mdi-chat-plus-outline"></i>ارسال نظر
    </a>
    @else
    <a href="web" class="btn btn-green icon-right">
      <i class="mdi mdi-chat-plus-outline"></i>جهت ثبت نظر وارد شوید
    </a>
    @endif
  </div>
  <div class="comments-list">
    @foreach($comments as $comment)
    <div class="comment-item">
      <div class="user-image">
        <img src="v4_assets/images/icons/user-comment.svg" />
      </div>
      <div class="user-info">
        <h6 class="name">{{$comment->user->name}}</h6>
        <div class="date">{{$comment->registe_date}}</div>
        <div class="text">
          {{$comment->comment}}
        </div>
        <div class="rate">
          <span>{{$comment->score}}</span>
          <i class="mdi mdi-star"></i>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>

<div class="my-pagination">
  <nav aria-label="Page navigation">
    <?php $link_limit = 7; ?>
    @if($comments->lastPage() >= 1)
    <ul class="pagination">
      <li class="{{ ($comments->currentPage() == 1) ? ' disabled page-item' : 'page-item' }}">
        <a id="paginationBtnPage" class="page-link" data-id="1" href="javascript:void(0);">
          <i class="mdi mdi-arrow-right"></i>
          <span>بعدی</span>
        </a>
      </li>
      @for($i = 1; $i <= $comments->lastPage(); $i++)
        <?php
        $half_total_links = floor($link_limit / 2);
        $from = $comments->currentPage() - $half_total_links;
        $to = $comments->currentPage() + $half_total_links;
        if ($comments->currentPage() < $half_total_links) {
          $to += $half_total_links - $comments->currentPage();
        }
        if ($comments->lastPage() - $comments->currentPage() < $half_total_links) {
          $from -= $half_total_links - ($comments->lastPage() - $comments->currentPage()) - 1;
        }
        ?>
        @if($from < $i && $i < $to) <li class="{{ ($comments->currentPage() == $i) ? 'page-item active' : 'page-item' }}">
          <a id="paginationBtnPage" class="page-link" data-id="{{ $i }}" href="javascript:void(0);">{{ $i }}</a>
          </li>
          @endif
          @endfor
          <li class="{{ ($comments->currentPage() == $comments->lastPage()) ? 'page-item disabled' : 'page-item' }}">
            <a id="paginationBtnPage" class="page-link" data-id="{{$comments->lastPage()}}" href="javascript:void(0);">
              <span>قبلی</span>
              <i class="mdi mdi-arrow-left"></i>
            </a>
          </li>
    </ul>
    @endif
  </nav>
</div>