@extends('layouts.user-panel-master')

@section('Page_Title')
    دوره های من
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="grid-inner">
        <div class="main-header">
            <div class="title">
                <h3><i class="mdi mdi-play-circle-outline"></i>{{ $course->title ?: '---' }}</h3>
            </div>
            <div class="btns-action">
                <a href="{{ route('web.my-courses') }}" class="btn btn-default-outline btn-sm icon-left">
                    <span class="icon"><i class="mdi mdi-arrow-left"></i></span>
                    <span class="text">بازگشت</span>
                </a>
            </div>
        </div>
        <div class="main-body">
            <div class="px-md-4 px-3 pb-md-4 pb-3">
                <div class="myalert alert alert-info alert-dismissible fade show" role="alert">
                    <div class="icon"><i class="mdi mdi-cloud-download-outline"></i></div>
                    <div class="text">با کلیک بر روی دکمه دانلود می توانید ویدئو درس را دانلود نمائید
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
                <div class="myalert alert alert-success alert-dismissible fade show" role="alert">
                    <div class="icon"><i class="mdi mdi-check-circle-outline"></i></div>
                    <div class="text">بعد از مشاهده همه درس های دوره ، گزینه شرکت در آزمون فعال می شود.
                        با قبولی در آزمون <strong>گواهینامه دیجیتال</strong> برای شما صادر می
                        شود</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
                <div class="main-btns-action">
                    <button class="btn btn-danger-outline icon-right btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modal-bugs">
                        <span class="icon"><i class="mdi mdi-bug-outline"></i></span>
                        <span class="icon">گزارش خرابی</span>
                    </button>
                    <button class="btn btn-default-outline icon-right btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modal-add-notebook">
                        <span class="icon"><i class="mdi mdi-plus-circle-outline"></i></span>
                        <span class="icon">یادداشت جدید</span>
                    </button>
                    <a href="userProfile-course-details-survey.html"
                       class="btn btn-secondary icon-right btn-sm">
                        <span class="icon"><i class="mdi mdi-star-outline"></i></span>
                        <span class="icon">نظرسنجی</span>
                    </a>
                    <a href="exam-test.html" class="btn btn-default icon-right btn-sm">
                        <span class="icon"><i class="mdi mdi-list-status"></i></span>
                        <span class="icon">شرکت در آزمون</span>
                    </a>
                </div>
            </div>
            <div class="tab-secions full-height mt-0">
                <ul class="nav nav-underline nav-profile" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#custom-tab-pane-1" role="tab">
                            <span class="icon"><i class="mdi mdi-play-circle-outline"></i></span>
                            <span class="text">دروس دوره</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#custom-tab-pane-2" role="tab">
                            <span class="icon"><i class="mdi mdi-pencil-outline"></i></span>
                            <span class="text">یادداشت‌ها</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#custom-tab-pane-3" role="tab">
                            <span class="icon"><i class="mdi mdi-attachment"></i></span>
                            <span class="text">فایل‌های ضمیمه</span>
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="custom-tab-pane-1" role="tabpanel"
                         tabindex="0">
                        <div class="tab-inner">
                            <div class="videos-list-content">

                                @foreach($course?->lessons as $lesson)
                                    <div class="item">
                                        <div class="c-body">
                                            <figure class="video-pic">
                                                <div class="img-inner">
                                                    <img src="{{ $course->poster_url }}" alt="{{ $lesson->title ?: '---' }}" />
                                                </div>
                                            </figure>
                                            <div class="info">
                                                <h6>{{ $lesson->lesson_number }} - {{ $lesson->title ?: '---' }}</h6>
                                                <div class="actions">
                                                    @php
                                                        $time=$lesson?->minutes > 0 ? $lesson?->hour ?: '0'.':'.$lesson?->minutes : $lesson?->hour;
                                                    @endphp
                                                    <div class="time">{{ $time }}</div>
                                                    <div class="btns-action">
                                                        <button class="btn-details"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapse_course_{{ $lesson->id }}">مشاهده
                                                            جزییات</button>
                                                        <a onclick="DownloadVideo('{{ $lesson->cloud_mp4_url }}', {{ $course->id }}, {{ $lesson->id }})" id="id_btn_download_{{ $lesson->id }}" style="cursor:pointer;" class="btn-download">دانلود</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-collapsed collapse @if($loop->index == 0) show @endif" id="collapse_course_{{ $lesson->id }}">
                                            <div class="details">
                                                <ul class="file-info-list">
                                                    <li><span><i class="mdi mdi-account-outline"></i>مدرس
                                                                        :</span>
                                                        مهناز افشار
                                                    </li>
                                                    <li><span><i class="mdi mdi-clock-outline"></i>زمان دوره
                                                                        :</span>

                                                        @if($lesson?->hour >= 0)
                                                            {{ $lesson?->minutes }} دقیقه
                                                        @else
                                                            @php
                                                                $time=$lesson?->minutes > 0 ? $lesson?->hour.':'.$lesson?->minutes : $lesson?->hour;
                                                            @endphp
                                                            {{ $time }} ساعت
                                                        @endif

                                                    </li>
                                                    <li><span><i
                                                                class="mdi mdi-file-download-outline"></i>حجم
                                                                        دوره
                                                                        :</span>
                                                        {{ $lesson?->size ?: '---' }} مگابایت</li>
                                                    <li><span><i
                                                                class="mdi mdi-calendar-check-outline"></i>تاریخ
                                                                        بروزرسانی
                                                                        :</span>
                                                        {{ jdate($lesson?->updated_at)->format('Y/m/d') }}</li>
                                                    <li><span><i
                                                                class="mdi mdi-information-outline"></i>وضعیت
                                                                        :</span>
                                                        @if($lesson->status == '1')
                                                            در دسترس
                                                        @else
                                                            عدم دسترسی
                                                        @endif
                                                    </li>
                                                </ul>
                                                <div class="text">
                                                    <strong>توضیحات : </strong>
                                                    {{ $lesson->memo ?: '---' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="custom-tab-pane-2" role="tabpanel" tabindex="0">
                        <div class="tab-inner">

                            @foreach($notes as $note)

                                <div class="card-info">
                                    <h6>{{ $note->note_title ?: '---' }}</h6>
                                    <div class="date">{{ $note->created_at ?: '---' }}</div>
                                    <p>{{ $note->note ?: '---' }}</p>
                                </div>

                            @endforeach

                        </div>
                    </div>
                    <div class="tab-pane fade show" id="custom-tab-pane-3" role="tabpanel" tabindex="0">
                        <div class="tab-inner">
                            <div class="accordion" id="accordionParent">

                                @foreach($attachDic as $key => $attach_cat)

                                    <div class="accordion-item">
                                        <button class="accordion-button" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#accordion_file_attachment_{{ $loop->index }}">
                                            {{ $key }}
                                        </button>
                                        <div id="accordion_file_attachment_{{ $loop->index }}"
                                             class="accordion-collapse collapse @if($loop->index == 0) show @endif"
                                             data-bs-parent="#accordionParent">
                                            <div class="accordion-body">

                                                @foreach($attach_cat as $attach)
                                                    <div class="card-download-item">
                                                        <div class="info">
                                                            <h4 class="name">{{ $attach->title ?: '---' }}</h4>
                                                            <h6 class="desc">{{ $attach->memo ?: '---' }}</h6>
                                                        </div>
                                                        <div class="btn-action">
                                                            <a href="{{ $attach->attachment_file ?: '---' }}" target="_blank" class="btn-download">
                                                                <i class="mdi mdi-download"></i>دانلود
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>



                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('Page_JS')
    <script>
        $('#search_input').on('keydown', function (event) {
            if (event.keyCode == '13') {
                $('#search_form').submit();
            }
        })
    </script>

    <script>
        function DownloadVideo(video_url, idCourse, idLesson) {
            if (!video_url) {
                return;
            }

            $(`#id_btn_download_${idLesson}`).text('لطفا منتظر بمانید ...').prop('disabled', true);
            ChangeButtonEnablingStatus(`id_btn_download_${idLesson}`, 'disable');

            var fd = new FormData();
            fd.append('idCourse', idCourse);
            fd.append('idLesson', idLesson);

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/web/learning/education/complete-lesson', // URL to your PHP script
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function (response) {
                    $(`#id_btn_download_${idLesson}`).text('دانلود').prop('disabled', false);
                    ChangeButtonEnablingStatus(`id_btn_download_${idLesson}`, 'enable');
                    window.open(video_url, '_blank')
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $(`#id_btn_download_${idLesson}`).text('دانلود').prop('disabled', false);
                    ChangeButtonEnablingStatus(`id_btn_download_${idLesson}`, 'enable');

                    toastMessage('خطا', 'خطایی رخ داد. این لینک درحال حاضر در دسترس نمی باشد!', 'danger')
                }
            });

        }

    </script>
@endsection
