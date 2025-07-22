@extends('layouts.user-panel-master')

@section('Page_Title')
    تخفیف ها
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="grid-inner">
        <div class="main-header">
            <div class="title">
                <h3><i class="mdi mdi-email-outline"></i>تخفیف ها</h3>
            </div>
        </div>
        <div class="main-body">
            <div class="px-md-4 px-3 pb-md-4 pb-3">
                <form id="search_form">
                    <div class="profile-search">
                        <select name="status" class="form-select" onchange="$('#search_form').submit()" aria-label="advice type">
                            <option value="" selected>همه</option>
                            <option value="new" @if(request('status') == 'new') selected @endif>جدید</option>
                            <option value="expired" @if(request('status') == 'expired') selected @endif>منقضی</option>
                        </select>
                        <div class="inputgroup">
                            <input type="text" id="search_input" name="search" value="{{ request('search') }}"
                                   class="myinput" placeholder="جستجو">
                            <div class="icon"><i class="mdi mdi-magnify"></i></div>
                        </div>
                    </div>
                </form>

                @foreach($discounts as $discount)
                    <div class="card-info">
                        <h6>
                            {{ $discount->title ?: '---' }}
               <span class="badge @if($discount->status)text-bg-secondary @else text-bg-danger @endif">
                                @if($discount->status)
                       متقضی
                   @else
                       جدید
                   @endif
                            </span>
                        </h6>
                        <div class="date">{{ $discount->end_date ?: '---' }}</div>
                        <div class="discount-code-content">
                            کد تخفیف :
                            <span>{{ $discount->coupon_code ?: '---' }}</span>
                        </div>
                    </div>
                @endforeach

                {{ $discounts->appends(request()->query())->links('web.components.pagination') }}
            </div>
        </div>
    </div>

@endsection


@section('Page_JS')
    <script>
        $('#search_input').on('keydown', function (event) {
            if (event.keyCode == '13') {
                $('#search_form').submit();
            }
        })
    </script>
@endsection
