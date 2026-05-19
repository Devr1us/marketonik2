<?php

namespace Database\Seeders;

use App\Models\Product as ProductModel;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoProductsSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::firstOrCreate(
            ['username' => 'toko_resmi'],
            [
                'name'     => 'Marketonik Official',
                'email'    => 'official@marketonik.local',
                'password' => 'demo123',
                'role'     => User::ROLE_PEMBELI,
            ]
        );

        $second = User::firstOrCreate(
            ['username' => 'mitra_elektronik'],
            [
                'name'     => 'Mitra Elektronik Nusantara',
                'email'    => 'mitra@marketonik.local',
                'password' => 'demo123',
                'role'     => User::ROLE_PEMBELI,
            ]
        );

        // Format: [title, category, description, specs]
        $templates = [
            ['Smart TV 4K', 'TV & Monitor', 'Panel VA, HDR10+, smart OS.', ['Ukuran' => '55 inci', 'Resolusi' => '3840×2160', 'Port' => 'HDMI 3×, USB 2×', 'Refresh' => '60 Hz']],
            ['Soundbar Dolby Atmos', 'Audio & Headphone', 'Suara mengisi ruangan.', ['Saluran' => '5.1.2', 'Daya' => '420 W', 'Koneksi' => 'eARC, Bluetooth 5.2', 'Subwoofer' => 'Wireless']],
            ['Laptop Ultrabook', 'Laptop & Komputer', 'Tipis, ringan, produktif.', ['Prosesor' => 'Intel Core Ultra 7', 'RAM' => '16 GB LPDDR5X', 'SSD' => '512 GB NVMe', 'Layar' => '14" 2.8K OLED']],
            ['Laptop Gaming', 'Laptop & Komputer', 'Performa tinggi pendinginan ganda.', ['Prosesor' => 'AMD Ryzen 9', 'GPU' => 'RTX 4070 8GB', 'RAM' => '32 GB', 'Layar' => '16" 165Hz']],
            ['Smartphone Flagship', 'Smartphone', 'Kamera malam & charging super.', ['Layar' => '6.7" AMOLED 120Hz', 'Kamera' => '50+48+12 MP', 'Baterai' => '5000 mAh', 'IP' => 'IP68']],
            ['Smartphone Mid-Range', 'Smartphone', 'Performa harian terbaik.', ['Layar' => '6.5" IPS 90Hz', 'Kamera' => '64+8+2 MP', 'Baterai' => '5000 mAh', 'Chipset' => 'Octa-core']],
            ['Earbuds ANC', 'Audio & Headphone', 'Peredam bising adaptif.', ['Driver' => '11 mm', 'Codec' => 'LDAC', 'ANC' => 'Hybrid 3-mic', 'Case' => 'Wireless charging']],
            ['Headset Gaming', 'Gaming', 'Surround & mic noise cancel.', ['Driver' => '50 mm', 'Mic' => 'Bidirectional', 'Koneksi' => 'USB + 3.5mm', 'RGB' => 'Sync']],
            ['Kamera Mirrorless', 'Kamera & Foto', 'Full-frame untuk kreator.', ['Sensor' => '33 MP full-frame', 'Stabilisasi' => '5-axis IBIS', 'Video' => '4K 60p', 'Mount' => 'E-mount']],
            ['Monitor Gaming', 'TV & Monitor', 'Respons cepat.', ['Ukuran' => '27"', 'Refresh' => '240 Hz', 'Respon' => '1 ms GtG', 'HDR' => 'HDR600']],
            ['Keyboard Mekanikal', 'Gaming', 'Switch hot-swap.', ['Layout' => 'TKL', 'Switch' => 'Linear factory-lube', 'Koneksi' => '2.4G / BT / USB', 'Keycap' => 'PBT doubleshot']],
            ['Mouse Gaming Wireless', 'Gaming', 'Presisi esports.', ['Sensor' => '26K DPI', 'Berat' => '63 g', 'Polling' => '4000 Hz', 'Baterai' => '90 jam']],
            ['Tablet Pro', 'Laptop & Komputer', 'Untuk kreator & meeting.', ['Layar' => '12.9" Liquid Retina', 'Chipset' => 'Flagship Octa-core', 'Penyimpanan' => '256 GB', 'Stylus' => 'Kompatibel']],
            ['Smartwatch GPS', 'Aksesoris', 'Pelacakan olahraga & kesehatan.', ['Sensor' => 'SpO2, HR, ECG', 'GPS' => 'Dual-band', 'Baterai' => 'hingga 14 hari', 'Air' => '5 ATM']],
            ['Router WiFi 7', 'Aksesoris', 'Jaringan rumah masa depan.', ['Pita' => 'Tri-band', 'Port' => '2.5 G WAN/LAN', 'Antena' => '8 high-gain', 'Mesh' => 'Siap']],
            ['SSD NVMe Gen4', 'Laptop & Komputer', 'Upgrade kecepatan sistem.', ['Kapasitas' => '2 TB', 'Baca' => '7400 MB/s', 'Tulis' => '6900 MB/s', 'TBW' => '1200']],
            ['RAM DDR5 Kit', 'Laptop & Komputer', 'Dual channel performa.', ['Kapasitas' => '32 GB (2×16)', 'Kecepatan' => '6000 MT/s', 'Timing' => 'CL30', 'Profil' => 'XMP 3.0']],
            ['GPU Desktop', 'Laptop & Komputer', 'Gaming & render.', ['Model' => 'RTX 4080 SUPER', 'VRAM' => '16 GB GDDR6X', 'TDP' => '320 W', 'Ray Tracing' => 'Gen 3']],
            ['Drone Foldable', 'Kamera & Foto', 'Stabil & aman untuk pemula.', ['Kamera' => '4K HDR', 'Jangkauan' => '10 km', 'Baterai' => '46 menit', 'Sensor' => 'Omnidirectional']],
            ['Monitor Creator', 'TV & Monitor', 'Warna akurat untuk desain.', ['Ukuran' => '27"', 'Panel' => 'IPS Nano', 'Resolusi' => '4K', 'Warna' => '99% AdobeRGB']],
            ['Speaker Bluetooth Portable', 'Audio & Headphone', 'Bass dalam ukuran kecil.', ['Driver' => 'Stereo 48 mm', 'Baterai' => '20 jam', 'IP' => 'IP67', 'Party' => 'TWS pair']],
            ['Hi-Fi Amplifier', 'Audio & Headphone', 'Menggerakkan bookshelf besar.', ['Daya' => '2×120 W @ 8Ω', 'THD' => '<0.02%', 'Input' => 'RCA + BT 5.3', 'Remote' => 'Ya']],
            ['Power Bank 20000mAh', 'Aksesoris', 'Fast charge multi-port.', ['Output' => 'PD 65W', 'Port' => '2C + 2A', 'Bahan' => 'Aluminium', 'Indikator' => 'LED']],
            ['Charger GaN 100W', 'Aksesoris', 'Ringkas untuk laptop+ponsel.', ['Port' => '2C + 1A', 'Protokol' => 'PD3.0, PPS', 'Enkripsi' => 'Multi-proteksi', 'Plug' => 'Foldable']],
            ['Webcam 4K', 'Aksesoris', 'Meeting tajam.', ['Resolusi' => '4K30 / 1080p60', 'HDR' => 'Ya', 'Autofocus' => 'PDAF', 'Privasi' => 'Shutter']],
            ['Mic USB Condenser', 'Audio & Headphone', 'Podcast & streaming.', ['Polar' => 'Kardioid', 'Sample rate' => '96 kHz', 'Latency' => 'Zero-latency monitor', 'Mount' => 'Shock mount']],
            ['Portable SSD 2TB', 'Aksesoris', 'Backup cepat on-the-go.', ['Kecepatan' => '2000 MB/s', 'IP' => 'IP55', 'Enkripsi' => 'AES-256', 'Kabel' => 'USB-C']],
            ['USB-C Hub Pro', 'Aksesoris', 'Dongle all-in-one.', ['HDMI' => '4K60', 'USB' => '3×10Gbps', 'SD' => 'UHS-II', 'PD' => 'Pass-through 100W']],
            ['Handheld Gaming PC', 'Gaming', 'Main di mana saja.', ['APU' => 'Zen4 + RDNA3', 'RAM' => '16 GB', 'SSD' => '512 GB', 'Layar' => '7" 120Hz']],
            ['VR Headset PC', 'Gaming', 'Imersi gaming.', ['Resolusi' => 'per-eye 2160×2160', 'Refresh' => '120 Hz', 'FOV' => '114°', 'Tracking' => 'Inside-out']],
            ['Drawing Tablet', 'Aksesoris', 'Desain digital presisi.', ['Area' => '10×6 inci', 'Pressure' => '8192 level', 'Tilt' => '±60°', 'ExpressKeys' => '8']],
            ['Gimbal Smartphone', 'Kamera & Foto', 'Video stabil walking.', ['Payload' => '300 g', 'Battery' => '8 jam', 'Axis' => '3-axis', 'Tracking' => 'ActiveTrack']],
            ['Portable Monitor OLED', 'TV & Monitor', 'Dual screen di jalan.', ['Ukuran' => '15.6"', 'Resolusi' => '1080p OLED', 'Port' => 'Mini HDMI + USB-C', 'Berat' => '650 g']],
            ['Smart Door Lock', 'Lainnya', 'Akses tanpa kunci fisik.', ['Metode' => 'PIN, kartu, app', 'Baterai' => '8×AA 12 bulan', 'Alarm' => 'Tamper', 'Backup' => 'Key override']],
            ['IP Camera Outdoor', 'Lainnya', 'Keamanan rumah 24/7.', ['Resolusi' => '2K', 'Night' => 'Color vision', 'Storage' => 'microSD + cloud', 'AI' => 'Human detect']],
            ['Smart Plug Energy', 'Lainnya', 'Monitor konsumsi listrik.', ['Max' => '16 A', 'App' => 'Scheduling', 'Voice' => 'Alexa/Google', 'Meter' => 'Real-time']],
            ['Proyektor Mini', 'TV & Monitor', 'Bioskop di kamar.', ['Resolusi' => '1080p native', 'Brightness' => '900 ANSI', 'Keystone' => 'Auto', 'OS' => 'Android TV']],
            ['Thunderbolt Dock', 'Aksesoris', 'Satu kabel ke banyak port.', ['TB' => 'Thunderbolt 4', 'Display' => 'Dual 4K', 'LAN' => '2.5 GbE', 'USB' => '5×']],
            ['PCIe Capture Card', 'Gaming', 'Streaming game konsol.', ['Input' => '4K60 HDR', 'Passthrough' => '4K60', 'Latency' => 'Ultra-low', 'HDR' => '10-bit']],
            ['Sim Racing Wheel', 'Gaming', 'Pengalaman balap rumah.', ['Torque' => '8 Nm', 'Pedal' => 'Load cell', 'Rotation' => '1080°', 'Platform' => 'PC + konsol']],
            ['Mini PC Silent', 'Laptop & Komputer', 'HTPC & server rumah.', ['CPU' => '8-core low power', 'RAM' => '16 GB', 'SSD' => '512 GB', 'Port' => '2.5G LAN']],
            ['Wireless Charging Pad', 'Aksesoris', 'Isi malam tanpa kabel.', ['Output' => '15W Qi2', 'Material' => 'Aluminium + kaca', 'Fan' => 'Silent', 'LED' => 'Dim']],
            ['Fitness Ring', 'Aksesoris', 'Pelacak sehat minimalis.', ['Sensor' => 'HR, SpO2, suhu', 'Baterai' => '7 hari', 'Air' => '5 ATM', 'App' => 'iOS/Android']],
            ['Studio Lights LED', 'Kamera & Foto', 'Lighting konten.', ['CCT' => '2700–6500K', 'CRI' => '96+', 'Daya' => '60 W', 'Mount' => 'Bowens']],
            ['Mixer Audio USB', 'Audio & Headphone', 'Kontrol multi-channel.', ['Channel' => '8 mono + 2 stereo', 'EQ' => '3-band', 'USB' => '24-bit 96k', 'Phantom' => '+48V']],
            ['Turntable Vinyl', 'Audio & Headphone', 'Analog warmth.', ['Drive' => 'Direct', 'Kecepatan' => '33/45 RPM', 'Pre-amp' => 'Built-in', 'Cartridge' => 'MM included']],
            ['Blu-ray Player 4K', 'TV & Monitor', 'Film koleksi fisik.', ['HDR' => 'Dolby Vision', 'Audio' => 'Dolby Atmos', 'WiFi' => 'Dual-band', 'HDMI' => '2.1']],
            ['Home Theater AV Receiver', 'Audio & Headphone', 'Pusat hiburan rumah.', ['Saluran' => '9.2', 'HDMI' => '7 in / 2 out', 'Daya' => '120 W/ch', 'Room' => 'Dirac Live']],
            ['Massage Gun Pro', 'Lainnya', 'Recovery otot.', ['Kecepatan' => '3200 rpm', 'Amplitudo' => '12 mm', 'Baterai' => '6 jam', 'Head' => '6 attachments']],
            ['Smart Scale Body', 'Lainnya', 'Komposisi tubuh lengkap.', ['Metrik' => '13+', 'App' => 'Sync cloud', 'Kapasitas' => '180 kg', 'Akurasi' => '50 g']],
        ];

        $imageUrls = require __DIR__.'/image_urls.php';

        $cities = ['Jakarta Selatan', 'Jakarta Barat', 'Bandung', 'Surabaya', 'Yogyakarta', 'Medan', 'Semarang', 'Denpasar', 'Makassar', 'Palembang', 'Malang', 'Batam'];

        foreach (array_values($templates) as $index => $tpl) {
            $idx      = $index + 1;
            [$titleBase, $category, $descBase, $specs] = $tpl;
            $sellerId = $idx % 5 === 0 ? $second->id : $seller->id;
            $city     = $cities[$idx % count($cities)];
            $discount = [0, 5, 8, 10, 12, 15, 18, 20, 25][$idx % 9];
            $price    = 299000 + ($idx * 137000) % 42000000;
            $stock    = 3 + ($idx % 18);

            $title = $titleBase.' Seri '.chr(64 + (($idx - 1) % 26) + 1);

            ProductModel::create([
                'user_id'          => $sellerId,
                'title'            => $title,
                'category'         => $category,
                'slug'             => ProductModel::uniqueSlug($sellerId, $title),
                'description'      => $descBase.' Unit #'.$idx.' — kondisi baru segel distributor, siap kirim dari '.$city.'.',
                'seller_location'  => $city.', Indonesia',
                'specifications'   => $specs + ['SKU' => 'MN-'.str_pad((string) $idx, 4, '0', STR_PAD_LEFT), 'Garansi resmi' => ($idx % 2 === 0 ? '1 tahun' : '2 tahun')],
                'price'            => $price,
                'discount_percent' => $discount,
                'stock'            => $stock,
                'image_url'        => $imageUrls[$index % count($imageUrls)],
                'is_active'        => true,
            ]);
        }
    }
}
