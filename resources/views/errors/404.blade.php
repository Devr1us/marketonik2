<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Tidak Ditemukan - Marketonik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#0a0b12] text-zinc-100">
    <main class="flex min-h-screen items-center justify-center px-6">
        <section class="max-w-lg text-center">
            <p class="font-display text-7xl font-extrabold text-amber-300">404</p>
            <h1 class="mt-4 font-display text-3xl font-bold text-white">Halaman tidak ditemukan</h1>
            <p class="mt-3 text-sm text-zinc-400">Alamat yang dibuka tidak tersedia atau sudah dipindahkan.</p>
            <a href="{{ url('/') }}" class="mt-6 inline-flex rounded-xl bg-amber-500 px-5 py-3 text-sm font-bold text-zinc-950 hover:bg-amber-400">Kembali ke Beranda</a>
        </section>
    </main>
</body>
</html>
