<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) {
        $products = Product::query()
            ->with('categories');

        if ($request->has('categories')) {
            $categoryIds = $request->categories;
            $products->whereIn('id', function ($query) use ($categoryIds) {
                $query->select('product_id')
                    ->from('category_product')
                    ->whereIn('category_id', $categoryIds);
            })->get();
        }

        if ($request->has('order_by')) {
            if ($request->order_by === 'latest') {
                $products->orderBy('created_at', 'desc');
            }
        }
        return ProductResource::collection($products->paginate($request->get('per_page', 10)));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }
}
