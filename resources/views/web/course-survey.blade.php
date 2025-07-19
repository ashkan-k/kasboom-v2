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
                <h3><i class="mdi mdi-star-outline"></i>نظرسنجی</h3>
            </div>
            <div class="btns-action">
                <a href="{{ route('web.my-course-detail', $courseId) }}"
                   class="btn btn-default-outline btn-sm icon-left">
                    <span class="icon"><i class="mdi mdi-arrow-left"></i></span>
                    <span class="text">بازگشت</span>
                </a>
            </div>
        </div>
        <div class="main-body">
            <form action="{{ route('web.my-course-survey-store', $courseId) }}" method="post">
                @csrf

                <div class="px-md-4 px-3 pb-md-4 pb-3">

                    @foreach($survey as $item)
                        <div class="rating-container" data-rating-id="product{{ $item->id }}">
                            <div class="rating-title">{{ $item->title ?: '---' }}</div>
                            <div class="rating-stars">
                                <span class="star" data-value="1">★</span>
                                <span class="star" data-value="2">★</span>
                                <span class="star" data-value="3">★</span>
                                <span class="star" data-value="4">★</span>
                                <span class="star" data-value="5">★</span>
                            </div>
                            <input type="hidden" name="ratings[{{ $item->id }}]" class="rating-input" value="1">
                        </div>
                    @endforeach

                    <div class="textarea-group">
                        <label class="h6 mb-2">متن نظر , پیشنهاد و انتقاد</label>
                        <textarea class="textarea" name="message" required cols="20" rows="4"></textarea>
                    </div>
                    <div class="btns-action mt-4 text-center">
                        <button type="submit" class="btn btn-default icon-right"><i
                                class="mdi mdi-check"></i>ثبت و ارسال
                            نظرسنجی
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ToastMessage --}}
    <div id="toastmessage-content"></div>

@endsection


@section('Page_JS')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // انتخاب تمام کانتینرهای امتیازدهی
            const ratingContainers = document.querySelectorAll('.rating-container');

            // تنظیم پیش‌فرض یک ستاره برای هر کانتینر
            ratingContainers.forEach(container => {
                const starsInContainer = container.querySelectorAll('.star');
                const ratingInput = container.querySelector('.rating-input');

                // فعال کردن ستاره اول
                starsInContainer[0].classList.add('active');
                // تنظیم مقدار فیلد مخفی به 1
                ratingInput.value = 1;
            });

            // مدیریت رویدادهای کلیک و هاور برای ستاره‌ها
            const allStars = document.querySelectorAll('.star');
            allStars.forEach(star => {
                star.addEventListener('click', function () {
                    const container = this.closest('.rating-container');
                    const starsInContainer = container.querySelectorAll('.star');
                    const value = this.getAttribute('data-value');
                    const ratingInput = container.querySelector('.rating-input');

                    // به‌روزرسانی مقدار فیلد مخفی
                    ratingInput.value = value;

                    // مدیریت کلاس‌های active
                    starsInContainer.forEach(s => s.classList.remove('active'));
                    for (let i = 0; i < value; i++) {
                        starsInContainer[i].classList.add('active');
                    }
                });

                star.addEventListener('mouseover', function () {
                    const container = this.closest('.rating-container');
                    const starsInContainer = container.querySelectorAll('.star');
                    const value = this.getAttribute('data-value');

                    starsInContainer.forEach(s => s.classList.remove('hover'));
                    for (let i = 0; i < value; i++) {
                        starsInContainer[i].classList.add('hover');
                    }
                });

                star.addEventListener('mouseout', function () {
                    const container = this.closest('.rating-container');
                    const starsInContainer = container.querySelectorAll('.star');
                    starsInContainer.forEach(s => s.classList.remove('hover'));
                });
            });
        });
    </script>

    @if (session()->has('survey_submit_error'))
        <script>
            toastMessage('خطا', '{{ session('survey_submit_error') }}', 'danger');
        </script>
    @endif
@endsection
