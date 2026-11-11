<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->filled('q'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->q . '%');
            })
            ->when($request->filled('kategori'), function ($query) use ($request) {
                $query->where('category_id', $request->kategori);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories      = Category::orderBy('name')->get();
        $totalProducts   = Product::count();
        $totalCategories = Category::count();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'totalProducts',
            'totalCategories'
        ));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'        => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:categories,id'],
            'price'       => ['required', 'integer', 'min:0', 'max:100000000'],
            'unit'        => ['required', Rule::in(Product::UNITS)],
            'description' => ['nullable', 'string', 'max:500'],
        ], [
            'required' => ':attribute wajib diisi.',
            'integer'  => ':attribute harus berupa angka bulat.',
            'min'      => ':attribute minimal :min.',
            'max'      => ':attribute melebihi batas maksimum (:max).',
            'in'       => ':attribute tidak valid.',
            'exists'   => ':attribute tidak valid.',
        ], [
            'name'        => 'Nama produk',
            'category_id' => 'Kategori',
            'price'       => 'Harga',
            'unit'        => 'Satuan',
            'description' => 'Deskripsi',
        ]);
    }
}