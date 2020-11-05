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

// 商品検索処理
Route::post('/search', 'SearchPriceController@searchItem')->name('search.item');

// 商品検索結果画面
Route::get('/result', 'SearchPriceController@searchResult')->name('search.result');

Route::group(['middleware' => 'guest'], function(){
  // ログイン画面
  Route::get('/user/login', 'LoginController@login')->name('user.login');

  // ログイン処理
  Route::post('login', 'Auth\LoginController@login')->name('login');
});

// ログイン完了画面
Route::get('/user/complete', 'LoginController@userComplete')->name('user.complete');

Route::group(['middleware' => 'auth'], function(){
  // ログアウト処理
  Route::get('logout', 'Auth\LoginController@logout')->name('logout');
});

// ログアウト完了画面
Route::get('/user/logout', 'LoginController@userLogout')->name('user.logout');

Route::group(['middleware' => 'guest'], function(){
  // 新規会員登録画面
  Route::get('/join/new', 'JoinController@new')->name('join.new');

  // 新規会員登録確認ボタン処理
  Route::post('/join/postUser', 'JoinController@postUser')->name('join.postUser');

  // 新規会員登録確認画面
  Route::get('/join/check', 'JoinController@check')->name('join.check');

  // 新規会員登録完了/戻るボタン処理
  Route::post('/join/send', 'JoinController@joinSend')->name('join.send');

  // 新規会員登録完了画面
  Route::get('/join/thanks', 'JoinController@thanks')->name('join.thanks');
});

// お問い合わせ作成画面
Route::get('/contact/form', 'ContactController@form')->name('contact.form');

// 問い合わせ確認ボタン処理
Route::post('/contact/postContact', 'ContactController@postContact')->name('contact.postContact');

// お問い合わせ確認画面
Route::get('/contact/confirm', 'ContactController@confirm')->name('contact.confirm');

// お問い合わせ送信完了/戻るボタン処理
Route::post('/contact/send', 'ContactController@contactSend')->name('contact.send');

// お問い合わせ送信完了画面
Route::get('/contact/complete', 'ContactController@contactComplete')->name('contact.complete');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
