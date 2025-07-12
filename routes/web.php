<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\courseController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\landuseController;
use App\Http\Controllers\mainController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\userController;
use App\Http\Controllers\web\WebPanelUserController;
use App\Http\Controllers\webinarController;
use App\Http\Controllers\wikiController;
use Illuminate\Support\Facades\Route;

Route::get('/web/login', function () {
    return redirect('register');
});

//main
Route::get('subsid', ['as' => 'main.subsid', 'uses' => 'mainController@subsid']);
Route::get('qore', ['as' => 'main.qore', 'uses' => 'mainController@qore']);
Route::get('feedback', ['as' => 'main.feedback', 'uses' => 'mainController@feedback']);
Route::post('regist_feedback', ['as' => 'main.regist_feedback', 'uses' => 'mainController@regist_feedback']);
Route::get('changeurl', ['as' => 'main.amar', 'uses' => 'mainController@changeurl']);
Route::get('amar', ['as' => 'main.amar', 'uses' => 'mainController@amar']);
Route::get('test', ['as' => 'main.index', 'uses' => 'mainController@test']);
Route::get('tabliq', ['as' => 'main.index', 'uses' => 'mainController@tabliq']);
Route::get('change/{id_course}/{id_teacher}', ['as' => 'main.change', 'uses' => 'mainController@change']);


//Route::get('/', ['as' => 'main.index', 'uses' => 'mainController@index']);
Route::get('/', [courseController::class, 'course_index_new']);
//Route::get('/', 'courseController@ramezan1403');


Route::get('/default', ['as' => 'main.index', 'uses' => 'mainController@index']);
Route::get('/faq', [mainController::class, 'faq']);
Route::get('/404', [mainController::class, 'pege404']);
Route::get('/about', [mainController::class, 'about']);
Route::get('/contactus', [mainController::class, 'contactus']);
Route::post('/contact', [mainController::class, 'contact']);
Route::get('/shopp', ['as' => 'main.shopp', 'uses' => 'mainController@shopp']);
Route::get('/help', [mainController::class, 'help']);
Route::get('/ch/{path?}', [mainController::class, 'redirect']);
Route::get('sign_mobile', ['as' => 'main.sign_mobile', 'uses' => 'mainController@sign_mobile']);
Route::get('work-with-us', [mainController::class, 'work_with_us']);
Route::get('update', ['as' => 'main.update_page', 'uses' => 'mainController@update_page']);
Route::get('exhibition', ['as' => 'main.exhibition', 'uses' => 'mainController@exhibition']);
Route::get('shop_vtour', ['as' => 'main.vtour', 'uses' => 'mainController@vtour']);

Route::post('/inviteBySMS', ['as' => 'main.inviteBySMS', 'uses' => 'mainController@inviteBySMS']);
Route::post('/newsletter', ['as' => 'main.newsletter', 'uses' => 'mainController@newsletter']);
Route::post('/getCity', [mainController::class, 'getCity']);
Route::post('/inform', ['as' => 'main.inform', 'uses' => 'mainController@inform']);
Route::post('updateUserPass', ['as' => 'user.updateUserPass', 'uses' => 'userController@updateUserPass']);
Route::post('updateUserPermission', ['as' => 'user.updateUserPermission', 'uses' => 'userController@updateUserPermission']);
Route::post('send_message', ['as' => 'main.send_message', 'uses' => 'mainController@send_message']);
Route::post('get_comment', ['as' => 'main.get_comment', 'uses' => 'mainController@get_comment']);
Route::post('send_comment', ['as' => 'main.send_comment', 'uses' => 'mainController@send_comment']);
Route::post('get_message', ['as' => 'main.get_message', 'uses' => 'mainController@get_message']);
Route::post('all_messages', ['as' => 'all_messages', 'uses' => 'mainController@all_messages']);
Route::post('all_comment', ['as' => 'all_comment', 'uses' => 'mainController@all_comment']);
Route::post('reply_message', ['as' => 'reply_message', 'uses' => 'mainController@reply_message']);
Route::post('getMiddleCategory', ['as' => 'getMiddleCategory', 'uses' => 'mainController@getMiddleCategory']);
Route::post('getSubCategory', ['as' => 'getSubCategory', 'uses' => 'mainController@getSubCategory']);
Route::post('/send_ticket', ['as' => 'main.send_ticket', 'uses' => 'mainController@send_ticket']);
Route::post('check_username', ['as' => 'main.check_username', 'uses' => 'mainController@check_username']);
Route::post('public_search', ['as' => 'main.public_search', 'uses' => 'mainController@public_search']);

Route::get('comming', ['as' => 'main.comming', 'uses' => 'mainController@comming']);


// news
Route::get('/news', ['as' => 'news.news', 'uses' => 'newsController@news']);
Route::get('/news/{type}', ['as' => 'news.news_type', 'uses' => 'newsController@news_type']);
Route::get('/news/{id_news}/{title?}', ['as' => 'news.news_detail', 'uses' => 'newsController@news_detail']);
Route::post('news/search_news_ajax', ['as' => 'news.search_news_ajax', 'uses' => 'newsController@search_news_ajax']);
Route::post('news/search_news_category_ajax', ['as' => 'news.search_news_category_ajax', 'uses' => 'newsController@search_news_category_ajax']);
Route::post('news/search_news_writer_ajax', ['as' => 'news.search_news_writer_ajax', 'uses' => 'newsController@search_news_writer_ajax']);


//webinar
Route::get('/workshops', ['as' => 'webinar.workshop_list', 'uses' => 'workshopController@workshop_list']);
Route::get('/webinar/{id}/{title?}', ['as' => 'webinar.webinar', 'uses' => 'workshopController@webinar']);
Route::post('/search_workshop_ajax', ['as' => 'webinar.search_workshop_ajax', 'uses' => 'workshopController@search_workshop_ajax']);
Route::post('/filter_workshop_ajax', ['as' => 'webinar.filter_workshop_ajax', 'uses' => 'workshopController@filter_workshop_ajax']);


//Route::post('/search_consult_ajax', ['as' => 'consult.search_consult_ajax', 'uses' => 'consultController@search_consult_ajax']);
//Route::post('/filter_consult_ajax', ['as' => 'consult.filter_consult_ajax', 'uses' => 'consultController@filter_consult_ajax']);
//Route::post('register_consult_factor', ['as' => 'consult.register_consult_factor', 'uses' => 'consultController@register_consult_factor']);


// amayesh
Route::get('/landuse', [landuseController::class, 'landuse']);
Route::get('/landuseitem/{classname}', [landuseController::class, 'landuseitem']);
Route::get('/landusecity/{id}/{name}', [landuseController::class, 'landusecity']);

// nashenavayan
Route::get('/nashenavayan', ['as' => 'landing.nashenavayan', 'uses' => 'LandingController@nashenavayan']);

// suppliers
Route::get('/suppliers', ['as' => 'landing.suppliers', 'uses' => 'LandingController@suppliers']);
Route::get('/supplier/panuch', ['as' => 'landing.supplier.panuch', 'uses' => 'LandingController@supplier_panuch']);

// roadmap
//Route::get('/roadmap', ['as' => 'landing.roadmap', 'uses' => 'LandingController@roadmap']);
Route::get('/roadmap/charm', ['as' => 'landing.roadmap.charm', 'uses' => 'LandingController@roadmap_charm']);
//Route::get('/roadmap/namad', ['as' => 'landing.roadmap.namad', 'uses' => 'LandingController@roadmap_namad']);

Route::get('/roadmap', [LandingController::class, 'roadmap']);
Route::get('/roadmap/{slug}', [LandingController::class, 'roadmapContent']);

//auth
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register-check-phonenumber', [AuthController::class, 'registerCheckPhonenumber']);
Route::post('/register-store', [AuthController::class, 'registerStore']);
Route::post('/auth/send-verify-phonenumber', [AuthController::class, 'sendVerifyPhonenumber']);
Route::post('/verify-phonenumber', [AuthController::class, 'verifyPhonenumber']);
Route::post('/auth/check-disposable-password', [AuthController::class, 'checkDisposablePassword']);
Route::get('/auth/csis', [userController::class, 'csisLogin']);


// user
Route::get('/profile/{id_user}/{title?}', ['as' => 'user.user_profile', 'uses' => 'userController@user_profile']);
//Route::get('/register', ['as' => 'user.register', 'uses' => 'userController@register']);
Route::get('/reg', ['as' => 'user.reg', 'uses' => 'userController@register_co']);
Route::post('/signup', ['as' => 'user.signup', 'uses' => 'userController@signup']);
Route::get('/signup', ['as' => 'user.signup', 'uses' => 'userController@signup']);
Route::post('/signup_co', ['as' => 'user.signup_co', 'uses' => 'userController@signup_co']);
Route::get('/signup_co', ['as' => 'user.signup_co', 'uses' => 'userController@signup_co']);
//Route::post('/signup_co2', ['as' => 'user.signup_co2', 'uses' => 'userController@signup_co2']);
//Route::get('/signup_co2', ['as' => 'user.signup_co2', 'uses' => 'userController@signup_co2']);

