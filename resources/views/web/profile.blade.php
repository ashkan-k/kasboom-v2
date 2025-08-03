@extends('layouts.user-panel-master')

@section('Page_Title')
    پروفایل من
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="grid-inner">
        <div class="main-header">
            <div class="title">
                <h3><i class="mdi mdi-cog-outline"></i>تنظیمات</h3>
            </div>
        </div>
        <div class="main-body">
            <div class="tab-secions">
                <ul class="nav nav-underline nav-profile" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#custom-tab-pane-1" role="tab">
                            <span class="icon"><i class="mdi mdi-pencil-outline"></i></span>
                            <span class="text">تغییر کلمه عبور</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#custom-tab-pane-2" role="tab">
                            <span class="icon"><i class="mdi mdi-map-marker-outline"></i></span>
                            <span class="text">تنظیمات پروفایل</span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="custom-tab-pane-1" role="tabpanel"
                     tabindex="0">
                    <div class="tab-inner px-3 pb-4">
                        <form action="{{route('web.change-password')}}" method="post">
                            @csrf

                            <div class="row align-items-end">
                                <div class="col-lg-7">
                                    <div class="inputgroup">
                                        <input type="password" name="currentPassword" class="myinput" placeholder="رمز عبور فعلی"
                                               autocomplete="on" required>
                                        <label>رمز عبور فعلی</label>
                                        <div class="icon"><i class="mdi mdi-lock-outline"></i></div>

                                        @error('currentPassword')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="inputgroup">
                                        <input type="password" name="newPassword" class="myinput" placeholder="رمز عبور جدید"
                                               autocomplete="on" required>
                                        <label>رمز عبور جدید</label>
                                        <div class="icon"><i class="mdi mdi-lock-outline"></i></div>

                                        @error('newPassword')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="inputgroup">
                                        <input type="password" name="newPassword_confirmation" class="myinput"
                                               placeholder="تکرار رمز عبور جدید" autocomplete="on" required>
                                        <label>تکرار رمز عبور جدید</label>
                                        <div class="icon"><i class="mdi mdi-lock-outline"></i></div>

                                        @error('newPassword_confirmation')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="btns-group mt-4 mb-4 text-center">
                                <button class="btn btn-default icon-right"><i class="mdi mdi-check"></i>ثبت
                                    تغییرات</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-tab-pane-2" role="tabpanel" tabindex="0">
                    <form action="{{ route('web.store-profile') }}" method="post">
                        @csrf

                        <div class="tab-inner px-3 pb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="twostep_auth" @if($user->twostep_auth == 1) checked @endif) value="1" type="checkbox" role="switch" id="switch-1">
                                <label class="form-check-label" for="switch-1">
                                    فعال سازی رمز دوم پیامکی
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="view_phone" @if($user->view_phone == 1) checked @endif value="1" type="checkbox" role="switch" id="switch-2">
                                <label class="form-check-label" for="switch-2">
                                    نمایش شماره موبایل دوم در پروفایل
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="view_email" @if($user->view_email == 1) checked @endif value="1" type="checkbox" role="switch" id="switch-3">
                                <label class="form-check-label" for="switch-3">
                                    نمایش ایمیل و وب سایت در پروفایل
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="view_socialnetworks" @if($user->view_socialnetworks == 1) checked @endif value="1" type="checkbox" role="switch" id="switch-4">
                                <label class="form-check-label" for="switch-4">
                                    نمایش آدرس شبکه های اجتماعی در پروفایل
                                </label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" name="view_chat" @if($user->view_chat == 1) checked @endif value="1" type="checkbox" role="switch" id="switch-5">
                                <label class="form-check-label" for="switch-5">
                                    فعال سازی چت و گفتگو
                                </label>
                            </div>
                        </div>

                        <div class="btns-group mt-4 mb-4 text-center">
                            <button class="btn btn-default icon-right"><i class="mdi mdi-check"></i>ثبت
                                تغییرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ToastMessage --}}
    <div id="toastmessage-content"></div>

@endsection


@section('Page_JS')
    @if (session()->has('chang_password_success'))
        <script>
            toastMessage('موفق', '{{ session('chang_password_success') }}', 'success');
        </script>
    @endif
    @if (session()->has('profile_setting_success'))
        <script>
            toastMessage('موفق', '{{ session('profile_setting_success') }}', 'success');
        </script>
    @endif
@endsection
