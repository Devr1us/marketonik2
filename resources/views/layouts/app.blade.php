<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Marketonik Luxe') — Elektronik Premium</title>
    <link rel="icon" href="{{ asset('images/marketonik-logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|syne:500,600,700,800" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-[#07080f] text-zinc-100 antialiased font-sans selection:bg-amber-500/30 selection:text-amber-100">
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 left-1/2 h-[32rem] w-[60rem] -translate-x-1/2 rounded-full bg-gradient-to-b from-amber-500/15 via-fuchsia-600/10 to-transparent blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>

    @auth
    <header class="sticky top-0 z-40 border-b border-white/10 bg-[#07080f]/80 backdrop-blur-xl">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4">
            <a href="{{ route('pembeli.dashboard') }}" class="group flex items-center gap-3">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-zinc-200 p-1 shadow-inner ring-1 ring-white/10">
                    <img src="{{ asset('images/marketonik-logo.png') }}" alt="Marketonik" width="36" height="36" class="h-9 w-9 object-contain" loading="eager" decoding="async">
                </span>
                <div>
                    <p class="font-display text-lg font-bold tracking-tight text-white group-hover:text-amber-200">Marketonik</p>
                    <p class="text-xs text-zinc-500">Luxe Electronics</p>
                </div>
            </a>
            <nav class="hidden items-center gap-6 text-sm font-medium text-zinc-400 md:flex">
                <a class="hover:text-amber-300 {{ request()->routeIs('pembeli.dashboard') ? 'text-amber-300' : '' }}" href="{{ route('pembeli.dashboard') }}">Dashboard</a>
                <a class="hover:text-amber-300" href="{{ route('toko.index') }}">Katalog</a>
                <a class="hover:text-amber-300" href="{{ route('keranjang.index') }}">Keranjang</a>
                <a class="hover:text-amber-300" href="{{ route('pesanan.index') }}">Pesanan</a>
            </nav>
            <div class="flex items-center gap-3">
                <span class="hidden max-w-[10rem] truncate text-xs text-zinc-500 sm:inline">{{ auth()->user()->name }}</span>
                <form action="{{ route('auth.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="rounded-lg border border-white/15 px-3 py-1.5 text-xs font-semibold text-zinc-300 hover:border-amber-500/50 hover:text-amber-200">Keluar</button>
                </form>
            </div>
        </div>
    </header>
    @endauth

    <main class="mx-auto max-w-6xl px-4 py-8">
        @if(session('ok'))
            <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-200">{{ session('ok') }}</div>
        @endif
        @if(session('info'))
            <div class="mb-6 rounded-xl border border-sky-500/30 bg-sky-500/10 px-4 py-3 text-sm text-sky-200">{{ session('info') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-6 rounded-xl border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-sm text-rose-200">
                <ul class="list-inside list-disc space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        @yield('content')
    </main>

    @auth
    <footer class="border-t border-white/10 py-10 text-center text-xs text-zinc-600">
        Marketonik Luxe — demo e-commerce elektronik. Diskon tampil di etiket emas.
    </footer>
    @endauth
</body>
</html>
