<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kilo — Laundry Kiloan Tanpa Ribet</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=IBM+Plex+Mono:wght@500;600&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#1E2A3A',
                        soap: '#00398c',
                        sun: '#F2B705',
                        tagred: '#D64545',
                        foam: '#DCEFEA',
                        linen: '#F3F6F5',
                    },
                    fontFamily: {
                        display: ['"Space Grotesk"', 'sans-serif'],
                        body: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"IBM Plex Mono"', 'monospace'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #F3F6F5;
        }

        /* Price-tag / garment-tag shape with a punched hole */
        .tag {
            position: relative;
            clip-path: polygon(26px 0, 100% 0, 100% 100%, 26px 100%, 0 50%);
        }

        .tag::before {
            content: '';
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            width: 7px;
            height: 7px;
            border-radius: 9999px;
            background: #F3F6F5;
        }

        /* Receipt-style dashed perforation */
        .perforated {
            border-top: 2px dashed rgba(30, 42, 58, 0.2);
        }

        .stub:not(:last-child) {
            border-right: 2px dashed rgba(30, 42, 58, 0.15);
        }

        @media (max-width: 767px) {
            .stub:not(:last-child) {
                border-right: none;
                border-bottom: 2px dashed rgba(30, 42, 58, 0.15);
            }
        }

        .shirt-pattern {
            background-image: radial-gradient(rgba(243, 246, 245, 0.12) 1.5px, transparent 1.5px);
            background-size: 18px 18px;
        }

        .mobile-menu {
            transition: max-height 0.25s ease;
        }
    </style>
</head>
<body class="font-body text-ink antialiased">

<!-- ============ NAVBAR ============ -->
<header class="sticky top-0 z-50 bg-linen/90 backdrop-blur border-b border-ink/10">
    <div class="max-w-6xl mx-auto px-5 md:px-8 h-16 flex items-center justify-between">
        <a href="#" class="flex items-center gap-2 font-display font-700 text-xl tracking-tight">
      <span class="w-8 h-8 rounded-full bg-soap text-white flex items-center justify-center">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round"><circle cx="12" cy="13" r="7"/><path d="M12 9v4l3 2"/></svg>
      </span>
            Cucian.id
        </a>

        <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-ink/80">
            <a href="#layanan" class="hover:text-ink transition">Layanan</a>
            <a href="#cara-kerja" class="hover:text-ink transition">Cara Kerja</a>
            <a href="#harga" class="hover:text-ink transition">Harga</a>
            <a href="#testimoni" class="hover:text-ink transition">Testimoni</a>
        </nav>

        <a href="{{ route('login')  }}"
           class="hidden md:inline-flex items-center gap-2 bg-ink text-white text-sm font-semibold px-5 py-2.5 rounded-full hover:bg-soap transition">
            Masuk ke Aplikasi
        </a>

        <button id="menuBtn" class="md:hidden w-9 h-9 flex items-center justify-center" aria-label="Buka menu">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round">
                <path d="M4 7h16M4 12h16M4 17h16"/>
            </svg>
        </button>
    </div>

    <div id="mobileMenu" class="mobile-menu md:hidden overflow-hidden max-h-0 border-t border-ink/10 bg-linen">
        <nav class="flex flex-col px-5 py-4 gap-4 text-sm font-medium">
            <a href="#layanan" class="hover:text-soap">Layanan</a>
            <a href="#cara-kerja" class="hover:text-soap">Cara Kerja</a>
            <a href="#harga" class="hover:text-soap">Harga</a>
            <a href="#testimoni" class="hover:text-soap">Testimoni</a>
            <a href="/login" class="bg-ink text-white text-center px-5 py-2.5 rounded-full font-semibold">Masuk ke
                Aplikasi</a>
        </nav>
    </div>
</header>

