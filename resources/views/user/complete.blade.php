@extends('layouts.master')
@section('title', 'ログイン完了')
@section('csrf')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section('content')
<div class="content">
  <h1 class="text-center">ログイン</h1>
  <div class="card mt-3">
    <div class="card-body text-center mail_box">
      <h2 class="h3 card-title text-center mt-2">ようこそ{{Auth::user()->name}}さん！</h2>
      <div id="content">
        <p>ログインが完了しました</p>
        <p>
          <button class="btn btn-primary mt-2 mb-2" type="button" onclick="location.href='{{ route('search') }}'">
            トップへ戻る
          </button>
        </p>
        <!-- <p>
          <button class="btn btn-blue-grey mt-2 mb-2" type="button" onclick="location.href='login_m.php'">
            ログイン情報を編集する
          </button>
        </p> -->
      </div>
    </div>
  </div>
</div>
@endsection