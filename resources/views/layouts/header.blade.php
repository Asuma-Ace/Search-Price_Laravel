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
          @auth
          <a href="{{ route('logout') }}">ログアウト</a>
          @else
          <a href="{{ route('user.login') }}">ログイン</a>
          @endauth
        </li>
        @guest
        <li>
          <a href="{{ route('join.new') }}">新規会員登録</a>
        </li>
        @endguest
        <li>
          <a href="{{ route('contact.form') }}">お問い合わせ</a>
        </li>
      </ul>
    </div>
  </div>
</div>