<!-- ============ HERO ============ -->
<section class="relative overflow-hidden">
    <div class="max-w-6xl mx-auto px-5 md:px-8 pt-14 md:pt-20 pb-16 grid md:grid-cols-2 gap-12 items-center">

        <div>
            <div
                class="tag inline-flex items-center bg-sun text-ink font-mono text-xs font-semibold pl-6 pr-4 py-2 mb-6"
                style="--hole:#F2B705">
                MULAI Rp7.000&nbsp;/&nbsp;KG
            </div>

            <h1 class="font-display font-700 text-4xl sm:text-5xl leading-[1.08] tracking-tight mb-5">
                Cucian numpuk,<br>
                <span class="text-soap">beres</span> tanpa ribet.
            </h1>

            <p class="text-ink/70 text-base sm:text-lg leading-relaxed mb-8 max-w-md">
                Jadwalkan jemput dari HP, kurir kami timbang di depan kamu, dan cucian wangi rapi balik dalam 24 jam.
                Kamu nggak perlu angkat ember, apalagi ngantre di kios.
            </p>

            <div class="flex flex-wrap gap-3 mb-10">
                <a href="{{ route('login')  }}"
                   class="bg-ink text-white text-sm font-semibold px-6 py-3.5 rounded-full hover:bg-soap transition">
                    Masuk ke Aplikasi
                </a>
            </div>

            <div class="flex items-center gap-4 text-sm text-ink/60">
                <div class="flex -space-x-2">
                    <span class="w-8 h-8 rounded-full bg-foam border-2 border-linen"></span>
                    <span class="w-8 h-8 rounded-full bg-soap/30 border-2 border-linen"></span>
                    <span class="w-8 h-8 rounded-full bg-sun/40 border-2 border-linen"></span>
                </div>
                <span>Dipercaya 80rb+ pelanggan di 12 kota</span>
            </div>
        </div>

        <!-- Website mockup -->
        <div class="relative flex justify-center md:justify-end">

            <div
                class="tag absolute -left-3 top-4 bg-white shadow-md pl-5 pr-4 py-2 text-xs font-mono font-semibold text-ink z-20 hidden sm:block"
                style="--hole:#ffffff">
                Kurir tiba 15 menit
            </div>
            <div
                class="tag absolute -right-3 bottom-6 bg-white shadow-md pl-5 pr-4 py-2 text-xs font-mono font-semibold text-soap z-20 hidden sm:block"
                style="--hole:#ffffff">
                Deterjen eco-friendly
            </div>

            <div
                class="relative w-full max-w-[480px] bg-white rounded-2xl border border-ink/10 shadow-2xl overflow-hidden">

                <!-- browser chrome -->
                <div class="bg-linen border-b border-ink/10 px-4 py-3 flex items-center gap-3">
                    <div class="flex gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-tagred/70"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-sun/70"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-foam"></span>
                    </div>
                    <div
                        class="flex-1 bg-white border border-ink/10 rounded-full px-3 py-1 text-[11px] font-mono text-ink/50 flex items-center gap-1.5">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2.5" stroke-linecap="round">
                            <rect x="5" y="11" width="14" height="9" rx="2"/>
                            <path d="M8 11V8a4 4 0 018 0v3"/>
                        </svg>
                        Cucian.id/dashboard
                    </div>
                </div>

                <div class="flex">
                    <!-- sidebar -->
                    <div class="hidden sm:flex w-14 flex-col items-center gap-4 py-6 border-r border-ink/10">
                        <span class="w-8 h-8 rounded-lg bg-soap text-white flex items-center justify-center">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round"><circle cx="12" cy="13" r="7"/><path
                                    d="M12 9v4l3 2"/></svg>
                        </span>
                        <span class="w-8 h-8 rounded-lg bg-foam text-soap flex items-center justify-center">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round"><rect x="5" y="4" width="14" height="16"
                                                                               rx="2"/><path d="M9 4v2M15 4v2"/></svg>
                        </span>
                        <span class="w-8 h-8 rounded-lg text-ink/30 flex items-center justify-center">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                 stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path
                                    d="M12 7v5l3 2"/></svg>
                        </span>
                    </div>

                    <!-- main content -->
                    <div class="flex-1 p-5">
                        <p class="text-xs text-ink/50 mb-0.5">Halo, Dinda 👋</p>
                        <p class="font-display font-600 text-base mb-4">Jemput cucianmu hari ini?</p>

                        <div class="bg-linen rounded-xl p-4 mb-3">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-xs font-semibold text-ink/50">NOTA #KL-0482</span>
                                <span
                                    class="text-xs font-mono bg-foam text-soap px-2 py-0.5 rounded-full">Diproses</span>
                            </div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-ink/70">Cuci + Setrika</span>
                                <span class="font-mono font-semibold">3.2 kg</span>
                            </div>
                            <div class="flex justify-between text-sm mb-3">
                                <span class="text-ink/70">Total</span>
                                <span class="font-mono font-semibold">Rp28.800</span>
                            </div>
                            <div class="w-full h-1.5 bg-foam rounded-full overflow-hidden">
                                <div class="h-full w-2/3 bg-sun rounded-full"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div class="bg-linen rounded-lg p-2.5 flex items-center gap-2">
                                <span
                                    class="w-7 h-7 shrink-0 rounded-full bg-foam flex items-center justify-center text-soap">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round"><circle cx="12" cy="13" r="7"/><path
                                            d="M12 9v4l3 2"/></svg>
                                </span>
                                <span class="text-xs font-medium">Cuci Kiloan</span>
                            </div>
                            <div class="bg-linen rounded-lg p-2.5 flex items-center gap-2">
                                <span
                                    class="w-7 h-7 shrink-0 rounded-full bg-foam flex items-center justify-center text-soap">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round"><rect x="5" y="4" width="14"
                                                                                       height="16" rx="2"/><path
                                            d="M9 4v2M15 4v2"/></svg>
                                </span>
                                <span class="text-xs font-medium">Dry Clean</span>
                            </div>
                        </div>

                        <div class="bg-ink text-white text-sm font-semibold text-center py-2.5 rounded-full">Jadwalkan
                            Jemput
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- stat stubs -->
    <div class="max-w-6xl mx-auto px-5 md:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 border-t border-b border-ink/10">
            <div class="stub py-6 text-center">
                <p class="font-display font-700 text-2xl">500rb+</p>
                <p class="text-xs text-ink/60 mt-1">Kg dicuci / bulan</p>
            </div>
            <div class="stub py-6 text-center">
                <p class="font-display font-700 text-2xl">1.200+</p>
                <p class="text-xs text-ink/60 mt-1">Kurir aktif</p>
            </div>
            <div class="stub py-6 text-center">
                <p class="font-display font-700 text-2xl">4.9/5</p>
                <p class="text-xs text-ink/60 mt-1">Rating pengguna</p>
            </div>
            <div class="stub py-6 text-center">
                <p class="font-display font-700 text-2xl">24 Jam</p>
                <p class="text-xs text-ink/60 mt-1">Layanan express</p>
            </div>
        </div>
    </div>
