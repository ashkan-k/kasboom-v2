@extends('layouts.user-panel-master')

@section('Page_Title')
    نتیجه آزمون دوره آموزشی
@endsection

@section('Page_CSS')

@endsection

@section('Content')

    <div class="work-withUs margin-bottom">
        <div class="container">
            <div class="title">
                <h2>
                    نتیجه آزمون دوره {{$course->title}}
                </h2>
                <p>حداقل امتیاز قابل قبول: 70
                </p>
                <p>
                    امتیاز کسب شده: {{$class_room->quiz_score}}
                </p>
            </div>
            <div class="work-form">
                <div class="form-inner">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="inputgroup">
                                @if($class_room->quiz_score < 70) <p id="message"
                                                                     class="bg-danger text-white text-center">
                                    متاسفانه! شما امتیاز لازم از آزمون دوره را دریافت نکردید. بعد از 15 روز مجددا می
                                    توانید در آزمون شرکت نمائید
                                </p>
                                @else
                                    <p id="message" class="bg-success text-white text-center">
                                        تبریک! شما در آزمون دوره آموزشی قبول شدید و بیشتر از حداقل امتیاز قابل قبول را
                                        دریافت کردید.
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <p>جدول نتیجه آزمون:</p>
                            <table class="table table-bordered table-hover text-nowrap">
                                <tr>
                                    <th class="text-center "></th>
                                    <th>سوال آزمون</th>
                                    <th class="text-center">جواب شما</th>
                                    <th class="text-right">نتیجه جواب شما</th>
                                </tr>
                                <?php $cnt = 0;
                                $cnt_false = 0;
                                $cnt_true = 0;
                                ?>
                                @foreach($user_quizs as $quiz)
                                    <?php $cnt = $cnt + 1; ?>
                                    <tr>
                                        <td class="text-center">{{$cnt}}</td>
                                        <td>
                                            <div class="text-muted">{{$quiz->questions->question}} </div>
                                        </td>
                                        <td class="text-center"> {{$quiz->user_answer}}</td>
                                        @if($quiz->answer == 0)
                                            <?php $cnt_false = $cnt_false + 1; ?>
                                            <td class="text-right text-red">اشتباه</td>
                                        @else
                                            <?php $cnt_true = $cnt_true + 1; ?>
                                            <td class="text-right text-success">صحیح</td>
                                        @endif
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" class="text-right text-danger">مجموع جواب های اشتباه</td>
                                    <td class="text-right text-danger">{{$cnt_false}} سوال</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right text-success">مجموع جواب های صحیح</td>
                                    <td class="text-right text-success">{{$cnt_true}} سوال</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="font-weight-semibold text-uppercase text-right">امتیاز
                                        نهایی
                                    </td>
                                    <td class="font-weight-semibold text-right">{{$class_room->quiz_score}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="send-request">
                            {{-- @if($class_room->quiz_score >= 70)--}}
                            {{-- <a href="_upload_/_users_/{{Auth::user()->code}}/certificates/{{$class_room->cert_filename}}" target="_blank" class="btn btn-gradient icon-right" ><i class="mdi mdi-credit-card"></i>مشاهده گواهی نامه پایان دوره</a>--}}
                            {{-- id="btn_request_certificate"--}}
                            {{-- @endif--}}

{{--                            @if($class_room->quiz_score >= 70)--}}
                                <button type="button" class="btn btn-gradient icon-right"
                                        onclick="window.open('{{ route('web.my-certificate-download', $course->id) }}', '_blank')"><i class="mdi mdi-printer"></i>
                                    دانلود گواهینامه
                                </button>
                                <br>
{{--                            @endif--}}

                            <br>
                            راه رسیدن به موفقیت و شکست دقیقا از یک مسیر است، اما این شما هستید که انتخاب می کنید در شکست
                            ها متوقف شوید یا به مقصد موفقیت پیشروی کنید.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('Page_JS')
    <script>
        course_id = {
        {
            $course - > id
        }
        }
        ;
    </script>
@endsection