Route::get('/forgot', ['as' => 'user.forgot', 'uses' => 'userController@forgot']);
Route::post('/forgot_user', ['as' => 'user.forgot_user', 'uses' => 'userController@forgot_user']);
//Route::get('/login', ['as' => 'user.login', 'uses' => 'userController@login']);
Route::get('/login', [userController::class, 'login']);
Route::get('/logout', [userController::class, 'logout']);
Route::post('/signin', [userController::class, 'signin']);
Route::get('/signin', [userController::class, 'signin']);
Route::get('/verify', [userController::class, 'verify']);
Route::post('/verify_code', [userController::class, 'verify_code']);
Route::get('/verify_code', [userController::class, 'verify_code']);
Route::get('/verify_code_complete_register', [userController::class, 'verify_code_complete_register']);
Route::post('/verify_code_complete_register', [userController::class, 'verify_code_complete_register']);

Route::get('/verify_code_complete_forgot', ['as' => 'user.verify_code_complete_forgot', 'uses' => 'userController@verify_code_complete_forgot']);
Route::post('/verify_code_complete_forgot', ['as' => 'user.verify_code_complete_forgot', 'uses' => 'userController@verify_code_complete_forgot']);

Route::get('kasboom_test', ['as' => 'user.test', 'uses' => 'userController@kasboom_test']);

// user profile
Route::group(['prefix' => 'user'], function () {

    Route::group(array('middleware' => ['auth', 'checkLogin']), function () {
        Route::get('dashboard', ['as' => 'user.user_dashboard', 'uses' => 'userController@user_dashboard']);

        Route::get('notification', ['as' => 'user.notification', 'uses' => 'userController@notification']);
        Route::get('course', ['as' => 'user.mycourses', 'uses' => 'userController@mycourses']);
        Route::get('webinar', ['as' => 'user.mywebinars', 'uses' => 'userController@mywebinars']);
        Route::get('whishlist', ['as' => 'user.whishlist', 'uses' => 'userController@whishlist']);
        Route::get('message', ['as' => 'user.message', 'uses' => 'userController@message']);
        Route::get('info', ['as' => 'user.info', 'uses' => 'userController@info']);

        Route::get('payments', ['as' => 'user.payments', 'uses' => 'userController@payments']);
        Route::get('all_payments', ['as' => 'user.all_payments', 'uses' => 'userController@all_payments']);

        Route::get('myquizs', ['as' => 'user.myquizs', 'uses' => 'userController@myquizs']);
        Route::get('show_myquizs', ['as' => 'user.show_myquizs', 'uses' => 'userController@show_myquizs']);

        Route::get('mycertificates', ['as' => 'user.mycertificates', 'uses' => 'userController@mycertificates']);
        Route::get('show_mycertificates', ['as' => 'user.show_mycertificates', 'uses' => 'userController@show_mycertificates']);

        Route::get('myfavorites', ['as' => 'user.myfavorites', 'uses' => 'userController@myfavorites']);
        Route::get('show_myfavorites', ['as' => 'user.show_myfavorites', 'uses' => 'userController@show_myfavorites']);

        Route::get('mycomments', ['as' => 'user.mycomments', 'uses' => 'userController@mycomments']);
        Route::get('show_mycomments', ['as' => 'user.show_mycomments', 'uses' => 'userController@show_mycomments']);

        Route::get('consults', ['as' => 'user.myconsults', 'uses' => 'userController@myconsults']);
        Route::get('show_myconsults', ['as' => 'user.show_myconsults', 'uses' => 'userController@show_myconsults']);

        Route::get('consulting/{id}/{title?}', ['as' => 'user.consulting', 'uses' => 'userController@consulting']);


        Route::get('wallet', ['as' => 'user.mywallet', 'uses' => 'userController@mywallet']);
        Route::get('increase_wallet', ['as' => 'user.increase_wallet', 'uses' => 'userController@increase_wallet']);
        Route::post('increas_to_wallet', ['as' => 'user.increas_to_wallet', 'uses' => 'userController@increas_to_wallet']);
        Route::get('get_wallet', ['as' => 'user.get_wallet', 'uses' => 'userController@get_wallet']);
        Route::post('get_from_wallet', ['as' => 'user.get_from_wallet', 'uses' => 'userController@get_from_wallet']);


        Route::get('settings', ['as' => 'user.mysetting', 'uses' => 'userController@mysetting']);
        Route::post('updateUserInfo', ['as' => 'user.updateUserInfo', 'uses' => 'userController@updateUserInfo']);
        Route::post('updateUserSkills', ['as' => 'user.updateUserSkills', 'uses' => 'userController@updateUserSkills']);
        Route::post('updateUserContacts', ['as' => 'user.updateUserContacts', 'uses' => 'userController@updateUserContacts']);
        Route::post('updateUserCards', ['as' => 'user.updateUserCards', 'uses' => 'userController@updateUserCards']);
        Route::post('updateUserSetting', ['as' => 'user.updateUserSetting', 'uses' => 'userController@updateUserSetting']);
        Route::post('updateUserImages', ['as' => 'user.updateUserImages', 'uses' => 'userController@updateUserImages']);
        Route::post('updateUserPass', ['as' => 'user.updateUserPass', 'uses' => 'userController@updateUserPass']);

        Route::get('avatar', ['as' => 'manager.avatar', 'uses' => 'userController@avatar']);

    });


    Route::get('/calendar', function () {
        return view('manager.calendar2');
    });
});

