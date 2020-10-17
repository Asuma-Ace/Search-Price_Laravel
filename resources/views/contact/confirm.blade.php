@extends('layouts.master')
@section('title', 'お問い合わせフォーム 内容確認画面')
@section('csrf')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection
@section('content')
<div class="content_form">
  <h1 class="text-center">お問い合わせフォーム</h1>
  <div class="card mt-3">
    <div class="card-body text-center mail_box">
      <h2 class="h3 card-title text-center mt-2">お問い合わせ 内容確認</h2>

      <form action="{{ route('contact.send') }}" method="POST">
      @csrf
        <dl>
          <div class="md-form check">
            <dt class="h5">お名前（ユーザー名）</dt>
            <dd>{{ $posts['name'] }}</dd>
          </div>
          <div class="md-form check">
            <dt class="h5">メールアドレス</dt>
            <dd>{{ $posts['email'] }}</dd>
          </div>
          <div class="md-form check">
            <dt class="h5">件名</dt>
            <dd>{{ $posts['subject'] }}</dd>
          </div>
          <div class="md-form check">
            <dt class="h5">お問い合わせ内容</dt>
            <dd>{!! nl2br(e($posts['inquiry'])) !!}</dd>
          </div>
        </dl>

        <button class="btn btn-blue-grey mt-2 mb-2" type="submit" name="back">
        戻る
        </button>

        <button class="btn btn-default mt-2 mb-2" type="submit">
        上記の内容で送信
        </button>
      </form>
    </div>
  </div>
</div>
@endsection