</section>

<!-- ============ CARA KERJA ============ -->
<section id="cara-kerja" class="max-w-6xl mx-auto px-5 md:px-8 py-20 md:py-28">
    <div class="max-w-lg mb-14">
        <p class="font-mono text-xs font-semibold text-soap mb-3">CARA KERJA</p>
        <h2 class="font-display font-700 text-3xl md:text-4xl tracking-tight">Empat langkah, kayak baca nota
            laundry</h2>
    </div>

    <div
        class="bg-white rounded-3xl shadow-sm border border-ink/10 divide-y divide-dashed divide-ink/15 overflow-hidden">
        <div class="grid md:grid-cols-[auto,1fr] gap-6 md:gap-10 p-6 md:p-8 items-start">
            <span class="font-mono text-4xl text-ink/15 font-semibold">01</span>
            <div>
                <h3 class="font-display font-600 text-lg mb-1">Jadwalkan Jemput</h3>
                <p class="text-ink/65 text-sm leading-relaxed">Pilih waktu dan alamat lewat aplikasi. Ongkos jemput
                    gratis, tinggal duduk manis nunggu kurir datang.</p>
            </div>
        </div>
        <div class="grid md:grid-cols-[auto,1fr] gap-6 md:gap-10 p-6 md:p-8 items-start">
            <span class="font-mono text-4xl text-ink/15 font-semibold">02</span>
            <div>
                <h3 class="font-display font-600 text-lg mb-1">Kurir Angkut &amp; Timbang</h3>
                <p class="text-ink/65 text-sm leading-relaxed">Cucian ditimbang langsung di depan kamu, dan kamu dapat
                    nota digital berisi berat serta estimasi harga.</p>
            </div>
        </div>
        <div class="grid md:grid-cols-[auto,1fr] gap-6 md:gap-10 p-6 md:p-8 items-start">
            <span class="font-mono text-4xl text-ink/15 font-semibold">03</span>
            <div>
                <h3 class="font-display font-600 text-lg mb-1">Dicuci, Disetrika, Dilipat</h3>
                <p class="text-ink/65 text-sm leading-relaxed">Diproses sesuai label perawatan kain masing-masing, pakai
                    deterjen ramah lingkungan dan hipoalergenik.</p>
            </div>
        </div>
        <div class="grid md:grid-cols-[auto,1fr] gap-6 md:gap-10 p-6 md:p-8 items-start">
            <span class="font-mono text-4xl text-ink/15 font-semibold">04</span>
            <div>
                <h3 class="font-display font-600 text-lg mb-1">Diantar Balik, Rapi</h3>
                <p class="text-ink/65 text-sm leading-relaxed">Notifikasi masuk begitu kurir otw. Cucian sampai dalam
                    keadaan wangi dan terlipat rapi, siap masuk lemari.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============ LAYANAN ============ -->
