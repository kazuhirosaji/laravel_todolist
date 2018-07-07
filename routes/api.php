<?php

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function() {
    Route::get('articles',  function() {
        $articles = Article::all()->take(5);
        return $articles;
    });

	Route::get('article/{id}', function ($id) {
		$article = Article::find($id);
		return $article;
	});

    Route::get('article',  function() {
        $articles = Article::all()->take(5);
        return $articles;
    });

    // 記事を投稿す処理
    Route::post('/article/{id}',function($id){
        //投稿するユーザーを取得
        // $user = User::where('id',$id)->first();

        //リクエストデータを元に記事を作成
        $article = new Article();
        $article->title = request('title');
        $article->content = request('content');
        $article->user_id = 1;

        //ユーザーに関連づけて保存
       	$article->save();

        //テストのためtitile、contentのデータをリターン
        return ['title' => request('title'),'content' => request('content')];
    });

});

