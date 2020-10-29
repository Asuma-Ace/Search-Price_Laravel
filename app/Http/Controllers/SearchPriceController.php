<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\loginRequest;
use App\Http\Requests\JoinRequest;
use App\Http\Requests\ContactRequest;
use App\Models\User;
use App\Models\Contact;
use RakutenRws_Client;
use YConnect\Credential\ClientCredential;
use YConnect\YConnectClient;

class SearchPriceController extends Controller
{
    /**
     * 商品検索画面を表示
     * 
     * @return view
     */
    public function search()
    {
        $categories = ['すべてのカテゴリ', 'レディースファッション', 'メンズファッション', '腕時計', 'ジュエリー・アクセサリー', '食品','スイーツ・お菓子', '水・ソフトドリンク', 'ビール・洋酒', '日本酒・焼酎', 'スポーツ・アウトドア', 'ダイエット・健康', '美容・コスメ', 'パソコン・周辺機器', 'スマートフォン・タブレット', 'TV・オーディオ・カメラ', '家電', '家具・インテリア', '花・ガーデン・DIY', '日用品・雑貨・文具', 'キッチン用品', '生き物・ペット用品', '楽器・音響機器', 'おもちゃ', 'TVゲーム', 'ホビー', 'キッズ・ベビー・マタニティ', '車・バイク', '車用品・バイク用品', 'CD・DVD', '本・雑誌・コミック', 'サービス・レンタル'];
        $minPrices = [1 => '下限なし', 1000 => '1000', 3000 => '3000', 5000 => '5000', 10000 => '10000', 20000 => '20000', 30000 => '30000', 50000 => '50000'];
        $maxPrices = [1000 => '1000', 3000 => '3000', 5000 => '5000', 10000 => '10000', 20000 => '20000', 30000 => '30000', 50000 => '50000'];

        return view('search.index', compact('categories', 'minPrices', 'maxPrices'));
    }

    /**
     * 商品検索処理
     * 
     * @return view
     */
    public function searchItem(Request $request)
    {
        $rules = [
            'keyword' => 'min:2',
            'y_shop' => 'required_without:r_shop',
            'minPrice' => 'lt:maxPrice',
        ];
        $message = [
            'keyword.min' => '* キーワードを２文字以上で入力してください',
            'y_shop.required_without' => '* ECモール選択してください',
            'minPrice.lt' => '* 正しい価格帯を選択してください',
        ];
        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return redirect('/')
            ->withErrors($validator)
            ->withInput();
        }