<section id="layanan" class="bg-white border-y border-ink/10">
    <div class="max-w-6xl mx-auto px-5 md:px-8 py-20 md:py-28">
        <div class="max-w-lg mb-14">
            <p class="font-mono text-xs font-semibold text-soap mb-3">LAYANAN</p>
            <h2 class="font-display font-700 text-3xl md:text-4xl tracking-tight">Satu aplikasi, segala urusan
                cucian</h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">

            <div class="border border-ink/10 rounded-2xl p-6 hover:border-soap/50 hover:shadow-md transition">
        <span class="w-11 h-11 rounded-xl bg-foam flex items-center justify-center text-soap mb-4">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round"><circle cx="12" cy="13" r="7"/><path d="M12 9v4l3 2"/></svg>
        </span>
                <h3 class="font-display font-600 mb-1">Cuci Kiloan</h3>
                <p class="text-sm text-ink/60 mb-3">Cuci + kering + lipat untuk pakaian harian.</p>
                <p class="font-mono text-sm text-soap font-semibold">mulai Rp7.000/kg</p>
            </div>

            <div class="border border-ink/10 rounded-2xl p-6 hover:border-soap/50 hover:shadow-md transition">
        <span class="w-11 h-11 rounded-xl bg-foam flex items-center justify-center text-soap mb-4">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round"><path d="M6 3l1 4-3 2 6 12 6-12-3-2 1-4"/></svg>
        </span>
                <h3 class="font-display font-600 mb-1">Cuci Setrika</h3>
                <p class="text-sm text-ink/60 mb-3">Cucian sampai licin rapi, siap gantung.</p>
                <p class="font-mono text-sm text-soap font-semibold">mulai Rp9.000/kg</p>
            </div>

            <div class="border border-ink/10 rounded-2xl p-6 hover:border-soap/50 hover:shadow-md transition">
        <span class="w-11 h-11 rounded-xl bg-foam flex items-center justify-center text-soap mb-4">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round"><rect x="5" y="4" width="14" height="16" rx="2"/><path d="M9 4v2M15 4v2"/></svg>
        </span>
                <h3 class="font-display font-600 mb-1">Dry Clean</h3>
                <p class="text-sm text-ink/60 mb-3">Untuk jas, gaun, dan bahan yang butuh perawatan halus.</p>
                <p class="font-mono text-sm text-soap font-semibold">mulai Rp25.000/pcs</p>
            </div>

            <div class="border border-ink/10 rounded-2xl p-6 hover:border-soap/50 hover:shadow-md transition">
        <span class="w-11 h-11 rounded-xl bg-foam flex items-center justify-center text-soap mb-4">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round"><path d="M4 15l4-6h5l2 3h5v3H4z"/><path d="M4 15v2h16v-2"/></svg>
        </span>
                <h3 class="font-display font-600 mb-1">Cuci Sepatu</h3>
                <p class="text-sm text-ink/60 mb-3">Deep clean, deodorize, sampai sol putih lagi.</p>
                <p class="font-mono text-sm text-soap font-semibold">mulai Rp20.000/pasang</p>
            </div>

            <div class="border border-ink/10 rounded-2xl p-6 hover:border-soap/50 hover:shadow-md transition">
        <span class="w-11 h-11 rounded-xl bg-foam flex items-center justify-center text-soap mb-4">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round"><path d="M6 3l1 4-3 2 6 12 6-12-3-2 1-4"/></svg>
        </span>
                <h3 class="font-display font-600 mb-1">Setrika Saja</h3>
                <p class="text-sm text-ink/60 mb-3">Cucian sudah bersih, tinggal butuh dirapikan.</p>
                <p class="font-mono text-sm text-soap font-semibold">mulai Rp5.000/kg</p>
            </div>

            <div class="border border-ink/10 rounded-2xl p-6 hover:border-soap/50 hover:shadow-md transition">
        <span class="w-11 h-11 rounded-xl bg-foam flex items-center justify-center text-soap mb-4">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
        </span>
                <h3 class="font-display font-600 mb-1">Express 6 Jam</h3>
                <p class="text-sm text-ink/60 mb-3">Buat kebutuhan mendadak, kelar dalam hitungan jam.</p>
                <p class="font-mono text-sm text-soap font-semibold">mulai Rp15.000/kg</p>
            </div>

        </div>
    </div>
