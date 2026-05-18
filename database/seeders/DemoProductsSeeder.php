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
                'name' => 'Marketonik Official',
                'email' => 'official@marketonik.local',
                'password' => 'demo',
            ]
        );

        $second = User::firstOrCreate(
            ['username' => 'mitra_elektronik'],
            [
                'name' => 'Mitra Elektronik Nusantara',
                'email' => 'mitra@marketonik.local',
                'password' => 'demo',
            ]
        );

        $templates = [
            ['Smart TV 4K', 'Panel VA, HDR10+, smart OS.', ['Ukuran' => '55 inci', 'Resolusi' => '3840×2160', 'Port' => 'HDMI 3×, USB 2×', 'Refresh' => '60 Hz']],
            ['Soundbar Dolby Atmos', 'Suara mengisi ruangan.', ['Saluran' => '5.1.2', 'Daya' => '420 W', 'Koneksi' => 'eARC, Bluetooth 5.2', 'Subwoofer' => 'Wireless']],
            ['Kulkas Side-by-Side', 'Pendinginan merata inverter.', ['Kapasitas' => '600 L', 'Kelas energi' => 'A++', 'Fitur' => 'No Frost, Smart Cooling', 'Warna' => 'Silver']],
            ['Mesin Cuci Front Load', 'Hemat air & listrik.', ['Kapasitas' => '10 kg', 'Putaran' => '1400 RPM', 'Program' => '14 mode', 'Garansi motor' => '10 tahun']],
            ['AC Split Inverter', 'Dingin cepat, hemat listrik.', ['PK' => '1.5 PK', 'BTU' => '12000', 'Filter' => 'Anti-bakteri', 'Refrigeran' => 'R32']],
            ['Laptop Ultrabook', 'Tipis, ringan, produktif.', ['Prosesor' => 'Intel Core Ultra 7', 'RAM' => '16 GB LPDDR5X', 'SSD' => '512 GB NVMe', 'Layar' => '14" 2.8K OLED']],
            ['Laptop Gaming', 'Performa tinggi pendinginan ganda.', ['Prosesor' => 'AMD Ryzen 9', 'GPU' => 'RTX 4070 8GB', 'RAM' => '32 GB', 'Layar' => '16" 165Hz']],
            ['Tablet Pro', 'Untuk kreator & meeting.', ['Layar' => '12.9" Liquid Retina', 'Chipset' => 'Flagship Octa-core', 'Penyimpanan' => '256 GB', 'Stylus' => 'Kompatibel']],
            ['Smartphone Flagship', 'Kamera malam & charging super.', ['Layar' => '6.7" AMOLED 120Hz', 'Kamera' => '50+48+12 MP', 'Baterai' => '5000 mAh', 'IP' => 'IP68']],
            ['Smartwatch GPS', 'Pelacakan olahraga & kesehatan.', ['Sensor' => 'SpO2, HR, ECG', 'GPS' => 'Dual-band', 'Baterai' => 'hingga 14 hari', 'Air' => '5 ATM']],
            ['Earbuds ANC', 'Peredam bising adaptif.', ['Driver' => '11 mm', 'Codec' => 'LDAC', 'ANC' => 'Hybrid 3-mic', 'Case' => 'Wireless charging']],
            ['Kamera Mirrorless', 'Full-frame untuk kreator.', ['Sensor' => '33 MP full-frame', 'Stabilisasi' => '5-axis IBIS', 'Video' => '4K 60p', 'Mount' => 'E-mount']],
            ['Drone Foldable', 'Stabil & aman untuk pemula.', ['Kamera' => '4K HDR', 'Jangkauan' => '10 km', 'Baterai' => '46 menit', 'Sensor' => 'Omnidirectional']],
            ['Monitor Creator', 'Warna akurat untuk desain.', ['Ukuran' => '27"', 'Panel' => 'IPS Nano', 'Resolusi' => '4K', 'Warna' => '99% AdobeRGB']],
            ['Monitor Gaming', 'Respons cepat.', ['Ukuran' => '27"', 'Refresh' => '240 Hz', 'Respon' => '1 ms GtG', 'HDR' => 'HDR600']],
            ['Keyboard Mekanikal', 'Switch hot-swap.', ['Layout' => 'TKL', 'Switch' => 'Linear factory-lube', 'Koneksi' => '2.4G / BT / USB', 'Keycap' => 'PBT doubleshot']],
            ['Mouse Gaming Wireless', 'Presisi esports.', ['Sensor' => '26K DPI', 'Berat' => '63 g', 'Polling' => '4000 Hz', 'Baterai' => '90 jam']],
            ['Router WiFi 7', 'Jaringan rumah masa depan.', ['Pita' => 'Tri-band', 'Port' => '2.5 G WAN/LAN', 'Antena' => '8 high-gain', 'Mesh' => 'Siap']],
            ['NAS 4-Bay', 'Cadangan & media server.', ['CPU' => 'Quad-core 2.0 GHz', 'RAM' => '4 GB (upgradeable)', 'LAN' => '2.5 GbE', 'Slot' => '4× SATA']],
            ['Power Station', 'Listrik darurat portabel.', ['Kapasitas' => '1024 Wh', 'Output' => '2200 W surge', 'Port' => 'AC×4, USB-C PD 100W', 'Solar' => 'Input MPPT']],
            ['Air Fryer Digital', 'Masak rendah lemak.', ['Kapasitas' => '6 L', 'Suhu' => '40–200°C', 'Program' => '12 preset', 'Keranjang' => 'Anti-lengket']],
            ['Microwave Inverter', 'Panaskan merata.', ['Kapasitas' => '25 L', 'Daya' => '900 W', 'Grill' => '1000 W', 'Panel' => 'Touch']],
            ['Setrika Uap Vertikal', 'Rapikan tanpa meja setrika.', ['Uap' => '35 g/min', 'Tangki' => '2 L', 'Panas' => '30 detik', 'Aksesoris' => 'Sarung pelindung']],
            ['Vacuum Robot', 'Mapping LiDAR.', ['Hisap' => '5500 Pa', 'Mapping' => 'Multi-floor', 'Dock' => 'Auto empty', 'Baterai' => '5200 mAh']],
            ['Printer Ink Tank', 'Biaya cetak rendah.', ['Warna' => '4 warna', 'Kecepatan' => '15 ppm mono', 'Koneksi' => 'WiFi + USB', 'ADF' => '35 lembar']],
            ['Proyektor Mini', 'Bioskop di kamar.', ['Resolusi' => '1080p native', 'Brightness' => '900 ANSI', 'Keystone' => 'Auto', 'OS' => 'Android TV']],
            ['Power Strip Surge', 'Lindungi perangkat mahal.', ['Stopkontak' => '6 + 4 USB', 'Surge' => '3000 J', 'Switch' => 'Individual', 'Kabel' => '2 m']],
            ['UPS Line-Interactive', 'Aman saat mati listrik.', ['VA' => '1500 VA', 'Port' => 'USB monitoring', 'Waktu' => '~10 menit PC', 'Sinewave' => 'Simulated']],
            ['Kipas Angin Tower', 'Hening & hemat.', ['Kecepatan' => '12 level', 'Daya' => '35 W', 'Remote' => 'Ya', 'Oscillasi' => '90°']],
            ['Humidifier Ultrasonik', 'Udara nyaman AC.', ['Kapasitas' => '5 L', 'Output' => '350 ml/jam', 'Aroma' => 'Tray esensial', 'Timer' => '1–12 jam']],
            ['Power Bank 20000mAh', 'Fast charge multi-port.', ['Output' => 'PD 65W', 'Port' => '2C + 2A', 'Bahan' => 'Aluminium', 'Indikator' => 'LED']],
            ['Charger GaN 100W', 'Ringkas untuk laptop+ponsel.', ['Port' => '2C + 1A', 'Protokol' => 'PD3.0, PPS', 'Enkripsi' => 'Multi-proteksi', 'Plug' => 'Foldable']],
            ['SSD NVMe Gen4', 'Upgrade kecepatan sistem.', ['Kapasitas' => '2 TB', 'Baca' => '7400 MB/s', 'Tulis' => '6900 MB/s', 'TBW' => '1200']],
            ['RAM DDR5 Kit', 'Dual channel performa.', ['Kapasitas' => '32 GB (2×16)', 'Kecepatan' => '6000 MT/s', 'Timing' => 'CL30', 'Profil' => 'XMP 3.0']],
            ['GPU Desktop', 'Gaming & render.', ['Model' => 'RTX 4080 SUPER', 'VRAM' => '16 GB GDDR6X', 'TDP' => '320 W', 'Ray Tracing' => 'Gen 3']],
            ['Headset Gaming', 'Surround & mic noise cancel.', ['Driver' => '50 mm', 'Mic' => 'Bidirectional', 'Koneksi' => 'USB + 3.5mm', 'RGB' => 'Sync']],
            ['Webcam 4K', 'Meeting tajam.', ['Resolusi' => '4K30 / 1080p60', 'HDR' => 'Ya', 'Autofocus' => 'PDAF', 'Privasi' => 'Shutter']],
            ['Mic USB Condenser', 'Podcast & streaming.', ['Polar' => 'Kardioid', 'Sample rate' => '96 kHz', 'Latency' => 'Zero-latency monitor', 'Mount' => 'Shock mount']],
            ['Mixer Audio USB', 'Kontrol multi-channel.', ['Channel' => '8 mono + 2 stereo', 'EQ' => '3-band', 'USB' => '24-bit 96k', 'Phantom' => '+48V']],
            ['Speaker Bluetooth Portable', 'Bass dalam ukuran kecil.', ['Driver' => 'Stereo 48 mm', 'Baterai' => '20 jam', 'IP' => 'IP67', 'Party' => 'TWS pair']],
            ['Hi-Fi Amplifier', 'Menggerakkan bookshelf besar.', ['Daya' => '2×120 W @ 8Ω', 'THD' => '<0.02%', 'Input' => 'RCA + BT 5.3', 'Remote' => 'Ya']],
            ['Turntable Vinyl', 'Analog warmth.', ['Drive' => 'Direct', 'Kecepatan' => '33/45 RPM', 'Pre-amp' => 'Built-in', 'Cartridge' => 'MM included']],
            ['Blu-ray Player 4K', 'Film koleksi fisik.', ['HDR' => 'Dolby Vision', 'Audio' => 'Dolby Atmos', 'WiFi' => 'Dual-band', 'HDMI' => '2.1']],
            ['Home Theater AV Receiver', 'Pusat hiburan rumah.', ['Saluran' => '9.2', 'HDMI' => '7 in / 2 out', 'Daya' => '120 W/ch', 'Room' => 'Dirac Live']],
            ['Electric Toothbrush Sonic', 'Kesehatan gigi premium.', ['Getaran' => '62000/min', 'Mode' => '5', 'Baterai' => '30 hari', 'Travel case' => 'Ya']],
            ['Hair Dryer Ion', 'Pengering cepat tanpa panas berlebih.', ['Daya' => '1600 W', 'Suhu' => '4 step', 'Ion' => 'Negatif', 'Nozzle' => 'Magnetic']],
            ['Electric Kettle Smart', 'Suhu presisi untuk kopi.', ['Kapasitas' => '1.7 L', 'Suhu' => '40–100°C', 'App' => 'WiFi', 'Material' => 'Stainless double wall']],
            ['Induction Cooktop', 'Masak aman & cepat.', ['Zona' => '2 flex', 'Daya' => '3500 W', 'Sensor' => 'Pan detector', 'Timer' => '99 menit']],
            ['Rice Cooker Fuzzy', 'Nasi pulen otomatis.', ['Kapasitas' => '1.8 L', 'Program' => '12', 'Timer' => '24 jam', 'Inner pot' => 'Diamond coat']],
            ['Water Purifier RO', 'Air minum langsung.', ['Kapasitas' => '600 GPD', 'UV' => 'Sterilisasi', 'Filter' => '4 tahap', 'Hot' => 'Instant']],
            ['Air Purifier HEPA', 'Ruang hingga 60 m².', ['CADR' => '520 m³/h', 'Filter' => 'H13 HEPA', 'Sensor' => 'PM2.5', 'App' => 'Ya']],
            ['Dehumidifier', 'Basement & musim hujan.', ['Kapasitas' => '20 L/hari', 'Tank' => '4 L', 'Drain' => 'Continuous', 'Mode' => 'Dry/Laundry']],
            ['Electric Scooter', 'Mobilitas perkotaan.', ['Jarak' => '45 km', 'Top speed' => '25 km/h (limit)', 'Motor' => '350 W', 'Rem' => 'Disc + E-ABS']],
            ['E-Bike Commuter', 'Sepeda listrik ringan.', ['Baterai' => '504 Wh', 'Jarak' => '80 km', 'Gigi' => 'Shimano 9-speed', 'Berat' => '18 kg']],
            ['Dashcam 4K', 'Rekam perjalanan jelas.', ['Depan' => '4K', 'Belakang' => '1080p', 'GPS' => 'Built-in', 'Park' => 'Buffered']],
            ['Car Charger 120W', 'Isi cepat di mobil.', ['Port' => '2C + 1A', 'PD' => '100W + 20W', 'Material' => 'Aluminium', 'Proteksi' => 'Multi']],
            ['Bluetooth FM Transmitter', 'Audio mobil tanpa kabel.', ['Codec' => 'aptX HD', 'Mic' => 'Noise cancel', 'QC' => '3.0', 'Display' => 'Color']],
            ['Smart Door Lock', 'Akses tanpa kunci fisik.', ['Metode' => 'PIN, kartu, app', 'Baterai' => '8×AA 12 bulan', 'Alarm' => 'Tamper', 'Backup' => 'Key override']],
            ['IP Camera Outdoor', 'Keamanan rumah 24/7.', ['Resolusi' => '2K', 'Night' => 'Color vision', 'Storage' => 'microSD + cloud', 'AI' => 'Human detect']],
            ['Smart Plug Energy', 'Monitor konsumsi listrik.', ['Max' => '16 A', 'App' => 'Scheduling', 'Voice' => 'Alexa/Google', 'Meter' => 'Real-time']],
            ['Smart Bulb RGB', 'Suasana ruangan.', ['Brightness' => '1100 lm', 'Warna' => '16 juta', 'Matter' => 'Support', 'Lifetime' => '25000 jam']],
            ['Electric Screwdriver Kit', 'Perbaikan rumah ringan.', ['Torsi' => '5 Nm', 'Mata' => '32 pcs', 'Baterai' => '2000 mAh', 'LED' => 'Shadowless']],
            ['Thermal Label Printer', 'Usaha online & logistik.', ['Lebar' => '4 inch', 'Resolusi' => '203 dpi', 'Koneksi' => 'USB + BT', 'Kecepatan' => '150 mm/s']],
            ['Drawing Tablet', 'Desain digital presisi.', ['Area' => '10×6 inci', 'Pressure' => '8192 level', 'Tilt' => '±60°', 'ExpressKeys' => '8']],
            ['Studio Lights LED', 'Lighting konten.', ['CCT' => '2700–6500K', 'CRI' => '96+', 'Daya' => '60 W', 'Mount' => 'Bowens']],
            ['Gimbal Smartphone', 'Video stabil walking.', ['Payload' => '300 g', 'Battery' => '8 jam', 'Axis' => '3-axis', 'Tracking' => 'ActiveTrack']],
            ['Portable SSD 2TB', 'Backup cepat on-the-go.', ['Kecepatan' => '2000 MB/s', 'IP' => 'IP55', 'Enkripsi' => 'AES-256', 'Kabel' => 'USB-C']],
            ['Thunderbolt Dock', 'Satu kabel ke banyak port.', ['TB' => 'Thunderbolt 4', 'Display' => 'Dual 4K', 'LAN' => '2.5 GbE', 'USB' => '5×']],
            ['PCIe Capture Card', 'Streaming game konsol.', ['Input' => '4K60 HDR', 'Passthrough' => '4K60', 'Latency' => 'Ultra-low', 'HDR' => '10-bit']],
            ['Sim Racing Wheel', 'Pengalaman balap rumah.', ['Torque' => '8 Nm', 'Pedal' => 'Load cell', 'Rotation' => '1080°', 'Platform' => 'PC + konsol']],
            ['VR Headset PC', 'Imersi gaming.', ['Resolusi' => 'per-eye 2160×2160', 'Refresh' => '120 Hz', 'FOV' => '114°', 'Tracking' => 'Inside-out']],
            ['Handheld Gaming PC', 'Main di mana saja.', ['APU' => 'Zen4 + RDNA3', 'RAM' => '16 GB', 'SSD' => '512 GB', 'Layar' => '7" 120Hz']],
            ['Mini PC Silent', 'HTPC & server rumah.', ['CPU' => '8-core low power', 'RAM' => '16 GB', 'SSD' => '512 GB', 'Port' => '2.5G LAN']],
            ['Network Switch Managed', 'Rack bisnis kecil.', ['Port' => '24× Gigabit + 4× SFP+', 'PoE' => '370 W budget', 'L3' => 'Lite', 'Noise' => 'Low fan']],
            ['Synology Alternative NAS', 'Penyimpanan pribadi.', ['Bay' => '2-bay', 'CPU' => 'ARM quad', 'RAM' => '2 GB', 'App' => 'Docker ready']],
            ['Electric Height Desk', 'Kerja berdiri sehat.', ['Range' => '60–125 cm', 'Muatan' => '120 kg', 'Memory' => '4 preset', 'Anti-collision' => 'Ya']],
            ['Ergonomic Chair Mesh', 'Duduk nyaman seharian.', ['Lumbar' => 'Adaptif', 'Arm' => '4D', 'Gas lift' => 'Class 4', 'Roda' => 'PU silent']],
            ['Standing Desk Converter', 'Upgrade meja biasa.', ['Luas' => '95×40 cm', 'Tinggi' => '50 cm', 'Muatan' => '15 kg', 'Keyboard tray' => 'Ya']],
            ['USB-C Hub Pro', 'Dongle all-in-one.', ['HDMI' => '4K60', 'USB' => '3×10Gbps', 'SD' => 'UHS-II', 'PD' => 'Pass-through 100W']],
            ['Bluetooth Trackpad', 'Kontrol gestur desktop.', ['Multi-touch' => 'Ya', 'Baterai' => '1 bulan', 'Koneksi' => 'BT 5.0', 'Surface' => 'Glass']],
            ['Wireless Charging Pad', 'Isi malam tanpa kabel.', ['Output' => '15W Qi2', 'Material' => 'Aluminium + kaca', 'Fan' => 'Silent', 'LED' => 'Dim']],
            ['Smart Scale Body', 'Komposisi tubuh lengkap.', ['Metrik' => '13+', 'App' => 'Sync cloud', 'Kapasitas' => '180 kg', 'Akurasi' => '50 g']],
            ['Fitness Ring', 'Pelacak sehat minimalis.', ['Sensor' => 'HR, SpO2, suhu', 'Baterai' => '7 hari', 'Air' => '5 ATM', 'App' => 'iOS/Android']],
            ['Portable Monitor OLED', 'Dual screen di jalan.', ['Ukuran' => '15.6"', 'Resolusi' => '1080p OLED', 'Port' => 'Mini HDMI + USB-C', 'Berat' => '650 g']],
            ['Laser Engraver Mini', 'Personalize barang.', ['Area' => '200×200 mm', 'Laser' => '5W diode', 'Software' => 'LightBurn', 'Safety' => 'Goggles included']],
            ['3D Printer FDM', 'Prototipe cepat.', ['Volume' => '220×220×250 mm', 'Nozzle' => '0.4 mm', 'Bed' => 'PEI magnetic', 'Leveling' => 'Auto']],
            ['Soldering Station Digital', 'Perbaikan elektronik.', ['Suhu' => '90–480°C', 'Daya' => '70 W', 'Tip' => 'T12 compatible', 'ESD' => 'Safe']],
            ['Oscilloscope USB', 'Ukur sinyal portabel.', ['Bandwidth' => '100 MHz', 'Sample' => '1 GSa/s', 'Channel' => '2', 'Software' => 'PC']],
            ['Bench Power Supply', 'Uji rangkaian aman.', ['Output' => '0–30 V / 0–10 A', 'Presisi' => '10 mV / 10 mA', 'Proteksi' => 'OVP/OCP', 'Serial' => 'USB']],
            ['Component Storage Cabinet', 'Organizer resistor & IC.', ['Laci' => '64 small', 'Label' => 'Sticker set', 'Material' => 'Anti-statis ABS', 'Kunci' => 'Ya']],
            ['ESD Mat Kit', 'Meja servis aman.', ['Ukuran' => '60×30 cm', 'Ground' => 'Cord + plug', 'Wrist' => 'Strap included', 'Resistansi' => '10^6–10^9']],
            ['Thermal Paste Premium', 'Pendinginan CPU/GPU.', ['Konduktivitas' => '12.5 W/mK', 'Volume' => '4 g', 'Electric' => 'Non-conductive', 'Aplikator' => 'Spatula']],
            ['Cable Management Box', 'Rapikan charger & kabel.', ['Ukuran' => 'Large', 'Material' => 'ABS fire-retardant', 'Vent' => 'Slot udara', 'Lid' => 'Magnetic']],
            ['Laptop Cooling Pad', 'Turunkan suhu gaming.', ['Fan' => '6× turbo', 'Kecepatan' => 'Adj', 'Sudut' => '6 level', 'USB hub' => '2 port']],
            ['RGB Light Strip 5m', 'Ambient gaming room.', ['LED' => 'Addressable', 'App' => 'Music sync', 'Adhesive' => '3M VHB', 'Power' => '24V adapter']],
            ['Smart Thermostat', 'Hemat AC otomatis.', ['Sensor' => 'Humidity', 'Schedule' => '7 hari', 'Geofencing' => 'Ya', 'Voice' => 'Google/Alexa']],
            ['Robot Window Cleaner', 'Kaca gedung & rumah.', ['AI' => 'Edge detect', 'Cable' => 'Safety rope', 'Remote' => 'Ya', 'Pad' => 'Microfiber washable']],
            ['Portable Air Conditioner', 'Pendingin ruangan fleksibel.', ['BTU' => '9000', 'Exhaust' => 'Window kit', 'Dehumidifier' => 'Ya', 'Remote' => 'LCD']],
            ['Mini Fridge Skincare', 'Kosmetik dingin.', ['Kapasitas' => '10 L', 'Suhu' => '3–15°C', 'Noise' => '28 dB', 'Rak' => 'Adjustable']],
            ['Wine Cooler Dual Zone', 'Penyimpanan koleksi.', ['Botol' => '46', 'Zona' => '5–12°C / 12–18°C', 'Glas' => 'UV protected', 'Vibration' => 'Low']],
            ['Espresso Machine Semi-Auto', 'Kafe di rumah.', ['Tekanan' => '15 bar', 'Boiler' => 'Dual thermocoil', 'Steam wand' => 'Pro', 'Portafilter' => '58 mm']],
            ['Bean Roaster Home', 'Sangrai kopi segar.', ['Kapasitas' => '800 g', 'Profil' => '9 kurva', 'Chaff' => 'Collector', 'Cooling' => 'Forced']],
            ['Sous Vide Precision', 'Masak suhu pasti.', ['Presisi' => '±0.1°C', 'Daya' => '1100 W', 'App' => 'Resep', 'Clip' => 'Adjustable']],
            ['Bread Maker Pro', 'Roti otomatis overnight.', ['Program' => '19', 'Timer' => '15 jam', 'Dispenser' => 'Kacang/kismis', 'Crust' => '3 level']],
            ['Ice Maker Countertop', 'Es batu cepat pesta.', ['Kapasitas' => '12 kg/24 jam', 'Wadah' => '2 L', 'Self-clean' => 'Ya', 'Bullet ice' => '9 pcs/6 menit']],
            ['Water Flosser Cordless', 'Higiene mulut.', ['Tekanan' => '10 level', 'Tank' => '300 ml', 'Tips' => '4 included', 'Travel' => 'Pouch']],
            ['Massage Gun Pro', 'Recovery otot.', ['Kecepatan' => '3200 rpm', 'Amplitudo' => '12 mm', 'Baterai' => '6 jam', 'Head' => '6 attachments']],
            ['Heated Blanket Electric', 'Tidur nyaman dingin.', ['Ukuran' => '180×150 cm', 'Level' => '10', 'Timer' => '12 jam', 'Wash' => 'Machine safe']],
            ['Electric Blanket Throw', 'Selimut hangat sofa.', ['Material' => 'Flannel + sherpa', 'Auto-off' => '10 jam', 'Cert' => 'Overheat protect', 'Wash' => 'Ya']],
            ['Ceramic Heater Oscillating', 'Penghangat ruangan cepat.', ['Daya' => '2000 W', 'Remote' => 'Ya', 'Tip-over' => 'Cutoff', 'Filter' => 'Dust washable']],
            ['Oil Radiator 11 Fins', 'Panas merata aman anak.', ['Daya' => '2500 W', 'Roda' => '360°', 'Timer' => '24 jam', 'Cord' => 'Store']],
            ['Steam Iron Station', 'Setrika profesional.', ['Tekanan uap' => '6 bar', 'Tank' => '1.8 L', 'Auto-off' => '8 menit', 'Soleplate' => 'Ceramic']],
            ['Garment Steamer Upright', 'Rapikan jas tanpa setrika.', ['Uap' => '35 g/min', 'Tangki' => '2.5 L', 'Hanger' => 'Built-in', 'Pole' => 'Telescopic']],
            ['Robot Lawn Mower', 'Rumput rapi otomatis.', ['Area' => 'hingga 1000 m²', 'Boundary' => 'Wire / RTK', 'Slope' => '35%', 'Rain' => 'Sensor']],
            ['Electric Pressure Washer', 'Cuci mobil & teras.', ['PSI' => '2000', 'Flow' => '6.5 L/min', 'Nozzle' => '5 quick', 'Foam' => 'Canon included']],
            ['Cordless Leaf Blower', 'Kebun bersih cepat.', ['Kecepatan udara' => '120 mph', 'Baterai' => '5 Ah', 'Turbo' => 'Mode', 'Weight' => '2.1 kg']],
            ['Chainsaw Battery', 'Potong kayu ringan.', ['Bar' => '14 inch', 'Chain speed' => '20 m/s', 'Oil' => 'Auto lube', 'Brake' => 'Chain instant']],
            ['Electric Bike Conversion Kit', 'Ubah sepeda biasa.', ['Motor' => '250 W hub', 'Baterai' => '36V 10Ah', 'Display' => 'LCD', 'Sensor' => 'Cadence']],
            ['Solar Panel Portable', 'Charging outdoor.', ['Watt' => '200 W foldable', 'Output' => 'USB-C PD 45W', 'MC4' => 'Adapter', 'IP' => 'IP65']],
            ['Power Inverter Car', 'AC dari aki mobil.', ['Output' => '1000 W pure sine', 'Port' => '2 AC + USB', 'Fan' => 'Temp controlled', 'Alarm' => 'Low voltage']],
            ['Jump Starter Battery', 'Starter mobil & powerbank.', ['Peak' => '2000 A', 'USB' => 'QC3.0', 'Light' => 'LED SOS', 'Safety' => 'Reverse protect']],
            ['Tire Inflator Digital', 'Pompa ban portabel.', ['Tekanan' => '150 PSI', 'Preset' => 'Mobil/motor/sepeda', 'LED' => 'Lamp', 'Cable' => '12V']],
            ['Car Vacuum Cordless', 'Interior bersih.', ['Hisap' => '15 kPa', 'Baterai' => '30 menit', 'HEPA' => 'Filter washable', 'Aksesoris' => 'Crevice tool']],
            ['OBD2 Scanner Bluetooth', 'Diagnosis mobil.', ['Protokol' => 'Semua mayor', 'App' => 'iOS/Android', 'Clear' => 'DTC', 'Live data' => 'Ya']],
            ['TPMS Tire Sensors', 'Tekanan ban real-time.', ['Sensor' => '4× external', 'Display' => 'Solar LCD', 'Alarm' => 'High/low', 'Install' => '5 menit']],
            ['Backup Camera Wireless', 'Parkir aman.', ['Resolusi' => '720p', 'Night' => 'IR', 'Latency' => '<100 ms', 'Guide' => 'Dynamic']],
            ['HUD Speed Projector', 'Kecepatan di kaca depan.', ['GPS' => '10 Hz', 'Display' => 'Color', 'Auto dim' => 'Ya', 'Plug' => 'OBD optional']],
            ['Electric Bike Battery Pack', 'Cadangan perjalanan.', ['Volt' => '48 V', 'Ah' => '17.5', 'Cells' => '21700 Samsung', 'BMS' => 'Smart']],
            ['E-Scooter Spare Tire Solid', 'Anti bocor.', ['Ukuran' => '10 inch', 'Compound' => 'Honeycomb', 'Weight' => '1.2 kg', 'Mount' => 'Split rim']],
            ['GPS Pet Tracker', 'Hewan tidak tersesat.', ['Jangkauan' => 'Unlimited LTE', 'Baterai' => '7 hari', 'Geo-fence' => 'Ya', 'Water' => 'IPX7']],
            ['Smart Feeder Pet', 'Makan terjadwal.', ['Kapasitas' => '6 L', 'Portion' => '1–20', 'Camera' => '1080p', 'Voice' => '2-way']],
            ['Aquarium Heater Digital', 'Ikan tropis stabil.', ['Watt' => '300 W', 'Range' => '16–34°C', 'Sensor' => 'Dual', 'Shatter' => 'Quartz tube']],
            ['Auto Fish Feeder', 'Liburan tenang.', ['Kapasitas' => '200 ml', 'Jadwal' => '4x/hari', 'Baterai' => 'AA×2 3 bulan', 'Mount' => 'Clamp']],
            ['LED Grow Light Full Spectrum', 'Tanaman indoor.', ['PPFD' => 'High', 'Daisy' => 'Chain', 'Timer' => 'Built-in', 'Heat' => 'Passive sink']],
            ['Hydroponic Tower Indoor', 'Sayur di apartemen.', ['Tingkat' => '30 lubang', 'Pompa' => 'Quiet', 'Timer' => 'Nutrient cycle', 'Lamp' => 'Included']],
        ];

        $imageUrls = require __DIR__.'/image_urls.php';

        $cities = ['Jakarta Selatan', 'Jakarta Barat', 'Bandung', 'Surabaya', 'Yogyakarta', 'Medan', 'Semarang', 'Denpasar', 'Makassar', 'Palembang', 'Malang', 'Batam'];

        foreach (array_values($templates) as $index => $tpl) {
            $idx = $index + 1;
            [$titleBase, $descBase, $specs] = $tpl;
            $sellerId = $idx % 5 === 0 ? $second->id : $seller->id;
            $city = $cities[$idx % count($cities)];
            $discount = [0, 5, 8, 10, 12, 15, 18, 20, 25][$idx % 9];
            $price = 299000 + ($idx * 137000) % 42000000;
            $stock = 3 + ($idx % 18);

            $title = $titleBase.' Seri '.chr(64 + (($idx - 1) % 26) + 1);

            ProductModel::create([
                'user_id' => $sellerId,
                'title' => $title,
                'slug' => ProductModel::uniqueSlug($sellerId, $title),
                'description' => $descBase.' Unit #'.$idx.' — kondisi baru segel distributor, siap kirim dari '.$city.'.',
                'seller_location' => $city.', Indonesia',
                'specifications' => $specs + ['SKU' => 'MN-'.str_pad((string) $idx, 4, '0', STR_PAD_LEFT), 'Garansi resmi' => ($idx % 2 === 0 ? '1 tahun' : '2 tahun')],
                'price' => $price,
                'discount_percent' => $discount,
                'stock' => $stock,
                'image_url' => $imageUrls[$index % count($imageUrls)],
                'is_active' => true,
            ]);
        }
    }
}
