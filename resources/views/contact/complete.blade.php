@extends('layouts.master')
@section('title', 'お問い合わせフォーム 送信完了画面')
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
      <h2 class="h3 card-title text-center mt-2">お問い合わせ 送信完了</h2>
      <div id="content">
        <p>お問い合わせ頂き、ありがとうございました。<br>
            入力頂いたメールアドレスに受付完了のメールを自動送信しています。<br>
            メールが届かない場合、送信エラーの可能性もありますのでお手数ですが再度お問い合わせください。
        </p>
        <p>なお、お問い合わせ内容に関しましては内容を確認の上、回答させて頂きます。<br>
        しばらくお待ちくださいませ。
        </p>
        <p class="text-center">
          <button class="text-center btn btn-blue-grey mt-2 mb-2" type="submit" onclick="location.href='{{ route('search') }}'">
            トップへ戻る
          </button>
        </p>
      </div>
    </div>
  </div>
</div>
@endsection