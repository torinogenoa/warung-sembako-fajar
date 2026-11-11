<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    {{-- Nama produk --}}
    <div>
        <label for="name" class="mb-1 block text-sm font-semibold text-slate-700">Nama Produk</label>
        <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" required
               placeholder="Contoh: Beras Premium"
               class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 @error('name') border-red-400 @enderror">
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Kategori --}}
    <div>
        <label for="category_id" class="mb-1 block text-sm font-semibold text-slate-700">Kategori</label>
        <select id="category_id" name="category_id" required
                class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 @error('category_id') border-red-400 @enderror">
            <option value="">-- Pilih kategori --</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                    {{ $category->icon }} {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Harga & satuan --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="price" class="mb-1 block text-sm font-semibold text-slate-700">Harga (Rp)</label>
            <div class="flex">
                <span class="inline-flex items-center rounded-l-xl border border-r-0 border-slate-300 bg-slate-50 px-3 text-sm font-semibold text-slate-500">Rp</span>
                <input id="price" type="number" name="price" min="0" step="1" value="{{ old('price', $product->price) }}" required
                       placeholder="15000"
                       class="w-full rounded-r-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 @error('price') border-red-400 @enderror">
            </div>
            @error('price')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="unit" class="mb-1 block text-sm font-semibold text-slate-700">Satuan</label>
            <select id="unit" name="unit" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 @error('unit') border-red-400 @enderror">
                @foreach (\App\Models\Product::UNITS as $unit)
                    <option value="{{ $unit }}" @selected(old('unit', $product->unit ?: 'pcs') === $unit)>
                        {{ $unit }}
                    </option>
                @endforeach
            </select>
            @error('unit')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Deskripsi --}}
    <div>
        <label for="description" class="mb-1 block text-sm font-semibold text-slate-700">Deskripsi Produk</label>
        <textarea id="description" name="description" rows="4" maxlength="500"
                  placeholder="Deskripsi singkat produk (maks. 500 karakter)"
                  class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 @error('description') border-red-400 @enderror">{{ old('description', $product->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tombol --}}
    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
        <a href="{{ route('admin.products.index') }}"
           class="rounded-xl border border-slate-300 px-6 py-2.5 text-center text-sm font-semibold text-slate-600 hover:bg-slate-50">
            Batal
        </a>
        <button type="submit"
                class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow transition hover:bg-blue-700">
            {{ $submitLabel }}
        </button>
    </div>
</form>