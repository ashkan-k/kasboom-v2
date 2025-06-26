@extends('layouts.front-master')

@section('Page_Title')
    کسب بوم - مرکز راهنما
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <!-- Page Background -->
    <div class="page-background">
        <div class="text">
            <div class="text-inner">
                <h2>نیاز به راهنمایی دارید؟</h2>
                <h6>مرکز راهنمای سامانه کسب بوم</h6>
            </div>
        </div>
    </div>

    <!-- Help Center -->
    <div class="help-center">
        <div class="container-lg">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card-help">
                        <div class="card-h">
                            <div class="icon">
                                <img src="/assets-v2/images/icons/kasbom-help/register.svg" alt="عضویت"/>
                            </div>
                        </div>
                        <div class="card-b">
                            <h2>عضویت</h2>
                            <p>نحوه عضویت شخصی و سازمانی در سامانه کسب بوم</p>
                        </div>
                        <div class="card-f">
                            <a href="/assets/help/register.pdf" class="btn btn-default icon-right"><i
                                    class="mdi mdi-download-circle-outline"></i>دریافت راهنما</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card-help">
                        <div class="card-h">
                            <div class="icon">
                                <img src="/assets-v2/images/icons/kasbom-help/log-in.svg" alt="ورود"/>
                            </div>
                        </div>
                        <div class="card-b">
                            <h2>ورود</h2>
                            <p>نحوه ورود به حساب کاربری کسب بوم</p>
                        </div>
                        <div class="card-f">
                            <a href="/assets/help/login.pdf" class="btn btn-default icon-right"><i
                                    class="mdi mdi-download-circle-outline"></i>دریافت راهنما</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card-help">
                        <div class="card-h">
                            <div class="icon">
                                <img src="/assets-v2/images/icons/kasbom-help/password.svg" alt="فعال سازی رمز دوم"/>
                            </div>
                        </div>
                        <div class="card-b">
                            <h2>فعال سازی رمز دوم</h2>
                            <p>طریقه فعال سازی رمز دوم برای افزایش امنیت پروفایل کاربری</p>
                        </div>
                        <div class="card-f">
                            <a href="/assets/help/sms.pdf" class="btn btn-default icon-right"><i
                                    class="mdi mdi-download-circle-outline"></i>دریافت راهنما</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card-help">
                        <div class="card-h">
                            <div class="icon">
                                <img src="/assets-v2/images/icons/kasbom-help/learning.svg" alt="خرید دوره آموزشی"/>
                            </div>
                        </div>
                        <div class="card-b">
                            <h2>خرید دوره آموزشی</h2>
                            <p>نحوه خرید و مشاهده دوره آموزشی</p>
                        </div>
                        <div class="card-f">
                            <a href="/assets/help/course.pdf" class="btn btn-default icon-right"><i
                                    class="mdi mdi-download-circle-outline"></i>دریافت راهنما</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="title">
                <h2>پشتیبانی برخط (آنلاین)</h2>
            </div>
            <div class="help-box">
                <p>در پشتیبانی برخط سامانه کسب بوم، هر سوالی که داشتید می توانید با کلیک بر روی دکمه پایین سمت راست،
                    پنجره گفت و گو با پشتیبانان سامانه نمایان می شود و می توانید سوالات خود را به صورت برخط بپرسید.</p>
            </div>
        </div>
    </div>

@endsection


@section('Page_JS')

@endsection
