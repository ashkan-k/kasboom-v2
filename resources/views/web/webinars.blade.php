@extends('layouts.user-panel-master')

@section('Page_Title')
    وبینار های من
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="grid-inner">
        <div class="main-header">
            <div class="title">
                <h3><i class="mdi mdi-video-outline"></i>وبینار‌ها</h3>
            </div>
        </div>
        <div class="main-body">
            <div class="px-md-4 px-3 pb-md-4 pb-3">
                <form id="search_form">
                    <div class="profile-search">
                        <select name="order_by" class="form-select" onchange="$('#search_form').submit()"
                                aria-label="advice type">
                            <option value="created_at" selected>جدیدترین</option>
                            <option value="view_count" @if(request('order_by') == 'view_count') selected @endif>بیشترین
                                بازدید
                            </option>
                            {{--                            <option value="3">آخرین بازدید</option>--}}
                        </select>
                        <div class="inputgroup">
                            <input type="text" id="search_input" name="search" value="{{ request('search') }}"
                                   class="myinput" placeholder="جستجو">
                            <div class="icon"><i class="mdi mdi-magnify"></i></div>
                        </div>
                    </div>
                </form>

                <div class="row">

                    @foreach($webinars as $row)
                        <?php
                        $webinar = $row->webinar;
                        $title = str_replace(' ', '_', $webinar?->title);
                        $time = $webinar?->minutes > 0 ? $webinar?->hour . ':' . $webinar?->minutes : $webinar?->hour;
                        ?>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 px-lg-2">
                            <div class="card-course mb-4" title="{{ $title ?: '---' }}">
                                <div class="card-inner">
                                    <div class="img-container">
                                        <div class="img-inner">
                                            <img src="_upload_/_webinars_/{{$webinar->code}}/medium_{{$webinar->image}}" alt="{{ $title ?: '---' }}"/>
                                        </div>
                                        <div class="status">
                                            @if($webinar->have_certificate === 1)
                                                <div class="certificate">گواهینامه دارد</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-b">
                                        <h3 class="name">{{ $title ?: '---' }}</h3>
                                        <div class="info">
                                            <h4 class="teacher"><i class="mdi mdi-account-outline"></i>{{$webinar->teacher_name}}</h4>
                                            <p class="duration"><i class="mdi mdi-clock-outline"></i>مدت
                                                زمان دوره :
                                                <span>{{ $webinar->webinar_start_time_hour }}:00 - {{ $webinar->webinar_end_time_hour }}:00 - {{ $webinar->webinar_date }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="c-footer">
                                    <a href="/skill/webinar/{{ $webinar->id }}/{{ $title }}" target="_blank" class="btn-details">مشاهده جزییات</a>
                                    <a href="{{ $webinar->cloud_url ?: '---' }}" target="_blank" class="btn-download">داانلود ویدیو</a>
                                </div>
                            </div>
                        </div>

                    @endforeach

                </div>

                {{ $webinars->links('web.components.pagination') }}

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
@endsection
