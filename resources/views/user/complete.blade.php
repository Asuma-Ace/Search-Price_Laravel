<?php

$email = isset($_POST['email']) ? $_POST['email'] : NULL;
$password = isset($_POST['password']) ? $_POST['password'] : NULL;

if (!empty($email) && !empty($password)) {
  $login = $db->prepare('SELECT * FROM users WHERE email=? AND password=?');
  $login->execute([
    $email,
    sha1($password)
  ]);
  $user = $login->fetch();

  if ($user) {
    $_SESSION['id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['time'] = time();
    $_SESSION['save'] = $_POST['save'];

    $two_week = 60*60*24*14;

    if ($_POST['save'] === 'on') {
      setcookie('email', $email,time()+$two_week);
      setcookie('password', $password, time()+$two_week);
    } else {
      setcookie('email', '', time()-3600);
      setcookie('password', '', time()-3600);
    }

    unset($_SESSION['email'], $_SESSION['password'] ,$_SESSION['error'], $_SESSION['token']);

  } else {
    $error['login'] = 'false';
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['error'] = $error;
  }
}

if (isset($_SESSION['id'])) {
  $login_out_url = 'logout.php';
  $login_out = 'ログアウト';
  $login_user = '<a href="login_m.php" class="login_user">' .$_SESSION['name'] . '</a>';
  $one_month = 3600*24*30;
  $one_day = 3600*24;
  
  if ($_SESSION['save'] === 'on' && $_SESSION['time'] + $one_month > time()) {
    $_SESSION['time'] = time();
  } elseif ($_SESSION['time'] + $one_day > time()) {
    $_SESSION['time'] = time();
  } else {
    header('Location: logout.php');
    exit();
  }
}
?>
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
      <h2 class="h3 card-title text-center mt-2">ようこそtestさん！</h2>
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