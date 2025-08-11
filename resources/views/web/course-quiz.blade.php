<!DOCTYPE html>
<html lang="fa" class="no-js" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#68c4b4" />
    <meta name="msapplication-navbutton-color" content="#68c4b4">
    <meta name="apple-mobile-web-app-status-bar-style" content="#68c4b4">
    <title>کسبوم ‍| آموزشگاه کسبوم</title>
    <link rel="stylesheet" href="/user-panel/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="/user-panel/scss/main.css">
    <link rel="stylesheet" href="/user-panel/plugin/swiperjs/swiper-bundle.min.css">

    <!-- Font Icons -->
    <link href="/user-panel/css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css">

    <!-- Favicon -->
    <link rel="icon" href="/user-panel/images/small-icon.png">
    <link rel="apple-touch-icon" href="/user-panel/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/user-panel/images/logo-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/user-panel/images/logo-114x114.png">

</head>

<body>

<div class="exam-wrapper">
    <div class="container">
        <div class="exam-header">
            <div class="inner">
                <div class="title">
                    <h2>آزمون دوره آشنایی مقدماتی با گیاهان دارویی (حرفه عطاری)</h2>
                    <p>تعداد سوالات : 20</p>
                </div>
                <div class="btns-action">
                    <a href="{{ route('web.my-course-detail', $course->id ?: '---') }}" class="btn btn-default-outline btn-sm icon-left">
                        <i class="mdi mdi-arrow-left"></i>
                        <span class="text">بازگشت</span>
                    </a>
                </div>
                <div class="countdown-container">
                    <div id="clock-timer">
                        <span>زمان باقیمانده :</span>
                        <div id="countdown" class="clock">00:15</div>
                    </div>
                    <div id="end-message">زمان شما به پایان رسید</div>
                </div>
            </div>
        </div>

        <form action="{{ route('web.my-course-quiz-correction') }}" method="POST">
            @csrf
            <input type="hidden" name="courseId" value="{{ $course->id }}"> <!-- فرض بر این است که $id_course در ویو تعریف شده است -->

            <div class="exam-body">
                @foreach($quiz as $item)
                    <div class="card-question">
                        <h6>{{ $loop->index + 1 }} - {{ $item->question ?: '---' }}</h6>
                        <input type="hidden" name="answer[{{ $loop->index }}][id]" value="{{ $item->id }}">
                        <div class="radio-group">
                            <div class="form-check mt-0 mb-2">
                                <input class="form-check-input" type="radio" name="answer[{{ $loop->index }}][value]" id="radio-{{ $item->id }}-1" value="1" required>
                                <label class="form-check-label" for="radio-{{ $item->id }}-1">{{ $item->option1 ?: '---' }}</label>
                            </div>
                            <div class="form-check mt-0 mb-2">
                                <input class="form-check-input" type="radio" name="answer[{{ $loop->index }}][value]" id="radio-{{ $item->id }}-2" value="2">
                                <label class="form-check-label" for="radio-{{ $item->id }}-2">{{ $item->option2 ?: '---' }}</label>
                            </div>
                            <div class="form-check mt-0 mb-2">
                                <input class="form-check-input" type="radio" name="answer[{{ $loop->index }}][value]" id="radio-{{ $item->id }}-3" value="3">
                                <label class="form-check-label" for="radio-{{ $item->id }}-3">{{ $item->option3 ?: '---' }}</label>
                            </div>
                            <div class="form-check mt-0 mb-2">
                                <input class="form-check-input" type="radio" name="answer[{{ $loop->index }}][value]" id="radio-{{ $item->id }}-4" value="4">
                                <label class="form-check-label" for="radio-{{ $item->id }}-4">{{ $item->option4 ?: '---' }}</label>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="btns-action mt-4 text-center">
                    <button type="submit" class="btn btn-default icon-right"><i class="mdi mdi-check"></i>تایید و ثبت پاسخ‌ها</button>
                </div>
            </div>
        </form>

    </div>
</div>

<!-- Scripts -->
<script src="/user-panel/js/jquery-3.5.1.min.js"></script>
<script src="/user-panel/js/bootstrap.bundle.min.js"></script>
<script src="/user-panel/plugin/swiperjs/swiper-bundle.min.js"></script>
<script src="/user-panel/plugin/swiperjs/swiper-initial.js"></script>
<script src="/user-panel/js/scripts.js"></script>

<script>
    let timeLeft = 1200;
    const countdownElement = document.getElementById('countdown');
    const endMessageElement = document.getElementById('end-message');
    const clockTimer = document.getElementById('clock-timer');
    const countdownContainer = document.querySelector('.countdown-container');
    function updateCountdown() {
        const minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        seconds = seconds < 10 ? '0' + seconds : seconds;
        countdownElement.textContent = `${minutes}:${seconds}`;
        timeLeft--;
        if (timeLeft < 0) {
            clearInterval(countdownTimer);
            clockTimer.style.display = 'none';
            endMessageElement.style.display = 'block';
            countdownContainer.classList.add('danger')

            setTimeout(() => {
                window.location.href = "{{ route('web.my-course-detail', $course->id ?: '---') }}";
            }, 2000);
        }
    }
    const countdownTimer = setInterval(updateCountdown, 1000);
    updateCountdown();
</script>


</body>

</html>
