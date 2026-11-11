@extends('layouts.admin')

@section('title', 'Dashboard Produk')

@section('content')

    {{-- Judul & tombol tambah --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-blue-900">Dashboard Produk</h1>
            <p class="text-sm text-slate-500">Kelola seluruh produk yang tampil di katalog.</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white shadow transition hover:bg-blue-700">
            ➕ Tambah Produk
        </a>
    </div>

    {{-- Statistik --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-2xl border border-blue-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Produk</p>
            <p class="mt-1 text-3xl font-extrabold text-blue-700">{{ $totalProducts }}</p>
        </div>
        <div class="rounded-2xl border border-blue-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-slate-500">Total Kategori</p>
            <p class="mt-1 text-3xl font-extrabold text-blue-700">{{ $totalCategories }}</p>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.products.index') }}"
          class="mb-6 flex flex-col gap-3 rounded-2xl border border-blue-100 bg-white p-4 shadow-sm sm:flex-row">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama produk..."
               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">

        <select name="kategori"
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 sm:w-64">
            <option value="">Semua kategori</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(request('kategori') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Filter</button>
            <a href="{{ route('admin.products.index') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">Reset</a>
        </div>
    </form>

    {{-- Tabel produk --}}
    <div class="overflow-hidden rounded-2xl border border-blue-100 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-blue-100 text-sm">
                <thead class="bg-blue-50 text-left text-xs font-bold uppercase tracking-wider text-blue-800">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3">Nama Produk</th>
                        <th class="px-4 py-3">Kategori</th>
                        <th class="px-4 py-3">Harga</th>
                        <th class="px-4 py-3">Satuan</th>
                        <th class="px-4 py-3">Deskripsi</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($products as $product)
                        <tr class="hover:bg-blue-50/40">
                            <td class="px-4 py-3 text-slate-500">{{ $products->firstItem() + $loop->index }}</td>
                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $product->name }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                    {{ $product->category->name }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 font-semibold text-blue-700">{{ $product->formatted_price }}</td>
                            <td class="px-4 py-3">{{ $product->unit }}</td>
                            <td class="max-w-xs truncate px-4 py-3 text-slate-500">{{ $product->description }}</td>
                            <td class="whitespace-nowrap px-4 py-3 text-right">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="inline-block rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100">
                                    ✏️ Edit
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="rounded-lg bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-100">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-slate-500">
                                Belum ada produk. Klik <strong>Tambah Produk</strong> untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>

@endsection