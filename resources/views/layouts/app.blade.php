<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('shop.name') . ' - Katalog Produk')</title>
    <meta name="description" content="Katalog sembako lengkap dengan harga bersahabat. Pesan mudah lewat WhatsApp.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CSS via CDN (tanpa npm) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>
</head>
<body class="flex min-h-screen flex-col bg-slate-50 font-sans text-slate-700 antialiased">

    {{-- Navbar --}}
    <header class="sticky top-0 z-40 border-b border-blue-100 bg-white/90 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('catalog') }}" class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-xl text-white shadow-sm">🛒</span>
                <span class="text-lg font-extrabold tracking-tight text-blue-900">
                    {{ config('shop.name') }}
                </span>
            </a>

            <nav class="flex items-center gap-2 sm:gap-4">
                <a href="{{ route('catalog') }}" class="hidden rounded-lg px-3 py-2 text-sm font-medium text-slate-600 transition hover:bg-blue-50 hover:text-blue-700 sm:block">Katalog</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg border border-blue-200 px-4 py-2 text-sm font-semibold text-blue-700 transition hover:bg-blue-50">Admin</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Tombol chat WhatsApp melayang --}}
    <a href="https://wa.me/{{ preg_replace('/\D/', '', config('shop.whatsapp')) }}"
       target="_blank" rel="noopener"
       class="fixed bottom-5 right-5 z-50 flex items-center gap-2 rounded-full bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg transition hover:bg-blue-700">
        💬 Chat Toko
    </a>

    {{-- Footer --}}
    <footer class="border-t border-blue-100 bg-white">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-4 py-6 text-center text-sm text-slate-500 sm:flex-row sm:px-6 sm:text-left lg:px-8">
            <p>&copy; {{ date('Y') }} <span class="font-semibold text-blue-800">{{ config('shop.name') }}</span>. Semua hak dilindungi.</p>
            <p>📍 {{ config('shop.address') }}</p>
        </div>
    </footer>

</body>
</html>