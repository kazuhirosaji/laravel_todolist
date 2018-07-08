<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ArticleTableSeeder::class);
        $this->call(UserTableSeeder::class);
    }
}

class ArticleTableSeeder extends Seeder {

    public function run()
    {
        DB::table('articles')->delete();
        for($i = 1; $i <= 10; $i++) {
            Article::create(array(
                'user_id' => $i,
                'content' => "Article{$i} 本文",
                'title' => "Article{$i} Title",
            ));
        }
    }
}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();
        for($i = 1; $i <= 10; $i++) {
            User::create(array(
                'name' => "ユーザ{$i}",
                'email' => "test_{$i}@company.jp",
                'password' => "aaaaaaaa",
            ));
        }
    }
}
