<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — Marketonik</title>
    <link rel="icon" href="{{ asset('images/marketonik-logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|syne:500,600,700,800" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-[#0a0b12] text-zinc-100 antialiased font-sans">
    <div class="pointer-events-none fixed inset-0 -z-10 bg-gradient-to-br from-violet-950/30 via-[#0a0b12] to-amber-950/20"></div>

    <div class="flex min-h-full">
        <aside class="hidden w-64 shrink-0 border-r border-white/10 bg-black/30 p-6 lg:block">
            <a href="{{ route('admin.dashboard') }}" class="mb-10 block">
                <p class="font-display text-lg font-bold text-white">Marketonik</p>
                <p class="text-xs text-violet-300/80">Panel Admin</p>
            </a>
            <nav class="space-y-1 text-sm">
                <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-violet-500/20 text-violet-100' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">Dashboard</a>
                <a href="{{ route('admin.users.index') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.users.*') ? 'bg-violet-500/20 text-violet-100' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">Pembeli</a>
                <a href="{{ route('admin.products.index') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.products.index', 'admin.products.toggle', 'admin.products.destroy') ? 'bg-violet-500/20 text-violet-100' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">Daftar Produk</a>
                <a href="{{ route('admin.products.create') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.products.create') ? 'bg-violet-500/20 text-violet-100' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">Jual Produk</a>
                <a href="{{ route('admin.orders.index') }}" class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.orders.*') ? 'bg-violet-500/20 text-violet-100' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">Pesanan</a>
            </nav>
            <form action="{{ route('admin.logout') }}" method="post" class="mt-10">
                @csrf
                <button type="submit" class="w-full rounded-lg border border-white/15 px-3 py-2 text-xs font-semibold text-zinc-400 hover:border-rose-500/40 hover:text-rose-200">Keluar</button>
            </form>
        </aside>

        <div class="flex flex-1 flex-col">
            <header class="flex items-center justify-between border-b border-white/10 px-4 py-4 lg:px-8">
                <div class="lg:hidden">
                    <p class="font-display font-bold text-white">Admin</p>
                </div>
                <p class="hidden text-sm text-zinc-500 lg:block">{{ auth()->user()->name }}</p>
                <nav class="flex gap-2 text-xs lg:hidden">
                    <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-2 py-1 text-zinc-400">Home</a>
                    <a href="{{ route('admin.orders.index') }}" class="rounded-lg px-2 py-1 text-zinc-400">Pesanan</a>
                </nav>
            </header>

            <main class="flex-1 p-4 lg:p-8">
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
        </div>
    </div>
</body>
</html>