// manager profile
Route::group(['prefix' => '_manager'], function () {
    Route::group(array('middleware' => ['auth', 'checkLogin']), function () {


        Route::get('dashboard', ['as' => 'manager.admin_dashboard', 'uses' => 'adminController@admin_dashboard']);
        Route::get('dashboard', ['as' => 'manager.admin_dashboard', 'uses' => 'adminController@admin_dashboard']);
        Route::post('comment/view', ['as' => 'manager.viewComment', 'uses' => 'adminController@viewComment']);
        Route::post('comment/delete', ['as' => 'manager.deleteComment', 'uses' => 'adminController@deleteComment']);
        Route::get('last_comments', ['as' => 'manager.last_comments', 'uses' => 'adminController@last_comments']);
        Route::get('all_last_comments', ['as' => 'manager.all_last_comments', 'uses' => 'adminController@all_last_comments']);
        Route::post('verify_comment', ['as' => 'manager.verify_comment', 'uses' => 'adminController@verify_comment']);
        Route::post('delete_comment', ['as' => 'manager.delete_comment', 'uses' => 'adminController@delete_comment']);
//        Route::get('comment/{id}/view', ['as' => 'manager.viewComment', 'uses' => 'adminController@viewComment']);
//        Route::get('comment/{id}/edit', ['as' => 'manager.editComment', 'uses' => 'adminController@editComment']);
//        Route::get('comment/{id}/delete', ['as' => 'manager.deleteComment', 'uses' => 'adminController@deleteComment']);

        Route::get('hires', ['as' => 'manager.hires', 'uses' => 'adminController@hires']);
        Route::get('hire/{id}/{title?}', ['as' => 'manager.hire', 'uses' => 'adminController@hire']);
        Route::post('hire_update', ['as' => 'manager.hireUpdate', 'uses' => 'adminController@hireUpdate']);
        Route::post('hire_store', ['as' => 'manager.hire_store', 'uses' => 'adminController@hire_store']);
        Route::post('hire_deactive', ['as' => 'manager.hire_deactive', 'uses' => 'adminController@hire_deactive']);
        Route::post('hire_active', ['as' => 'manager.hire_active', 'uses' => 'adminController@hire_active']);
        Route::post('hire_notes', ['as' => 'manager.hire_notes', 'uses' => 'adminController@hire_notes']);
        Route::post('hire_blogs', ['as' => 'manager.hire_blogs', 'uses' => 'adminController@hire_blogs']);
        Route::post('hire_podcasts', ['as' => 'manager.hire_podcasts', 'uses' => 'adminController@hire_podcasts']);
        Route::post('hire_videocasts', ['as' => 'manager.hire_videocasts', 'uses' => 'adminController@hire_videocasts']);
        Route::post('hire_consults', ['as' => 'manager.hire_consults', 'uses' => 'adminController@hire_consults']);
        Route::post('hire_sample_ques', ['as' => 'manager.hire_sample_ques', 'uses' => 'adminController@hire_sample_ques']);
//        Route::post('hire_quizs', ['as' => 'manager.hire_quizs', 'uses' => 'adminController@hire_quizs']);
        Route::post('hire_my_ques', ['as' => 'manager.hire_my_ques', 'uses' => 'adminController@hire_my_ques']);
        Route::get('hires/comments', ['as' => 'manager.hire_comments', 'uses' => 'adminController@hire_comments']);
        Route::get('all_hire_comments', ['as' => 'manager.all_hire_comments', 'uses' => 'adminController@all_hire_comments']);


        Route::get('courses', ['as' => 'manager.courses', 'uses' => 'courseController@courses']);
        Route::get('all_courses', ['as' => 'manager.manager_view_all_courses', 'uses' => 'courseController@all_courses']);
        Route::get('course/teachers', ['as' => 'manager.teachers', 'uses' => 'courseController@teachers']);
        Route::get('course/users', ['as' => 'manager.course_users', 'uses' => 'courseController@course_users']);
        Route::get('all_course_users', ['as' => 'manager.all_course_users', 'uses' => 'courseController@all_course_users']);
        Route::get('all_course_comments', ['as' => 'manager.all_course_comments', 'uses' => 'adminController@all_course_comments']);
        Route::get('course_add', ['as' => 'manager.course_add_form', 'uses' => 'courseController@add_form']);
        Route::post('course/add_course', ['as' => 'manager.add_course', 'uses' => 'courseController@add_course']);
        Route::post('course/edit_course', ['as' => 'manager.edit_course', 'uses' => 'courseController@edit_course']);
        Route::post('course/edit_course_info', ['as' => 'manager.edit_course_info', 'uses' => 'courseController@edit_course_info']);
        Route::post('course/edit_course_content', ['as' => 'manager.edit_course_content', 'uses' => 'courseController@edit_course_content']);
        Route::post('course/add_lesson', ['as' => 'manager.add_lesson', 'uses' => 'courseController@add_lesson']);
        Route::post('course/add_lesson_attach', ['as' => 'manager.add_lesson_attach', 'uses' => 'courseController@add_lesson_attach']);
        Route::post('course/delete_lesson ', ['as' => 'manager.delete_lesson', 'uses' => 'courseController@delete_lesson']);
        Route::post('course/lesson_attachments ', ['as' => 'manager.lesson_attachments', 'uses' => 'courseController@lesson_attachments']);
        Route::post('course/delete_lesson_attachment ', ['as' => 'manager.delete_lesson_attachment', 'uses' => 'courseController@delete_lesson_attachment']);
        Route::post('course/get_lesson ', ['as' => 'manager.get_lesson', 'uses' => 'courseController@get_lesson']);
        Route::post('course/edit_lesson ', ['as' => 'manager.edit_lesson', 'uses' => 'courseController@edit_lesson']);
        Route::get('course/all_comments', ['as' => 'course.all_comments', 'uses' => 'courseController@all_comments']);
        Route::get('course/allcourse_comments', ['as' => 'course.allcourse_comments', 'uses' => 'courseController@allcourse_comments']);
        Route::get('course/comments', ['as' => 'course.show_course_comments', 'uses' => 'courseController@show_course_comments']);
        Route::get('course/quizques', ['as' => 'course.show_course_quizques', 'uses' => 'courseController@show_course_quizques']);
        Route::post('course/add_quiz_question', ['as' => 'course.add_quiz_question', 'uses' => 'courseController@add_quiz_question']);
        Route::post('course/delete_quiz_question', ['as' => 'course.delete_quiz_question', 'uses' => 'courseController@delete_quiz_question']);
        Route::get('course/users', ['as' => 'course.course_users', 'uses' => 'courseController@show_course_users']);
        Route::get('course/users_form', ['as' => 'course.users_form', 'uses' => 'courseController@course_users_form']);
        Route::get('course/messages', ['as' => 'course.course_messages', 'uses' => 'courseController@show_course_messages']);
        Route::post('course/reply_message', ['as' => 'course.reply_message', 'uses' => 'courseController@reply_message']);
        Route::post('course/delete_course ', ['as' => 'manager.delete_course', 'uses' => 'courseController@delete_course']);
        Route::get('course/{id}/{title?}', ['as' => 'manager.manage_course_edit', 'uses' => 'courseController@manage_course_edit']);


        Route::get('webinars', ['as' => 'manager.webinars', 'uses' => 'webinarController@webinars']);
        Route::get('webinar/all_webinars', ['as' => 'manager.manager_view_all_webinars', 'uses' => 'webinarController@all_webinars']);
        Route::get('webinar/detail/{id}/{title?}', ['as' => 'manager.webinar_detail', 'uses' => 'webinarController@webinar_detail']);
        Route::get('webinar/add', ['as' => 'manager.webinar_add_form', 'uses' => 'webinarController@add_form']);
        Route::post('webinar/add_webinar', ['as' => 'manager.webinar_add_webinar', 'uses' => 'webinarController@add_webinar']);
        Route::post('webinar/add_webinar_attach', ['as' => 'manager.add_webinar_attach', 'uses' => 'webinarController@add_webinar_attach']);
        Route::post('webinar/delete_attach', ['as' => 'manager.delete_attach', 'uses' => 'webinarController@delete_attach']);
        Route::post('webinar/edit_webinar', ['as' => 'manager.edit_webinar', 'uses' => 'webinarController@edit_webinar']);
        Route::post('webinar/comments', ['as' => 'manager.webinar_comments', 'uses' => 'webinarController@webinar_comments']);
        Route::post('webinar/users', ['as' => 'manager.webinar_users', 'uses' => 'webinarController@webinar_users']);
        Route::post('webinar/delete', ['as' => 'manager.webinar_delete', 'uses' => 'webinarController@webinar_delete']);

//        Route::get('webinar/teachers', ['as' => 'manager.teachers', 'uses' => 'webinarControllwe@teachers']);
//        Route::get('webinar/users', ['as' => 'manager.course_users', 'uses' => 'webinarControllwe@course_users']);
//        Route::get('all_course_users', ['as' => 'manager.all_course_users', 'uses' => 'webinarControllwe@all_course_users']);
//        Route::get('all_course_comments', ['as' => 'manager.all_course_comments', 'uses' => 'adminController@all_course_comments']);
//        Route::get('course_add', ['as' => 'manager.course_add_form', 'uses' => 'webinarControllwe@add_form']);
//        Route::post('webinar/add_course', ['as' => 'manager.add_course', 'uses' => 'webinarControllwe@add_course']);
//        Route::post('webinar/edit_course', ['as' => 'manager.edit_course', 'uses' => 'webinarControllwe@edit_course']);
//        Route::post('webinar/edit_course_info', ['as' => 'manager.edit_course_info', 'uses' => 'webinarControllwe@edit_course_info']);
//        Route::post('webinar/edit_course_content', ['as' => 'manager.edit_course_content', 'uses' => 'webinarControllwe@edit_course_content']);
//        Route::post('webinar/add_lesson', ['as' => 'manager.add_lesson', 'uses' => 'webinarControllwe@add_lesson']);
//        Route::post('webinar/add_lesson_attach', ['as' => 'manager.add_lesson_attach', 'uses' => 'webinarControllwe@add_lesson_attach']);
//        Route::post('webinar/delete_lesson ', ['as' => 'manager.delete_lesson', 'uses' => 'webinarControllwe@delete_lesson']);
//        Route::post('webinar/lesson_attachments ', ['as' => 'manager.lesson_attachments', 'uses' => 'webinarControllwe@lesson_attachments']);
//        Route::post('webinar/delete_lesson_attachment ', ['as' => 'manager.delete_lesson_attachment', 'uses' => 'webinarControllwe@delete_lesson_attachment']);
//        Route::post('webinar/get_lesson ', ['as' => 'manager.get_lesson', 'uses' => 'webinarControllwe@get_lesson']);
//        Route::post('webinar/edit_lesson ', ['as' => 'manager.edit_lesson', 'uses' => 'webinarControllwe@edit_lesson']);
//        Route::get('webinar/all_comments', ['as' => 'course.all_comments', 'uses' => 'webinarControllwe@all_comments']);
//        Route::get('webinar/allcourse_comments', ['as' => 'course.allcourse_comments', 'uses' => 'webinarControllwe@allcourse_comments']);
//        Route::get('webinar/comments', ['as' => 'course.show_course_comments', 'uses' => 'webinarControllwe@show_course_comments']);
//        Route::get('webinar/quizques', ['as' => 'course.show_course_quizques', 'uses' => 'webinarControllwe@show_course_quizques']);
//        Route::post('webinar/add_quiz_question', ['as' => 'course.add_quiz_question', 'uses' => 'webinarControllwe@add_quiz_question']);
//        Route::post('webinar/delete_quiz_question', ['as' => 'course.delete_quiz_question', 'uses' => 'webinarControllwe@delete_quiz_question']);
//        Route::get('webinar/users', ['as' => 'course.course_users', 'uses' => 'webinarControllwe@show_course_users']);
//        Route::get('webinar/users_form', ['as' => 'course.users_form', 'uses' => 'webinarControllwe@course_users_form']);
//        Route::get('webinar/messages', ['as' => 'course.course_messages', 'uses' => 'webinarControllwe@show_course_messages']);
//        Route::post('webinar/reply_message', ['as' => 'course.reply_message', 'uses' => 'webinarControllwe@reply_message']);
//        Route::post('webinar/delete_course ', ['as' => 'manager.delete_course', 'uses' => 'webinarControllwe@delete_course']);
//        Route::get('webinar/{id}/{title?}', ['as' => 'manager.manage_course_edit', 'uses' => 'webinarControllwe@manage_course_edit']);


        Route::get('wikiideas', ['as' => 'manager.wikiideas', 'uses' => 'wikiController@wikiideas']);
        Route::get('wikiideas/add', ['as' => 'manager.add_form', 'uses' => 'wikiController@add_form']);
        Route::post('wikiideas/add_idea', ['as' => 'manager.add_idea', 'uses' => 'wikiController@add_idea']);
        Route::post('wikiideas/delete_idea ', ['as' => 'manager.delete_idea', 'uses' => 'wikiController@delete_idea']);
        Route::get('idea/{id}/{title?}', ['as' => 'manager.view_idea', 'uses' => 'wikiController@view_idea']);
        Route::post('wikiideas/edit_idea', ['as' => 'manager.edit_idea', 'uses' => 'wikiController@edit_idea']);
        Route::get('all_ideas', ['as' => 'manager.all_ideas', 'uses' => 'wikiController@all_ideas']);
        Route::post('wikiideas/comments', ['as' => 'manager.wiki_comments', 'uses' => 'wikiController@wiki_comments']);
        Route::get('wikiideas/allcomments', ['as' => 'manager.wiki_all_comments', 'uses' => 'wikiController@wiki_all_comments']);
        Route::get('all_wiki_comments', ['as' => 'manager.all_wiki_comments', 'uses' => 'wikiController@all_wiki_comments']);


        Route::get('blogs', ['as' => 'manager.blogs', 'uses' => 'blogController@blogs']);
        Route::get('all_blogs', ['as' => 'manager.all_blogs', 'uses' => 'blogController@all_blogs']);
        Route::get('all_blog_comments', ['as' => 'manager.all_blog_comments', 'uses' => 'blogController@all_blog_comments']);
        Route::get('blog/add', ['as' => 'manager.add_form', 'uses' => 'blogController@add_form']);
        Route::post('blog/add_blog', ['as' => 'manager.add_blog', 'uses' => 'blogController@add_blog']);
        Route::post('blog/delete_blog', ['as' => 'manager.delete_blog', 'uses' => 'blogController@delete_blog']);
        Route::post('blog/edit_blog', ['as' => 'manager.edit_blog', 'uses' => 'blogController@edit_blog']);
        Route::post('blog/comments', ['as' => 'manager.blog_comments', 'uses' => 'blogController@blog_comments']);
        Route::get('blog/allcomments', ['as' => 'manager.allcomments', 'uses' => 'blogController@allcomments']);
        Route::get('all_blog_comments', ['as' => 'manager.all_blog_comments', 'uses' => 'blogController@all_blog_comments']);
        Route::get('blog/{id}/{title?}', ['as' => 'manager.view_blog', 'uses' => 'blogController@view_blog']);


        Route::get('landuses', ['as' => 'manager.landuses', 'uses' => 'landuseController@landuses']);
        Route::get('all_landuses', ['as' => 'manager.all_landuses', 'uses' => 'landuseController@all_landuses']);
//        Route::get('all_blog_comments', ['as' => 'manager.all_blog_comments', 'uses' => 'landuseController@all_blog_comments']);
        Route::get('landuse/add', ['as' => 'manager.add_form', 'uses' => 'landuseController@add_form']);
        Route::post('landuse/add_landuse', ['as' => 'manager.add_landuse', 'uses' => 'landuseController@add_landuse']);
        Route::post('landuse/delete_landuse', ['as' => 'manager.delete_landuse', 'uses' => 'landuseController@delete_landuse']);
        Route::post('landuse/edit_landuse', ['as' => 'manager.edit_landuse', 'uses' => 'landuseController@edit_landuse']);
//        Route::post('landuse/comments', ['as' => 'manager.landuse_comments', 'uses' => 'landuseController@blog_comments']);
//        Route::get('landuse/allcomments', ['as' => 'manager.allcomments', 'uses' => 'landuseController@allcomments']);
//        Route::get('all_landuse_comments', ['as' => 'manager.all_landuse_comments', 'uses' => 'landuseController@all_blog_comments']);
        Route::get('landuse/{id}/{title?}', ['as' => 'manager.view_landuse', 'uses' => 'landuseController@view_landuse']);
        Route::post('landuse/up_to_gallery_landuse', ['as' => 'manager.up_to_gallery_landuse', 'uses' => 'landuseController@up_to_gallery_landuse']);
        Route::post('landuse/delete_landuse_image', ['as' => 'manager.delete_landuse_image', 'uses' => 'landuseController@delete_landuse_image']);

        Route::get('news', ['as' => 'manager.newss', 'uses' => 'newsController@newss']);
        Route::get('all_news', ['as' => 'manager.all_news', 'uses' => 'newsController@all_news']);
        Route::get('all_news_comments', ['as' => 'manager.all_news_comments', 'uses' => 'newsController@all_news_comments']);
        Route::get('news/add', ['as' => 'manager.add_form', 'uses' => 'newsController@add_form']);
        Route::post('news/add_news', ['as' => 'manager.add_news', 'uses' => 'newsController@add_news']);
        Route::post('news/delete_news', ['as' => 'manager.delete_news', 'uses' => 'newsController@delete_news']);
        Route::post('news/edit_news', ['as' => 'manager.edit_idea', 'uses' => 'newsController@edit_news']);
        Route::post('news/comments', ['as' => 'manager.news_comments', 'uses' => 'newsController@news_comments']);
        Route::get('news/allcomments', ['as' => 'manager.allcomments', 'uses' => 'newsController@allcomments']);
        Route::get('all_news_comments', ['as' => 'manager.all_news_comments', 'uses' => 'newsController@all_news_comments']);
        Route::get('news/{id}/{title?}', ['as' => 'manager.view_news', 'uses' => 'newsController@view_news']);


        Route::get('consults', ['as' => 'manager.consults', 'uses' => 'consultController@consults']);
        Route::get('all_consults', ['as' => 'manager.all_consults', 'uses' => 'consultController@all_consults']);
        Route::post('consult/all_comments', ['as' => 'manager.consult_all_comments', 'uses' => 'consultController@consult_all_comments']);
        Route::get('all_consult_comments', ['as' => 'manager.all_consult_comments', 'uses' => 'consultController@all_consult_comments']);

        Route::get('consult/add', ['as' => 'manager.add_form', 'uses' => 'consultController@add_form']);
        Route::post('consult/add_consult', ['as' => 'manager.add_consult', 'uses' => 'consultController@add_consult']);
        Route::post('consult/add_education', ['as' => 'manager.add_education', 'uses' => 'consultController@add_education']);
        Route::post('consult/delete_education', ['as' => 'manager.delete_education', 'uses' => 'consultController@delete_education']);
        Route::post('consult/delete_consult', ['as' => 'manager.delete_consult', 'uses' => 'consultController@delete_consult']);
        Route::post('consult/edit_consult_info', ['as' => 'manager.edit_consult_info', 'uses' => 'consultController@edit_consult_info']);
        Route::post('consult/edit_consult_skill', ['as' => 'manager.edit_consult_skill', 'uses' => 'consultController@edit_consult_skill']);
        Route::post('consult/edit_consult_contact', ['as' => 'manager.edit_consult_contact', 'uses' => 'consultController@edit_consult_contact']);
        Route::post('consult/edit_consult_bank', ['as' => 'manager.edit_consult_bank', 'uses' => 'consultController@edit_consult_bank']);
        Route::post('consult/all_consultTimes', ['as' => 'manager.all_consultTimes', 'uses' => 'consultController@all_consultTimes']);
        Route::post('consult/all_consulting', ['as' => 'manager.all_consulting', 'uses' => 'consultController@all_consulting']);
        Route::get('consult/course/{id}/users', ['as' => 'manager.consult_course_users', 'uses' => 'consultController@course_users']);
        Route::post('consult/course/all_course_users', ['as' => 'manager.consult_all_course_users', 'uses' => 'consultController@all_course_users']);
        Route::get('consults/comments', ['as' => 'manager.consults_comments', 'uses' => 'consultController@consults_comments']);
        Route::post('consult/all_consult_payments', ['as' => 'manager.all_consult_payments', 'uses' => 'consultController@all_consult_payments']);
        Route::get('consult/list_reserve', ['as' => 'manager.list_reserve', 'uses' => 'consultController@list_reserve']);
        Route::post('consult/set_consult_time', ['as' => 'manager.set_consult_time', 'uses' => 'consultController@set_consult_time']);
        Route::post('consult/complete_consult', ['as' => 'manager.complete_consult', 'uses' => 'consultController@complete_consult']);
        Route::get('consulting/{id}/{title?}', ['as' => 'manager.view_consulting', 'uses' => 'consultController@view_consulting']);
        Route::get('consult/{id}/{title?}', ['as' => 'manager.view_consult', 'uses' => 'consultController@view_consult']);


        Route::get('teachers', ['as' => 'manager.teachers', 'uses' => 'teacherController@teachers']);
        Route::get('all_teachers', ['as' => 'manager.all_teachers', 'uses' => 'teacherController@all_teachers']);
        Route::get('all_teacher_comments', ['as' => 'manager.all_teacher_comments', 'uses' => 'teacherController@all_teacher_comments']);
        Route::get('teacher/add', ['as' => 'manager.add_form', 'uses' => 'teacherController@add_form']);
        Route::post('teacher/add_teacher', ['as' => 'manager.add_teacher', 'uses' => 'teacherController@add_teacher']);
        Route::post('teacher/add_education', ['as' => 'manager.add_education', 'uses' => 'teacherController@add_education']);
        Route::post('teacher/delete_education', ['as' => 'manager.delete_education', 'uses' => 'teacherController@delete_education']);
        Route::post('teacher/delete_teacher', ['as' => 'manager.delete_teacher', 'uses' => 'teacherController@delete_teacher']);
        Route::post('teacher/edit_teacher_info', ['as' => 'manager.edit_teacher_info', 'uses' => 'teacherController@edit_teacher_info']);
        Route::post('teacher/edit_teacher_skill', ['as' => 'manager.edit_teacher_skill', 'uses' => 'teacherController@edit_teacher_skill']);
        Route::post('teacher/edit_teacher_contact', ['as' => 'manager.edit_teacher_contact', 'uses' => 'teacherController@edit_teacher_contact']);
        Route::post('teacher/edit_teacher_bank', ['as' => 'manager.edit_teacher_bank', 'uses' => 'teacherController@edit_teacher_bank']);
        Route::post('teacher/comments', ['as' => 'manager.teacher_comments', 'uses' => 'teacherController@all_comments']);
        Route::post('teacher/all_courses', ['as' => 'manager.teacher_all_courses', 'uses' => 'teacherController@all_courses_with_manager']);
        Route::get('teacher/course/{id}/users', ['as' => 'manager.teacher_course_users', 'uses' => 'teacherController@course_users']);
        Route::post('teacher/course/all_course_users', ['as' => 'manager.teacher_all_course_users', 'uses' => 'teacherController@all_course_users']);
        Route::get('teachers/comments', ['as' => 'manager.teachers_comments', 'uses' => 'teacherController@teachers_comments']);
        Route::get('teacher/{id}/{title?}', ['as' => 'manager.view_teacher', 'uses' => 'teacherController@view_teacher']);


        // webinar
        Route::get('workshops', ['as' => 'manager.workshops', 'uses' => 'workshopController@workshops']);
        Route::get('all_workshops', ['as' => 'manager.all_workshops', 'uses' => 'workshopController@all_workshops']);
        Route::get('webinar/comments', ['as' => 'manager.workshop_comments', 'uses' => 'workshopController@workshop_comments']);
        Route::get('all_workshop_comments', ['as' => 'manager.all_workshop_comments', 'uses' => 'workshopController@all_workshop_comments']);


        // category
        Route::get('category', ['as' => 'manager.category', 'uses' => 'categoryController@category']);
        Route::get('shop_category', ['as' => 'manager.shop_category', 'uses' => 'categoryController@shop_category']);
        Route::get('category/add', ['as' => 'manager.add_form', 'uses' => 'categoryController@add_form']);
        Route::post('category/add_category', ['as' => 'manager.add_category', 'uses' => 'categoryController@add_category']);
        Route::post('category/add_shop_group_category', ['as' => 'manager.add_shop_group_category', 'uses' => 'categoryController@add_shop_group_category']);
        Route::post('category/add_shop_daste_category', ['as' => 'manager.add_shop_daste_category', 'uses' => 'categoryController@add_shop_daste_category']);
        Route::post('category/delete_category ', ['as' => 'manager.delete_category', 'uses' => 'categoryController@delete_category']);
        Route::post('category/edit_category', ['as' => 'manager.edit_category', 'uses' => 'categoryController@edit_category']);
        Route::get('all_categorys', ['as' => 'manager.all_category', 'uses' => 'categoryController@all_categorys']);
        Route::get('all_shop_categorys', ['as' => 'manager.all_shop_categorys', 'uses' => 'categoryController@all_shop_categorys']);


        // user
        Route::get('all_users', ['as' => 'manager.all_users', 'uses' => 'userController@all_users']);
        Route::get('user_setting/{id}/{title?}', ['as' => 'manager.manager_user_setting', 'uses' => 'userController@manager_user_setting']);
        Route::get('user_detail/{id}/{title?}', ['as' => 'manager.manager_user_detail', 'uses' => 'userController@manager_user_detail']);
        Route::get('user_dashboard/{id}/{title?}', ['as' => 'manager.manager_user_dashboard', 'uses' => 'userController@manager_user_dashboard']);
        Route::get('teacher_dashboard/{id}/{title?}', ['as' => 'manager.manager_teacher_dashboard', 'uses' => 'teacherController@manager_teacher_dashboard']);
        Route::get('consult_dashboard/{id}/{title?}', ['as' => 'manager.manager_consult_dashboard', 'uses' => 'consultController@manager_consult_dashboard']);
        Route::post('user/updatePersonalSetting', ['as' => 'manager.updatePersonalSetting', 'uses' => 'userController@updatePersonalSetting']);
        Route::post('user/increasWallet', ['as' => 'manager.increasWallet', 'uses' => 'userController@increasWallet']);
        Route::post('user/decreasWallet', ['as' => 'manager.decreasWallet', 'uses' => 'userController@decreasWallet']);
        Route::post('user/changeStatus', ['as' => 'manager.changeStatus', 'uses' => 'userController@changeStatus']);
        Route::post('user/changePermissions', ['as' => 'manager.changePermissions', 'uses' => 'userController@changePermissions']);
        Route::post('user/changePass', ['as' => 'manager.changePass', 'uses' => 'userController@changePass']);
        Route::post('user/add_user', ['as' => 'manager.add_user', 'uses' => 'userController@add_user']);
        Route::get('user/add', ['as' => 'manager.add_user_form', 'uses' => 'userController@add_user_form']);

        Route::get('info', ['as' => 'manager.user_info', 'uses' => 'adminController@user_info']);


        Route::get('necessary', ['as' => 'manager.necessary', 'uses' => 'adminController@necessary']);
        Route::get('shops', ['as' => 'manager.shop', 'uses' => 'adminController@shop']);
        Route::get('faq', ['as' => 'manager.faq', 'uses' => 'adminController@faq']);
        Route::get('contactus', ['as' => 'manager.contactus', 'uses' => 'adminController@contactus']);
        Route::get('users', ['as' => 'manager.users', 'uses' => 'adminController@users']);

        Route::get('quizs', ['as' => 'manager.quizs', 'uses' => 'adminController@quizs']);
        Route::get('certificates', ['as' => 'manager.certificates', 'uses' => 'adminController@certificates']);
        Route::get('favorites', ['as' => 'manager.favorites', 'uses' => 'adminController@favorites']);
        Route::get('comments', ['as' => 'manager.comments', 'uses' => 'adminController@comments']);
        Route::get('chats', ['as' => 'manager.chats', 'uses' => 'adminController@chats']);
        Route::get('payments', ['as' => 'manager.payments', 'uses' => 'adminController@payments']);
        Route::get('get_wallet', ['as' => 'manager.get_wallet', 'uses' => 'adminController@get_wallet']);
        Route::get('settings', ['as' => 'manager.settings', 'uses' => 'adminController@setting']);

        Route::post('newUser', ['as' => 'manager.newUser', 'uses' => 'adminController@newUser']);
        Route::post('updateUser', ['as' => 'manager.updateUser', 'uses' => 'adminController@updateUser']);
        Route::post('deactiveUser', ['as' => 'manager.deactiveUser', 'uses' => 'adminController@deactiveUser']);
        Route::post('activeUser', ['as' => 'manager.activeUser', 'uses' => 'adminController@activeUser']);
        Route::post('updateUserSetting', ['as' => 'manager.updateUserSetting', 'uses' => 'adminController@updateUserSetting']);
        Route::post('updateUserImages', ['as' => 'manager.updateUserImages', 'uses' => 'adminController@updateUserImages']);
        Route::post('updateUserPass', ['as' => 'manager.updateUserPass', 'uses' => 'adminController@updateUserPass']);


        Route::group(['prefix' => 'markaz'], function () {
            Route::get('vams', ['as' => 'manager.vams', 'uses' => 'markazController@managerVams']);
            Route::get('vam/{id}', ['as' => 'manager.view_vam', 'uses' => 'markazController@manager_view_vam']);

            Route::get('databases2', ['as' => 'manager.databases2', 'uses' => 'markazController@manager_databases2']);
            Route::get('dbs2/{id}', ['as' => 'manager.view_databases2', 'uses' => 'markazController@manager_view_databases2']);

            Route::get('followup', ['as' => 'markaz.followup', 'uses' => 'markazController@manager_followup']);

        });


    });


    Route::get('/calendar', function () {
        return view('manager.calendar2');
    });
});


