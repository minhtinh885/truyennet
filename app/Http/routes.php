<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::auth();
Route::get('/home', 'HomeController@index');
Route::get('/rss', 'HomeController@rss');
Route::get('/sitemap.xml', 'HomeController@siteMap');
route::group(['middleware' => 'auth'], function(){
	Route::get('/admin','Admin\AdminController@index');

});
Route::get('/auto-crawl-link-start', 'Admin\AutoCrawlController@auto_crawl_link');
Route::get('/the-loai/{category_slug}', 'HomeController@category');
Route::get('/danh-sach/{list_slug}', 'HomeController@listOption');
Route::get('/tim-kiem', 'HomeController@search');
Route::get('/{book_slug}', 'HomeController@show');


Route::group(['namespace' => 'Admin','middleware'=> ['auth', 'emailmiddleware']], function(){

	Route::get('/admin/upload', 'UploadController@index');
	Route::post('/admin/upload/file', 'UploadController@uploadFile');
	Route::delete('/admin/upload/file', 'UploadController@deleteFile');
	Route::post('/admin/upload/folder', 'UploadController@createFolder');
	Route::delete('/admin/upload/folder', 'UploadController@deleteFolder');

	Route::resource('admin/category', 'CategoryController', ['except' => ['show']]);
	Route::resource('admin/author', 'AuthorController', ['except' => ['show']]);
	Route::resource('admin/user-info', 'UserInfoController', ['except' => ['create', 'show']]);
	Route::resource('admin/book', 'BookController');
	Route::resource('admin/chapter', 'ChapterController', ['except' => ['index', 'show', 'create']]);
	Route::resource('admin/auto-crawl', 'AutoCrawlController', ['except' => ['show']]);

	Route::get('admin/{book_slug}/chapter-all', 'ChapterController@getChapterList');
	Route::get('admin/{book_slug}/create', 'ChapterController@create');

});

Route::get('/{book_slug}/{chapter_slug}', 'HomeController@chapter');

