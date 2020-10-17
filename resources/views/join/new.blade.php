@extends('layouts.master')
@section('title', '新規会員登録')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/join.css') }}">
@endsection
@section('content')
<div class="content">
  <h1 class="text-center">新規会員登録</h1>
  <div class="card mt-3">
    
    <!-- mail address -->
    <div class="card-body text-center mail_box">
      <h2 class="h3 card-title text-center mt-2">メールアドレスで登録</h2>

      <form method="POST" action="{{ route('join.postUser') }}">
      @csrf
        <div class="md-form">
          <label for="name">ユーザー名</label>
          <input class="form-control" type="text" id="name" name="name" oninvalid="InvalidName(this);" oninput="InvalidName(this);" value="{{ old('name') }}" required>
          @error('name')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>

        <div class="md-form">
          <label for="email">メールアドレス</label>
          <input class="form-control" type="email" id="email" name="email" oninvalid="InvalidEmail(this);" oninput="InvalidEmail(this);" value="{{ old('email') }}" maxlength="256" required>
          @error('email')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>

        <div class="md-form">
          <label for="password">パスワード [8文字以上]</label>
          <input class="form-control" type="password" id="password" name="password" oninvalid="InvalidPw(this);" oninput="InvalidPw(this);" value="{{ old('password') }}" required>
          @error('password')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>

        <div class="md-form">
          <label for="password_c">パスワード（確認用）</label>
          <input class="form-control" type="password" id="password_c" name="password_c" oninvalid="InvalidPwc(this);" oninput="InvalidPwc(this);" value="{{ old('password_c') }}" required>
          @error('password_c')
          <p class="error">{{ $message }}</p>
          @enderror
        </div>

        <button class="btn btn-block btn-default mt-2 mb-2" type="submit">
          確認画面へ
        </button>

        <div class="text-left">
          <a href="{{ route('user.login') }}" class="card-text">アカウントを既にお持ちの方はこちら（ログイン）</a>
        </div>

      </form>
    </div>
    <!-- mail address -->

    <!-- sns -->
    <div class="card-body text-center snsbox">
      <h3 class="h3 card-title text-center mt-2">SNSアカウントで登録</h3>

      <form method="POST" action="" class="mt-3 sns sns_top">
        <button class="btn btn-block btn-danger" type="submit">
          <i class="fab fa-google mr-1"></i></i>Googleで登録
        </button>
      </form>

      <form method="POST" action="" class="mt-3 sns">
        <button class="btn btn-block btn-info" type="submit">
          <i class="fab fa-twitter mr-1"></i></i>Twitterで登録
        </button>
      </form>

      <form method="POST" action="" class="mt-3 sns">
        <button class="btn btn-block btn-primary" type="submit">
          <i class="fab fa-facebook-f mr-1"></i>Facebookで登録
        </button>
      </form>

    </div>
    <!-- sns -->
  </div>
</div>
@endsection