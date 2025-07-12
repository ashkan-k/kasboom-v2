@extends('layouts.user-panel-master')

@section('Page_Title')
    دوره های من
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="grid-inner">
        <div class="main-header">
            <div class="title">
                <h3><i class="mdi mdi-credit-card-outline"></i>تراکنش‌های مالی</h3>
            </div>
        </div>
        <div class="main-body">
            <div class="px-md-4 px-3 pb-md-4 pb-3">
                <form id="search_form">
                    <div class="profile-search">
{{--                        <select name="order_by" class="form-select" onchange="$('#search_form').submit()"--}}
{{--                                aria-label="advice type">--}}
{{--                            <option value="created_at" selected>جدیدترین</option>--}}
{{--                            <option value="view_count" @if(request('order_by') == 'view_count') selected @endif>بیشترین--}}
{{--                                بازدید--}}
{{--                            </option>--}}
{{--                            --}}{{--                            <option value="3">آخرین بازدید</option>--}}
{{--                        </select>--}}
                        <div class="inputgroup">
                            <input type="text" id="search_input" name="search" value="{{ request('search') }}"
                                   class="myinput" placeholder="جستجو">
                            <div class="icon"><i class="mdi mdi-magnify"></i></div>
                        </div>
                    </div>
                </form>

                @foreach($payments as $row)

                    <div class="card-transaction mb-2">
                        <div class="card-inner">
                            <div class="info">
                                <h6 class="name">{{ $loop->index + 1 }} - خرید {{ $row->product_course_title ?: '---' }}</h6>
                                <ul class="info-list">
                                    <li>شماره فاکتور :<span>{{ $row->factor_id ?: '---' }}</span></li>
                                    <li>تاریخ :<span>{{ $row->regist_date ?: '---' }}</span></li>
                                    <li>مبلغ پرداختی :<span>{{ number_format($row->price) }} تومان</span></li>
                                    <li>کد پیگیری :<span>{{ $row->refID ?: '---' }}</span></li>
                                </ul>
                            </div>
                            <div class="c-footer">
                                <a href="userProfile-transaction-details.html" class="btn-details">جزییات
                                    تراکنش</a>
                            </div>
                        </div>
                    </div>

                @endforeach

                {{ $payments->links('web.components.pagination') }}
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
