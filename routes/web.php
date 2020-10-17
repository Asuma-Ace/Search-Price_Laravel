<?php

use Illuminate\Support\Facades\Route;

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

// 商品検索画面
Route::get('/', 'SearchPriceController@search')->name('search');

// 商品検索結果画面

Route::group(['middleware' => 'guest'], function(){
  // ログイン画面
  Route::get('/user/login', 'SearchPriceController@login')->name('user.login');

  // ログイン処理
  Route::post('login', 'Auth\LoginController@login');
});

// ログイン完了画面
Route::get('/user/complete', 'SearchPriceController@userComplete')->name('user.complete');

Route::group(['middleware' => 'auth'], function(){
  // ログアウト処理
  Route::get('logout', 'Auth\LoginController@logout');
});

// ログアウト完了画面
Route::get('/user/logout', 'SearchPriceController@userLogout')->name('user.logout');

Route::group(['middleware' => 'guest'], function(){
  // 新規会員登録画面
  Route::get('/join/new', 'SearchPriceController@new')->name('join.new');

  // 新規会員登録確認ボタン処理
  Route::post('/join/postUser', 'SearchPriceController@postUser')->name('join.postUser');

  // 新規会員登録確認画面
  Route::get('/join/check', 'SearchPriceController@check')->name('join.check');

  // 新規会員登録完了/戻るボタン処理
  Route::post('/join/send', 'SearchPriceController@joinSend')->name('join.send');

  // 新規会員登録完了画面
  Route::get('/join/thanks', 'SearchPriceController@thanks')->name('join.thanks');
});

// お問い合わせ作成画面
Route::get('/contact/form', 'SearchPriceController@form')->name('contact.form');

// 問い合わせ確認ボタン処理
Route::post('/contact/postContact', 'SearchPriceController@postContact')->name('contact.postContact');

// お問い合わせ確認画面
Route::get('/contact/confirm', 'SearchPriceController@confirm')->name('contact.confirm');

// お問い合わせ送信完了/戻るボタン処理
Route::post('/contact/send', 'SearchPriceController@contactSend')->name('contact.send');

// お問い合わせ送信完了画面
Route::get('/contact/complete', 'SearchPriceController@contactComplete')->name('contact.complete');

Auth::routes();

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::get('/home', 'HomeController@index')->name('home');
