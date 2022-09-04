<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query();

        return CategoryResource::collection($categories->paginate($request->get('per_page', 10)));
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }
}
