@extends('layouts.master')
@section('title', '最安値検索結果（Yahoo!ショッピング＆楽天市場）')
@section('csrf')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<form action="{{ route('search.item') }}" method="post">
@csrf
  <div class="search">
    <div class="container">
      <div class="search_key">
        <input id="keyword" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" type="search" name="keyword" size="50" maxlength="64" placeholder="検索キーワードを入力してください" value="{{ $inputs['keyword'] }}" required>
        <button type="submit" id="search_btn"><i class="fas fa-search"></i>検索</button>
      </div>
    </div>
  </div>

  <div class="condition">
    <div class="container menu">
      <div class="condition_title">詳細条件<div class="menu_arrow">＞</div></div>
    </div>

    <div class="result_item">
      <table>
        <tr>
          <th class="subtitle">＞ECモール</th>
            <td class="detail">
              <table>
                <tr>
                  <td>
                    <input id="y_shop" name="y_shop" type="checkbox" value="y_shop" {{ isset($inputs['y_shop']) ? 'Checked' : '' }}><label for="y_shop">Yahoo!ショッピング</label>
                  </td>
                  <td>
                    <input id="r_shop" name="r_shop" type="checkbox" value="r_shop" {{ isset($inputs['r_shop']) ? 'Checked' : '' }}><label for="r_shop" >楽天市場</label>
                  </td>
                </tr>
              </table>
            </td>
        </tr>

        <tr>
          <th class="subtitle">＞カテゴリ</th>
            <td class="detail detail_item">
            <select name="category" id="category">
            @foreach ($categories as $k => $v)
              <option value="{{ $k }}" {{ Request::input('category') == $k ? 'selected' : '' }}>{{ $v }}</option>
            @endforeach
          </select>
            </td>
        </tr>

        <tr>
          <th class="subtitle">＞価格帯</th>
            <td class="price_range detail_item">
              <select name="minPrice" id="minPrice">
                @foreach ($minPrices as $k => $v)
                  <option value="{{ $k }}" {{ $inputs['minPrice'] == $k ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
              </select><span>円～</span>
              <select name="maxPrice" id="maxPrice">
                @foreach ($maxPrices as $k => $v)
                  <option value="{{ $k }}" {{ $inputs['maxPrice'] == $k ? 'selected' : '' }}>{{ $v }}</option>
                @endforeach
              </select><span>円</span>
            </td>
        </tr>
      </table>
    </div>
  </div>

<!-- result -->
  <div class="container">
    <div>Yahoo!ショッピング／{{ $counts[0] }}件</div>
    <div>楽天市場／{{ $counts[1] }}件</div>
    @foreach ($results as $item)
    <div class="item_card">
      <table>
        <tr>
          <th>{{ $num }}</th>
            <td class="result_img"><img src="{{ $item['img'] }}" width="146" height="146"></td>
            <td>
              <ul class="result_detail">
                <li class="result_name">{{ $item['name'] }}</li>
                <li class="result_price">価格<span>{{ $item['price'] }}</span>円
                {{ $item['tax'] == 0 || $item['tax'] == true ? '（税込）' : '（税別）'}}
                </li>
                <li class="result_store">店舗名／<a href="{{ $item['shop_url'] }}" target="_blank">{{ $item['shop'] }}</a></li>
                <li><button type="submit" class="transition" formaction="{{ $item['url'] }}" formtarget="_blank">ショッピングサイトへ</a></button></li>
              </ul>
            </td>
        </tr>
      </table>
    </div>
    <?php $num++; ?>
    @endforeach
<!-- result -->
<!-- page -->
    <div>
      <ul class="paging">
        @if ($page>0)
          <li><button type="submit" name="pre">前のページへ</button></li>
        @endif
          <li><button type="submit" name="next">次のページへ</button></li>
      </ul>
    </div>
<!-- page -->
</form>
@endsection