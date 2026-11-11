@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-blue-600 hover:underline">&larr; Kembali ke daftar produk</a>

        <div class="mt-4 rounded-2xl border border-blue-100 bg-white p-6 shadow-sm sm:p-8">
            <h1 class="text-2xl font-extrabold text-blue-900">Tambah Produk</h1>
            <p class="mb-6 mt-1 text-sm text-slate-500">Isi data produk baru untuk ditampilkan di katalog.</p>

            @include('admin.products._form', [
                'product'     => new \App\Models\Product(),
                'action'      => route('admin.products.store'),
                'method'      => 'POST',
                'submitLabel' => 'Simpan Produk',
            ])
        </div>
    </div>
@endsection