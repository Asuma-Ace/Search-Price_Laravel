@extends('layouts.master')
@section('title', '最安値検索（Yahoo!ショッピング＆楽天市場）')
@section('content')
<form action="{{ route('search.item') }}" method="post">
@csrf
  <div class="search">
    <div class="container">
      <div class="search_key">
        <input id="keyword" oninvalid="InvalidMsg(this);" oninput="InvalidMsg(this);" type="search" name="keyword" size="50" maxlength="64" placeholder="検索キーワードを入力してください" value="{{ old('keyword') }}" required>
        <button type="submit" id="search_btn"><i class="fas fa-search"></i>検索</button>
      </div>
    </div>
  </div>

  <div class="condition">
    <div class="container menu">
      <div class="condition_title">詳細条件<script class="menu_arrow open">＞</script></div>
    </div>

    @if ($errors->any())
    <div class="error_container">
      @foreach ($errors->all() as $error)
        <div class="error">{{ $error }}</div>
      @endforeach
    </div>
    @endif

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
                @foreach ($categories as $k => $v)
                  <option value="{{ $k }}" @if (old('category')==$k) selected @endif>{{ $v }}</option>
                @endforeach
              </select>
            </td>
        </tr>

        <tr>
          <th class="subtitle">＞価格帯</th>
            <td class="price_range detail_item">
              <select name="minPrice" id="minPrice">
                @foreach ($minPrices as $k => $v)
                  <option value="{{ $k }}" @if (old('minPrice')==$k) selected @endif>{{ $v }}</option>
                @endforeach
              </select><span>円～</span>
              <select name="maxPrice" id="maxPrice">
                @foreach ($maxPrices as $k => $v)
                  <option value="{{ $k }}" @if (old('maxPrice')==$k) selected @endif>{{ $v }}</option>
                @endforeach
                  <option value="99999999" @if (old('maxPrice')==99999999 || !old('maxPrice')) selected @endif>上限なし</option>
              </select><span>円</span>
            </td>
        </tr>
      </table>
    </div>    
  </div>

</form>
@endsection