// technical manager
Route::group(['prefix' => 'technical'], function () {
//    Route::group(array('middleware' => ['auth', 'checkLogin']), function () {

    Route::get('dashboard', ['as' => 'technical.dashboard', 'uses' => 'userController@dashboard']);
    Route::get('tollab_failure', ['as' => 'technical.tollab_failure', 'uses' => 'userController@tollab_failure']);
    Route::get('employee_failure', ['as' => 'technical.employee_failure', 'uses' => 'userController@employee_failure']);
    Route::get('tollab_complete', ['as' => 'technical.tollab_complete', 'uses' => 'userController@tollab_complete']);
    Route::get('all_failure_tollab', ['as' => 'technical.all_failure_tollab', 'uses' => 'userController@all_failure_tollab']);
    Route::get('all_failure_employee', ['as' => 'technical.all_failure_employee', 'uses' => 'userController@all_failure_employee']);
    Route::post('verify_user', ['as' => 'technical.verify_user', 'uses' => 'userController@verify_user']);
    Route::get('settings', ['as' => 'technical.settings', 'uses' => 'userController@technical_settings']);
    Route::get('viewuser/{id}', ['as' => 'technical.viewuser', 'uses' => 'userController@viewuser']);
    Route::post('updateUserinfo_technical', ['as' => 'technical.updateUserinfo_technical', 'uses' => 'userController@updateUserinfo_technical']);
//    });
});


