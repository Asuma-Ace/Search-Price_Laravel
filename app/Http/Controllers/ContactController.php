<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
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
            return redirect()->action('ContactController@form');
        }

        return redirect()->action("ContactController@confirm");
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
			return redirect()->action("ContactController@form");
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
            return redirect()->action("ContactController@form")->withInput($posts);
        }

        if(!isset($posts['name'], $posts['email'], $posts['subject'], $posts['inquiry'])){
			return redirect()->action("ContactController@form");
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
		return redirect()->action("ContactController@contactComplete");
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