</section>

<!-- ============ KENAPA KILO ============ -->
<section class="max-w-6xl mx-auto px-5 md:px-8 py-20 md:py-28 grid md:grid-cols-2 gap-12">
    <div>
        <p class="font-mono text-xs font-semibold text-soap mb-3">KENAPA Cucian.id</p>
        <h2 class="font-display font-700 text-3xl md:text-4xl tracking-tight mb-6">Bukan cuma cuci, kami jaga kualitas
            kainmu</h2>
        <p class="text-ink/65 leading-relaxed max-w-md">Setiap pesanan diperlakukan sesuai label perawatan pada kainnya
            sendiri — bukan disamaratakan dalam satu mesin besar.</p>
    </div>

    <div class="grid sm:grid-cols-2 gap-6">
        <div class="flex gap-4">
      <span class="w-11 h-11 shrink-0 rounded-xl bg-foam flex items-center justify-center text-soap">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round"><path d="M20 6L9 17l-5-5"/></svg>
      </span>
            <div>
                <h3 class="font-display font-600 text-sm mb-1">Kurir Terverifikasi</h3>
                <p class="text-sm text-ink/60">Semua kurir melalui pelatihan dan verifikasi identitas.</p>
            </div>
        </div>
        <div class="flex gap-4">
      <span class="w-11 h-11 shrink-0 rounded-xl bg-foam flex items-center justify-center text-soap">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round"><path d="M12 3c-4 3-7 4-7 9a7 7 0 0014 0c0-5-3-6-7-9z"/></svg>
      </span>
            <div>
                <h3 class="font-display font-600 text-sm mb-1">Deterjen Ramah Lingkungan</h3>
                <p class="text-sm text-ink/60">Hipoalergenik, aman untuk kulit sensitif dan bayi.</p>
            </div>
        </div>
        <div class="flex gap-4">
      <span class="w-11 h-11 shrink-0 rounded-xl bg-foam flex items-center justify-center text-soap">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round"><path d="M12 21s-7-4.5-7-11a7 7 0 0114 0c0 6.5-7 11-7 11z"/><circle cx="12" cy="10"
                                                                                                        r="2.5"/></svg>
      </span>
            <div>
                <h3 class="font-display font-600 text-sm mb-1">Lacak Real-Time</h3>
                <p class="text-sm text-ink/60">Pantau status cucian dari dijemput sampai diantar.</p>
            </div>
        </div>
        <div class="flex gap-4">
      <span class="w-11 h-11 shrink-0 rounded-xl bg-foam flex items-center justify-center text-soap">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round"><path d="M12 3l7 3v6c0 5-3 8-7 9-4-1-7-4-7-9V6l7-3z"/></svg>
      </span>
            <div>
                <h3 class="font-display font-600 text-sm mb-1">Garansi Cuci Ulang</h3>
                <p class="text-sm text-ink/60">Kurang puas? Cuci ulang gratis, tanpa banyak tanya.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============ HARGA ============ -->
