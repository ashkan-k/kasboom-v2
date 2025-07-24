@extends('layouts.user-panel-master')

@section('Page_Title')
    ایده‌های من
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="grid-main">
        <div class="grid-inner">
            <div class="main-header">
                <div class="title">
                    <h3><i class="mdi mdi-lightbulb-on-outline"></i>ایده‌های من</h3>
                </div>
                <div class="btns-action">
                    <a href="{{ route('web.my-ideas-create') }}" class="btn btn-default btn-sm icon-right">
                        <span class="icon"><i class="mdi mdi-plus-circle-outline"></i></span>
                        <span class="text">ثبت ایده</span>
                    </a>
                </div>
            </div>
            <div class="main-body">
                <div class="px-md-4 px-3 pb-md-4 pb-3">
                    <form id="search_form">
                        <div class="profile-search">
                            <select name="order_by" class="form-select" onchange="$('#search_form').submit()"
                                    aria-label="advice type">
                                <option value="created_at" selected>جدیدترین</option>
                                <option value="view_count" @if(request('order_by') == 'view_count') selected @endif>
                                    بیشترین بازدید
                                </option>
                                <option value="total_score" @if(request('order_by') == 'total_score') selected @endif>
                                    بیشترین امتیاز
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

                        @foreach($ideas as $idea)
                            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                <div class="card-course mb-4" title="{{$idea->title ?: '---'}}">
                                    <a href="{{url('wikiidea/details/' . $idea->id)}}" title="{{$idea->abstractMemo}}">
                                        <div class="img-container">
                                            <div class="img-inner">
                                                <img src="_upload_/_wikiideas_/{{$idea->code}}/medium_{{$idea->image}}"
                                                     alt="{{$idea->title ?: '---'}}"/>
                                            </div>
                                        </div>
                                        <div class="card-b">
                                            <h3 class="name">{{$idea->title ?: '---'}}</h3>
                                            <div class="info">
                                                <h4 class="teacher"><i
                                                        class="mdi mdi-account-outline"></i>{{ $idea?->teacher?->fullname ?: '---' }}
                                                </h4>
                                                <p class="duration"><i class="mdi mdi-clock-outline"></i>مدت
                                                    کف سرمایه :
                                                    <span>
                                                    {{number_format($idea->minimal_fund)}} تومان
                                                </span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{ $ideas->links('web.components.pagination') }}

                </div>
            </div>
        </div>
    </div>

    {{-- ToastMessage --}}
    <div id="toastmessage-content"></div>

@endsection


@section('Page_JS')
    <script>
        $('#search_input').on('keydown', function (event) {
            if (event.keyCode == '13') {
                $('#search_form').submit();
            }
        })
    </script>

    @if (session()->has('idea_submit_success'))
        <script>
            toastMessage('موفق', '{{ session('idea_submit_success') }}', 'success');
        </script>
    @endif
@endsection
