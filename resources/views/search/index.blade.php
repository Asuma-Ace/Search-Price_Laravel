@extends('layouts.master')
@section('title', '最安値検索（Yahoo!ショッピング＆楽天市場）')
@section('content')
<form action="{{ route('search.item') }}" method="post">
@csrf
  <div class="search">
    <div class="container">
      <div class="search_key">
        <input id="keyword" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" type="search" name="keyword" size="50" maxlength="64" placeholder="検索キーワードを入力してください" value="" required>
        <button type="submit" id="search_btn"><i class="fas fa-search"></i>検索</button>
      </div>
    </div>
  </div>

  <div class="condition">
    <div class="container menu">
      <div class="condition_title">詳細条件<script class="menu_arrow open">＞</script></div>
    </div>

    <div class="menu_item">
      <table>
        <tr>
          <th class="subtitle">＞ECモール</th>
            <td class="detail">
              <table>
                <tr>
                  <td>
                    <input id="y_shop" name="y_shop" type="checkbox" value="y_shop" Checked><label for="y_shop">Yahoo!ショッピング</label>
                  </td>
                  <td>
                    <input id="r_shop" name="r_shop" type="checkbox" value="r_shop" Checked><label for="r_shop">楽天市場</label>
                  </td>
                </tr>
              </table>
            </td>
        </tr>
        
        <tr>
          <th class="subtitle">＞カテゴリ</th>
            <td class="detail detail_item">
              <select name="category" id="category">
                <?php $categories = ['すべてのカテゴリ', 'レディースファッション', 'メンズファッション', '腕時計', 'ジュエリー・アクセサリー', '食品','スイーツ・お菓子', '水・ソフトドリンク', 'ビール・洋酒', '日本酒・焼酎', 'スポーツ・アウトドア', 'ダイエット・健康', '美容・コスメ', 'パソコン・周辺機器', 'スマートフォン・タブレット', 'TV・オーディオ・カメラ', '家電', '家具・インテリア', '花・ガーデン・DIY', '日用品・雑貨・文具', 'キッチン用品', '生き物・ペット用品', '楽器・音響機器', 'おもちゃ', 'TVゲーム', 'ホビー', 'キッズ・ベビー・マタニティ', '車・バイク', '車用品・バイク用品', 'CD・DVD', '本・雑誌・コミック', 'サービス・レンタル'];?>
                <?php foreach ($categories as $k => $v) : ?>
                  <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php endforeach; ?>
              </select>
            </td>
        </tr>

        <tr>
          <th class="subtitle">＞価格帯</th>
            <td class="price_range detail_item">
              <select name="minPrice" id="minPrice">
                <?php $minPrices = [1 => '下限なし', 1000 => '1000', 3000 => '3000', 5000 => '5000', 10000 => '10000', 20000 => '20000', 30000 => '30000', 50000 => '50000']; ?>
                <?php foreach ($minPrices as $k => $v): ?>
                  <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                <?php endforeach; ?>
              </select><span>円～</span>
              <select name="maxPrice" id="maxPrice">
                <?php $maxPrices = [1000 => '1000', 3000 => '3000', 5000 => '5000', 10000 => '10000', 20000 => '20000', 30000 => '30000', 50000 => '50000', 99999999 => '上限なし']; ?>
                <?php foreach ($maxPrices as $k => $v): ?>
                  <option value="<?php echo $k; ?>"<?php if ($k == 99999999) echo 'selected'; ?>><?php echo $v; ?></option>
                <?php endforeach; ?>
              </select><span>円</span>
            </td>
        </tr>
      </table>
    </div>    
  </div>

</form>
@endsection