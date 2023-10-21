<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Cache::rememberForever('posts', function () {
            return Post::all();
        });
        return response()->json($posts, 200);
    }

    public function show($id)
    {
        $post = Post::find($id);
        return response()->json($post, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'bail|required|min:1',
            'body' => 'max:500',
            'author_id' => 'bail|required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $newPost = new Post();
        $newPost->title = (string)$request->title;
        $newPost->body = (string)$request->body;
        $newPost->slug = (string)implode('-', explode(' ', strtolower($request->title)));
        $newPost->author_id = (string)$request->author_id;
        $newPost->tags = (array)$request->tags;
        $newPost->category_id = (string)$request->category_id;
        $newPost->save();
        return response()->json($newPost, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'bail|required|min:1',
            'body' => 'max:500',
            'author_id' => 'bail|required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $post = Post::find($id);
        $post->title = (string)$request->title;
        $post->body = (string)$request->body;
        $post->slug = (string)implode('-', explode(' ', strtolower($request->title)));
        $post->author_id = (string)$request->author_id;
        $post->tags = (array)$request->tags;
        $post->category_id = (string)$request->category_id;
        $post->save();
        return response()->json($post, 200);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()->json('delete', 200);
    }
}
