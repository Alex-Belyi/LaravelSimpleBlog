<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.

|иерархия?
*/
Route::get('blog/{slug}', ['as' => 'blog.single', 'uses' => 'BlogController@getSingle'])
    ->where('slug', '[\w\d\-\_]+' );  // где where -> там regular  expression
//auth auth/login is default in laravel
Route::get('auth/login', [ 'as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);  //'as' created urls for login
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout',[ 'as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

//Registration

Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

//pass reset
Route::get('password/reset/{token?}','Auth\PasswordController@showResetForm'); //token может не всегда быть поэтому ?
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

//categories

Route::resource('categories', 'CategoryController', ['except' => ['create']]); //resource for CRUD without create(except))
//можно писать only

//tags
Route::resource('tags', 'TagController', ['except' => ['create']]);

//comments
Route::post('comments/{post_id}', ['uses' => 'CommentsController@store', 'as' => 'comments.store']);
Route::get('comments/{id}/edit', ['uses' => 'CommentsController@edit', 'as' => 'comments.edit']);
Route::put('comments/{id}', ['uses' => 'CommentsController@update', 'as' => 'comments.update']);
Route::delete('comments/{id}', ['uses' => 'CommentsController@destroy', 'as' => 'comments.destroy']);
Route::get('comments/{id}/delete', ['uses' => 'CommentsController@delete', 'as' => 'comments.delete']);


Route::get('blog', ['uses' => 'BlogController@getIndex', 'as' => 'blog.index']);  // [] seems array()

Route::get('contact', 'PagesController@getContact');
Route::post('contact', 'PagesController@postContact');

Route::get('about', 'PagesController@getAbout');

Route::get('/', 'PagesController@getIndex');

Route::resource('posts','PostController');