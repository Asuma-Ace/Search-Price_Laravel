<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  @yield('csrf')
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="google-signin-client_id" content="511695979023-0kiein8ohpfrmbnq4uufn1cjmqavsuig.apps.googleusercontent.com">
  @include('layouts.stylesheet')
  <title>@yield('title')</title>
</head>

<body>
<header>
  @include('layouts.header')
</header>

<main>
<div class="user_jc container">ようこそ、<strong>ゲスト</strong>さん</div>
  @yield('content')
</main>

<footer>
  @include('layouts.footer')
</fotter>

@include('layouts.script')

</body>
</html>