// teacher
Route::group(['prefix' => 'teacher'], function () {

    Route::get('profile/{id_teacher}/{title?}', ['as' => 'teacher.teacher_profile', 'uses' => 'teacherController@teacher_profile']);

    Route::group(array('middleware' => ['auth', 'checkLogin']), function () {
        Route::get('dashboard', ['as' => 'teacher.teacher_dashboard', 'uses' => 'teacherController@teacher_dashboard']);

        Route::get('course', ['as' => 'teacher.courses', 'uses' => 'teacherController@courses']);
        Route::get('all_courses', ['as' => 'teacher.all_courses', 'uses' => 'teacherController@all_courses']);
//        Route::get('course/{id_course}/users', ['as' => 'teacher.course_users', 'uses' => 'teacherController@course_users']);
        Route::get('course/{id_course}/detail', ['as' => 'teacher.course_detail', 'uses' => 'teacherController@course_detail']);
        Route::get('message/{id_message}/detail', ['as' => 'main.detail_message', 'uses' => 'mainController@detail_message']);
//        Route::get('all_course_users', ['as' => 'teacher.all_course_users', 'uses' => 'teacherController@all_course_users']);
        Route::get('course_comments', ['as' => 'course.course_comments', 'uses' => 'courseController@course_comments']);
        Route::get('all_course_comments', ['as' => 'course.all_course_comments', 'uses' => 'courseController@all_course_comments']);
        Route::post('lessonAttachments', ['as' => 'teacher.lessonAttachments', 'uses' => 'teacherController@lessonAttachments']);
        Route::get('course_quiz', ['as' => 'teacher.course_quiz', 'uses' => 'teacherController@course_quiz']);
        Route::get('message', ['as' => 'teacher.message', 'uses' => 'teacherController@message']);

        Route::get('comment', ['as' => 'teacher.comment', 'uses' => 'teacherController@comments']);
        Route::get('all_comments', ['as' => 'teacher.all_comments', 'uses' => 'teacherController@all_comments']);
        Route::post('get_comment', ['as' => 'teacher.get_comment', 'uses' => 'teacherController@get_comment']);
        Route::get('settings', ['as' => 'teacher.settings', 'uses' => 'teacherController@settings']);
        Route::get('info', ['as' => 'teacher.info', 'uses' => 'teacherController@info']);
        Route::get('payments', ['as' => 'teacher.payments', 'uses' => 'teacherController@payments']);
        Route::get('all_payments', ['as' => 'teacher.all_payments', 'uses' => 'teacherController@all_payments']);
        Route::get('wallet', ['as' => 'teacher.wallet', 'uses' => 'teacherController@wallet']);

    });

});


