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
            <a href="{{ route('admin.dashboard') }}" class="mb-10 flex items-center gap-3">
                <span class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-xl bg-zinc-200 p-1">
                    <img src="{{ asset('images/marketonik-logo.png') }}" alt="Marketonik" class="h-7 w-7 object-contain">
                </span>
                <div>
                    <p class="font-display text-base font-bold text-white leading-none">Marketonik</p>
                    <p class="text-[10px] text-violet-300/80 mt-0.5">Panel Admin</p>
                </div>
            </a>
            <nav class="space-y-0.5 text-sm">
                @foreach([
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => '📊', 'match' => 'admin.dashboard'],
                    ['route' => 'admin.reports.index', 'label' => 'Laporan', 'icon' => '📈', 'match' => 'admin.reports.*'],
                    ['route' => 'admin.orders.index', 'label' => 'Pesanan', 'icon' => '🧾', 'match' => 'admin.orders.*'],
                    ['route' => 'admin.products.index', 'label' => 'Produk', 'icon' => '📦', 'match' => 'admin.products.index'],
                    ['route' => 'admin.products.create', 'label' => 'Tambah Produk', 'icon' => '➕', 'match' => 'admin.products.create'],
                    ['route' => 'admin.kategori.index', 'label' => 'Kategori', 'icon' => '🏷️', 'match' => 'admin.kategori.*'],
                    ['route' => 'admin.users.index', 'label' => 'Pembeli', 'icon' => '👥', 'match' => 'admin.users.*'],
                ] as $nav)
                <a href="{{ route($nav['route']) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 transition {{ request()->routeIs($nav['match']) ? 'bg-violet-500/20 text-violet-100' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                    <span class="text-base">{{ $nav['icon'] }}</span>
                    <span>{{ $nav['label'] }}</span>
                </a>
                @endforeach
            </nav>
            <div class="mt-6 border-t border-white/10 pt-6">
                <div class="mb-4 flex items-center gap-2 px-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-violet-400 to-violet-600 text-xs font-bold text-white shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-zinc-500">Administrator</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 rounded-xl border border-white/10 px-3 py-2 text-xs font-semibold text-zinc-400 hover:border-rose-500/40 hover:text-rose-300 transition">
                        <span>🚪</span> Keluar
                    </button>
                </form>
            </div>
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
