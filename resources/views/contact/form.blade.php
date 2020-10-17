@extends('layouts.master')
@section('title', 'お問い合わせフォーム 内容入力画面')
@section('css')
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection
@section('content')
<div class="content_form">
  <h1 class="text-center">お問い合わせフォーム</h1>
  <div class="card mt-3">
    <div class="card-body text-center mail_box">
      <h2 class="h3 card-title text-center mt-2">お問い合わせ 内容入力</h2>

      <form method="POST" action="{{ route('contact.postContact') }}">
      @csrf
        <div class="md-form">
          <label for="name">お名前（ユーザー名）<span class="error">*必須</span></label>
          <input class="form-control" type="text" id="name" name="name" oninvalid="InvalidName(this);" oninput="InvalidName(this);" value="{{ old('name') }}" required>
          @error('name')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>

        <div class="md-form">
          <label for="email">メールアドレス<span class="error">*必須</span></label>
          <input class="form-control" type="email" id="email" name="email" oninvalid="InvalidEmail(this);" oninput="InvalidEmail(this);" value="{{ old('email') }}" maxlength="256" required>
          @error('email')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>

        <div class="md-form">
          <label for="subject">件名（50文字以内）<span class="error">*必須</span><span id="s_count"></span>/50</label>
          <input class="form-control" type="text" id="subject" name="subject" oninvalid="InvalidSubject(this);" oninput="InvalidSubject(this);" value="{{ old('subject') }}" required>
          @error('subject')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>

        <div class="md-form">
          <label for="inquiry" class="inquirylabel">お問い合わせ内容（1000文字以内）<span class="error">*必須</span><span id="b_count"></span>/1000</label>
          <textarea  class="form-control" id="inquiry" name="inquiry" cols="35" rows="9" oninvalid="InvalidInquiry(this);" oninput="InvalidInquiry(this);" value="{{ old('inquiry') }}" required>{{ old('inquiry') }}</textarea>
          @error('inquiry')
            <p class="error">{{ $message }}</p>
          @enderror
        </div>

        <button class="btn btn-default mt-2 mb-2" type="submit">
          確認画面へ
        </button>

      </form>
    </div>
  </div>
</div>
@endsection