// admin profile
Route::group(['prefix' => 'markaz'], function () {
    Route::group(array('middleware' => ['auth', 'checkLogin']), function () {

        Route::get('vam', ['as' => 'markaz.vams', 'uses' => 'markazController@vam']);
        Route::get('vam_followup', ['as' => 'markaz.vam_followup', 'uses' => 'markazController@vam_followup']);
        Route::post('vam_followup_check', ['as' => 'markaz.vam_followup_check', 'uses' => 'markazController@vam_followup_check']);
        Route::post('requestVam', ['as' => 'markaz.requestVam', 'uses' => 'markazController@requestVam']);

        Route::post('addVamProduct', ['as' => 'markaz.addVamProduct', 'uses' => 'markazController@addVamProduct']);
        Route::post('deleteVamProduct', ['as' => 'markaz.deleteVamProduct', 'uses' => 'markazController@deleteVamProduct']);
        Route::post('uploadVamAttach', ['as' => 'markaz.uploadVamAttach', 'uses' => 'markazController@uploadVamAttach']);
        Route::post('verifyVam', ['as' => 'markaz.verifyVam', 'uses' => 'markazController@verifyVam']);
        Route::get('vam_from1', ['as' => 'markaz.vam_from1', 'uses' => 'markazController@vam_from1']);
        Route::get('database', ['as' => 'markaz.database', 'uses' => 'markazController@database']);
        Route::get('databases1', ['as' => 'markaz.databases1', 'uses' => 'markazController@databases1']);
        Route::get('databases2', ['as' => 'markaz.databases2', 'uses' => 'markazController@databases2']);
        Route::get('databases3', ['as' => 'markaz.databases3', 'uses' => 'markazController@databases3']);
        Route::get('databases4', ['as' => 'markaz.databases4', 'uses' => 'markazController@databases4']);
        Route::get('database1', ['as' => 'markaz.markaz_db1', 'uses' => 'markazController@markaz_db1']);
        Route::get('database2', ['as' => 'markaz.markaz_db2', 'uses' => 'markazController@markaz_db2']);
        Route::get('database3', ['as' => 'markaz.markaz_db3', 'uses' => 'markazController@markaz_db3']);
        Route::get('database4', ['as' => 'markaz.markaz_db4', 'uses' => 'markazController@markaz_db4']);

        Route::post('registDatabase1', ['as' => 'markaz.registDatabase1', 'uses' => 'markazController@registDatabase1']);
        Route::post('registDatabase1Course', ['as' => 'markaz.registDatabase1Course', 'uses' => 'markazController@registDatabase1Course']);
        Route::post('deleteDatabase1Course', ['as' => 'markaz.deleteDatabase1Course', 'uses' => 'markazController@deleteDatabase1Course']);
        Route::post('uploadDatabase1Attach', ['as' => 'markaz.uploadDatabase1Attach', 'uses' => 'markazController@uploadDatabase1Attach']);
        Route::post('verifyDatabase1', ['as' => 'markaz.verifyDatabase1', 'uses' => 'markazController@verifyDatabase1']);

        Route::post('registDatabase2', ['as' => 'markaz.registDatabase2', 'uses' => 'markazController@registDatabase2']);
        Route::post('uploadDatabase2Attach', ['as' => 'markaz.uploadDatabase2Attach', 'uses' => 'markazController@uploadDatabase2Attach']);
        Route::post('verifyDatabase2', ['as' => 'markaz.verifyDatabase2', 'uses' => 'markazController@verifyDatabase2']);

        Route::post('registDatabase3', ['as' => 'markaz.registDatabase3', 'uses' => 'markazController@registDatabase3']);
        Route::post('uploadDatabase3Attach', ['as' => 'markaz.uploadDatabase3Attach', 'uses' => 'markazController@uploadDatabase3Attach']);
        Route::post('verifyDatabase3', ['as' => 'markaz.verifyDatabase3', 'uses' => 'markazController@verifyDatabase3']);

        Route::post('registDatabase4', ['as' => 'markaz.registDatabase4', 'uses' => 'markazController@registDatabase4']);
        Route::post('uploadDatabase4Attach', ['as' => 'markaz.uploadDatabase4Attach', 'uses' => 'markazController@uploadDatabase4Attach']);
        Route::post('verifyDatabase4', ['as' => 'markaz.verifyDatabase4', 'uses' => 'markazController@verifyDatabase4']);

        Route::get('all_dbs1', ['as' => 'markaz.all_dbs1', 'uses' => 'markazController@all_dbs1']);
        Route::get('dbs1/{id}', ['as' => 'markaz.view_item_dbs1', 'uses' => 'markazController@view_item_dbs1']);
        Route::post('edit_database1_report', ['as' => 'markaz.edit_database1_report', 'uses' => 'markazController@edit_database1_report']);

        Route::get('all_dbs2', ['as' => 'markaz.all_dbs2', 'uses' => 'markazController@all_dbs2']);
        Route::get('dbs2/{id}', ['as' => 'markaz.view_item_dbs2', 'uses' => 'markazController@view_item_dbs2']);
        Route::post('edit_database2_report', ['as' => 'markaz.edit_database2_report', 'uses' => 'markazController@edit_database2_report']);

        Route::get('all_dbs3', ['as' => 'markaz.all_dbs3', 'uses' => 'markazController@all_dbs3']);
        Route::get('dbs3/{id}', ['as' => 'markaz.view_item_dbs3', 'uses' => 'markazController@view_item_dbs3']);
        Route::post('edit_database3_report', ['as' => 'markaz.edit_database3_report', 'uses' => 'markazController@edit_database3_report']);

        Route::get('all_dbs4', ['as' => 'markaz.all_dbs4', 'uses' => 'markazController@all_dbs4']);
        Route::get('dbs4/{id}', ['as' => 'markaz.view_item_dbs4', 'uses' => 'markazController@view_item_dbs4']);
        Route::post('edit_database4_report', ['as' => 'markaz.edit_database4_report', 'uses' => 'markazController@edit_database4_report']);


        Route::post('upload_image/{type}/{id_user?}', ['as' => 'markaz.upload_image', 'uses' => 'markazController@upload_image']);
        Route::get('delete_image/', ['as' => 'markaz.delete_image', 'uses' => 'markazController@delete_image']);

        Route::get('recover_followcode', ['as' => 'markaz.recover_followcode', 'uses' => 'markazController@recover_followcode']);

        Route::group(['prefix' => 'admin'], function () {

            Route::get('/', ['as' => 'markaz.followup', 'uses' => 'markazController@admin_dashboard']);
            Route::get('dashboard', ['as' => 'markaz.admin_dashboard', 'uses' => 'markazController@admin_dashboard']);
            Route::get('vams', ['as' => 'markaz.vams', 'uses' => 'markazController@vams']);
            Route::get('all_vams/{type?}', ['as' => 'markaz.all_vams', 'uses' => 'markazController@all_vams']);
            Route::get('vam/{id}', ['as' => 'markaz.view_vam', 'uses' => 'markazController@view_vam']);
            Route::post('edit_reports', ['as' => 'markaz.edit_reports', 'uses' => 'markazController@edit_reports']);
            Route::get('followup', ['as' => 'markaz.followup', 'uses' => 'markazController@followup']);
            Route::post('check_followup', ['as' => 'markaz.check_followup', 'uses' => 'markazController@check_followup']);
            Route::get('settings', ['as' => 'markaz.settings', 'uses' => 'markazController@settings']);
            Route::get('vam1', ['as' => 'markaz.vam1', 'uses' => 'markazController@vam1']);
            Route::get('kanons', ['as' => 'markaz.kanons', 'uses' => 'markazController@kanons']);
            Route::get('all_kanons', ['as' => 'markaz.all_kanons', 'uses' => 'markazController@all_kanons']);
            Route::post('addkanon', ['as' => 'markaz.addkanon', 'uses' => 'markazController@addkanon']);
            Route::post('delkanon', ['as' => 'markaz.delkanon', 'uses' => 'markazController@delkanon']);

            Route::get('databases2', ['as' => 'markaz.databases2', 'uses' => 'markazController@databases2']);
            Route::get('all_dbs2', ['as' => 'markaz.all_dbs2', 'uses' => 'markazController@all_dbs2']);
            Route::get('dbs2/{id}', ['as' => 'markaz.view_item_dbs2', 'uses' => 'markazController@view_item_dbs2']);
            Route::post('edit_database2_report', ['as' => 'markaz.edit_database2_report', 'uses' => 'markazController@edit_database2_report']);

            Route::post('requestVam_editor', ['as' => 'markaz.requestVam_editor', 'uses' => 'markazController@requestVam_editor']);

        });


    });

    Route::get('/calendar', function () {
        return view('manager.calendar2');
    });
});


