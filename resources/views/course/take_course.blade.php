@extends('layouts.front-master')

@section('Page_Title')
آموزشگاه کسب بوم - ثبت نام دوره آموزشی
@endsection

@section('Page_CSS')

@endsection

@section('Content')

<!-- Factor Content ==> success , error -->
<div class="factor-content">
  <div class="container">
    <div class="factor-inner" style="margin-top: 200px !important;">
      <div class="factor-title">
        <h2>پیش فاکتور ثبت نام دوره آموزشی</h2>
      </div>
      <div class="factor-name">
        <h4>{{$course->title}}</h4>
      </div>
      <form action="course/course_payment" method="post">
        {{csrf_field()}}

        <div class="factor-body">
          <ul class="list">
            <li>
              <span class="name">تاریخ صدرو پیش فاکتور</span>
              <span class="desc">{{$nowdate_shamsi}}</span>
            </li>
            <li>
              <span class="name">نام و نام خانوادگی شرکت کننده</span>
              <span class="desc"> {{$user_name}}</span>
            </li>
            <li>
              <span class="name">وضعیت پرداخت</span>
              <span class="desc error">پرداخت نشده</span>
            </li>
            <li>
              <span class="name">هزینه دوره</span>
              <span class="desc">
                {{$course->price>0 ? number_format($course->price)." تومان ": "رایگان"}}
              </span>
              <input type="hidden" name="id_course" value="{{$course->id}}" readonly>
            </li>
          </ul>
          <div class="discount-code">
            <div class="descount-title">کد تخفیف دارید؟</div>
            <form action="">
              <div class="discount-form">
                <div class="search-input">
                  <input type="text" class="input" id="discount" maxlength="15" name="discount" placeholder="کد تخفیف را وارد کنید">
                </div>
                <div class="search-button">
                  <input type="hidden" value="course" id="discount_type" readonly disabled>
                  <button type="button" class="btn btn-green anim-2s" id="btn_discount"> اعمال تخفیف </button>
                </div>
              </div>
            </form>
          </div>
          <div class="discount-code">
            <div class="descount-title">کد معرف</div>
            <div class="discount-form">
              <div class="search-input">
                <input type="text" class="input" id="referral" maxlength="15" name="referral" placeholder="کد معرف را وارد کنید">
              </div>
            </div>
          </div>
          <ul class="list">
            <li>
              <span class="name">درصد و مبلغ تخفیف</span>
              <span class="desc" id="discount_pay">0<small class="toman">تومان</small></span>
            </li>
            <li>
              <span class="name">موجودی کیف پول</span>
              <span class="desc">{{$wallet != null ? number_format($wallet)." تومان " : 0}} </span>
              <input id="wallet_price" type="hidden" readonly value="{{$wallet != null ? $wallet : 0}}">
            </li>
            @if ($subsid > 0)
            <li>
              <span class="name">یارانه آموزشی قابل استفاده در این دوره</span>
              <span class="desc" id="subsid">{{ number_format($subsid) }} <small class="toman">تومان</small></span>

            </li>
            @endif
            <input id="subsid_price" type="hidden" readonly value="{{$subsid != null ? $subsid   : 0}}">

            <li>
              <span class="name" style="color: red"> مبلغ نهایی پرداخت با کسر کیف پول</span>

              <span class="desc" id="final_price" style="color: red">
                @if(($wallet+$subsid)>$course->price)
                0 تومان
                @else
                {{$course->price>0 ? number_format($course->price-$wallet-$subsid)." تومان " : "رایگان"}}
                @endif
              </span>
            </li>
          </ul>
          <div class="pay-option">
            <div class="descount-title">نوع پرداخت</div>

            <div class="radio-group">
              <div class="form-check" id="div_wallet">
                <input class="form-check-input" type="radio" name="payment_type" id="payment_type_wallet" value="wallet" checked />
                <label class="form-check-label" for="payment_type_wallet">
                  <img src="/assets-v2/images/wallet.svg" alt="کیف پول مجازی" />
                  <span>پرداخت با کیف پول</span>
                </label>
              </div>

              <div class="form-check" id="div_online">
                <input class="form-check-input" type="radio" name="payment_type" id="payment_type_online" value="online" />
                <label class="form-check-label" for="payment_type_online">
                  <img src="/assets-v2/images/zarinpal.svg" alt="درگاه زرین پال" />
                  <span>
                    @if($wallet+$subsid>0)
                    <span> پرداخت با درگاه آنلاین زرین پال با کسر کیف پول: </span>&nbsp;<span id="wallet-online" style="color: red">{{number_format($course->price - $wallet-$subsid)}}</span> تومان
                    @else
                    <span> پرداخت با درگاه آنلاین زرین پال </span>&nbsp;
                    @endif
                  </span>
                </label>
              </div>
            </div>
          </div>
          <div class="factor-footer">
            <button type="submit" class="btn btn-gradient icon-right"><i class="mdi mdi-credit-card-outline"></i>پرداخت آنلاین و ثبت نهایی</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection


@section('Page_JS')
<script>
  wallet = {{($wallet + $subsid)}};
  $(document).ready(function() { course_price = {{$course->price}}; });
  @if(($wallet + $subsid) >= $course->price)
  $("#div_wallet").show();
  $("#div_online").hide();
  $("#payment_type_wallet").prop("checked", true);
  @else
  $("#div_wallet").hide();
  $("#div_online").show();
  $("#payment_type_online").prop("checked", true);
  @endif
</script>
@endsection
