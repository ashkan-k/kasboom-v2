@extends('layouts.front-master')

@section('Page_Title')
آموزشگاه کسبوم - ثبت نام وبینار آموزشی
@endsection

@section('Page_CSS')

@endsection

@section('Content')

<!-- Factor Content ==> success , error -->
<div class="factor-content" style="margin-top: 170px !important;">
  <div class="container">
    <div class="factor-inner">
      <div class="factor-title">
        <h2>پیش فاکتور ثبت نام وبینار آموزشی</h2>
      </div>
      <div class="factor-name">
        <h4>{{$webinar->title}}</h4>
      </div>
      <form action="skill/webinar/webinar_payment" method="post">
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
              <span class="name">هزینه ثبت نام</span>
              <span class="desc">
                {{$webinar->price>0 ? number_format($webinar->price)." تومان ": "رایگان"}}
              </span>
              <input type="hidden" name="id_webinar" value="{{$webinar->id}}" readonly>
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
          <ul class="list">
            <li>
              <span class="name">درصد و مبلغ تخفیف</span>
              <span class="desc" id="discount_pay">0<small class="toman">تومان</small></span>
            </li>
            @if ($subsid > 0 && auth()->user()->corp=='howzeh')
            <li>
              <span class="name">یارانه آموزشی قابل استفاده در این وبینار</span>
              <span class="desc" id="subsid">{{ number_format($subsid) }} <small class="toman">تومان</small></span>
            </li>
            @endif
            <li>
              <span class="name">موجودی کیف پول</span>
              <span class="desc">{{$wallet != null ? number_format($wallet)." تومان " : 0}} </span>
              <input id="wallet_price" type="hidden" readonly value="{{$wallet != null ? $wallet : 0}}">
            </li>
            <li>
              <span class="name">مبلغ نهایی پرداخت</span>

              <span class="desc" id="final_price">
                {{ ($final_price > 0 and $wallet <= $final_price) ? number_format($final_price - $wallet)." تومان " : "رایگان"}}
              </span>
            </li>
          </ul>
          <div class="pay-option">
            <div class="descount-title">نوع پرداخت</div>
            <div class="radio-group">
              @if($wallet >= $final_price)
              <div class="form-check" id="div_wallet">
                <input class="form-check-input" type="radio" name="payment_type" id="payment_type_wallet" value="wallet" checked />
                <label class="form-check-label" for="payment_type_wallet">
                  <img src="/assets-v2/images/wallet.svg" alt="کیف پول مجازی" />
                  <span>پرداخت با کیف پول</span>
                </label>
              </div>
              @else
              <div class="form-check" id="div_online">
                <input class="form-check-input" type="radio" name="payment_type" id="payment_type_online" value="online" />
                <label class="form-check-label" for="payment_type_online">
                  <img src="/assets-v2/images/zarinpal.svg" alt="درگاه زرین پال" />
                  <span>
                    <span> پرداخت با زرین پال با کسر کیف پول: </span>&nbsp;<span id="wallet-online" style="color: red">{{number_format($final_price - $wallet)}}</span> تومان
                  </span>
                </label>
              </div>
              @endif
            </div>
          </div>
          <div class="factor-footer">
            @if($final_price == 0)
            <button type="submit" class="btn btn-gradient icon-right"><i class="mdi mdi-credit-card-outline"></i>ثبت نام رایگان وبینار</button>
            @else
            <button type="submit" class="btn btn-gradient icon-right"><i class="mdi mdi-credit-card-outline"></i>پرداخت و ثبت نهایی</button>
            @endif
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection


@section('Page_JS')
<script>
  wallet = {
    {
      $wallet
    }
  };
  $(document).ready(function() {
    webinar_price = {
      {
        $final_price
      }
    };
  });
  @if($wallet >= $final_price)
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
