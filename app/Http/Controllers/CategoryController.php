<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    public function show(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);
        return response()->json($category, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'bail|required|min:1'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $newCategory = new Category();
        $newCategory->title = $request->title;
        $newCategory->slug = implode('-', explode(' ', strtolower($request->title)));
        $newCategory->save();
        return response()->json($newCategory, 200);
    }

    public function update(Request $request, $id)
    {
        if(empty($id) && isset($id)){
            return response()->json('Not valid $id', 400);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'bail|required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $updateCat = Category::find($id);
        $updateCat->title = $request->title;
        $updateCat->slug = implode('-', explode(' ', strtolower($request->title)));
        $updateCat->save();
        return response()->json($updateCat, 200);
    }

    public function destroy(Request $request, $id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json('delete', 200);
    }
}
