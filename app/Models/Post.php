<?php

namespace App\Models;

use App\Models\Category;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Post extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'blog_posts';

    protected function categoryId(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Category::find($value),
        );
    }
}
