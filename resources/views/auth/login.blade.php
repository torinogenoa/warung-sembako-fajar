@extends('layouts.app')

@section('title', 'Login Admin - ' . config('shop.name'))

@section('content')
    <div class="flex min-h-[70vh] items-center justify-center bg-gradient-to-br from-blue-50 to-white px-4 py-12">
        <div class="w-full max-w-md rounded-2xl border border-blue-100 bg-white p-8 shadow-lg">
            <div class="text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-2xl text-white shadow">🔐</span>
                <h1 class="mt-4 text-2xl font-extrabold text-blue-900">Login Admin</h1>
                <p class="mt-1 text-sm text-slate-500">Masuk untuk mengelola produk {{ config('shop.name') }}.</p>
            </div>

            <form method="POST" action="{{ route('login.attempt') }}" class="mt-8 space-y-5">
                @csrf

                <div>
                    <label for="email" class="mb-1 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 @error('email') border-red-400 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-semibold text-slate-700">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full rounded-xl border border-slate-300 px-4 py-2.5 focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 @error('password') border-red-400 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    Ingat saya
                </label>

                <button type="submit"
                        class="w-full rounded-xl bg-blue-600 px-4 py-3 text-sm font-bold text-white shadow transition hover:bg-blue-700">
                    Masuk
                </button>
            </form>

            <p class="mt-6 text-center text-sm">
                <a href="{{ route('catalog') }}" class="font-medium text-blue-600 hover:underline">&larr; Kembali ke katalog</a>
            </p>
        </div>
    </div>
@endsection