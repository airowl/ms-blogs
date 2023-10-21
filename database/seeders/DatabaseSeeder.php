<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Category;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(Faker $faker): void
    {
        $faker = $faker::create();

        //for ($i = 0; $i < 10; $i++) {
        //    $title = $faker->word();
        //    $newCatergory = new Category();
        //    $newCatergory->title = $title;
        //    $newCatergory->slug = implode('-', explode(' ', strtolower($title)));
        //    $newCatergory->save();
        //}

        for ($i = 0; $i < 100; $i++) {

            $comments = [];
            for ($j = 0; $j < 5; $j++) {
                $comments[] = [
                    'user' => $faker->numerify('user########################'),
                    'text' => $faker->paragraph(2)
                ];
            }

            $title = $faker->sentence(5);
            $newPost = new Post();
            $newPost->title = $title;
            $newPost->body = $faker->paragraph();
            $newPost->slug = implode('-', explode(' ', strtolower($title)));
            $newPost->author_id = $faker->numerify('user########################');
            $newPost->tags = $faker->words(5);
            $newPost->comments = $comments;
            $categories = Category::all();
            $s = $faker->randomElements($categories);
            $newPost->category_id = $s[0]->_id;

            $newPost->save();
        }
    }
}
