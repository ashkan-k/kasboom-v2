@extends('layouts.user-panel-master')

@section('Page_Title')
    تدریس در کسبوم
@endsection

@section('Page_CSS')
@endsection

@section('Content')

    <div class="grid-inner">
        <div class="main-header">
            <div class="title">
                <h3><i class="mdi mdi-handshake-outline"></i>تدریس در کسبوم</h3>
            </div>
        </div>
        <div class="main-body">
            <form action="{{ route('web.invite-teacher-store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="px-md-4 px-3 pb-md-4 pb-3">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                            <div class="inputgroup mt-0 mb-4">
                                <input name="fullname" type="text" class="myinput" placeholder="نام و نام خانوادگی"
                                       value=" @if(old('fullname')){{ old('fullname') }}@elseif(isset($object->fullname)){{ $object->fullname }}@endif"
                                       required
                                       autocomplete="on">
                                <label>نام و نام خانوادگی</label>
                                <div class="icon"><i class="mdi mdi-pencil-outline"></i></div>

                                @error('fullname')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                            <div class="inputgroup mt-0 mb-4">
                                <input name="tel" type="text" class="myinput" placeholder="شماره ثابت"
                                       value=" @if(old('tel')){{ old('tel') }}@elseif(isset($object->tel)){{ $object->tel }}@endif"
                                       required
                                       autocomplete="on">
                                <label>شماره ثابت</label>
                                <div class="icon"><i class="mdi mdi-phone"></i></div>

                                @error('tel')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                            <div class="inputgroup mt-0 mb-4">
                                <input name="phonenumber" type="text" class="myinput" placeholder="تلفن همراه"
                                       value=" @if(old('phonenumber')){{ old('phonenumber') }}@elseif(isset($object->phonenumber)){{ $object->phonenumber }}@endif"
                                       required
                                       autocomplete="on">
                                <label>تلفن همراه</label>
                                <div class="icon"><i class="mdi mdi-phone"></i></div>

                                @error('phonenumber')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                            <div class="select-group mt-0 mb-4">
                                <select required name="madrak" class="form-select mt-0" aria-label="advice type">
                                    <option value="" selected disabled>آخرین وضعیت تحصیلی</option>
                                    <option @if((isset($object) && $object->madrak == 'دیپلم') || old('madrak') == 'دیپلم') selected @endif value="دیپلم">دیپلم</option>
                                    <option @if((isset($object) && $object->madrak == 'دانشجوی کاردانی') || old('madrak') == 'دانشجوی کاردانی') selected @endif value="دانشجوی کاردانی">دانشجوی کاردانی</option>
                                    <option @if((isset($object) && $object->madrak == 'فارغ‌ التحصیل کاردانی') || old('madrak') == 'فارغ‌ التحصیل کاردانی') selected @endif value="فارغ‌ التحصیل کاردانی">فارغ‌ التحصیل کاردانی</option>
                                    <option @if((isset($object) && $object->madrak == 'فارغ‌ التحصیل دکترا') || old('madrak') == 'فارغ‌ التحصیل دکترا') selected @endif value="فارغ‌ التحصیل دکترا">فارغ‌ التحصیل دکترا</option>
                                    <option @if((isset($object) && $object->madrak == 'دانشجوی دکترا') || old('madrak') == 'دانشجوی دکترا') selected @endif value="دانشجوی دکترا">دانشجوی دکترا</option>
                                    <option @if((isset($object) && $object->madrak == 'فارغ‌ التحصیل کارشناسی ارشد') || old('madrak') == 'فارغ‌ التحصیل کارشناسی ارشد') selected @endif value="فارغ‌ التحصیل کارشناسی ارشد">فارغ‌ التحصیل کارشناسی ارشد</option>
                                    <option @if((isset($object) && $object->madrak == 'دانشجوی کارشناسی ارشد') || old('madrak') == 'دانشجوی کارشناسی ارشد') selected @endif value="دانشجوی کارشناسی ارشد">دانشجوی کارشناسی ارشد</option>
                                    <option @if((isset($object) && $object->madrak == 'فارغ‌ التحصیل کارشناسی') || old('madrak') == 'فارغ‌ التحصیل کارشناسی') selected @endif value="فارغ‌ التحصیل کارشناسی">فارغ‌ التحصیل کارشناسی</option>
                                    <option @if((isset($object) && $object->madrak == 'دانشجوی کارشناسی') || old('madrak') == 'دانشجوی کارشناسی') selected @endif value="دانشجوی کارشناسی">دانشجوی کارشناسی</option>
                                </select>

                                @error('madrak')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                            <div class="inputgroup mt-0 mb-4">
                                <input name="reshte" type="text" class="myinput" placeholder="رشته تحصیلی (آخرین وضعیت تحصیلی)"
                                       value=" @if(old('reshte')){{ old('reshte') }}@elseif(isset($object->reshte)){{ $object->reshte }}@endif"
                                       required
                                       autocomplete="on">
                                <label>رشته تحصیلی (آخرین وضعیت تحصیلی)</label>
                                <div class="icon"><i class="mdi mdi-text-subject"></i></div>

                                @error('reshte')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                            <div class="inputgroup mt-0 mb-4">
                                <input name="daneshgah" type="text" class="myinput" placeholder="دانشگاه محل تحصیل"
                                       value=" @if(old('daneshgah')){{ old('daneshgah') }}@elseif(isset($object->daneshgah)){{ $object->daneshgah }}@endif"
                                       required
                                       autocomplete="on">
                                <label>دانشگاه محل تحصیل</label>
                                <div class="icon"><i class="mdi mdi-text-subject"></i></div>

                                @error('daneshgah')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                            <div class="inputgroup mt-0 mb-4">
                                <input name="birthdate" type="text" class="myinput" placeholder="تاریخ تولد"
                                       value=" @if(old('birthdate')){{ old('birthdate') }}@elseif(isset($object->birthdate)){{ $object->birthdate }}@endif"
                                       required
                                       autocomplete="on">
                                <label>تاریخ تولد</label>
                                <div class="icon"><i class="mdi mdi-text-subject"></i></div>

                                @error('birthdate')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                            <div class="select-group mt-0 mb-4">
                                <select required name="id_state" class="form-select mt-0" aria-label="advice type">
                                    <option value="" selected disabled>استان</option>

                                    @foreach($states as $state)
                                        <option @if((isset($object) && $object->id_state == $state->id) || old('id_state') == $state->id) selected @endif value="{{ $state->id ?: '---' }}">{{ $state->name ?: '---' }}</option>
                                    @endforeach
                                </select>

                                @error('id_state')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                            <div class="select-group mt-0 mb-4">
                                <select required name="id_city" class="form-select mt-0" aria-label="advice type">
                                    <option value="" selected disabled>شهر</option>

                                    @foreach($states as $state)
                                        <option @if((isset($object) && $object->id_city == $state->id) || old('id_city') == $state->id) selected @endif value="{{ $state->id ?: '---' }}">{{ $state->name ?: '---' }}</option>
                                    @endforeach
                                </select>

                                @error('id_city')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="col-12">
                            <div class="my-3">
                                <h6 class="fw-bold fs-6">وابستگی سازمانی، دانشگاهی، صنعتی یا شرکتی</h6>
                                <p class="fw-normal fs-8">لطفا وابستگی سازمانی، دانشگاهی، صنعتی یا شرکتی خود
                                    را
                                    (هیأت
                                    علمی، متخصص در صنعت، فعال در بخش خصوصی شرکت‌ها، دانشجو،
                                    فریلنسر و...) وارد کنید (حداکثر دو مورد). در صوت نداشتن وابستگی سازمانی
                                    فعلی، می‌توانید این بخش را خالی بگذارید.</p>
                                {{--                            <div class="text-right">--}}
                                {{--                                <button class="btn btn-default icon-right"><i--}}
                                {{--                                        class="mdi mdi-plus"></i>اضافه کردن</button>--}}
                                {{--                            </div>--}}
                                <div class="item-section">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="inputgroup nopadding simple-label mt-0 mb-3">
                                                <label>نام سازمان، دانشگاه، شرکت صنعتی، فناوری و
                                                    خصوصی</label>
                                                <input name="company_name_1" type="text" class="myinput" placeholder=""
                                                       value="@if(old('company_name_1')){{ old('company_name_1') }}@elseif(isset($object->company_name_1)){{ $object->company_name_1 }}@endif"
                                                       autocomplete="on">

                                                @error('company_name_1')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="inputgroup nopadding simple-label mt-0 mb-3">
                                                <label>موقعیت و نوع همکاری</label>
                                                <input name="company_type_work_1" type="text" class="myinput" placeholder=""
                                                       value="@if(old('company_type_work_1')){{ old('company_type_work_1') }}@elseif(isset($object->company_type_work_1)){{ $object->company_type_work_1 }}@endif"
                                                       autocomplete="on">

                                                @error('company_type_work_1')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="inputgroup nopadding simple-label mt-0 mb-3">
                                                <label>نام سازمان، دانشگاه، شرکت صنعتی، فناوری و
                                                    خصوصی</label>
                                                <input name="company_name_2" type="text" class="myinput" placeholder=""
                                                       value="@if(old('company_name_2')){{ old('company_name_2') }}@elseif(isset($object->company_name_2)){{ $object->company_name_2 }}@endif"
                                                       autocomplete="on">

                                                @error('company_name_2')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="inputgroup nopadding simple-label mt-0 mb-3">
                                                <label>موقعیت و نوع همکاری</label>
                                                <input name="company_type_work_2" type="text" class="myinput" placeholder=""
                                                       value="@if(old('company_type_work_2')){{ old('company_type_work_2') }}@elseif(isset($object->company_type_work_2)){{ $object->company_type_work_2 }}@endif"
                                                       autocomplete="on">

                                                @error('company_type_work_2')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="my-3">
                                <h6 class="fw-bold fs-6">اطلاعات مرتبط با آموزش</h6>
                                <p class="fw-normal fs-8">لطفا عناوین آموزش‌هایی را که تمایل به ارائه آن‌ها
                                    در کسبوم دارید؛ در جدول زیر وارد کنید.</p>
                                <div class="item-section">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="select-group mt-0 mb-3">
                                                <select class="form-select mt-0" aria-label="advice type">
                                                    <option value="0" selected disabled>تخصص
                                                    </option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>

                                                @error('id_cat_mega_1')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="select-group mt-0 mb-3">
                                                <select class="form-select mt-0" aria-label="advice type">
                                                    <option value="0" selected disabled>تخصص
                                                    </option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>

                                                @error('id_cat_middle_1')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="select-group mt-0 mb-3">
                                                <select class="form-select mt-0" aria-label="advice type">
                                                    <option value="0" selected disabled>تخصص
                                                    </option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>

                                                @error('id_cat_sub_1')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="select-group mt-0 mb-3">
                                                <select class="form-select mt-0" aria-label="advice type">
                                                    <option value="0" selected disabled>تخصص
                                                    </option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>

                                                @error('id_cat_mega_2')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="select-group mt-0 mb-3">
                                                <select class="form-select mt-0" aria-label="advice type">
                                                    <option value="0" selected disabled>تخصص
                                                    </option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>

                                                @error('id_cat_middle_2')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="select-group mt-0 mb-3">
                                                <select class="form-select mt-0" aria-label="advice type">
                                                    <option value="0" selected disabled>تخصص
                                                    </option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>

                                                @error('id_cat_sub_2')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    @error('category_error')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="col-12">
                            <div class="my-3">
                                <h6 class="fw-bold fs-6">سابقه تهیه محتوای متنی یا آموزش ویدئویی</h6>
                                <p class="fw-normal fs-8">اگر تاکنون محتوای متنی (کتاب، مقاله، نوشته وبلاگ
                                    و...) و یا ویدئوی آموزشی تالیف و منتشر کرده‌اید که مرتبط با موضوعات
                                    تدریسی شما هست؛ آن‌ها را در ادامه لیست نمایید.</p>
                                <div class="item-section">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="inputgroup nopadding simple-label mt-0 mb-3">
                                                <label>عنوان</label>
                                                <input name="history_title_1" type="text" class="myinput" placeholder=""
                                                       value="@if(old('history_title_1')){{ old('history_title_1') }}@elseif(isset($object->history_title_1)){{ $object->history_title_1 }}@endif"
                                                       autocomplete="on">

                                                @error('history_title_1')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="select-group mt-0 mb-3">
                                                <select name="history_type_1" class="form-select mt-0" aria-label="advice type">
                                                    <option value="" selected disabled>نوع سند
                                                    </option>
                                                    <option @if((isset($object) && $object->history_type_1 == 'آموزش ویدئویی') || old('history_type_1') == 'آموزش ویدئویی') selected @endif value="آموزش ویدئویی">آموزش ویدئویی</option>
                                                    <option @if((isset($object) && $object->history_type_1 == 'مقاله فارسی') || old('history_type_1') == 'مقاله فارسی') selected @endif value="مقاله فارسی">مقاله فارسی</option>
                                                    <option @if((isset($object) && $object->history_type_1 == 'مقاله انگلیسی') || old('history_type_1') == 'مقاله انگلیسی') selected @endif value="مقاله انگلیسی">مقاله انگلیسی</option>
                                                    <option @if((isset($object) && $object->history_type_1 == 'کتاب فارسی') || old('history_type_1') == 'کتاب فارسی') selected @endif value="کتاب فارسی">کتاب فارسی</option>
                                                    <option @if((isset($object) && $object->history_type_1 == 'نوشته آنلاین') || old('history_type_1') == 'نوشته آنلاین') selected @endif value="نوشته آنلاین">نوشته آنلاین</option>
                                                </select>

                                                @error('history_type_1')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="inputgroup nopadding simple-label mt-0 mb-3">
                                                <input name="history_link_1" type="text" class="myinput" placeholder=""
                                                       value="@if(old('history_link_1')){{ old('history_link_1') }}@elseif(isset($object->history_link_1)){{ $object->history_link_1 }}@endif"
                                                       autocomplete="on">

                                                @error('history_link_1')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="inputgroup nopadding simple-label mt-0 mb-3">
                                                <label>عنوان</label>
                                                <input name="history_title_2" type="text" class="myinput" placeholder=""
                                                       value="@if(old('history_title_2')){{ old('history_title_2') }}@elseif(isset($object->history_title_2)){{ $object->history_title_2 }}@endif"
                                                       autocomplete="on">

                                                @error('history_title_2')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="select-group mt-0 mb-3">
                                                <select name="history_type_2" class="form-select mt-0" aria-label="advice type">
                                                    <option value="" selected disabled>نوع سند
                                                    </option>
                                                    <option @if((isset($object) && $object->history_type_2 == 'آموزش ویدئویی') || old('history_type_2') == 'آموزش ویدئویی') selected @endif value="آموزش ویدئویی">آموزش ویدئویی</option>
                                                    <option @if((isset($object) && $object->history_type_2 == 'مقاله فارسی') || old('history_type_2') == 'مقاله فارسی') selected @endif value="مقاله فارسی">مقاله فارسی</option>
                                                    <option @if((isset($object) && $object->history_type_2 == 'مقاله انگلیسی') || old('history_type_2') == 'مقاله انگلیسی') selected @endif value="مقاله انگلیسی">مقاله انگلیسی</option>
                                                    <option @if((isset($object) && $object->history_type_2 == 'کتاب فارسی') || old('history_type_2') == 'کتاب فارسی') selected @endif value="کتاب فارسی">کتاب فارسی</option>
                                                    <option @if((isset($object) && $object->history_type_2 == 'نوشته آنلاین') || old('history_type_2') == 'نوشته آنلاین') selected @endif value="نوشته آنلاین">نوشته آنلاین</option>
                                                </select>

                                                @error('history_type_2')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="inputgroup nopadding simple-label mt-0 mb-3">
                                                <input name="history_link_2" type="text" class="myinput" placeholder=""
                                                       value="@if(old('history_link_2')){{ old('history_link_2') }}@elseif(isset($object->history_link_2)){{ $object->history_link_2 }}@endif"
                                                       autocomplete="on">

                                                @error('history_link_2')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card-upload">
                                <h6 class="upload-title">بارگذاری عکس</h6>
                                <p class="upload-desc">فایل با پسوند Webp, PNG, JPEG قایل
                                    قبول
                                    می‌باشد, حداکثر اندازه فایل 1 مگابایت</p>
                                {{--                            <form action="/file-upload" class="dropzone m-t-20" id="file-images-logo">--}}
                                <div class="fallback">
                                    <input name="inviteImage" required type="file" />

                                    @error('inviteImage')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{--                            </form>--}}
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card-upload">
                                <h6 class="upload-title">بارگذاری فیلم (اختیاری)</h6>
                                <p class="upload-desc">فایل با پسوند MP4, MKV قایل
                                    قبول
                                    می‌باشد, حداکثر اندازه فایل 50 مگابایت</p>
                                {{--                            <form action="/file-upload" class="dropzone m-t-20" id="file-images-logo">--}}
                                <div class="fallback">
                                    <input name="inviteFile" type="file" />

                                    @error('inviteFile')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                {{--                            </form>--}}
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="textarea-plugin-content">
                                <label>توضیحات</label>
{{--                                <form action="">--}}
                                    <div class="texteditor-content">
                                                    <textarea name="memo" required id="editor1" rows="5"
                                                              cols="80">@if(old('memo')){{ old('memo') }}@elseif(isset($object->memo)){{ $object->memo }}@endif</textarea>

                                        @error('memo')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
{{--                                </form>--}}
                            </div>
                        </div>
                    </div>
                    <div class="btns-action mt-4 text-center">
                        <button type="submit" class="btn btn-default icon-right"><i
                                class="mdi mdi-check"></i>ارسال درخواست همکاری</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ToastMessage --}}
    <div id="toastmessage-content"></div>

@endsection


@section('Page_JS')
    <script src="/user-panel/plugin/ckeditor4/ckeditor.js"></script>
    <script src="/user-panel/plugin/ckeditor4/ckeditor-initial.js"></script>

    <script>
        $('#search_input').on('keydown', function (event) {
            if (event.keyCode == '13') {
                $('#search_form').submit();
            }
        })
    </script>

    @if (session()->has('store_invite_teacher_success'))
        <script>
            toastMessage('موفق', '{{ session('store_invite_teacher_success') }}', 'success');
        </script>
    @endif
@endsection
