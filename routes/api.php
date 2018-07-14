<?php

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
        Log::info('article index');
        // $articles = Article::all()->take(5);

        $articles = Article::orderBy('id', 'desc')
               ->take(5)
               ->get();

        return $articles;
    });

	Route::get('article/{id}', function ($id) {
        Log::info('article detail');
		$article = Article::find($id);
		return $article;
	});

    // 記事を投稿する処理
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

        Log::info('new pusher event');
        event(new App\Events\PusherEvent($article));

        //テストのためtitile、contentのデータをリターン
        return ['title' => request('title'),'content' => request('content')];
    });

    Route::get('/pusher', function() {
        Log::info('new pusher event');
        event(new App\Events\PusherEvent(['title' => 'title', 'content' => 'pusher event']));
        return 'return pusher';
    });

});

