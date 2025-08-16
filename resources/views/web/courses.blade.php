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
                <h3><i class="mdi mdi-play-circle-outline"></i>دوره‌ها</h3>
            </div>
        </div>
        <div class="main-body">
            <div class="px-md-4 px-3 pb-md-4 pb-3">
                <form id="search_form">
                    <div class="profile-search">
                        <select name="order_by" class="form-select" onchange="$('#search_form').submit()" aria-label="advice type">
                            <option value="created_at" selected>جدیدترین</option>
                            <option value="view_count" @if(request('order_by') == 'view_count') selected @endif>بیشترین بازدید</option>
{{--                            <option value="3">آخرین بازدید</option>--}}
                        </select>
                        <div class="inputgroup">
                            <input type="text" id="search_input" name="search" value="{{ request('search') }}" class="myinput" placeholder="جستجو">
                            <div class="icon"><i class="mdi mdi-magnify"></i></div>
                        </div>
                    </div>
                </form>

                <div class="row">

                    @foreach($courses as $row)
                        <?php
                        $course = $row->course;
                        $title = str_replace(' ', '_', $course?->title);
                        $slug= "/course/".$course?->getSlug();
                        $teacher= $course?->teacher ? $course?->teacher->fullname : 'کسبوم';
                        $time=$course?->minutes > 0 ? $course?->hour.':'.$course?->minutes : $course?->hour;
                        ?>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 px-lg-2">
                            <div class="card-course mb-4" title="{{ $course?->title }}">
                                <a href="{{ route('web.my-course-detail', $course->id ?: '---') }}">
                                    <div class="img-container">
                                        <div class="img-inner">
                                            <img src="{{ $course->getMediumPoster() }}" alt="{{ $course?->title ?: '---' }}" />
                                        </div>
                                    </div>
                                    <div class="card-b">
                                        <h3 class="name">{{ $course?->title ?: '---' }}</h3>
                                        <div class="info">
                                            <h4 class="teacher"><i class="mdi mdi-account-outline"></i>{{ $teacher }}</h4>
                                            <p class="duration"><i class="mdi mdi-clock-outline"></i>مدت
                                                زمان دوره :
                                                <span>{{ $time }}
                                                                ساعت</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                    @endforeach

                </div>

                {{ $courses->links('web.components.pagination') }}

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
