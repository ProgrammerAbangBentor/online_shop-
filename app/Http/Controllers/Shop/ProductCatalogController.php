<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductCatalogController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $categoryId = $request->input('category_id');

        $products = Product::query()
            ->with('category')
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('pages.shop.products.index', compact('products', 'categories', 'q', 'categoryId'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('pages.shop.products.show', compact('product'));
    }
}
