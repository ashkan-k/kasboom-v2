@extends('layouts.user-panel-master')

@section('Page_Title')
    کسب بوم
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="grid-inner">
        <div class="main-header">
            <div class="title">
                <h3><i class="mdi mdi-view-dashboard-outline"></i>پیشخوان</h3>
            </div>
        </div>
        <div class="main-body">
            <div class="px-md-4 px-3">
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 px-lg-1">
                        <div class="card-dashboard-info color-primary">
                            <a href="#" class="card-inner">
                                <h5>دوره‌های من</h5>
                                <p>برای مشاهده دوره‌ها کلیک کنید</p>
                                <div class="number">
                                    <span>{{ $courseCount }}</span> دوره
                                </div>
                                <div class="icon"><i class="mdi mdi-play-circle-outline"></i></div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 px-lg-1">
                        <div class="card-dashboard-info color-secondary">
                            <a href="web/learning/education" class="card-inner">
                                <h5>گواهینامه‌ها</h5>
                                <p>برای مشاهده گواهینامه‌ها کلیک کنید</p>
                                <div class="number">
                                    <span>{{ $certificationsCount }}</span> مورد
                                </div>
                                <div class="icon"><i class="mdi mdi-certificate-outline"></i></div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 px-lg-1">
                        <div class="card-dashboard-info">
                            <a href="#" class="card-inner">
                                <h5>یارانه آموزشی</h5>
                                <p>مبلغ یارانه آموزشی شما</p>
                                <div class="number">
                                    <span>{{ number_format($subsid) }}</span> تومان
                                </div>
                                <div class="icon"><i class="mdi mdi-credit-card-outline"></i></div>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 px-lg-1">
                        <div class="card-dashboard-info">
                            <a href="#" class="card-inner">
                                <h5>کیف پول</h5>
                                <p>مانده موجودی کیف پول</p>
                                <div class="number">
                                    <span>{{ number_format($wallet) }}</span> تومان
                                </div>
                                <div class="icon"><i class="mdi mdi-wallet-outline"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-secions">
                <ul class="nav nav-underline nav-profile" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#custom-tab-pane-1" role="tab">
                            <span class="icon"><i class="mdi mdi-play-circle-outline"></i></span>
                            <span class="text">دوره‌ها</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#custom-tab-pane-2" role="tab">
                            <span class="icon"><i class="mdi mdi-video-outline"></i></span>
                            <span class="text">وبینار‌ها</span>
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="custom-tab-pane-1" role="tabpanel"
                         tabindex="0">
                        <div class="tab-inner">
                            <div class="table-responsive">
                                <table class="table custom-table align-middle">
                                    <thead class="table-light">
                                    <tr>
                                        <th scope="col">عنوان</th>
                                        <th scope="col">قیمت (تومان)</th>
                                        <th scope="col">خرید</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($courses as $course)
                                        <tr>
                                            <td>{{ $course->title ?: '---' }}</td>
                                            <td>{{ number_format($course->price) }}</td>
                                            <td>
                                                <a href="skill/take_course/{{ $course->id ?: '---' }}/{{ $course->getSlug() ?: '---' }}" target="_blank" class="btn btn-primary btn-sm">مشاهده و
                                                    خرید</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tab-pane-2" role="tabpanel" tabindex="0">
                        <div class="tab-inner">
                            <div class="table-responsive">
                                <table class="table custom-table align-middle">
                                    <thead class="table-light">
                                    <tr>
                                        <th scope="col">عنوان</th>
                                        <th scope="col">قیمت (تومان)</th>
                                        <th scope="col">خرید</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($webinars as $webinar)
                                        <tr>
                                            <td>{{ $webinar->title ?: '---' }}</td>
                                            <td>{{ number_format($webinar->price) }}</td>
                                            <td>
                                                <a href="skill/webinar/{{$webinar->id ?: '---'}}/{{str_replace(' ','_',$webinar->title ?: '---')}}" target="_blank" class="btn btn-primary btn-sm">مشاهده و
                                                    خرید</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-secions">
                <ul class="nav nav-underline nav-profile" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#custom-tab-pane-3" role="tab">
                            <span class="icon"><i class="mdi mdi-alert-circle-outline"></i></span>
                            <span class="text">اطلاعیه‌ها</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab"
                                data-bs-target="#custom-tab-pane-4" role="tab">
                            <span class="icon"><i class="mdi mdi-bell-outline"></i></span>
                            <span class="text">اعلان‌ها</span>
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="custom-tab-pane-3" role="tabpanel"
                         tabindex="0">
                        <div class="tab-inner">

                            @foreach($notifications as $notification)
                                <div class="card-info">
                                    <h6>{{ $notification->title ?: '---' }}
{{--                                        <span class="badge text-bg-danger">جدید</span>--}}
                                    </h6>
                                    <div class="date">{{ $notification->created_at['jalali'] }}</div>
                                    <p>{{ $notification->memo ?: '---' }}</p>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tab-pane-4" role="tabpanel" tabindex="0">
                        <div class="tab-inner"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('Page_JS')
@endsection
