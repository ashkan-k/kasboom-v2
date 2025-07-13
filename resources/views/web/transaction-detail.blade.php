@extends('layouts.user-panel-master')

@section('Page_Title')
    تراکنش های مالی من
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="grid-main">
        <div class="grid-inner">
            <div class="main-header">
                <div class="title">
                    <h3><i class="mdi mdi-play-circle-outline"></i>جزییات تراکنش</h3>
                </div>
                <div class="btns-action">
                    <a href="{{ route('web.my-transactions') }}"
                       class="btn btn-default-outline btn-sm icon-left">
                        <span class="icon"><i class="mdi mdi-arrow-left"></i></span>
                        <span class="text">بازگشت</span>
                    </a>
                </div>
            </div>
            <div class="main-body">
                <div class="px-md-4 px-3 pb-md-4 pb-3">
                    <div class="main-btns-action">
                        <a href="#" class="btn btn-default icon-right btn-sm">
                            <span class="icon"><i class="mdi mdi-printer"></i></span>
                            <span class="icon">چاپ فاکتور</span>
                        </a>
                    </div>

                    <!-- جزییات تراکنش -->
                    <div class="information-list">
                        <h6 class="title"><i class="mdi mdi-information-outline"></i>جزییات تراکنش</h6>
                        <ul>
                            <li>شماره فاکتور :<span>{{ $transaction->factor_id ?: '---' }}</span></li>
                            <li>نوع خرید :<span>
                                    @if($transaction->payment_for == 'course')
                                        دوره
                                    @else
                                        وبینار
                                    @endif
                                </span></li>
                           <li>عنوان دوره :<span>{{ $transaction->product_course_title ?: '---' }}</span></li>
                             <li>تاریخ خرید :<span>{{ $transaction->regist_date ?: '---' }}</span></li>
                            <li>نام درگاه :<span>{{ $transaction->bankname ?: '---' }}</span></li>
                            <li>کد پیگیری بانک :<span>{{ $transaction->refID ?: '---' }}</span></li>
                        </ul>
                    </div>

                    <!-- مبلغ و تخفیف‌ -->
                    <div class="information-list">
                        <h6 class="title"><i class="mdi mdi-credit-card-outline"></i>مبلغ و تخفیف‌</h6>
                        <ul>
                            <li>مبلغ دوره :<span>{{ number_format($transaction->price) }} تومان</span></li>
                            <li>کد تخفیف :<span>{{ $transaction->discount_code ?: '---' }}</span></li>
                            <li>درصد تخفیف :<span>{{ $transaction->discount_percent ?: '0' }}%</span></li>
                            <li>مبلغ تخفیف :<span>{{ number_format($transaction->discount_price) }}</span></li>
                            <li>مبلغ پرداختی<span>{{ number_format($transaction->payment_price) }} تومان</span></li>
                        </ul>
                    </div>

                    <!-- معرف -->
                    <div class="information-list">
                        <h6 class="title"><i class="mdi mdi-account-outline"></i>سرانه آموزش</h6>
                        <ul>
                            <li>مبلغ سرانه آموزش :<span>{{ number_format($transaction->subsid_price) }} تومان</span></li>
                        </ul>
                    </div>

                    <!-- کیف پول -->
                    <div class="information-list">
                        <h6 class="title"><i class="mdi mdi-wallet-outline"></i>کیف پول</h6>
                        <ul>
                            <li>مبلغ برداشت از کیف پول :<span>{{ number_format($transaction->wallet_price) }} تومان</span></li>
{{--                            <li>مبلغ برداشت از هدیه آموزشی :<span>0 تومان</span></li>--}}
                        </ul>
                    </div>
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
