<?php



Route::group(['prefix' => 'v1'], function () {
  Route::post('auth', 'Restful\RestfulController@auth');
  Route::post('register', 'Restful\RestfulController@register');
  Route::post('edit-user', 'Restful\RestfulController@editUser');
});


//Route::prefix('v1')->namespace('Api\v1')->group(function(){
//    route::get('/wikiideas', 'wikiideaController@wikiideas');
//    route::get('/wikiidea/{id}', 'wikiideaController@wikiidea');
//
//    route::get('/courses', 'courseController@courses');
//    route::get('/course/{id}', 'courseController@course');
//
//    route::get('/consults', 'consultController@consults');
//    route::get('/consult/{id}', 'consultController@consult');
//
//    route::get('/blogs', 'blogController@blogs');
//    route::get('/blog/{id}', 'blogController@blog');
//
//    route::post('/center_verify', 'blogController@center_verify');
//});

Route::post('git-store', 'apiController@gitStore');
Route::post('domestika-store', 'apiController@domestikaStore');


Route::get('test2', function () {
    return response()->json(['message' => 'ok']);
});

