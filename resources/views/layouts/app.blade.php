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

    {{-- Background ambient --}}
    <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 left-1/2 h-[32rem] w-[60rem] -translate-x-1/2 rounded-full bg-gradient-to-b from-amber-500/15 via-fuchsia-600/10 to-transparent blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>

    {{-- Toast Notifications --}}
    @if(session('ok') || session('info') || $errors->any())
    <div id="toast-container" class="fixed right-4 top-4 z-[100] flex flex-col gap-2 w-80">
        @if(session('ok'))
        <div class="toast-item flex items-start gap-3 rounded-xl border border-emerald-500/30 bg-[#07080f]/95 px-4 py-3 shadow-2xl shadow-black/50 backdrop-blur-xl ring-1 ring-emerald-500/20">
            <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400 text-xs">✓</span>
            <p class="text-sm text-emerald-200">{{ session('ok') }}</p>
            <button onclick="this.closest('.toast-item').remove()" class="ml-auto text-zinc-600 hover:text-zinc-400 text-xs">✕</button>
        </div>
        @endif
        @if(session('info'))
        <div class="toast-item flex items-start gap-3 rounded-xl border border-sky-500/30 bg-[#07080f]/95 px-4 py-3 shadow-2xl shadow-black/50 backdrop-blur-xl ring-1 ring-sky-500/20">
            <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-sky-500/20 text-sky-400 text-xs">i</span>
            <p class="text-sm text-sky-200">{{ session('info') }}</p>
            <button onclick="this.closest('.toast-item').remove()" class="ml-auto text-zinc-600 hover:text-zinc-400 text-xs">✕</button>
        </div>
        @endif
        @if($errors->any())
        <div class="toast-item flex items-start gap-3 rounded-xl border border-rose-500/30 bg-[#07080f]/95 px-4 py-3 shadow-2xl shadow-black/50 backdrop-blur-xl ring-1 ring-rose-500/20">
            <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-rose-500/20 text-rose-400 text-xs">!</span>
            <div class="flex-1">
                @foreach($errors->all() as $e)
                    <p class="text-sm text-rose-200">{{ $e }}</p>
                @endforeach
            </div>
            <button onclick="this.closest('.toast-item').remove()" class="ml-auto text-zinc-600 hover:text-zinc-400 text-xs">✕</button>
        </div>
        @endif
    </div>
    <script>
        setTimeout(() => {
            document.querySelectorAll('.toast-item').forEach(el => {
                el.style.transition = 'opacity 0.5s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            });
        }, 4000);
    </script>
    @endif

    @auth
    {{-- Navbar --}}
    <header class="sticky top-0 z-40 border-b border-white/10 bg-[#07080f]/80 backdrop-blur-xl">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3">
            {{-- Logo --}}
            <a href="{{ route('pembeli.dashboard') }}" class="group flex items-center gap-3">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-zinc-200 p-1 shadow-inner ring-1 ring-white/10">
                    <img src="{{ asset('images/marketonik-logo.png') }}" alt="Marketonik" width="32" height="32" class="h-8 w-8 object-contain">
                </span>
                <div class="hidden sm:block">
                    <p class="font-display text-base font-bold tracking-tight text-white group-hover:text-amber-200 leading-none">Marketonik</p>
                    <p class="text-[10px] text-zinc-500 leading-none mt-0.5">Luxe Electronics</p>
                </div>
            </a>

            {{-- Nav Links --}}
            <nav class="hidden items-center gap-1 md:flex">
                <a href="{{ route('pembeli.dashboard') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('pembeli.dashboard') ? 'bg-amber-500/15 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                    Dashboard
                </a>
                <a href="{{ route('toko.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('toko.*') ? 'bg-amber-500/15 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                    Katalog
                </a>
                <a href="{{ route('jual.create') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('jual.*') ? 'bg-amber-500/15 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                    Jual
                </a>
                <a href="{{ route('pesanan.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('pesanan.*') ? 'bg-amber-500/15 text-amber-300' : 'text-zinc-400 hover:bg-white/5 hover:text-white' }}">
                    Pesanan
                </a>
            </nav>

            {{-- Right side --}}
            <div class="flex items-center gap-2">
                {{-- Cart badge --}}
                @php $cartCount = auth()->user()->cartItems()->count(); @endphp
                <a href="{{ route('keranjang.index') }}" class="relative flex h-9 w-9 items-center justify-center rounded-xl border border-white/10 text-zinc-400 hover:border-amber-500/40 hover:text-amber-300 transition {{ request()->routeIs('keranjang.*') ? 'border-amber-500/40 text-amber-300 bg-amber-500/10' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-amber-500 text-[9px] font-bold text-zinc-950">{{ $cartCount > 9 ? '9+' : $cartCount }}</span>
                    @endif
                </a>

                {{-- User menu --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="flex items-center gap-2 rounded-xl border border-white/10 px-3 py-2 text-sm text-zinc-300 hover:border-amber-500/40 hover:text-white transition">
                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-gradient-to-br from-amber-400 to-amber-600 text-[10px] font-bold text-zinc-950">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="hidden max-w-[8rem] truncate text-xs sm:inline">{{ auth()->user()->name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition class="absolute right-0 top-full mt-2 w-48 rounded-xl border border-white/10 bg-[#0d0e18]/95 p-1 shadow-2xl shadow-black/50 backdrop-blur-xl">
                        <div class="px-3 py-2 border-b border-white/10 mb-1">
                            <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-zinc-500">@{{ auth()->user()->username }}</p>
                        </div>
                        <a href="{{ route('pembeli.dashboard') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-xs text-zinc-400 hover:bg-white/5 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>
                        <a href="{{ route('pesanan.index') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-xs text-zinc-400 hover:bg-white/5 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Riwayat Pesanan
                        </a>
                        <div class="border-t border-white/10 mt-1 pt-1">
                            <form action="{{ route('auth.logout') }}" method="post">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-xs text-rose-400 hover:bg-rose-500/10 hover:text-rose-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Mobile menu button --}}
                <button id="mobile-menu-btn" class="flex h-9 w-9 items-center justify-center rounded-xl border border-white/10 text-zinc-400 hover:border-white/20 md:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile nav --}}
        <div id="mobile-menu" class="hidden border-t border-white/10 px-4 py-3 md:hidden">
            <nav class="flex flex-col gap-1">
                <a href="{{ route('pembeli.dashboard') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('pembeli.dashboard') ? 'bg-amber-500/15 text-amber-300' : 'text-zinc-400' }}">Dashboard</a>
                <a href="{{ route('toko.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('toko.*') ? 'bg-amber-500/15 text-amber-300' : 'text-zinc-400' }}">Katalog</a>
                <a href="{{ route('jual.create') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('jual.*') ? 'bg-amber-500/15 text-amber-300' : 'text-zinc-400' }}">Jual Produk</a>
                <a href="{{ route('keranjang.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('keranjang.*') ? 'bg-amber-500/15 text-amber-300' : 'text-zinc-400' }}">Keranjang @if($cartCount > 0)<span class="ml-1 rounded-full bg-amber-500 px-1.5 py-0.5 text-[9px] font-bold text-zinc-950">{{ $cartCount }}</span>@endif</a>
                <a href="{{ route('pesanan.index') }}" class="rounded-lg px-3 py-2.5 text-sm font-medium {{ request()->routeIs('pesanan.*') ? 'bg-amber-500/15 text-amber-300' : 'text-zinc-400' }}">Pesanan</a>
            </nav>
        </div>
    </header>
    @endauth

    <main class="mx-auto max-w-6xl px-4 py-8">
        @yield('content')
    </main>

    @auth
    <footer class="border-t border-white/10 mt-16">
        <div class="mx-auto max-w-6xl px-4 py-10">
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="flex h-8 w-8 items-center justify-center overflow-hidden rounded-lg bg-zinc-200 p-1">
                            <img src="{{ asset('images/marketonik-logo.png') }}" alt="Marketonik" class="h-6 w-6 object-contain">
                        </span>
                        <span class="font-display font-bold text-white">Marketonik</span>
                    </div>
                    <p class="text-xs text-zinc-500 leading-relaxed">Platform e-commerce elektronik premium dengan koleksi produk pilihan terbaik.</p>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 mb-3">Belanja</p>
                    <div class="space-y-2">
                        <a href="{{ route('toko.index') }}" class="block text-xs text-zinc-400 hover:text-amber-300">Semua Produk</a>
                        @foreach(\App\Models\Product::CATEGORIES as $cat)
                        <a href="{{ route('toko.index', ['kategori' => $cat]) }}" class="block text-xs text-zinc-400 hover:text-amber-300">{{ $cat }}</a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 mb-3">Akun</p>
                    <div class="space-y-2">
                        <a href="{{ route('pembeli.dashboard') }}" class="block text-xs text-zinc-400 hover:text-amber-300">Dashboard</a>
                        <a href="{{ route('pesanan.index') }}" class="block text-xs text-zinc-400 hover:text-amber-300">Riwayat Pesanan</a>
                        <a href="{{ route('keranjang.index') }}" class="block text-xs text-zinc-400 hover:text-amber-300">Keranjang</a>
                        <a href="{{ route('jual.create') }}" class="block text-xs text-zinc-400 hover:text-amber-300">Jual Produk</a>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-500 mb-3">Info</p>
                    <div class="space-y-2 text-xs text-zinc-500">
                        <p>Pengiriman ke seluruh Indonesia</p>
                        <p>Garansi produk resmi</p>
                        <p>Pembayaran aman & terenkripsi</p>
                        <p class="mt-4 text-zinc-600">© {{ date('Y') }} Marketonik Luxe</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    @endauth

    <script>
        // Mobile menu toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        if (btn && menu) {
            btn.addEventListener('click', () => menu.classList.toggle('hidden'));
        }

        // Simple Alpine.js-like x-data for dropdown (no Alpine needed)
        document.querySelectorAll('[x-data]').forEach(el => {
            const btn = el.querySelector('button');
            const dropdown = el.querySelector('[x-show]');
            if (!btn || !dropdown) return;
            dropdown.style.display = 'none';
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isHidden = dropdown.style.display === 'none';
                dropdown.style.display = isHidden ? 'block' : 'none';
            });
            document.addEventListener('click', () => {
                dropdown.style.display = 'none';
            });
        });
    </script>
</body>
</html>
