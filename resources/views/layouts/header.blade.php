<?php
$login_out_url = '/user/login';
$login_out = 'ログイン';
$login_user = 'ゲスト';

if (isset($_SESSION['id'])) {
  $login_out_url = '../logout.php';
  $login_out = 'ログアウト';
  $login_user = '<a href="../login_m.php" class="login_user">' .$_SESSION['name'] . '</a>';
  if ($_SESSION['save'] === 'on' && $_SESSION['time'] + 3600*24*30 > time()) {
    $_SESSION['time'] = time();
  } elseif ($_SESSION['time'] + 3600*24 > time()) {
    $_SESSION['time'] = time();
  } else {
    header('Location: ../logout.php');
    exit();
  }
}
?>
<div class="container">
  <div class="header-title">
    <div id="top-btn" class="header-logo"><a href="{{ route('search') }}">最安値検索<span id="shop">（Yahoo!ショッピング＆楽天市場）</span></a></div>
  </div>
  <div id="wrapper">
    <p class="btn-gnavi">
      <span></span>
      <span></span>
      <span></span>
    </p>        
    <div class="header-menu" id="global-navi">
      <ul class="header-menu-right">
        <li>
          <a href="<?php echo $login_out_url; ?>"><?php echo $login_out; ?></a>
        </li>
        <?php if (!isset($_SESSION['id'])): ?>
        <li>
          <a href="{{ route('join.new') }}">新規会員登録</a>
        </li>
        <?php endif; ?>
        <li>
          <a href="{{ route('contact.form') }}">お問い合わせ</a>
        </li>
      </ul>
    </div>
  </div>
</div>