<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\JoinRequest;
use App\Models\User;

class JoinController extends Controller
{
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
            return redirect()->action('JoinController@new');
        }

        return redirect()->action("JoinController@check");
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
			return redirect()->action("JoinController@new");
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
            return redirect()->action("JoinController@new")->withInput($posts);
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
			return redirect()->action("JoinController@new");
		}

        //ここでメールを送信する処理など
        $request->session()->forget(['_token', 'name', 'email','password','password_c',]);
		return redirect()->action("JoinController@thanks");
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

}
