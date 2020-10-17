<?php
$email = isset($_SESSION['email']) ? $_SESSION['email'] : NULL;
$password = isset($_SESSION['password']) ? $_SESSION['password'] : NULL;
$error = isset($_SESSION['error']) ? $_SESSION['error'] : NULL;

if ($email === NULL && $password === NULL) {
  if (!empty($_COOKIE['email']) && !empty($_COOKIE['password'])) {
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];
  }
}
?>
@extends('layouts.master')
@section('title', 'ログイン')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section('content')
<div class="content">
  <h1 class="text-center">ログイン</h1>
  <div class="card mt-3">

    <!-- mail address -->
    <div class="card-body text-center mail_box">
      <h2 class="h3 card-title text-center mt-2">メールアドレスでログイン</h2>

      <form method="POST" action="{{ route('login') }}">
      @csrf
        <div class="md-form">
          <label for="email">メールアドレス</label>
          <input class="form-control" type="email" id="email" name="email" oninvalid="InvalidEmail(this);" oninput="InvalidEmail(this);" value="{{ old('email') }}" maxlength="256" required>
          @error('email')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>

        <div class="md-form">
          <label for="password">パスワード</label>
          <input class="form-control" type="password" id="password" name="password" oninvalid="InvalidPw(this);" oninput="InvalidPw(this);" value="{{ old('password') }}" required>
          @error('password')
            <p class="error">{{ $message }}</p>
          @enderror
          <?php if ($error['login'] =='false' ): ?>
          <p class="error">* ログインに失敗しました。正しく入力してください</p>
        <?php endif; ?>
        </div>

        <input id="save" type="checkbox" name="remember" value="on" {{ old('remember') ? 'checked' : '' }}>
        <label for="save" class="save">メールアドレスとパスワードを保存</label>

        <button class="btn btn-block btn-default mt-2 mb-2" type="submit">
          ログイン
        </button>
        
        <div class="text-left">
          <a href="{{ route('join.new') }}" class="card-text">アカウントをお持ちでない方はこちら（新規会員登録）</a>
        </div>

      </form>
    </div>
    <!-- mail address -->

    <!-- sns -->
    <div class="card-body text-center snsbox">
      <h3 class="h3 card-title text-center mt-2">SNSアカウントでログイン</h3>

      <div class="g-signin2" data-onsuccess="signOut"></div>

      <form method="POST" action="" class="mt-3 sns sns_top">
        <button class="btn btn-block btn-danger" type="submit">
          <i class="fab fa-google mr-1"></i></i>Googleでログイン
        </button>
      </form>

      <form method="POST" action="" class="mt-3 sns">
        <button class="btn btn-block btn-info" type="submit">
          <i class="fab fa-twitter mr-1"></i></i>Twitterでログイン
        </button>
      </form>

      <form method="POST" action="" class="mt-3 sns">
        <button class="btn btn-block btn-primary" type="submit">
          <i class="fab fa-facebook-f mr-1"></i>Facebookでログイン
        </button>
      </form>

    </div>
    <!-- sns -->

  </div>
</div>
@endsection