@extends('layouts.user-panel-master')

@section('Page_Title')
    گواهینامه های من
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="grid-inner">
        <div class="main-header">
            <div class="title">
                <h3><i class="mdi mdi-video-outline"></i>گواهینامه ها</h3>
            </div>
        </div>
        <div class="main-body">
            <div class="px-md-4 px-3 pb-md-4 pb-3">
                <form id="search_form">
                    <div class="profile-search">
                        <select name="type" class="form-select" onchange="$('#search_form').submit()"
                                aria-label="advice type">
                            <option value="دوره" selected>دوره</option>
                            <option value="وبینار" @if(request('type') == 'وبینار') selected @endif>
                                وبینار
                            </option>
                        </select>
                        <div class="inputgroup">
                            <input type="text" id="search_input" name="search" value="{{ request('search') }}"
                                   class="myinput" placeholder="جستجو">
                            <div class="icon"><i class="mdi mdi-magnify"></i></div>
                        </div>
                    </div>
                </form>

                <div class="row">

                    @foreach($certificates as $row)
                        <?php
                        if ($type == 'دوره'){
                            $obj = $row->course;
                            $title = str_replace(' ', '_', $obj?->title);
                            $slug= "/course/".$obj?->getSlug();
                            $teacher= $obj?->teacher ? $obj?->teacher->fullname : 'کسبوم';
                            $time=$obj?->minutes > 0 ? $obj?->hour.':'.$obj?->minutes : $obj?->hour;
                            $link = $slug;
                        }else{
                            $obj = $row->webinar;
                            $title = str_replace(' ', '_', $obj?->title);
                            $time = $obj?->minutes > 0 ? $obj?->hour . ':' . $obj?->minutes : $obj?->hour;
                            $teacher = $obj->teacher_name;
                            $link = "/skill/webinar/$obj->id/$title";
                        }
                        ?>

                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 px-lg-2">
                                <div class="card-course mb-4" title="{{ $title ?: '---' }}">
                                    <div class="card-inner">
                                        <div class="img-container">
                                            <div class="img-inner">
                                                @if($type == 'دوره')
                                                    <img src="_upload_/_courses_/{{$obj?->code}}/medium_{{$obj?->image}}" alt="{{ $title ?: '---' }}" />
                                                @else
                                                    <img src="_upload_/_webinars_/{{$obj->code}}/medium_{{$obj->image}}" alt="{{ $title ?: '---' }}"/>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-b">
                                            <h3 class="name">{{ $title ?: '---' }}</h3>
                                            <div class="info">
                                                <h4 class="teacher"><i class="mdi mdi-account-outline"></i>{{ $teacher }}</h4>
                                                <p class="duration"><i class="mdi mdi-clock-outline"></i>مدت
                                                    زمان دوره :
                                                    <span>
                                                        @if($type == 'دوره')
                                                            {{ $time }} ساعت
                                                        @else
                                                            {{ $obj->webinar_start_time_hour }}:00 - {{ $obj->webinar_end_time_hour }}:00 - {{ $obj->webinar_date }}
                                                        @endif
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="c-footer">
                                        <a href="{{ $link }}" target="_blank" class="btn-download">مشاهده دوره</a>
                                    </div>
                                </div>
                            </div>

                    @endforeach

                </div>

                {{ $certificates->links('web.components.pagination') }}

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
