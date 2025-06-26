@extends('layouts.front-master')

@section('Page_Title')
    کسبوم - فاکتور پرداخت
@endsection

@section('Page_CSS')

@endsection

@section('Content')
    <br>
    <br>
    <!-- Factor Content ==> success , error -->
    @if($payment->status==1)
        <div class="factor-content success">
            @else
                <div class="factor-content error">
                    @endif
                    <div class="container">
                        <div class="factor-inner">
                            <div class="factor-title">
                                <h2> فاکتور ثبت نام دوره آموزشی</h2>
                            </div>
                            <div class="factor-name">
                                <h4>{{$payment->product_course_title}}</h4>
                            </div>
                            <div class="factor-body">
                                <ul class="list">
                                    <li>
                                        <span class="name">شماره فاکتور</span>
                                        <span class="desc">{{$payment->factor_id}}</span>
                                    </li>
                                    <li>
                                        <span class="name">تاریخ صدرو پیش فاکتور</span>
                                        <span class="desc">{{$payment->regist_date}}</span>
                                    </li>
                                    <li>
                                        <span class="name">نام و نام خانوادگی پرداخت کننده</span>
                                        <span class="desc"> {{Auth::user()->name}}</span>
                                    </li>
                                    <li>
                                        <span class="name">وضعیت پرداخت</span>
                                        @if($payment->status==1)
                                            @if($payment->price>0)
                                                <span class="desc success">پرداخت شده</span>
                                            @else
                                                <span class="desc success">ثبت نام رایگان</span>
                                            @endif
                                        @else
                                            <span class="desc error">پرداخت نشده</span>
                                        @endif
                                    </li>
                                    <li>
                                        <span class="name">هزینه ثبت نام</span>
                                        <span class="desc">
                {{$payment->price>0 ? number_format($payment->price)." تومان ": "رایگان"}}
              </span>
                                    </li>
                                    <li>
                                        <span class="name">کد رهگیری پرداخت</span>
                                        <span class="desc">
                {{$payment->refID}}
              </span>
                                    </li>
                                    <li>
                                        <span class="name">درگاه پرداخت</span>
                                        <span class="desc">
                {{$payment->bankname}}
              </span>
                                    </li>
                                </ul>
                                <ul class="list">
                                    <li>
                                        <span class="name">کد تخفیف</span>
                                        <span class="desc"> {{$payment->discount_code}} </span>
                                    </li>
                                    <li id="tr_discount">
                                        <span class="name">درصد و مبلغ تخفیف</span>
                                        <span class="desc">{{$payment->discount_percent}} درصد برابر با {{number_format($payment->discount_price)}}<small
                                                class="toman">تومان</small></span>
                                    </li>
                                    <li>
                                        <span class="name">مبلغ نهایی پرداخت</span>
                                        <span class="desc">
                {{$payment->payment_price>0 ? number_format($payment->payment_price)." تومان " : "رایگان"}}
              </span>
                                    </li>
                                    <li>
                                        <span class="name">موجودی کیف پول</span>
                                        <span
                                            class="desc">{{Auth::user()->wallet>0 ? number_format(Auth::user()->wallet)." تومان " : 0}} </span>
                                    </li>
                                    <li>
                                        <span class="name">یارانه آموزشی</span>
                                        <span
                                            class="desc">{{Auth::user()->subsid>0 ? number_format(Auth::user()->subsid)." تومان " : 0}} </span>
                                    </li>
                                    <li>
                                        <span class="name">وضعیت پرداخت</span>
                                        @if($payment->status ==0)
                                            <span class="desc error">پرداخت ناموفق</span>
                                        @elseif($payment->status ==1)
                                            @if($payment->price>0)
                                                <span class="desc success">پرداخت موفق</span>
                                            @else
                                                <span class="desc success">ثبت نام رایگان دوره</span>
                                                @endif
                                                @endif
                                                </span>
                                    </li>
                                </ul>
                                <div class="factor-footer">
                                    @if($payment->status ==1)
                                        <a href="web/learning/learningDetails/{{$payment->id_target}}"
                                           class="btn btn-gradient icon-right"><i
                                                class="mdi mdi-credit-card-outline"></i> شروع یادگیری مهارت</a>
                                    @endif
                                    <button type="button" class="btn btn-info" onClick="javascript:window.print();"><i
                                            class="fa fa-file-pdf-o"></i>دریافت فایل pdf
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

@endsection


@section('Page_JS')

@endsection
