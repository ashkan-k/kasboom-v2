<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class apiController extends Controller
{
    public function gitStore(Request $request)
    {
        // بررسی وجود داده‌های دوره و درس‌ها
        if (!$request->has('course') || !$request->has('lessons')) {
            return response(['status' => 'error', 'message' => 'Missing required data'], 400);
        }

        $course_info = json_decode($request->input('course'), true);
        $lessons_info = json_decode($request->input('lessons'), true);

        // بررسی معتبر بودن داده‌های دوره
        if (!$course_info || !isset($course_info['slug']) || !isset($course_info['title'])) {
            return response(['status' => 'error', 'message' => 'Invalid course data'], 400);
        }

        do {
            $input = microtime(true) . Str::random(10);
            $code = sha1($input);
        } while (course::where('code', $code)->exists());

        // ایجاد مسیر ذخیره‌سازی تصویر
        $basePath = '_upload_/_courses_/';
        $coursePath = $basePath . $code;

        // ایجاد پوشه دوره اگر وجود نداشته باشد
        if (!file_exists($coursePath)) {
            mkdir($coursePath, 0755, true);
        }

        // دریافت و ذخیره تصویر
        if ($request->has('image') && $request->has('filename')) {
            $imageData = $request->input('image');
            $imageExt = pathinfo($request->input('filename'), PATHINFO_EXTENSION);
            $imageName = $course_info['slug'] . '.' . $imageExt;
            $imagePath = $coursePath . '/' . $imageName;

            // ذخیره تصویر
            file_put_contents($imagePath, base64_decode($imageData));

            // تنظیم مسیر تصویر در دیتابیس
            $course_info['image_url'] = $imageName;
        }

        $course = new course();
        $course->code = $code;
        $course->id_category = 1;
        $course->id_mega = 1;
        $course->id_middle = 2;
        $course->id_sub = 16;
        $course->teacher_percnet = 0;
        $course->have_certificate = 0;
        $course->have_ticket = 0;
        $course->price = 50000;
        $course->id_teacher = 143;
        $course->status = 0;
        $course->type = 'subtitle';
        $course->slug = $course_info['slug'];
        $course->title = $course_info['title'];
        $course->hour = $course_info['hour'] ?? 0;
        $course->minutes = $course_info['minutes'] ?? 0;
        $course->content = $course_info['content'] ?? '';
        $course->memo = Str::limit($course_info['content'] ?? '', 150);

        if (isset($course_info['image_url'])){
            $course->poster_url = $course->img_slider = $course->img_slider_mobile = $course->img_mini_banner = $course->img_big_banner = $course_info['image_url'];
        }
        if (isset($course_info['video_url'])){
            $course->intro_video = $course_info['video_url'];
        }

        $course->save();

//    // بررسی معتبر بودن داده‌های درس‌ها
        if (is_array($lessons_info)) {
            foreach ($lessons_info as $l_info) {
                $lesson = new lesson();
                $lesson->id_course = $course->id;
                $lesson->lesson_number = isset($l_info['lesson_number']) ? $l_info['lesson_number'] : null;
                $lesson->season = isset($l_info['season_number']) ? $l_info['season_number'] : null;
                $lesson->season_title = isset($l_info['season_title']) ? $l_info['season_title'] : null;
                $lesson->title = isset($l_info['title']) ? $l_info['title'] : null;
                $lesson->hour = isset($l_info['hour']) ? $l_info['hour'] : null;
                $lesson->minutes = isset($l_info['minutes']) ? $l_info['minutes'] : null;
                $lesson->save();
            }
        }

        return response(['status' => 'success']);
    }


    public function domestikaStore(Request $request)
    {
        // داده دریافتی را به صورت آرایه دریافت می‌کنیم
        $data = $request->all();
		return $data;
        // بررسی وجود داده‌های لازم
        if (!$data || !isset($data['attributes']) || !isset($data['data_file'])) {
            return response(['status' => 'error', 'message' => 'Missing required data'], 400);
        }

        $attr = $data['attributes'];
        $lessons = $data['data_file'];

        // بررسی معتبر بودن داده‌های دوره
        if (!isset($attr['titleEn']) || !isset($attr['url'])) {
            return response(['status' => 'error', 'message' => 'Invalid course data'], 400);
        }

        // تولید کد یکتا برای دوره
        do {
            $input = microtime(true) . \Illuminate\Support\Str::random(10);
            $code = sha1($input);
        } while (course::where('code', $code)->exists());

        // استخراج slug از url
        $slug = collect(explode('/', $attr['url']))->last();

        // ایجاد مسیر ذخیره‌سازی تصویر (در صورت نیاز)
        $basePath = '_upload_/_courses_/';
        $coursePath = $basePath . $code;
        if (!file_exists($coursePath)) {
            mkdir($coursePath, 0755, true);
        }

        // ذخیره تصویر اگر داده‌ای ارسال شده باشد
        if (isset($attr['image_urls'][0]['url_1x'])) {
            $imageUrl = $attr['image_urls'][0]['url_1x'];
            $imageExt = pathinfo(parse_url($imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
            $imageName = $slug . '.' . $imageExt;
            $imagePath = $coursePath . '/' . $imageName;
            // دانلود و ذخیره تصویر
            try {
                file_put_contents($imagePath, file_get_contents($imageUrl));
            } catch (\Exception $e) {
                $imageName = null;
            }
        } else {
            $imageName = null;
        }

        // ساخت و ذخیره دوره
        $course = new course();
        $course->code = $code;
        $course->id_category = 1;
        $course->teacher_percnet = 0;
        $course->have_certificate = 0;
        $course->have_ticket = 0;
        $course->price = 50000;
        $course->id_teacher = 143;
        $course->status = 2;
        $course->type = 'subtitle';
        $course->slug = $slug;
        $course->title = $attr['titleEn'];
        $course->hour = isset($lessons['lesson_hours']) ? intval($lessons['lesson_hours']) : 0;
        $course->minutes = isset($lessons['lesson_minutes']) ? intval($lessons['lesson_minutes']) : 0;
        $course->content = $lessons['description'] ?? '';
        $course->memo =$attr['shortDescription'];
        if ($imageName) {
            $course->poster_url = $course->img_slider = $course->img_slider_mobile = $course->img_mini_banner = $course->img_big_banner = $imageName;
        }
        $course->save();

        // ذخیره درس‌ها
        if (is_array($lessons)) {
            foreach ($lessons as $l_info) {
                $lesson = new lesson();
                $lesson->id_course = $course->id;
                $lesson->lesson_number = $l_info['lesson_number'] ?? null;
                $lesson->season = $l_info['season_number'] ?? null;
                $lesson->season_title = $l_info['season_title'] ?? null;
                $lesson->title = $l_info['title'] ?? null;
                $lesson->hour = $l_info['hour'] ?? null;
                $lesson->minutes = $l_info['minutes'] ?? null;
                $lesson->save();
            }
        }

        return response(['status' => 'success']);
    }



}