<section id="harga" class="bg-ink text-linen">
    <div class="max-w-6xl mx-auto px-5 md:px-8 py-20 md:py-28">
        <div class="max-w-lg mb-14">
            <p class="font-mono text-xs font-semibold text-sun mb-3">DAFTAR HARGA</p>
            <h2 class="font-display font-700 text-3xl md:text-4xl tracking-tight">Transparan dari awal, kayak papan
                harga di kios</h2>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-3xl overflow-hidden">
            <div
                class="grid grid-cols-[1fr,auto] px-6 md:px-8 py-4 perforated border-white/10 text-xs font-mono text-linen/50">
                <span>LAYANAN</span>
                <span>HARGA</span>
            </div>
            <div class="grid grid-cols-[1fr,auto] px-6 md:px-8 py-4 perforated border-white/10 items-center">
                <span class="font-medium">Cuci Kiloan (cuci, kering, lipat)</span>
                <span class="font-mono text-sun">Rp7.000 / kg</span>
            </div>
            <div class="grid grid-cols-[1fr,auto] px-6 md:px-8 py-4 perforated border-white/10 items-center">
                <span class="font-medium">Cuci Setrika</span>
                <span class="font-mono text-sun">Rp9.000 / kg</span>
            </div>
            <div class="grid grid-cols-[1fr,auto] px-6 md:px-8 py-4 perforated border-white/10 items-center">
                <span class="font-medium">Setrika Saja</span>
                <span class="font-mono text-sun">Rp5.000 / kg</span>
            </div>
            <div class="grid grid-cols-[1fr,auto] px-6 md:px-8 py-4 perforated border-white/10 items-center">
                <span class="font-medium">Dry Clean (per potong)</span>
                <span class="font-mono text-sun">mulai Rp25.000</span>
            </div>
            <div class="grid grid-cols-[1fr,auto] px-6 md:px-8 py-4 perforated border-white/10 items-center">
                <span class="font-medium">Cuci Sepatu (per pasang)</span>
                <span class="font-mono text-sun">mulai Rp20.000</span>
            </div>
            <div class="grid grid-cols-[1fr,auto] px-6 md:px-8 py-4 perforated border-white/10 items-center">
                <span class="font-medium">Tambahan Express 6 Jam</span>
                <span class="font-mono text-sun">+Rp8.000 / kg</span>
            </div>
        </div>

        <p class="text-xs text-linen/50 mt-4 font-mono">* Ongkos jemput &amp; antar gratis untuk pesanan minimum 3
            kg.</p>
    </div>
</section>

<!-- ============ TESTIMONI ============ -->
<section id="testimoni" class="max-w-6xl mx-auto px-5 md:px-8 py-20 md:py-28">
    <div class="max-w-lg mb-14">
        <p class="font-mono text-xs font-semibold text-soap mb-3">TESTIMONI</p>
        <h2 class="font-display font-700 text-3xl md:text-4xl tracking-tight">Kata mereka yang cuciannya udah beres</h2>
    </div>

    <div class="grid md:grid-cols-3 gap-8 md:gap-6">

        <div class="tag bg-white shadow-md border border-ink/10 p-6 pl-8 -rotate-1" style="--hole:#ffffff">
            <div class="flex gap-1 text-sun mb-3">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
            </div>
            <p class="text-sm text-ink/70 leading-relaxed mb-4">"Anak kos jadi nggak perlu antre di kios laundry lagi.
                Tinggal jadwalin, kurir dateng, beres."</p>
            <p class="text-sm font-display font-600">Dinda R.</p>
            <p class="text-xs text-ink/50">Mahasiswa, Bandung</p>
        </div>

        <div class="tag bg-white shadow-md border border-ink/10 p-6 pl-8 rotate-1 md:mt-6" style="--hole:#ffffff">
            <div class="flex gap-1 text-sun mb-3">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
            </div>
            <p class="text-sm text-ink/70 leading-relaxed mb-4">"Baju kantor disetrika rapi banget, kayak baru dari
                toko. Lacak posisi kurirnya juga enak dipakai."</p>
            <p class="text-sm font-display font-600">Fajar S.</p>
            <p class="text-xs text-ink/50">Karyawan swasta, Jakarta</p>
        </div>

        <div class="tag bg-white shadow-md border border-ink/10 p-6 pl-8 -rotate-1" style="--hole:#ffffff">
            <div class="flex gap-1 text-sun mb-3">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2l3 7 7 .5-5.5 4.8L18 21l-6-4-6 4 1.5-6.7L2 9.5 9 9z"/>
                </svg>
            </div>
            <p class="text-sm text-ink/70 leading-relaxed mb-4">"Sepatu putih anak saya sempat kuning, pas dicuci di
                Cucian.id balik bersih lagi. Harganya juga masuk akal."</p>
            <p class="text-sm font-display font-600">Ibu Sari W.</p>
            <p class="text-xs text-ink/50">Ibu rumah tangga, Surabaya</p>
        </div>

    </div>
