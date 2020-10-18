<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\loginRequest;
use App\Http\Requests\JoinRequest;
use App\Http\Requests\ContactRequest;
use App\Models\User;
use App\Models\Contact;
use RakutenRws_Client;

class SearchPriceController extends Controller
{
    /**
     * 商品検索画面を表示
     * 
     * @return view
     */
     public function search()
     {
         return view('search.index');
     }

    /**
     * 商品検索処理
     * 
     * @return view
     */
    public function searchItem(Request $request)
    {
        $client = new RakutenRws_Client();

        $client->setApplicationId('1004237893173434293');

        $inputs = $request->all();
        // dd($client);
        if(isset($inputs['keyword'])){
            $response = $client->execute('IchibaItemSearch', array(
                // 検索キーワード、UTF-8
                'keyword' => rawurlencode($inputs['keyword']),
                // ジャンルID
                'genreId' => $inputs['category'],
                // 最小価格
                'minPrice' => $inputs['minPrice'],
                // 最大価格
                'maxPrice' => $inputs['maxPrice'],
                // 取得ページ(1~100)
                'page' => 1,
                // 1ページあたりの取得件数(1~30)
                'hits' => 10,
                // ソート（並べ方）、UTF-8
                'sort' => rawurlencode('+itemPrice'),

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
                $items = array();
                foreach ($response as $item) {
                    $items[] = array(
                        'name' => (string)$item['itemName'],
                        'url' => (string)$item['itemUrl'],
                        'img' => (string)$item['mediumImageUrls'][0]['imageUrl'],
                        'price' => (int)$item['itemPrice'],
                        'tax' => (int)$item['taxFlag'],
                        'shop' => (string)$item['shopName'],
                        'shop_url' => (string)$item['shopUrl'],
                      );
                }
                return redirect()->action('SearchPriceController@result');
            } else {
                echo 'Error:'.$response->getMessage();
            }
        } else {
            return redirect()->action('SearchPriceController@search');
        }
    }

    /**
     * 商品検索結果画面を表示
     * 
     * @return view
     */
    public function result()
    {
        return view('search.result');
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
    public function complete()
    {
        return view('contact.complete');
    }

}