// consult profile
Route::group(['prefix' => 'consult'], function () {

    Route::get('profile/{id_consult}/{fullname?}', ['as' => 'consult.consult_profile', 'uses' => 'consultController@consult_profile']);
    Route::get('index', ['as' => 'consult.consult_index', 'uses' => 'consultController@consult_index']);
    Route::get('/', ['as' => 'consult.consult_index', 'uses' => 'consultController@consult_index']);

    Route::get('/category/{id_category}/{title}', ['as' => 'consult.consult_category', 'uses' => 'consultController@consult_category']);
    Route::post('/search_consult', ['as' => 'consult.search_consult', 'uses' => 'consultController@search_consult']);
    Route::get('/consults', ['as' => 'consult.consult_list', 'uses' => 'consultController@consult_list']);
    Route::post('/search_consult_ajax', ['as' => 'consult.search_consult_ajax', 'uses' => 'consultController@search_consult_ajax']);
    Route::post('/filter_consult_ajax', ['as' => 'consult.filter_consult_ajax', 'uses' => 'consultController@filter_consult_ajax']);
    Route::get('/consult/{id_consult}/{fullname?}', ['as' => 'consult.consult_profile', 'uses' => 'consultController@consult_profile']);
    Route::post('consulting_factor', ['as' => 'consult.consulting_factor', 'uses' => 'consultController@register_consult_factor']);
    Route::post('reserve_consult_payment', ['as' => 'consult.reserve_consult_payment', 'uses' => 'consultController@reserve_consult_payment']);
    Route::get('/verifyPayment', ['as' => 'consult.verifyPayment', 'uses' => 'consultController@verifyPayment']);
    Route::get('faq', ['as' => 'consult.faq', 'uses' => 'consultController@faq']);


    Route::group(array('middleware' => ['auth', 'checkLogin']), function () {
        Route::get('dashboard', ['as' => 'consult.consult_dashboard', 'uses' => 'consultController@consult_dashboard']);
        Route::get('list_consulting', ['as' => 'consult.list_consulting', 'uses' => 'consultController@list_consulting']);
        Route::post('all_consultTimes', ['as' => 'consult.all_consultTimes', 'uses' => 'consultController@all_consultTimes']);
        Route::get('consulting/{id}/{title?}', ['as' => 'consult.consulting', 'uses' => 'consultController@consulting']);

        Route::get('message', ['as' => 'consult.message', 'uses' => 'consultController@message']);
        Route::get('comments', ['as' => 'consult.comments', 'uses' => 'consultController@comments']);

        Route::get('all_comments', ['as' => 'consult.all_comments', 'uses' => 'consultController@consult_all_comments']);
        Route::post('get_comment', ['as' => 'consult.get_comment', 'uses' => 'consultController@get_comment']);
        Route::get('settings', ['as' => 'consult.settings', 'uses' => 'consultController@settings']);
        Route::get('info', ['as' => 'consult.info', 'uses' => 'consultController@info_consult']);

        Route::get('payments', ['as' => 'consult.payments', 'uses' => 'consultController@payments']);
        Route::get('all_consult_payments', ['as' => 'consult.all_consult_payments', 'uses' => 'consultController@all_consult_payments']);
        Route::get('wallet', ['as' => 'consult.wallet', 'uses' => 'consultController@wallet']);

    });

});


Route::get('/employed-true', 'userController@employed_true');
Route::get('/employed-false', 'userController@employed_false');

Route::get('category/{slug}', [courseController::class, 'category_course'])->name('category_course');

// course
$subjects = [
    'course'
];


foreach ($subjects as $subject) {
    Route::group(['prefix' => $subject], function () {

        Route::get('/{slug}', [courseController::class, 'course_detail']);
        Route::get('/take_course/{id_course}/{slug?}', [courseController::class, 'take_course']);

        Route::group(array('middleware' => ['auth', 'checkLogin']), function () {
            Route::post('/add_note', ['as' => 'course.add_note', 'uses' => 'courseController@add_note']);
            Route::post('/get_certificate', ['as' => 'course.get_certificate', 'uses' => 'courseController@get_certificate']);
            Route::post('/delete_note', ['as' => 'course.delete_note', 'uses' => 'courseController@delete_note']);
            Route::post('/course_payment', [courseController::class, 'course_payment']);
            Route::get('/verifyPayment', [courseController::class, 'verifyPayment']);
            Route::post('/lesson_complete', ['as' => 'course.lesson_complete', 'uses' => 'courseController@lesson_complete']);
            Route::get('/quiz/{id_course}/{title?}', ['as' => 'course.quiz', 'uses' => 'courseController@quiz']);
            Route::get('/quiz_result/{id_classroom}/{title?}', ['as' => 'course.quiz_result', 'uses' => 'courseController@quiz_result']);
            Route::post('/quiz_correction', ['as' => 'course.quiz_correction', 'uses' => 'courseController@quiz_correction']);
        });

    });
}

$skill_subjects = [
    's', 'skill'
];

foreach ($skill_subjects as $subject) {

    Route::group(['prefix' => $subject], function () {
        Route::get('/new', [courseController::class, 'course_index_new']);
        Route::post('/course/suggestion/change', [courseController::class, 'courseSuggestionChange']);
        Route::get('/invite_teacher', [courseController::class, 'invite_teacher']);
        Route::get('/course_suggestion', [courseController::class, 'course_suggestion']);
        Route::post('/invite_teacher_register', [courseController::class, 'invite_teacher_register']);
        Route::get('/category/{id_category}/{title?}', [courseController::class, 'category_courses']);
        Route::get('/lesson/{id_course}/{id_lesson}/{title?}', ['as' => 'course.lesson_detail', 'uses' => 'courseController@lesson_detail']);
        Route::get('/lessons/{id_cat}/{title?}', ['as' => 'course.cat_lessons', 'uses' => 'courseController@cat_lessons']);
        Route::post('/search_course', [courseController::class, 'search_course']);
        Route::post('/public_search', [courseController::class, 'public_search']);
        Route::get('/search', [courseController::class, 'search']);
        Route::post('/search_course_ajax', ['as' => 'course.search_course_ajax', 'uses' => 'courseController@search_course_ajax']);
        Route::post('/filter_course_ajax', ['as' => 'course.filter_course_ajax', 'uses' => 'courseController@filter_course_ajax']);
        Route::post('/category_courses', [courseController::class, 'category_courses']);
        Route::get('/faq', [courseController::class, 'faq']);
        Route::get('/courses', [courseController::class, 'course']);
        Route::get('/certificates', [courseController::class, 'certificates']);
//        Route::get('/category/{id_category}/{title?}', [courseController::class, 'category_course']);
        Route::get('/course/pre-registration/submit/{slug}', [courseController::class, 'coursePreRegistrationSubmit']);

        Route::get('webinars', [webinarController::class, 'webinar_list']);
        Route::get('webinar/verifyPayment', [webinarController::class, 'verifyPayment']);
        Route::post('webinar/search', [webinarController::class, 'search']);
        Route::post('webinar/filter', [webinarController::class, 'filter']);
        Route::get('webinar/{id}/{title?}', [webinarController::class, 'webinar_intro']);
        Route::get('take_webinar/{id_webinar}/{title?}', [webinarController::class, 'take_webinar']);
        Route::post('webinar/webinar_payment', [webinarController::class, 'webinar_payment']);

        Route::group(array('middleware' => ['auth', 'checkLogin']), function () {
            Route::post('/regist_course_suggestion', [courseController::class, 'regist_course_suggestion']);
        });
    });

}


