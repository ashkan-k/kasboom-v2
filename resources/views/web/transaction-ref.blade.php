@extends('layouts.user-panel-master')

@section('Page_Title')
    تراکنش های کد معرف من
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="grid-main">
        <div class="grid-inner">
            <div class="main-header">
                <div class="title">
                    <h3><i class="mdi mdi-credit-card-outline"></i>تراکنش‌های کد معرف</h3>
                </div>
            </div>
            <div class="main-body">
                <div class="px-md-4 px-3 pb-md-4 pb-3">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 px-md-1">
                            <div class="card-dashboard-info">
                                <a href="#" class="card-inner">
                                    <h5>تعداد معرف</h5>
                                    <p>تعداد نفراتی که دعوت کرده اید</p>
                                    <div class="number">
                                        <span>{{ $refCount }}</span> نفر
                                    </div>
                                    <div class="icon"><i class="mdi mdi-account-group-outline"></i></div>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 px-md-1">
                            <div class="card-dashboard-info">
                                <a href="#" class="card-inner">
                                    <h5>کیف پول</h5>
                                    <p>مانده موجودی کیف پول</p>
                                    <div class="number">
                                        <span>{{ number_format(auth()->user()->wallet) }}</span> تومان
                                    </div>
                                    <div class="icon"><i class="mdi mdi-credit-card-outline"></i></div>
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6 px-md-1">
                            <div class="card-dashboard-info">
                                <a href="#" class="card-inner">
                                    <h5>مجموع فروش</h5>
                                    <p>مبلغ حاصل فروش</p>
                                    <div class="number">
                                        <span>{{ number_format($refPrice) }}</span> تومان
                                    </div>
                                    <div class="icon"><i class="mdi mdi-wallet-outline"></i></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <form id="search_form">
                        <div class="profile-search mt-3">
{{--                            <select name="order_by" class="form-select" onchange="$('#search_form').submit()" aria-label="advice type">--}}
{{--                                <option value="created_at" selected>جدیدترین</option>--}}
{{--                                <option value="view_count" @if(request('order_by') == 'view_count') selected @endif>بیشترین بازدید</option>--}}
{{--                                --}}{{--                            <option value="3">آخرین بازدید</option>--}}
{{--                            </select>--}}
                            <div class="inputgroup">
                                <input type="text" id="search_input" name="search" value="{{ request('search') }}" class="myinput" placeholder="جستجو">
                                <div class="icon"><i class="mdi mdi-magnify"></i></div>
                            </div>
                        </div>
                    </form>

                    @foreach($transactions as $row)

                        <div class="card-transaction mb-2">
                            <div class="card-inner">
                                <div class="info">
                                    <h6 class="name">{{ $loop->index + 1 }} - خرید {{ $row->product_course_title ?: '---' }}</h6>
                                    <ul class="info-list">
                                        <li>شماره فاکتور :<span>{{ $row->factor_id ?: '---' }}</span></li>
                                        <li>تاریخ :<span>{{ $row->regist_date ?: '---' }}</span></li>
                                        <li>مبلغ پرداختی :<span>{{ number_format($row->referral_price) }} تومان</span></li>
                                        <li>کد پیگیری :<span>{{ $row->refID ?: '---' }}</span></li>
                                    </ul>
                                </div>
                                <div class="c-footer">
{{--                                    <a href="userProfile-transaction-details.html" class="btn-details">جزییات--}}
{{--                                        تراکنش</a>--}}
                                </div>
                            </div>
                        </div>

                    @endforeach

                    {{ $transactions->links('web.components.pagination') }}

                </div>
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
