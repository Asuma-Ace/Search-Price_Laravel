@extends('layouts.master')
@section('title', '新規会員登録完了')
@section('csrf')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/join.css') }}">
@endsection
@section('content')
<div class="content">
  <h1 class="text-center">新規会員登録</h1>
  <div class="card mt-3">
    <div class="card-body text-center mail_box">
      <h2 class="h3 card-title text-center mt-2">新規会員登録完了</h2>
      <div id="content">
        <p>会員登録が完了しました</p>
        <p>
          <button class="btn btn-primary mt-2 mb-2" type="button" onclick="location.href='{{ route('user.login') }}'">
            ログインする
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