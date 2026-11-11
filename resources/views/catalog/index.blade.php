@extends('layouts.app')

@section('title', config('shop.name') . ' - Katalog Sembako')

@section('content')

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
        <div class="mx-auto max-w-7xl px-4 py-12 text-center sm:px-6 sm:py-16 lg:px-8">
            <span class="inline-block rounded-full bg-white/15 px-4 py-1 text-xs font-semibold uppercase tracking-wider text-blue-50">
                Belanja Sembako Praktis
            </span>
            <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-white sm:text-5xl">
                Kebutuhan Harian, <span class="text-blue-200">Harga Bersahabat</span>
            </h1>
            <p class="mx-auto mt-4 max-w-2xl text-base text-blue-100 sm:text-lg">
                Lihat katalog produk {{ config('shop.name') }}, lalu pesan atau tanya stok langsung lewat WhatsApp.
            </p>

            {{-- Pencarian --}}
            <form action="{{ route('catalog') }}#produk" method="GET" class="mx-auto mt-8 flex max-w-xl gap-2">
                @if ($activeCategory)
                    <input type="hidden" name="kategori" value="{{ $activeCategory }}">
                @endif
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari produk, misal: beras, minyak..."
                       class="w-full rounded-xl border-0 bg-white px-4 py-3 text-slate-700 shadow-sm placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-300">
                <button type="submit" class="rounded-xl bg-white px-5 py-3 text-sm font-bold text-blue-700 shadow-sm transition hover:bg-blue-50">
                    Cari
                </button>
            </form>
        </div>
    </section>

    {{-- Navigasi kategori --}}
    <nav class="sticky top-16 z-30 border-b border-blue-100 bg-white shadow-sm">
        <div class="mx-auto max-w-7xl overflow-x-auto px-4 sm:px-6 lg:px-8">
            <ul class="flex gap-2 whitespace-nowrap py-3">
                <li>
                    <a href="{{ route('catalog', array_filter(['q' => $search])) }}#produk"
                       class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold transition {{ !$activeCategory ? 'bg-blue-600 text-white shadow' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                        🛍️ Semua
                        <span class="rounded-full bg-white/25 px-2 text-xs">{{ $totalProducts }}</span>
                    </a>
                </li>
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('catalog', array_filter(['kategori' => $category->slug, 'q' => $search])) }}#produk"
                           class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold transition {{ $activeCategory === $category->slug ? 'bg-blue-600 text-white shadow' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                            {{ $category->icon }} {{ $category->name }}
                            <span class="rounded-full bg-white/25 px-2 text-xs">{{ $category->products_count }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>

    {{-- Daftar produk --}}
    <section id="produk" class="mx-auto max-w-7xl scroll-mt-32 px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">
            <h2 class="text-2xl font-bold text-blue-900">Katalog Produk</h2>
            <p class="text-sm text-slate-500">
                Menampilkan {{ $products->total() }} produk
                @if ($search !== '') untuk "<span class="font-semibold">{{ $search }}</span>" @endif
            </p>
        </div>

        @if ($products->count())
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($products as $product)
                    <article class="flex flex-col overflow-hidden rounded-2xl border border-blue-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        <div class="flex h-32 items-center justify-center bg-gradient-to-br from-blue-50 to-blue-100 text-5xl">
                            {{ $product->category->icon ?? '🛒' }}
                        </div>

                        <div class="flex flex-1 flex-col p-5">
                            <span class="inline-flex w-fit rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                {{ $product->category->name }}
                            </span>

                            <h3 class="mt-3 text-lg font-bold text-slate-800">{{ $product->name }}</h3>

                            <p class="mt-1 line-clamp-2 flex-1 text-sm text-slate-500">
                                {{ $product->description ?: 'Belum ada deskripsi.' }}
                            </p>

                            <div class="mt-4 flex items-baseline gap-1">
                                <span class="text-xl font-extrabold text-blue-700">{{ $product->formatted_price }}</span>
                                <span class="text-sm font-medium text-slate-400">/ {{ $product->unit }}</span>
                            </div>

                            <div class="mt-4 flex flex-col gap-2">
                                <a href="{{ $product->whatsappOrderUrl() }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-600">
                                    🛒 Pesan via WhatsApp
                                </a>
                                <a href="{{ $product->whatsappStockUrl() }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 bg-white px-4 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-50">
                                    ❓ Tanya Stok via WhatsApp
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-blue-200 bg-white px-6 py-16 text-center">
                <p class="text-5xl">🔍</p>
                <h3 class="mt-4 text-lg font-bold text-blue-900">Produk tidak ditemukan</h3>
                <p class="mt-1 text-sm text-slate-500">Coba kata kunci lain atau pilih kategori yang berbeda.</p>
                <a href="{{ route('catalog') }}" class="mt-6 inline-block rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                    Lihat Semua Produk
                </a>
            </div>
        @endif
    </section>

@endsection