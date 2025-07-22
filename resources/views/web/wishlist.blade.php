@extends('layouts.user-panel-master')

@section('Page_Title')
    علاقه ها
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="grid-main">
        <div class="grid-inner">
            <div class="main-header">
                <div class="title">
                    <h3><i class="mdi mdi-heart-outline"></i>علاقه‌مندی‌ها</h3>
                </div>
            </div>
            <div class="main-body">
                <div class="tab-secions">
                    <ul class="nav nav-underline nav-profile" role="tablist">
                        <li onclick="window.location.href='{{ route('web.my-bookmark') }}?type=product'"
                            class="nav-item" role="presentation">
                            <button class="nav-link @if(!request('type') || request('type') == 'product') active @endif">
                                <span class="icon"><i class="mdi mdi-package-variant-closed"></i></span>
                                <span class="text">محصولات</span>
                            </button>
                        </li>
                        <li onclick="window.location.href='{{ route('web.my-bookmark') }}?type=webinar'"
                            class="nav-item" role="presentation">
                            <button class="nav-link @if(request('type') == 'webinar') active @endif">
                                <span class="icon"><i class="mdi mdi-video-outline"></i></span>
                                <span class="text">وبینار</span>
                            </button>
                        </li>
                        <li onclick="window.location.href='{{ route('web.my-bookmark') }}?type=idea'" class="nav-item"
                            role="presentation">
                            <button class="nav-link @if(request('type') == 'idea') active @endif">
                                <span class="icon"><i class="mdi mdi-lightbulb-on-outline"></i></span>
                                <span class="text">ایده‌ها</span>
                            </button>
                        </li>
                        <li onclick="window.location.href='{{ route('web.my-bookmark') }}?type=course'" class="nav-item"
                            role="presentation">
                            <button class="nav-link @if(request('type') == 'course') active @endif">
                                <span class="icon"><i class="mdi mdi-play-circle-outline"></i></span>
                                <span class="text">دوره‌های آموزشی</span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade @if(!request('type') || request('type') == 'product') show active @endif"
                         id="custom-tab-pane-1" role="tabpanel"
                         tabindex="0">
                        <div class="tab-inner px-3 pb-4">

                            @if(!request('type') || request('type') == 'product')
                                <div class="row">

                                    @foreach($wishlists as $wishlist)
                                        {{--                                    @php--}}
                                        {{--                                        $image = \Illuminate\Support\Facades\DB::table('product_id')->where('id', $wishlist->id_target)->first();--}}
                                        {{--                                    @endphp--}}

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                            <div class="card-course mb-4" title="نام دوره">
                                                <a href="#">
                                                    <div class="img-container">
                                                        <div class="img-inner">
                                                            <img
                                                                src="{{ $wishlist->product?->ShopProductFirstImage() ?: '---' }}"
                                                                alt="{{ $wishlist->product?->product_name ?: '---' }}"/>
                                                        </div>
                                                    </div>
                                                    <div class="card-b">
                                                        <h3 class="name">{{ $wishlist->product?->product_name ?: '---' }}</h3>
                                                        <div class="info">
                                                            <h4 class="teacher"><i
                                                                    class="mdi mdi-account-outline"></i>{{ $wishlist->product?->User?->name ?: '---' }}
                                                            </h4>
                                                            {{--                                                        <p class="duration"><i--}}
                                                            {{--                                                                class="mdi mdi-clock-outline"></i>مدت--}}
                                                            {{--                                                            زمان دوره :--}}
                                                            {{--                                                            <span>4--}}
                                                            {{--                                                                        ساعت</span>--}}
                                                            {{--                                                        </p>--}}
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                                {{ $wishlists->appends(request()->query())->links('web.components.pagination') }}
                            @endif

                        </div>
                    </div>
                    <div class="tab-pane fade @if(request('type') == 'webinar') show active @endif"
                         id="custom-tab-pane-2" role="tabpanel" tabindex="0">
                        <div class="tab-inner">

                            @if(request('type') == 'webinar')
                                <div class="row">

                                    @foreach($wishlists as $wishlist)
                                        <?php
                                        $webinar = $wishlist->webinar;
                                        $title = str_replace(' ', '_', $webinar?->title);
                                        $time = $webinar?->minutes > 0 ? $webinar?->hour . ':' . $webinar?->minutes : $webinar?->hour;
                                        ?>

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                            <div class="card-course mb-4" title="نام دوره">
                                                <a href="/skill/webinar/{{$webinar?->id}}/{{$title}}" target="_blank">
                                                    <div class="img-container">
                                                        <div class="img-inner">
                                                            <img
                                                                src="_upload_/_webinars_/{{$webinar?->code}}/medium_{{$webinar?->image}}"
                                                                alt="{{ $title ?: '---' }}"/>
                                                        </div>
                                                    </div>
                                                    <div class="card-b">
                                                        <h3 class="name">{{ $title ?: '---' }}</h3>
                                                        <div class="info">
                                                            <h4 class="teacher"><i
                                                                    class="mdi mdi-account-outline"></i>{{ $webinar?->teacher_name ?: '---' }}
                                                            </h4>
                                                            <p class="duration"><i
                                                                    class="mdi mdi-clock-outline"></i>مدت
                                                                زمان دوره :
                                                                <span>{{ $webinar?->webinar_start_time_hour }}:00 - {{ $webinar?->webinar_end_time_hour }}:00 - {{ $webinar?->webinar_date }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                                {{ $wishlists->appends(request()->query())->links('web.components.pagination') }}
                            @endif

                        </div>
                    </div>
                    <div class="tab-pane fade @if(request('type') == 'idea') show active @endif" id="custom-tab-pane-3"
                         role="tabpanel" tabindex="0">
                        <div class="tab-inner">

                            @if(request('type') == 'webinar')
                                <div class="row">

                                    @foreach($wishlists as $wishlist)
                                        <?php
                                        $idea = $wishlist->idea;
                                        ?>

                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                            <div class="card-course mb-4" title="نام دوره">
                                                <a href="{{url('wikiidea/details/' . $idea?->id)}}" target="_blank">
                                                    <div class="img-container">
                                                        <div class="img-inner">
                                                            <img
                                                                src="_upload_/_wikiideas_/{{$idea?->code}}/medium_{{$idea?->image}}"
                                                                alt="{{$idea?->title ?: '---'}}"/>
                                                        </div>
                                                    </div>
                                                    <div class="card-b">
                                                        <h3 class="name">{{ $idea?->title ?: '---' }}</h3>
                                                        <div class="info">
                                                            <h4 class="teacher"><i
                                                                    class="mdi mdi-account-outline"></i>{{ $idea?->category?->title ?: '---' }}
                                                            </h4>
                                                            <p class="duration"><i
                                                                    class="mdi mdi-clock-outline"></i>کف سرمایه :
                                                                <span>{{number_format($idea?->minimal_fund)}} تومان</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                                {{ $wishlists->appends(request()->query())->links('web.components.pagination') }}
                            @endif

                        </div>
                    </div>
                    <div class="tab-pane fade @if(request('type') == 'course') show active @endif"
                         id="custom-tab-pane-4" role="tabpanel" tabindex="0">
                        <div class="tab-inner">تب 4</div>
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
@endsection