</section>

<!-- ============ CTA LOGIN ============ -->
<section id="masuk" class="relative bg-soap text-white overflow-hidden">
    <div class="absolute inset-0 shirt-pattern"></div>
    <div class="relative max-w-6xl mx-auto px-5 md:px-8 py-20 md:py-24 flex flex-col items-center text-center">
        <h2 class="font-display font-700 text-3xl md:text-4xl tracking-tight mb-4 max-w-xl">Cucian pertamamu, gratis
            ongkos jemput</h2>
        <p class="text-white/85 max-w-md mb-8">Masuk ke akun Cucian.id kamu dan jadwalkan jemputan pertama dalam kurang dari
            satu menit.</p>
        <a href="{{ route('login')  }}"
           class="bg-ink text-white text-sm font-semibold px-8 py-3.5 rounded-full hover:bg-white hover:text-ink transition">
            Masuk ke Aplikasi
        </a>
    </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="bg-ink text-linen/70">
    <div class="max-w-6xl mx-auto px-5 md:px-8 py-16 grid sm:grid-cols-2 md:grid-cols-4 gap-10">

        <div>
            <a href="#" class="flex items-center gap-2 font-display font-700 text-xl text-white mb-3">
        <span class="w-8 h-8 rounded-full bg-soap text-white flex items-center justify-center">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
               stroke-linecap="round"><circle cx="12" cy="13" r="7"/><path d="M12 9v4l3 2"/></svg>
        </span>
                Cucian.id
            </a>
            <p class="text-sm leading-relaxed max-w-xs">Layanan laundry kiloan antar-jemput. Timbang, cuci, lipat —
                semua kelar tanpa kamu angkat jemuran.</p>
        </div>

        <div>
            <h4 class="text-white font-display font-600 text-sm mb-4">Layanan</h4>
            <ul class="space-y-2.5 text-sm">
                <li><a href="#layanan" class="hover:text-white">Cuci Kiloan</a></li>
                <li><a href="#layanan" class="hover:text-white">Dry Clean</a></li>
                <li><a href="#layanan" class="hover:text-white">Cuci Sepatu</a></li>
                <li><a href="#layanan" class="hover:text-white">Express 6 Jam</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-white font-display font-600 text-sm mb-4">Perusahaan</h4>
            <ul class="space-y-2.5 text-sm">
                <li><a href="#cara-kerja" class="hover:text-white">Cara Kerja</a></li>
                <li><a href="#harga" class="hover:text-white">Harga</a></li>
                <li><a href="#" class="hover:text-white">Karier</a></li>
                <li><a href="#" class="hover:text-white">Gabung Jadi Kurir</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-white font-display font-600 text-sm mb-4">Kontak</h4>
            <ul class="space-y-2.5 text-sm">
                <li>halo@Cucian.id</li>
                <li>0800-1-KILOAN</li>
                <li>Senin–Minggu, 07.00–21.00</li>
            </ul>
        </div>

    </div>

    <div class="border-t border-white/10">
        <div
            class="max-w-6xl mx-auto px-5 md:px-8 py-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-linen/50">
            <span>&copy; {{ date('Y') }} Cucian.id. Semua hak dilindungi.</span>
            <span class="font-mono">Dibuat oleh barudak LPKIA</span>
        </div>
    </div>
</footer>

<script>
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    menuBtn.addEventListener('click', () => {
        if (mobileMenu.style.maxHeight && mobileMenu.style.maxHeight !== '0px') {
            mobileMenu.style.maxHeight = '0px';
        } else {
            mobileMenu.style.maxHeight = mobileMenu.scrollHeight + 'px';
        }
    });
</script>

</body>
</html>