        if(isset($request['keyword'])){
            $inputs = $request->all();
            $yahoo_counts = 0;
            $rakuten_counts = 0;
            $keyword = $request->session()->get('keyword');
            $page = session()->get('page');

            if ($keyword == $inputs['keyword']) {
                if (isset($request['next'])) {
                    $page += 1;
                    session()->put('page', $page);
                } elseif (isset($request['pre'])) {
                    $page -= 1;
                    session()->put('page', $page);
                }
            } else {
                $page = 0;
                session()->put('page', $page);
            }
            $request->session()->put($inputs);
            $num = 1 + $page * 20;

            if (isset($inputs['y_shop'])) {
                define('YAHOO_CLIENT_ID', config('app.yahoo_id'));

                $y_genre = ['1','2494','2495','2496','2496','2498','2498','2499','2499','2499','2512,2513','2500','2501','2502','2502','2504','2505','2506','2507,2503','2508','2508','2509','2510','2511','2511','2511','2497','2514','2514','2516,2517','10002','47727'];
                $inputs['category'] = $y_genre[$request['category']];
                $inputs['hits'] = isset($inputs['r_shop']) ? '10' : '20';

                // ベースリクエストURL
                $baseurl = 'https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch';

                // 入力パラメータ作成
                $params = array(
                // アプリケーションID
                'appid' => YAHOO_CLIENT_ID,
                // 検索キーワード、UTF-8
                'query' => rawurlencode($inputs['keyword']),
                // ジャンルカテゴリID(カンマ区切りで複数指定)
                'genre_category_id' => $inputs['category'],
                // 最小価格
                'price_from' => $inputs['minPrice'],
                // 最大価格
                'price_to' => $inputs['maxPrice'],
                // 返却結果の先頭位置
                'start' => 1+$page*10,
                // 検索結果の返却数
                'results' => $inputs['hits'],
                // 並び順、utf-8
                'sort' => rawurlencode('+price'),

                // used: 中古、new: 新品
                'condition' => 'new',
                // true：在庫ありのみ, false：在庫なしのみ
                'in_stock' => 'true',
                );
                // 入力パラメータリクエストURL
                $params_url='';
                foreach($params as $key => $value) {
                    $params_url .= '&' . $key . '=' . $value;
                }
                $params_url = substr($params_url, 1);

                // リクエストURL
                $url = $baseurl . '?' . $params_url;

                // JSON文字列を取得＆デコード
                $yahoo_json = json_decode(file_get_contents($url), true);
                // 検索結果取得件数
                $yahoo_counts = (int)$yahoo_json['totalResultsAvailable'];

                $yahoo_results = array();
                foreach($yahoo_json['hits'] as $item){
                    $yahoo_results[] = array(
                        'name' => (string)$item['name'],
                        'url' => (string)$item['url'],
                        'img' => (string)$item['image']['medium'],
                        'price' => (int)$item['price'],
                        'tax' => (boolean)$item['priceLabel']['taxable'],
                        'shop' => (string)$item['seller']['name'],
                        'shop_url' => (string)$item['seller']['url'],
                    );
                }
            }
            if (isset($inputs['r_shop'])) {
                $client = new RakutenRws_Client();
                define('RAKUTEN_APPLICATION_ID', config('app.rakuten_id'));
                $client->setApplicationId(RAKUTEN_APPLICATION_ID);

                $r_genre = ['0','100371','551177','558929','216129','100227','551167','100316','510915','510901','101070','100938','100939','100026','564500','211742','562637','100804','100005','215783','558944','101213','112493','566382','101205','101164','100533','101114','503190','101240','200162','101438'];
                $inputs['category'] = $r_genre[$request['category']];
                $inputs['hits'] = isset($inputs['y_shop']) ? '10' : '20';

                $response = $client->execute('IchibaItemSearch', array(
                    // 検索キーワード、UTF-8
                    'keyword' => $inputs['keyword'],
                    // ジャンルID
                    'genreId' => $inputs['category'],
                    // 最小価格
                    'minPrice' => $inputs['minPrice'],
                    // 最大価格
                    'maxPrice' => $inputs['maxPrice'],
                    // 取得ページ(1~100)
                    'page' => 1+$page,
                    // 1ページあたりの取得件数(1~30)
                    'hits' => $inputs['hits'],
                    // ソート（並べ方）、UTF-8
                    'sort' => '+itemPrice',

                    // 0：すべての商品, 1：販売可能な商品のみ
                    'availability' => 1, 
                    // 0 : すべての商品を検索対象, 1 : 商品画像ありの商品のみを検索対象
                    'imageFlag' => 1, 
                    // PC: 0, mobile: 1, smartphone: 2
                    'carrire' => 0, 
                    // 0 :すべての商品, 1 :送料込み／送料無料の商品のみ
                    'postageFlag' => 0, 
                    // 0 :ジャンルごとの商品数の情報を取得しない, 1 :取得する
                    'genreInformationFlag' => 1,
                ));

                if ($response->isOk()) {
                    // 検索結果取得件数
                    $rakuten_counts = (int)$response['count'];
                    $rakuten_results = array();
                    foreach ($response as $item) {
                        $rakuten_results[] = array(
                            'name' => (string)$item['itemName'],
                            'url' => (string)$item['itemUrl'],
                            'img' => (string)$item['mediumImageUrls'][0]['imageUrl'],
                            'price' => (int)$item['itemPrice'],
                            'tax' => (int)$item['taxFlag'],
                            'shop' => (string)$item['shopName'],
                            'shop_url' => (string)$item['shopUrl'],
                        );
                    }
                } else {
                    echo 'Error:'.$response->getMessage();
                }
            }
            if (isset($inputs['y_shop']) && isset($inputs['r_shop'])) {
                $counts = array($yahoo_counts, $rakuten_counts);
                $results = array_merge($yahoo_results, $rakuten_results);
                foreach ($results as $k => $v) {
                    $sort_keys[$k] = $v['price'];
                }
                array_multisort($sort_keys, SORT_ASC, $results);
            } elseif (isset($inputs['y_shop'])) {
                $counts = array($yahoo_counts, $rakuten_counts);
                $results = $yahoo_results;
            } elseif (isset($inputs['r_shop'])) {
                $counts = array($yahoo_counts, $rakuten_counts);
                $results = $rakuten_results;
            }
            $categories = [
                'すべてのカテゴリ', 'レディースファッション', 'メンズファッション', '腕時計', 'ジュエリー・アクセサリー', '食品','スイーツ・お菓子', '水・ソフトドリンク', 'ビール・洋酒', '日本酒・焼酎', 'スポーツ・アウトドア', 'ダイエット・健康', '美容・コスメ', 'パソコン・周辺機器', 'スマートフォン・タブレット', 'TV・オーディオ・カメラ', '家電', '家具・インテリア', '花・ガーデン・DIY', '日用品・雑貨・文具', 'キッチン用品', '生き物・ペット用品', '楽器・音響機器', 'おもちゃ', 'TVゲーム', 'ホビー', 'キッズ・ベビー・マタニティ', '車・バイク', '車用品・バイク用品', 'CD・DVD', '本・雑誌・コミック', 'サービス・レンタル'
            ];
            $minPrices = [
                1 => '下限なし', 1000 => '1000', 3000 => '3000', 5000 => '5000', 10000 => '10000', 20000 => '20000', 30000 => '30000', 50000 => '50000'
            ];
            $maxPrices = [
                1000 => '1000', 3000 => '3000', 5000 => '5000', 10000 => '10000', 20000 => '20000', 30000 => '30000', 50000 => '50000', 99999999 => '上限なし'
            ];
            return view('search.result', compact('categories', 'minPrices', 'maxPrices', 'inputs', 'results', 'counts', 'num', 'page'));
        } else {
            return redirect()->action('SearchPriceController@search');
        }
    }

    /**
     * ログイン画面を表示
     * 
     * @return view
     */
    public function login()
    {
        return view('user.login');
    }

    /**
     * ログイン完了画面を表示
     * 
     * @return view
     */
    public function userComplete()
    {
        if(Auth::check()) {
            return view('user.complete');
        } else {
            return view('user.login');
        }
    }

    /**
     * ログアウト画面を表示
     * 
     * @return view
     */
    public function userLogout()
    {
        if(!Auth::check()) {
            return view('user.logout');
        } else {
            return redirect()->action('Auth\LoginController@logout');
        }
    }


    /**
     * 新規会員登録画面を表示
     * 
     * @return view
     */
    public function new()
    {
        return view('join.new');
    }

    /**
     * 新規会員登録確認ボタン処理
     * 
     * @return view
     */
    public function postUser(JoinRequest $request)
    {
        $posts = $request->all();
        $request->session()->put($posts);

        if (!isset($posts['name'], $posts['email'], $posts['password'], $posts['password_c'])){
            return redirect()->action('SearchPriceController@new');
        }

        return redirect()->action("SearchPriceController@check");
    }

    /**
     * 新規会員登録確認画面を表示
     * 
     * @return view
     */
    public function check()
    {
        $posts = session()->all();

        if(!isset($posts['name'], $posts['email'], $posts['password'], $posts['password_c'])){
			return redirect()->action("SearchPriceController@new");
        }
        
        return view('join.check', compact('posts'));
    }

    /**
     * 新規会員登録完了/戻るボタン処理
     * 
     * @return view
     */
    public function joinSend(Request $request)
    {
        $posts = session()->all();

        if ($request->has("back")) {
            return redirect()->action("SearchPriceController@new")->withInput($posts);
        }

        $request->session()->regenerate();

        \DB::beginTransaction();
        try {
            User::create([
                'name' => $posts['name'],
                'email' => $posts['email'],
                'password' => Hash::make($posts['password']),
            ]);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        if(!isset($posts['name'], $posts['email'], $posts['password'], $posts['password_c'])){
			return redirect()->action("SearchPriceController@new");
		}

        //ここでメールを送信する処理など
        $request->session()->forget(['_token', 'name', 'email','password','password_c',]);
		return redirect()->action("SearchPriceController@thanks");
    }

    /**
     * 新規会員登録確認画面を表示
     * 
     * @return view
     */
    public function thanks()
    {
        return view('join.thanks');
    }

    /**
     * お問い合わせ作成画面を表示
     * 
     * @return view
     */
    public function form()
    {
        return view('contact.form');
    }

    /**
     * お問い合わせ内容確認ボタン処理
     * 
     * @return view
     */
    public function postContact(ContactRequest $request)
    {
        $posts = $request->all();
        $request->session()->put($posts);

        if (!isset($posts['name'], $posts['email'], $posts['subject'], $posts['inquiry'])){
            return redirect()->action('SearchPriceController@form');
        }

        return redirect()->action("SearchPriceController@confirm");
    }

    /**
     * お問い合わせ内容確認画面を表示
     * 
     * @return view
     */
    public function confirm()
    {
        $posts = session()->all();

        if(!isset($posts['name'], $posts['email'], $posts['subject'], $posts['inquiry'])){
			return redirect()->action("SearchPriceController@form");
        }
        
        return view('contact.confirm', compact('posts'));
    }

    /**
     * お問い合わせ送信完了/戻るボタン処理
     * 
     * @return view
     */
    public function contactSend(Request $request)
    {
        $posts = session()->all();

        if ($request->has("back")) {
            return redirect()->action("SearchPriceController@form")->withInput($posts);
        }

        if(!isset($posts['name'], $posts['email'], $posts['subject'], $posts['inquiry'])){
			return redirect()->action("SearchPriceController@form");
		}

        $request->session()->regenerate();

        \DB::beginTransaction();
        try {
            Contact::create([
                'name' => $posts['name'],
                'email' => $posts['email'],
                'subject' => $posts['subject'],
                'inquiry' => $posts['inquiry'],
            ]);
            \DB::commit();
        } catch(\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        //ここでメールを送信する処理など
        $request->session()->forget(['_token', 'name', 'email','subject','inquiry',]);
		return redirect()->action("SearchPriceController@contactComplete");
    }

    /**
     * お問い合わせ送信完了画面を表示
     * 
     * @return view
     */
    public function contactComplete()
    {
        return view('contact.complete');
    }

}
