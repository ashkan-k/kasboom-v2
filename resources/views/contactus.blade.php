@extends('layouts.front-master')

@section('Page_Title')
    کسب بوم - ارتباط با ما
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <!-- Page Background -->
    <div class="page-background">
        <div class="text">
            <div class="text-inner">
                <h2>تماس با ما</h2>
                <h6>جهت تماس با ما و بیان مسئله، نقد، نظر، انتقاد و پیشنهاد از فرم زیر استفاده نمائید تا کارشناسان ما در
                    اسرع وقت نسبت به بررسی موضوع ارسالی اقدام نمایند</h6>
            </div>
        </div>
    </div>

    <!-- Contact Us -->
    <div class="contact-us">
        <div class="container">
            <div class="contact-details">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="title">
                            <p>کسب بوم؛ با هدف توانمند سازی کسب و کارهای بومی ، سامانه ای جامع راه اندازی نموده است تا
                                علاقه مندان به حوزه کارآفرینی با عضویت در این سامانه بتوانند حرفه و مهارتی را آموزش
                                ببینند و شروع به کسب درامد نمایند. </p>
                        </div>
                        <div class="form-request">
                            <form action="contact" method="post" class="card-body" tabindex="500">
                                {{csrf_field()}}
                                @if($message)
                                    <p class="badge-danger text-center text-danger">{{$message}}</p>
                                @endif
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="inputgroup grey">
                                            <input type="text" name="fullname" class="myinput"
                                                   placeholder="نام و نام خانوادگی" autocomplete="on" required/>
                                            <label>نام و نام خانوادگی</label>
                                            <div class="icon"><i class="mdi mdi-account-outline"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="inputgroup grey">
                                            <input type="email" name="email" class="myinput"
                                                   placeholder="ایمیل (اختیاری)" autocomplete="on" required/>
                                            <label>ایمیل (اختیاری)</label>
                                            <div class="icon"><i class="mdi mdi-email-outline"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="inputgroup grey">
                                            <input type="number" name="tel" class="myinput"
                                                   placeholder="شماره موبایل (اختیاری)" autocomplete="on" required/>
                                            <label>شماره موبایل (اختیاری)</label>
                                            <div class="icon"><i class="mdi mdi-phone-outline"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="inputgroup grey">
                                            <input type="text" name="subject" class="myinput" placeholder="موضوع پیام"
                                                   autocomplete="on" required/>
                                            <label>موضوع پیام</label>
                                            <div class="icon"><i class="mdi mdi-pencil-outline"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="textarea-group grey">
                                            <textarea class="textarea" cols="30" name="memo" rows="4"
                                                      placeholder="پیام خود را بنویسید..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" required type="checkbox" value="" id="checkbox-01"/>
                                    <label class="form-check-label" for="checkbox-01">قوانین و شرایط را می پذیرم و صحت
                                        اطلاعات وارده را تایید میکنم</label>
                                </div>
                                <div class="send-request">
                                    <button type="submit" class="btn btn-default icon-right"><i
                                            class="mdi mdi-send"></i>ارسـال پیـام
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="map-content">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1911.3090304950445!2d50.04126558532808!3d36.32622828797546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f8b556b1dd64bbd%3A0xec9c537352c20416!2sQazvin%20Science%20%26%20Technology%20Park!5e0!3m2!1sen!2s!4v1609148984187!5m2!1sen!2s"
                                allowfullscreen="" aria-hidden="true" tabindex="0"></iframe>
                        </div>
                        <div class="address">
                            <span>آدرس : </span>
                            قزوین پارک علم و فن آوری ساختمان دکتر صالحی طبقه اول واحد 120
                        </div>
                        <div class="list-of-call">
                            <div class="item">
                                <div class="icon"><i class="mdi mdi-phone-outline"></i></div>
                                <div class="desc"><span class="titr">تلفن : </span>028-33694208</div>
                            </div>
                            <div class="item">
                                <div class="icon"><i class="mdi mdi-school-outline"></i></div>
                                <div class="desc"><span class="titr">واحد آموزش : </span>028-33694208</div>
                            </div>
                            <div class="item">
                                <div class="icon"><i class="mdi mdi-wallet-outline"></i></div>
                                <div class="desc"><span class="titr">واحد مالی : </span>028-33694208</div>
                            </div>
                            <div class="item">
                                <div class="icon"><i class="mdi mdi-shopping-outline"></i></div>
                                <div class="desc"><span class="titr">واحد فروش : </span>028-33694208</div>
                            </div>
                            <div class="item">
                                <div class="icon"><i class="mdi mdi-face-agent"></i></div>
                                <div class="desc"><span class="titr">واحد پشتیبانی (ارسال پیام در ایتا) : </span>09918892281
                                </div>
                            </div>
                            <div class="item">
                                <div class="icon"><i class="mdi mdi-web"></i></div>
                                <div class="desc"><span class="titr">آدرس اینترنتی سامانه : </span>www.Kasboom.ir
                                </div>
                            </div>
                            <div class="item">
                                <div class="icon"><i class="mdi mdi-email-outline"></i></div>
                                <div class="desc"><span class="titr">پست الکترونیکی مرکز : </span>info@kasboom.ir
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('Page_JS')

@endsection
