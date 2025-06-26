@extends('wiki.master_wikiidea')

@section('Page_Title')
    ویکی ایده - اشتراک گذاری ایده
@endsection


@section('Page_CSS_Before')

@endsection

@section('Page_CSS_After')
    <link href="assets_admin/plugins/fileuploads/css/dropify.css" rel="stylesheet" type="text/css" />

@endsection

@section('SliderDiv')
@endsection


@section('Content')
    <!--Contact-->

    <div class="sptb">
    <br>
        <div class="container">
          @if(! Auth::check())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              برای ثبت ایده باید ابتدا وارد حساب کاربری خود شوید
            </div>
          @endif
            <div class="row ">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="tab-content">
                                <div class="tab-pane active " id="tab_info">
                                    <form id="idea_form" class="form-horizontal p-5">
                                        <h5 class="font-weight-bold mb-4">اشتراک گذاری ایده</h5>
                                        <hr>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="item-card9-imgs">
                                                        <label class="form-label mt-2">تصویر شاخص</label>
                                                        <input type="file" class="dropify" id="idea_image" name="idea_image"  data-max-file-size="5M"  data-allowed-file-extensions="jpg jpeg png gif" />

                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">ویدیو معرفی ایده</label>
                                                    <input type="file" class="dropify" id="idea_video" name="idea_image"  data-max-file-size="100M"  data-allowed-file-extensions="mp4 mpg mpeg 3gp avi" />
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mb-0 mt-2"> عنوان ایده</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="d-flex">
                                                        <input type="text" id="idea_title" class="form-control" placeholder="" value="" maxlength="200">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mt-2">دسته بندی:</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="d-flex">
                                                        <select id="idea_category" style="width: 50%">
                                                            @foreach($cats as $cat)
                                                                <option value="{{$cat->id}}">{{$cat->title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mt-2">کف سرمایه:(به تومان)</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="d-flex">
                                                        <input type="number" id="idea_minimal_fund" value=""  maxlength="15" class="form-control" placeholder="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mt-2">ریسک</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="d-flex">
                                                        <select id="idea_risk" style="width: 50%">
                                                            <option value="پایین" class="form-control">پایین</option>
                                                            <option value="متوسط" class="form-control">متوسط</option>
                                                            <option value="زیاد" class="form-control">زیاد</option>
                                                            <option value="خیلی زیاد" class="form-control">خیلی زیاد</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mt-2">سودآوری</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="d-flex">
                                                        <select id="idea_profitability" style="width: 50%">
                                                            <option value="کوتاه مدت" class="form-control">کوتاه مدت</option>
                                                            <option value="میان مدت" class="form-control">میان مدت</option>
                                                            <option value="بلند مدت" class="form-control">بلند مدت</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mt-2">توضیح کوتاه سودآوری: </label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="d-flex">
                                                        <input type="text"  id="idea_profitability_memo" value="" maxlength="30"  class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mt-2">نیروی انسانی</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="d-flex">
                                                        <input type="text"  id="idea_manpower" value="" maxlength="30"  class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mt-2">مقیاس</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="d-flex">
                                                        <input type="text"  id="idea_scale" maxlength="50" value=""  class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mt-2">مناسب برای استان</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="d-flex">
                                                        <select id="idea_state" style="width: 50%">
                                                            @foreach($states as $state)
                                                                <option value="{{$state->id}}" class="form-control select2">{{$state->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="form-label mt-2">توضیح کوتاه</label>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="d-flex">
                                                        <input type="text"  id="idea_abstractMemo"  value="" maxlength="110"  class="form-control" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">توضیحات کامل</label>
                                            <textarea class="ckeditor" id ="idea_memo" name="idea_memo"  placeholder=""></textarea>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="label-info text-white text-center">بارگزاری ویدئو ممکن هست کمی طول بکشد لطفا شکیبا باشید. تشکر</p>
                            </div>
                            <div class="card-footer">
                                @if(Auth::check())
                                    <button type="button" id="btn_add_wikiidea" class="btn btn-warning waves-effect waves-light" style="float: left;"> ثبت ایده</button>
                                  @else
                                    <button type="button" readonly="" disabled="" class="btn btn-warning waves-effect waves-light" style="float: left;">برای ثبت ایده ابتدا وارد سایت شوید</button>
                                @endif
                            </div>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <br>
    </div>
    <!--/Contact-->


@endsection


@section('Page_JS')
    <script src="assets_admin/plugins/fileuploads/js/dropify.js"></script>
    <script src="assets/plugins/ckeditor/ckeditor.js"></script>
    <script src="assets/plugins/ckeditor/config.js"></script>

    <script>




        var drEvent = $('.dropify').dropify({
            messages: {
                'default': 'یک فایل را در اینجا بکشید و رها کنید یا کلیک کنید',
                'replace': 'برای جایگزینی یک فایل را در اینجا بکشید و رها کنید یا کلیک کنید',
                'remove': 'حذف',
                'error': 'خطا، چیزی اشتباه اضافه شده است.'
            },
            error: {
                'fileSize': 'اندازه فایل زیاد می باشد (فایل رزومه حداکثر 5 مگابایت و فایل نمونه تدریس  حداکثر 50 مگابایت می باشد).',
                'minWidth': 'The image width is too small min).',
                'maxWidth': 'The image width is too big px max).',
                'minHeight': 'The image height is too small px min).',
                'maxHeight': 'The image height is too big px max).',
                'imageFormat': 'فرمت روزمه نامعتبر می باشد. (rar-zip-pdf-docx-doc)'
            }
        });
        drEvent.on('dropify.errors', function (event, element) {
            ShowMessage('خطا در فایل انتخاب شده !', 'error')
        });
        drEvent.on('dropify.error.imageFormat', function (event, element) {
            ShowMessage('فرمت فایل معتبر نمی باشد. فرمت های قابل قبول تصاویر(docx-doc-pdf-rar-zip) و فرمت های قابل قبول ویدیو(avi-mp4-mp3-3gp-mpg-mpeg)', 'error');
        });

    </script>

@endsection
