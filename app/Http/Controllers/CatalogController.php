<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $categories    = Category::withCount('products')->orderBy('id')->get();
        $totalProducts = Product::count();
        $activeCategory = $request->query('kategori');
        $search         = trim((string) $request->query('q', ''));

        $products = Product::with('category')
            ->when($activeCategory, function ($query) use ($activeCategory) {
                $query->whereHas('category', function ($c) use ($activeCategory) {
                    $c->where('slug', $activeCategory);
                });
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($w) use ($search) {
                    $w->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('catalog.index', compact(
            'categories',
            'totalProducts',
            'activeCategory',
            'search',
            'products'
        ));
    }
}