@extends('layouts.front-master')

@section('Page_Title')
    همکاری با کسب بوم - پیشنهاد تهیه محتوی آموزشی
@endsection


@section('Page_CSS')

@endsection


@section('Content')

    <!-- Page Background -->
    <div class="page-background">
        <div class="text">
            <div class="text-inner">
                <h2>فرم درخواست</h2>
                <h6>موارد خواسته شده را وارد کنید</h6>
            </div>
        </div>
    </div>


    <!-- Work With Us -->
    <div class="public-section pt-4 pb-2">
        <div class="container-lg">
            <div class="section-inner min-width bg-gray">
                @if(! Auth::check())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        برای ثبت پیشنهاد باید ابتدا وارد حساب کاربری خود شوید
                    </div>
                @endif
                <div class="form-group">
                    <p id="message" class="label-success text-white text-center"></p>
                </div>
                <form action="">
                    <div class="form-inner">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="inputgroup">
                                    <p id="message" class="label-success text-white text-center"></p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="inputgroup">
                                    <input type="text" maxlength="200" id="title" placeholder="عنوان دوره آموزشی"
                                           class="myinput" autocomplete="off">
                                    <label>عنوان دوره آموزشی</label>
                                    <div class="icon"><i class="mdi mdi-face-profile"></i></div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="inputgroup">
                                    <input type="text" id="category" maxlength="50"
                                           placeholder="گروه آموزشی : ( صنایع دستی- طیور و ...)" class="myinput"
                                           autocomplete="off">
                                    <label>گروه آموزشی </label>
                                    <div class="icon"><i class="mdi mdi-numeric"></i></div>
                                </div>
                            </div>
                            {{--            <div class="col-lg-6 col-md-6 col-sm-12">--}}
                            {{--              <div class="inputgroup">--}}
                            {{--                <input type="number" id="minimal_fund" maxlength="15" placeholder="کف سرمایه - به تومان" class="myinput" autocomplete="off">--}}
                            {{--                <label>کف سرمایه</label>--}}
                            {{--                <div class="icon"><i class="mdi mdi-phone"></i></div>--}}
                            {{--              </div>--}}
                            {{--            </div>--}}
                            {{--            <div class="col-lg-6 col-md-6 col-sm-12">--}}
                            {{--              <div class="inputgroup">--}}
                            {{--                <input type="number" id="manpower" maxlength="12" placeholder="تعداد نیروی انسانی" class="myinput" autocomplete="off">--}}
                            {{--                <label>تعداد نیروی انسانی</label>--}}
                            {{--                <div class="icon"><i class="mdi mdi-pencil"></i></div>--}}
                            {{--              </div>--}}
                            {{--            </div>--}}
                            {{--            <div class="col-lg-6 col-md-6 col-sm-12">--}}
                            {{--              <select class="form-select" id="risk">--}}
                            {{--                <option value="پایین" selected>پایین</option>--}}
                            {{--                <option value="متوسط">متوسط</option>--}}
                            {{--                <option value="زیاد">زیاد</option>--}}
                            {{--                <option value="خیلی زیاد">خیلی زیاد</option>--}}
                            {{--              </select>--}}
                            {{--            </div>--}}
                            {{--            <div class="col-lg-6 col-md-6 col-sm-12">--}}
                            {{--              <select class="form-select" id="profitability">--}}
                            {{--                <option value="کوتاه مدت" selected>کوتاه مدت</option>--}}
                            {{--                <option value="میان مدت">میان مدت</option>--}}
                            {{--                <option value="بلند مدت">بلند مدت</option>--}}
                            {{--              </select>--}}
                            {{--            </div>--}}

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <select class="form-select" id="state">
                                    <option selected disabled>انتخاب استان</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state['id'] }}">{{ $state['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <div class="textarea-group grey">
                                    <textarea class="textarea" id="memo" cols="30" rows="4"
                                              placeholder="توضیحات بیشتر در صورت نیاز...." required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="send-request">
                            @if(Auth::check())
                                <button type="button" id="btn_regist_course_suggestion"
                                        class="btn btn-gradient icon-right"><i class="mdi mdi-send-outline"></i>ارسال
                                    پیشنهاد
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary icon-right" readonly="" disabled=""
                                        style="cursor: not-allowed"><i class="mdi mdi-send-outline"></i>برای ثبت پیشنهاد
                                    وارد سایت شوید
                                </button>
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
        $("#message").hide();
    </script>

@endsection
