@extends('layouts.user-panel-master')

@section('Page_Title')
    پیام‌های من
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="grid-inner">
        <div class="main-header">
            <div class="title">
                <h3><i class="mdi mdi-email-outline"></i>پیام‌ها</h3>
            </div>
        </div>
        <div class="main-body">
            <div class="px-md-4 px-3 pb-md-4 pb-3">
                <form id="search_form">
                    <div class="profile-search">
                        <select name="read_status" class="form-select" onchange="$('#search_form').submit()" aria-label="advice type">
                            <option value="" selected>همه</option>
                            <option value="new" @if(request('read_status') == 'new') selected @endif>جدید</option>
                            <option value="expired" @if(request('read_status') == 'expired') selected @endif>منقضی</option>
                        </select>
                        <div class="inputgroup">
                            <input type="text" id="search_input" name="search" value="{{ request('search') }}"
                                   class="myinput" placeholder="جستجو">
                            <div class="icon"><i class="mdi mdi-magnify"></i></div>
                        </div>
                    </div>
                </form>

                @foreach($messages as $message)
                    <div class="card-info">
                        <h6>{{ $message->subject ?: '---' }}<span class="badge @if($message->read_status)text-bg-secondary @else text-bg-danger @endif">
                                @if($message->read_status)
                                    متقضی
                                @else
                                    جدید
                                @endif
                            </span></h6>
                        <div class="date">{{ jdate($message->created_at)->format('H:i - Y/m/d') }}</div>
                        <p>{{ $message->message ?: '---' }}</p>
                    </div>
                @endforeach

                {{ $messages->appends(request()->query())->links('web.components.pagination') }}
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
