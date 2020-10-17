@extends('layouts.master')
@section('title', '新規会員登録確認')
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
      <h2 class="h3 card-title text-center mt-2">入力内容の確認</h2>

      <form action="{{ route('join.send') }}" method="POST">
      @csrf
        <dl>
          <div class="md-form check">
            <dt class="h5">ユーザー名</dt>
            <dd>{{ $posts['name'] }}</dd>
          </div>
          <div class="md-form check">
            <dt class="h5">メールアドレス</dt>
            <dd>{{ $posts['email'] }}</dd>
          </div>
          <div class="md-form check">
            <dt class="h5">パスワード</dt>
            <dd>【表示されません】</dd>
          </div>
        </dl>

        <button class="btn btn-blue-grey mt-2 mb-2" type="submit" name="back">
          戻る
        </button>

        <button class="btn btn-default mt-2 mb-2" type="submit">
          上記の内容で登録
        </button>
        
      </form>
    </div>
  </div>
</div>
@endsection