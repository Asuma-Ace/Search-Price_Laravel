@extends('layouts.master')
@section('title', 'ログアウト')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section('content')
  <div class="content">
    <h1 class="text-center">ログアウト</h1>
    <div class="card mt-3">
      <div class="card-body text-center mail_box">
        <h2 class="h3 card-title text-center mt-2">ログアウト完了</h2>
        <div id="content">
          <p>ログアウトいたしました。<br>ご利用ありがとうございました。</p>
          <p>
            <button class="btn btn-primary mt-2 mb-2" type="button" onclick="location.href='{{ route('user.login') }}'">
            ログインページへ
            </button>
          </p>
          <p>
            <button class="btn btn-blue-grey mt-2 mb-2" type="button" onclick="location.href='{{ route('search') }}'">
            トップへ戻る
            </button>
          </p>
        </div>
      </div>
    </div>
  </div>
  @endsection