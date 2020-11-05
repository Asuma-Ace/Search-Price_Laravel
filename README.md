# 最安値検索(yahoo!ショッピング&amp;楽天市場)  [Laravel版]
Laravel版は完成しておりますが、Fat Controllerなため現在修正中です。  
PHP版（Laravel未使用）はこちら  
https://github.com/Asuma-Samua/Search-Price_PHP
## アプリケーションURL
https://search-price-laravel.herokuapp.com/

## 概要
検索したキーワードに関する商品を「Yahoo!ショッピング」と「楽天市場」から同時に価格の安い順に取得します。

## 使用技術
・Laravel Framework 7.28.4  
・PHP 7.2.14  
・HTML5  
・css3  
・Bootstrap v4.5.2  
・JavaScript (ES6)  
・jQuery v3.5.1  
・MySQL 5.6.35  
・Apache  
・Heroku  
　￮ClearDB MySQL  
・Yahoo!ショッピングAPI  
・楽天市場商品検索API  

## 実装機能
### 検索関連
・キーワード検索機能  
・条件絞り込み機能  
・ページネーション機能  
・検索結果件数取得機能  
・ショッピングサイト遷移  

### ユーザー関連
・登録機能  
・ログイン・アウト機能  
・ログイン情報（アドレス・パスワード）保存機能  

### お問い合わせ関連
・お問い合わせ作成機能  
・文字数カウント機能  

## 初期設定
### ディレクトリクローン
``` $ git clone https://github.com/Asuma-Samua/Search-Price_Laravel.git   ```
### laravelアプリケーション起動

#### 関連ライブラリインストール
1. ``` $ composer install ```

#### 環境変数入力(.envファイルの変更)
1. APP_KEYを生成 ``` $ php artisan key:generate ```  
2. DB設定を使用するDBに合わせて変更  

#### データベース作成
``` $ php artisan migrate ```

#### テストデータ作成
``` $ php artisan db:seed ```

#### サーバー起動
1. development環境の場合 ``` $ php artisan serve ```  
2. production環境の場合 各自の環境に合わせてサーバーを起動してください。

#### ローカル環境で動かす場合
「app/Providers/AppServiceProvider.php」内29行目から31行目をコメントアウトしてください
```
class AppServiceProvider extends ServiceProvider
{
        ...
    public function boot()
    {
        Schema::defaultStringLength(191);
        // ローカル環境で動かす場合以下3行をコメントアウトする
        // if (\App::environment('production')) {
        //     \URL::forceScheme('https');
        // }
    }
}
```

## 使い方
1. ヘッダーの右側にある「**新規会員登録**」を押して新規会員登録を行ってください。（会員登録をしなくてもご利用いただけます）
2. 「*ユーザー名*」「*メールアドレス*」「*パスワード*」を入力して会員登録を完了させてください。
3. ヘッダーの右側にある「**ログイン**」を押してログインしてください。次回のログインをスムーズに行いたい場合、「**□メールアドレスとパスワードを保存**」をチェックしてください。
4. トップページで「*検索キーワード*」を入力し、「*詳細条件*」を選択してください。その後「**🔍検索**」を押して検索を行います。
5. 検索キーワードに関する商品を価格の安い順に20件取得します。さらに件数を取得したい場合、ページ下の「**次のページへ**」を押すことで次の20件を取得します。
6. ご質問がある場合、ヘッダーの右側にある「**お問い合わせ**」から必要事項を入力しお問い合わせフォームを送信できます。
7. ヘッダーの右側にある「**ログアウト**」ボタンを押してログアウトできます。

![sample image1](sample_img1.png)

![sample image2](sample_img2.png)

## 動作環境
Windows  

## ライセンス
[MIT license](https://opensource.org/licenses/MIT)

## 補足
お問い合わせフォーム完了画面内でメールの送信をしているとあるが、メール送信機能はまだ未実装なため送られておりません。

## 作成者
[三吉 明日真](https://github.com/Asuma-Samua)

## 参照
[Yahoo!ショッピング_API](https://developer.yahoo.co.jp/sample/shopping/)  
[楽天市場_API](https://webservice.rakuten.co.jp/api/ichibaitemsearch/)
