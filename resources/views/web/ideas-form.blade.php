@extends('layouts.user-panel-master')

@section('Page_Title')
    ایده‌های من
@endsection

@section('Page_CSS')
{{--    <link rel="stylesheet" href="/user-panel/plugin/dropzone/dropzone.min.css" />--}}

{{--    <style>--}}
{{--        .dropzone .dz-remove {--}}
{{--            cursor: pointer;--}}
{{--            color: red;--}}
{{--            font-weight: bold;--}}
{{--        }--}}
{{--    </style>--}}
@endsection

@section('Content')

    <div class="grid-main">
        <div class="grid-inner">
            <div class="main-header">
                <div class="title">
                    <h3><i class="mdi mdi-lightbulb-on-outline"></i>ایده جدید</h3>
                </div>
                <div class="btns-action">
                    <a href="{{ route('web.my-ideas') }}" class="btn btn-default-outline btn-sm icon-left">
                        <span class="icon"><i class="mdi mdi-arrow-left"></i></span>
                        <span class="text">بازگشت</span>
                    </a>
                </div>
            </div>
            <div class="main-body">
                <form action="{{ route('web.my-ideas-store') }}" enctype="multipart/form-data" method="post">
                    @csrf

                    @if(isset($object))
                        <input type="hidden" name="id" value="{{ $object->id }}">
                    @endif

                    <div class="px-md-4 px-3 pb-md-4 pb-3">
                        <div class="row">

                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="inputgroup mt-0 mb-4">
                                    <input name="title" type="text" class="myinput" placeholder="عنوان ایده"
                                          value=" @if(old('title')){{ old('title') }}@elseif(isset($object->title)){{ $object->title }}@endif"
                                           autocomplete="on">
                                    <label>عنوان ایده</label>
                                    <div class="icon"><i class="mdi mdi-pencil-outline"></i></div>

                                    @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="select-group mt-0 mb-4">
                                    <select name="id_category" class="form-select mt-0" aria-label="advice type">
                                        <option value="" selected disabled>انتخاب دسته بندی</option>

                                        @foreach($cats as $cat)
                                            <option @if((isset($object) && $object->id_category == $cat->id) || old('id_category') == $cat->id) selected @endif value="{{ $cat->id ?: '---' }}">{{ $cat->title ?: '---' }}</option>
                                        @endforeach
                                    </select>

                                    @error('id_category')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="inputgroup mt-0 mb-4">
                                    <input name="minimal_fund" type="text" class="myinput" placeholder="کف سرمایه" autocomplete="on"
                                           value="@if(old('minimal_fund')){{ old('minimal_fund') }}@elseif(isset($object->minimal_fund)){{ $object->minimal_fund }}@endif"
                                           required>
                                    <label>کف سرمایه</label>
                                    <div class="icon"><i class="mdi mdi-cash"></i></div>

                                    @error('minimal_fund')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="select-group mt-0 mb-4">
                                    <select name="risk" class="form-select mt-0" aria-label="advice type">
                                        <option value="" selected disabled>انتخاب ریسک</option>
                                        <option @if((isset($object) && $object->risk == 'پایین') || old('risk') == 'پایین') selected @endif value="پایین">پایین</option>
                                        <option @if((isset($object) && $object->risk == 'متوسط') || old('risk') == 'متوسط') selected @endif value="متوسط">متوسط</option>
                                        <option @if((isset($object) && $object->risk == 'زیاد') || old('risk') == 'زیاد') selected @endif value="زیاد">زیاد</option>
                                        <option @if((isset($object) && $object->risk == 'خیلی زیاد') || old('risk') == 'خیلی زیاد') selected @endif value="خیلی زیاد">خیلی زیاد</option>
                                    </select>

                                    @error('risk')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="select-group mt-0 mb-4">
                                    <select name="profitability" class="form-select mt-0" aria-label="advice type">
                                        <option value="" selected disabled>انتخاب سودآوری</option>
                                        <option @if((isset($object) && $object->profitability == 'کوتاه مدت') || old('profitability') == 'کوتاه مدت') selected @endif value="کوتاه مدت">کوتاه مدت</option>
                                        <option @if((isset($object) && $object->profitability == 'میان مدت') || old('profitability') == 'میان مدت') selected @endif value="میان مدت">میان مدت</option>
                                        <option @if((isset($object) && $object->profitability == 'بلند مدت') || old('profitability') == 'بلند مدت') selected @endif value="بلند مدت">بلند مدت</option>
                                    </select>

                                    @error('profitability')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="inputgroup mt-0 mb-4">
                                    <input name="manpower" type="text" class="myinput" placeholder="نیروی انسانی" autocomplete="on"
                                           value="@if(old('manpower')){{ old('manpower') }}@elseif(isset($object->manpower)){{ $object->manpower }}@endif"
                                           required>
                                    <label>نیروی انسانی</label>
                                    <div class="icon"><i class="mdi mdi-account-circle-outline"></i></div>

                                    @error('manpower')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="inputgroup mt-0 mb-4">
                                    <input name="scale" type="text" class="myinput" placeholder="مقیاس" autocomplete="on"
                                         value="@if(old('scale')){{ old('scale') }}@elseif(isset($object->scale)){{ $object->scale }}@endif"
                                           required>
                                    <label>مقیاس</label>
                                    <div class="icon"><i class="mdi mdi-account-circle-outline"></i></div>

                                    @error('scale')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="select-group mt-0 mb-4">
                                    <select name="id_state" class="form-select mt-0" aria-label="advice type">
                                        <option value="" selected disabled>انتخاب استان محدوده</option>

                                        @foreach($states as $state)
                                            <option @if((isset($object) && $object->id_state == $state->id) || old('id_state') == $state->id) selected @endif value="{{ $state->id ?: '---' }}">{{ $state->name ?: '---' }}</option>
                                        @endforeach
                                    </select>

                                    @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="radio-group mt-0 mb-4">
                                    <div class="radio-title">نوع انتشار</div>
                                    <div class="radio-inner">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ispublish"
                                                   value="1"
                                                   @if((isset($object) && $object->ispublish == '1') || old('state') == '1' || !old('state')) checked @endif
                                                   id="radioDefault1">
                                            <label class="form-check-label" for="radioDefault1">
                                                عمومی
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="ispublish"
                                                   @if((isset($object) && $object->ispublish == '0') || old('state') == '0') checked @endif
                                                   value="0"
                                                   id="radioDefault2">
                                            <label class="form-check-label" for="radioDefault2">
                                                خصوصی
                                            </label>
                                        </div>
                                    </div>

                                    @error('ispublish')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="textarea-group">
                                    <label class="h6 mb-3">توضیحات کوتاه سودآوری</label>
                                    <textarea name="profitability_memo" required class="textarea" cols="20" rows="3">@if(old('profitability_memo')){{ old('profitability_memo') }}@elseif(isset($object->profitability_memo)){{ $object->profitability_memo }}@endif</textarea>

                                    @error('profitability_memo')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="textarea-group">
                                    <label class="h6 mb-3">توضیحات کوتاه</label>
                                    <textarea name="abstractMemo" required class="textarea" cols="20" rows="3">@if(old('abstractMemo')){{ old('abstractMemo') }}@elseif(isset($object->abstractMemo)){{ $object->abstractMemo }}@endif</textarea>

                                    @error('abstractMemo')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="textarea-plugin-content">
                                    <label>توضیحات</label>
                                    {{--                                <form action="">--}}
                                    <div class="texteditor-content">
                                                    <textarea required name="memo" id="editor1" rows="10"
                                                              cols="80">@if(old('memo')){{ old('memo') }}@elseif(isset($object->memo)){{ $object->memo }}@endif</textarea>
                                    </div>
                                    {{--                                </form>--}}

                                    @error('memo')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card-upload">
                                    <h6 class="upload-title">بارگذاری عکس</h6>
                                    <p class="upload-desc">فایل با پسوند Webp, PNG, JPEG قایل
                                        قبول
                                        می‌باشد, حداکثر اندازه فایل 1 مگابایت</p>
                                    {{--                                <form action="/file-upload" class="dropzone m-t-20" id="file-images-logo">--}}
                                    <div class="fallback">
                                        <input name="ideaImage" type="file" />
                                    </div>
                                    {{--                                </form>--}}

                                    @error('ideaImage')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="btns-action mt-4 text-center">
                            <button type="submit" class="btn btn-default icon-right"><i
                                    class="mdi mdi-check"></i>ثبت ایده</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@section('Page_JS')
    <script src="/user-panel/plugin/ckeditor4/ckeditor.js"></script>
    <script src="/user-panel/plugin/ckeditor4/ckeditor-initial.js"></script>
{{--    <script src="/user-panel/plugin/dropzone/dropzone.min.js"></script>--}}
{{--    <script src="/user-panel/plugin/dropzone/dropzone.init.js"></script>--}}

    <script>
        $('#search_input').on('keydown', function (event) {
            if (event.keyCode == '13') {
                $('#search_form').submit();
            }
        })
    </script>
@endsection