//wikiidea
Route::group(['prefix' => 'wikiidea'], function () {

    Route::get('/', [wikiController::class, 'wikiidea']);
    Route::post('/cat/search/ajax', [wikiController::class, 'wikiListCatSearch']);
    Route::get('/cat/{title}', [wikiController::class, 'wikiListCat']);
    Route::get('/details/{id}', [wikiController::class, 'wikiideaDetails']);
    Route::post('/comments/details/search', [wikiController::class, 'commentsDetailsSearch']);
    Route::post('/store/comment', [wikiController::class, 'storeComment']);
    Route::post('/store/like', [wikiController::class, 'storeLike']);

    // wikiidea
    Route::get('/writer/{id_writer}/{title?}', [wikiController::class, 'wiki_writer']);
    Route::get('/category/{id_category}/{title}', [wikiController::class, 'wiki_category']);
    Route::get('/best', [wikiController::class, 'wiki_best']);
    Route::get('/view', [wikiController::class, 'wiki_view']);
    Route::get('/share', [wikiController::class, 'wiki_share']);
    Route::post('/add_idea', [wikiController::class, 'add_user_idea']);
    Route::post('/search_idea_ajax', [wikiController::class, 'search_idea_ajax']);
    Route::post('/filter_idea_ajax', [wikiController::class, 'filter_idea_ajax']);
    Route::get('/idea/{id_idea}/{title?}', [wikiController::class, 'idea_detail']);
    Route::post('/public_search', [wikiController::class, 'public_search']);
});


// hires profile
Route::group(['prefix' => 'hires'], function () {
    Route::get('/', ['as' => 'hire.hire_list', 'uses' => 'hireController@hire_list']);
    Route::get('/hire_intro/{id_hire}/{title?}', ['as' => 'hire.hire_intro', 'uses' => 'hireController@hire_intro']);
    Route::get('/hire_take/{id_hire}/{title?}', ['as' => 'hire.take_hire', 'uses' => 'hireController@hire_take']);
    Route::post('/hire_payment', ['as' => 'hire.hire_payment', 'uses' => 'hireController@hire_payment']);
    Route::get('/verifyPayment', ['as' => 'hire.verifyPayment', 'uses' => 'hireController@verifyPayment']);
    Route::get('/hire_room/{id_hire}/{title?}', ['as' => 'hire.hire_room', 'uses' => 'hireController@hire_room']);
    Route::post('hire_notes', ['as' => 'hire.hire_notes', 'uses' => 'hireController@hire_notes']);
    Route::post('hire_blogs', ['as' => 'hire.hire_blogs', 'uses' => 'hireController@hire_blogs']);
    Route::post('hire_videocasts', ['as' => 'hire.hire_videocasts', 'uses' => 'hireController@hire_videocasts']);
    Route::post('hire_podcasts', ['as' => 'hire.hire_podcasts', 'uses' => 'hireController@hire_podcasts']);
    Route::post('hire_questions', ['as' => 'hire.hire_questions', 'uses' => 'hireController@hire_questions']);
    Route::post('hire_consult', ['as' => 'hire.hire_consult', 'uses' => 'hireController@hire_consult']);
    Route::post('hire_myques', ['as' => 'hire.hire_myques', 'uses' => 'hireController@hire_myques']);
    Route::post('hire_quizs', ['as' => 'hire.hire_quizs', 'uses' => 'hireController@hire_quizs']);
    Route::get('hire_quiz_result/{id}/{title?}', ['as' => 'hire.hire_quiz_result', 'uses' => 'hireController@hire_quiz_result']);
    Route::get('hire_new_quiz/{id}/{title?}', ['as' => 'hire.hire_new_quiz', 'uses' => 'hireController@hire_new_quiz']);
    Route::post('hire_quiz_correction', ['as' => 'hire.hire_quiz_correction', 'uses' => 'hireController@hire_quiz_correction']);
    Route::post('send_user_ques', ['as' => 'hire.send_user_ques', 'uses' => 'hireController@send_user_ques']);

});


Route::group(['prefix' => 'lives'], function () {
    Route::get('/', ['as' => 'live.lives', 'uses' => 'liveController@lives']);
    Route::get('/lives', ['as' => 'live.lives', 'uses' => 'liveController@lives']);
    Route::get('/live/{id}/{title?}', ['as' => 'live.live', 'uses' => 'liveController@live']);
    Route::post('/live_invite', ['as' => 'live.live_invite', 'uses' => 'liveController@live_invite']);
});


Route::get('/category', ['as' => 'course.category', 'uses' => 'courseController@category']);
Route::post('/check_discount', [mainController::class, 'check_discount']);
Route::post('/add_favorite', [mainController::class, 'add_favorite']);
Route::post('/remove_favorite', [mainController::class, 'remove_favorite']);
Route::get('/add_favorite/{id_course}/{title?}', [courseController::class, 'add_favorite_url']);


// deaf

Route::group(['prefix' => 'deaf'], function () {
    Route::get('/', ['as' => 'deaf.index', 'uses' => 'deafController@index']);
});

Route::get('/test', ['as' => 'course.test', 'uses' => 'mainController@test']);

Route::post('/sms', ['as' => 'main.send_sms', 'uses' => 'mainController@send_sms']);
Route::get('/sms/webinar/{id}', ['as' => 'main.send_sms_webinar', 'uses' => 'mainController@send_sms_webinar']);

Route::get('/tech', ['as' => 'main.sign_tech', 'uses' => 'mainController@sign_tech']);

Route::get('/certificate/{type}/', [userController::class, 'downloadCertificate']);

Route::get('/check-certificate', [CertificateController::class, 'getCheckCertificate']);
Route::post('/check-certificate', [CertificateController::class, 'checkCertificate']);

Route::any('search', [SearchController::class, 'search']);
Route::get('feedback', 'FeedbackController@index');
Route::post('feedback-comment', 'FeedbackController@feedbackComment');

Route::get('yalda', 'courseController@yalda');
Route::get('ramezan', 'courseController@ramezan');
Route::get('father-day', 'courseController@fatherDay');
Route::get('/subsid', 'mainController@subsid');
Route::get('icdl', 'mainController@icdl');
Route::post('quiz_icdl', 'mainController@quiz_icdl');
Route::get('quiz-icdl/verifyPayment', 'mainController@verifyPaymentICDL');
Route::get('sms', 'AuthController@sendSmsPhonenumberVerifyCodeTest');

Route::get('tst', 'testController@resetprice');
Route::get('amar', 'testController@amar');
Route::get('reg_webinar/{id_webinar}/{id_course}', 'testController@register_webinar_to_class');
Route::get('reg_sugg/{id_sugg}/{id_course}/{max}', 'testController@register_sugg_to_class');

Route::get('reg_faild/{id_course}/{max}', 'testController@reg_faild');

Route::get('takafol', 'testController@takafol');

Route::post('domestika-store', 'apiController@domestikaStore');


// user panel routes
Route::group(['prefix' => 'web'], function () {
    Route::get('/', [WebPanelUserController::class, 'dashboard'])->name('web.dashboard');
    Route::get('learning/webinar', [WebPanelUserController::class, 'myWebinars'])->name('web.my-webinars');
    Route::get('transactions', [WebPanelUserController::class, 'payments'])->name('web.my-transactions');
    Route::get('transactions/details', [WebPanelUserController::class, 'paymentsDetails'])->name('web.my-transactions-detail');

    //        course
    Route::group(['prefix' => 'learning/education'], function () {
        Route::get('/', [WebPanelUserController::class, 'myCourses'])->name('web.my-courses');
        Route::post('store-course-survey', [UserController::class, 'storeCourseSurvey']);
        Route::post('get-questions', [UserController::class, 'getQuestions']);
        Route::post('get-questions-my', [UserController::class, 'getQuestionsMy']);
        Route::post('get-course-detail', [UserController::class, 'getCourseDetail']);
        Route::post('get-course-detail-survey', [UserController::class, 'getCourseDetailSurvey']);
        Route::post('store-course-question', [UserController::class, 'storeCourseQuestion']);
        Route::post('store-course-note', [UserController::class, 'storeCourseNote']);
        Route::post('delete-course-note', [UserController::class, 'deleteCourseNote']);
        Route::post('complete-lesson', [UserController::class, 'completeLesson']);
        Route::post('get-quiz', [UserController::class, 'getQuiz']);
        Route::post('get-quiz-result', [UserController::class, 'getQuizResult']);
        Route::post('correction-quiz', [UserController::class, 'correctionQuiz']);
    });

    // certificate
    Route::group(['prefix' => 'learning/certificate'], function () {
        Route::get('/', [WebPanelUserController::class, 'getCertificate'])->name('web.my-certificate');
        Route::get('/download/{id}', [WebPanelUserController::class, 'downloadCertificate']);
        Route::get('/download/webinar/{id}', [WebPanelUserController::class, 'downloadCertificateWebinar']);
    });
});
