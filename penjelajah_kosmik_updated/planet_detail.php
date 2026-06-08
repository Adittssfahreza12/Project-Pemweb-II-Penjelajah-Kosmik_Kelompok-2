<?php
include 'config.php';
$planets = [
    'matahari' => [
        'nama' => 'Matahari',
        'gambar' => 'assets/matahari.png',
        'deskripsi' => 'Matahari adalah bintang di pusat Tata Surya. Ia merupakan bola plasma panas sempurna yang membangkitkan energi melalui reaksi fusi nuklir di intinya, memancarkan energi tersebut sebagian besar sebagai cahaya kasat mata, infra merah, dan radiasi ultraviolet yang menjadi sumber energi utama bagi Bumi.',
        'data' => [
            'Diameter' => '1.392.700 km',
            'Suhu Inti' => 'Sekitar 15.000.000 °C',
            'Suhu Permukaan' => 'Sekitar 5.500 °C',
            'Massa' => '333.000 kali massa Bumi',
            'Tipe Bintang' => 'Katai Kuning (G2V)',
            'Gravitasi Permukaan' => '274 m/s² (28 kali bumi)'
        ],
        'funfact' => 'Matahari mencakup sekitar 99.86% dari total massa seluruh Tata Surya kita! Cahaya dari Matahari membutuhkan waktu sekitar 8 menit dan 20 detik untuk menempuh jarak ruang hampa hingga sampai ke permukaan Bumi.'
    ],
    'merkurius' => [
        'nama' => 'Merkurius',
        'gambar' => 'assets/merkurius.png',
        'deskripsi' => 'Planet terkecil di Tata Surya dan yang paling dekat dengan Matahari. Karena jaraknya yang sangat dekat, planet ini mengalami fluktuasi suhu yang paling ekstrem di antara planet lainnya, ditambah dengan atmosfer tipis (eksosfer) yang tidak mampu menahan panas.',
        'data' => [
            'Diameter' => '4.879 km',
            'Suhu' => '-173 °C (malam) hingga 427 °C (siang)',
            'Periode Rotasi' => '59 hari Bumi',
            'Periode Revolusi' => '88 hari Bumi',
            'Jumlah Satelit' => '0 (Tidak ada)',
            'Gravitasi Permukaan' => '3,7 m/s² (0,38 kali bumi)'
        ],
        'funfact' => 'Meskipun merupakan planet terdekat dari Matahari, Merkurius bukanlah planet terpanas di Tata Surya kita. Gelar planet terpanas justru dipegang oleh Venus karena atmosfernya yang super padat.'
    ],
    'venus' => [
        'nama' => 'Venus',
        'gambar' => 'assets/venus.png',
        'deskripsi' => 'Planet kedua dari Matahari ini sering disebut sebagai kembaran Bumi karena ukuran dan massanya yang mirip. Namun, Venus memiliki atmosfer super tebal yang didominasi karbon dioksida, menciptakan efek rumah kaca tak terkendali yang menjadikannya planet terpanas.',
        'data' => [
            'Diameter' => '12.104 km',
            'Suhu' => 'Rata-rata 464 °C (Konstan siang & malam)',
            'Periode Rotasi' => '243 hari Bumi',
            'Periode Revolusi' => '225 hari Bumi',
            'Jumlah Satelit' => '0 (Tidak ada)',
            'Gravitasi Permukaan' => '8,87 m/s² (0,90 kali bumi)'
        ],
        'funfact' => 'Venus berotasi secara retrograde, artinya ia berputar searah jarum jam (berlawanan arah dari Bumi dan mayoritas planet lain). Akibatnya, di Venus, Matahari terbit dari barat dan terbenam di timur!'
    ],
    'bumi' => [
        'nama' => 'Bumi',
        'gambar' => 'assets/bumi.png',
        'deskripsi' => 'Tempat tinggal kita, planet ketiga dari Matahari, dan sejauh ini menjadi satu-satunya objek astronomi yang diketahui menampung kehidupan. Bumi memiliki atmosfer yang kaya oksigen, medan magnet kuat pelindung radiasi, serta air cair di permukaannya.',
        'data' => [
            'Diameter' => '12.742 km',
            'Suhu' => '-89 °C hingga 58 °C (Rata-rata 15 °C)',
            'Periode Rotasi' => '23 jam 56 menit (1 Hari)',
            'Periode Revolusi' => '365,25 hari (1 Tahun)',
            'Jumlah Satelit' => '1 (Bulan / Luna)',
            'Gravitasi Permukaan' => '9,807 m/s² (1G)'
        ],
        'funfact' => 'Sekitar 71% permukaan Bumi tertutup oleh lautan luas, sementara sisa 29% berupa daratan kepulauan dan benua. Bumi juga merupakan satu-satunya planet di tata surya yang tidak dinamai berdasarkan mitologi Yunani-Romawi.'
    ],
    'mars' => [
        'nama' => 'Mars',
        'gambar' => 'assets/mars.png',
        'deskripsi' => 'Mars adalah planet keempat dari Matahari dan dikenal sebagai "Planet Merah" karena permukaannya yang kaya akan besi oksida (karatan). Planet gurun yang dingin ini memiliki atmosfer tipis, ngarai raksasa (Valles Marineris), dan gunung berapi tertinggi di Tata Surya.',
        'data' => [
            'Diameter' => '6.779 km',
            'Suhu' => 'Rata-rata -65 °C (bervariasi dari -87 °C sampai -5 °C)',
            'Periode Rotasi' => '24 jam 37 menit',
            'Periode Revolusi' => '687 hari Bumi',
            'Jumlah Satelit' => '2 (Phobos dan Deimos)',
            'Gravitasi Permukaan' => '3.721 m/s² (0,38 kali bumi)'
        ],
        'funfact' => 'Mars adalah rumah bagi Olympus Mons, sebuah gunung berapi perisai raksasa yang tingginya mencapai 22 km. Ukuran gunung ini tiga kali lipat lebih tinggi daripada Gunung Everest di Bumi!'
    ],
    'jupiter' => [
        'nama' => 'Jupiter',
        'gambar' => 'assets/jupiter.png',
        'deskripsi' => 'Planet kelima dan merupakan planet terbesar di Tata Surya kita. Sebagai raksasa gas, Jupiter tidak memiliki permukaan padat yang jelas dan sebagian besar tersusun atas hidrogen serta helium. Planet ini memancarkan medan magnet yang sangat kuat dan berbahaya.',
        'data' => [
            'Diameter' => '139.820 km',
            'Suhu' => 'Rata-rata -108 °C di atmosfer atas',
            'Periode Rotasi' => '9 jam 55 menit (Rotasi tercepat)',
            'Periode Revolusi' => '11,8 tahun Bumi',
            'Jumlah Satelit' => '95 (Termasuk Ganymede & Europa)',
            'Gravitasi Permukaan' => '24,79 m/s² (2,5 kali bumi)'
        ],
        'funfact' => 'Jupiter memiliki fitur ikonik bernama "Bintik Merah Raksasa" (Great Red Spot), yang sebenarnya merupakan badai berputar raksasa yang ukurannya lebih besar dari Bumi dan telah berkecamuk setidaknya selama 300 tahun.'
    ],
    'saturnus' => [
        'nama' => 'Saturnus',
        'gambar' => 'assets/saturnus.png',
        'deskripsi' => 'Planet keenam dari Matahari dan raksasa gas terbesar kedua. Saturnus sangat terkenal karena sistem cincinnya yang sangat masif, kompleks, dan indah. Cincin ini membentang ribuan kilometer tetapi ketebalannya rata-rata hanya sekitar 10 meter.',
        'data' => [
            'Diameter' => '116.460 km',
            'Suhu' => 'Rata-rata -139 °C',
            'Periode Rotasi' => '10 jam 33 menit',
            'Periode Revolusi' => '29,4 tahun Bumi',
            'Jumlah Satelit' => '146 (Satelit terbanyak, contoh: Titan)',
            'Gravitasi Permukaan' => '10,44 m/s² (1,06 kali bumi)'
        ],
        'funfact' => 'Saturnus adalah planet dengan massa jenis paling rendah di Tata Surya. Kerapatannya bahkan lebih kecil daripada air, artinya jika kamu punya wadah air yang cukup besar, Saturnus bisa mengapung di atasnya!'
    ],
    'uranus' => [
        'nama' => 'Uranus',
        'gambar' => 'assets/uranus.png',
        'deskripsi' => 'Planet ketujuh dari Matahari yang diklasifikasikan sebagai raksasa es. Uranus memiliki atmosfer yang kaya akan metana, air, amonia, dan hidrogen sulfida, memberikan warna biru muda kehijauan yang khas. Planet ini juga memiliki sistem cincin tipis yang redup.',
        'data' => [
            'Diameter' => '50.724 km',
            'Suhu' => 'Rata-rata -197 °C (Planet dengan rekor terdingin)',
            'Periode Rotasi' => '17 jam 14 menit (Mundur/Retrograde)',
            'Periode Revolusi' => '84 tahun Bumi',
            'Jumlah Satelit' => '28 (Contoh: Titania & Oberon)',
            'Gravitasi Permukaan' => '8,69 m/s² (0,88 kali bumi)'
        ],
        'funfact' => 'Uranus adalah satu-satunya planet yang berotasi miring secara horizontal dengan kemiringan sumbu ekstrim 98 derajat. Hal ini membuat Uranus terlihat seperti bola yang menggelinding mengitari Matahari!'
    ],
    'neptunus' => [
        'nama' => 'Neptunus',
        'gambar' => 'assets/neptunus.png',
        'deskripsi' => 'Planet kedelapan sekaligus planet terjauh dari pusat Tata Surya. Diklasifikasikan sebagai raksasa es, Neptunus berwarna biru pekat karena kandungan gas metana di atmosfernya. Jaraknya yang sangat jauh membuatnya tidak bisa dilihat dengan mata telanjang.',
        'data' => [
            'Diameter' => '49.244 km',
            'Suhu' => 'Rata-rata -201 °C',
            'Periode Rotasi' => '16 jam 6 menit',
            'Periode Revolusi' => '164,8 tahun Bumi',
            'Jumlah Satelit' => '16 (Contoh: Triton)',
            'Gravitasi Permukaan' => '11,15 m/s² (1,14 kali bumi)'
        ],
        'funfact' => 'Neptunus adalah tempat paling berangin di Tata Surya kita. Kecepatan angin badai kosmik di planet ini bisa mencapai 2.100 km/jam, jauh melampaui batas kecepatan suara dan kekuatan badai terdahsyat di Bumi!'
    ]
];

$planet_id = isset($_GET['name']) ? strtolower($_GET['name']) : '';

if (array_key_exists($planet_id, $planets)) {
    $current_planet = $planets[$planet_id];
} else {
    header("Location: planet.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail <?php echo $current_planet['nama']; ?> — Penjelajah Kosmik</title>

    <link rel="stylesheet" href="css/global.css" />
    <link rel="stylesheet" href="css/navbar.css" />
    <link rel="stylesheet" href="css/planet_detail.css" />
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="page-wrapper" style="background-image: linear-gradient(to bottom, rgba(3, 10, 26, 0.92), rgba(6, 28, 85, 0.34)), url('assets/background-planet.jpeg'); background-size: cover; background-position: center; background-attachment: fixed;">

        <a href="planet.php" class="back-link">← Daftar Planet</a>

        <main class="container detail-container">

            <div class="planet-image-section">
                <div class="glow-ring">
                    <img src="<?php echo $current_planet['gambar']; ?>" alt="<?php echo $current_planet['nama']; ?>" />
                </div>
            </div>

            <div class="planet-info-section">
                <div class="planet-title-row">
                    <h1 class="planet-title"><?php echo $current_planet['nama']; ?></h1>
                    <button class="favorit-btn" id="favBtn" onclick="toggleFavorit()" title="Tambah ke Favorit">
                        <span class="fav-icon">☆</span>
                        <span class="fav-label">Favorit</span>
                    </button>
                </div>
                <p class="planet-description">
                    <?php echo $current_planet['deskripsi']; ?>
                </p>

                <div class="biodata-grid">
                    <?php foreach ($current_planet['data'] as $label => $value): ?>
                        <div class="biodata-item card-premium">
                            <span class="card-label"><?php echo $label; ?></span>
                            <p class="card-value"><?php echo $value; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="funfact-section card-premium">
                    <h2 class="accent">Fun Fact</h2>
                    <p><?php echo $current_planet['funfact']; ?></p>
                </div>

            </div>
        </main>
    </div>

    <script src="navbar.js"></script>
    <script>
    // ── Favorit Planet — planet_detail.php ──────────────────────
    const PLANET_NAME = '<?php echo addslashes($current_planet['nama']); ?>';
    const PLANET_EMOJI = '<?php
        $emojis = [
            "Matahari"=>"☀️","Merkurius"=>"🪐","Venus"=>"🌕","Bumi"=>"🌍",
            "Mars"=>"🔴","Jupiter"=>"🟠","Saturnus"=>"💫","Uranus"=>"🔵","Neptunus"=>"🌊"
        ];
        echo $emojis[$current_planet['nama']] ?? "⭐";
    ?>';
    const FAV_API = 'favorit_api.php';

    function getUser() {
        try { return JSON.parse(sessionStorage.getItem('pk_user')); }
        catch(e) { return null; }
    }

    async function checkFavStatus() {
        const user = getUser();
        if (!user) return;
        try {
            const res = await fetch(FAV_API, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ action: 'check', user_id: user.id, nama: PLANET_NAME })
            });
            const data = await res.json();
            if (data.is_favorit) setFavActive(true);
        } catch(e) {}
    }

    function setFavActive(active) {
        const btn = document.getElementById('favBtn');
        if (!btn) return;
        btn.classList.toggle('active', active);
        btn.querySelector('.fav-icon').textContent = active ? '★' : '☆';
        btn.querySelector('.fav-label').textContent = active ? 'Tersimpan' : 'Favorit';
    }

    async function toggleFavorit() {
        const user = getUser();
        if (!user) {
            showFavToast('⚠️ Login dulu untuk menyimpan favorit!', 'warn');
            return;
        }

        const btn = document.getElementById('favBtn');
        const isActive = btn.classList.contains('active');
        btn.disabled = true;

        try {
            const action = isActive ? 'remove' : 'add';
            const payload = { action, user_id: user.id, nama: PLANET_NAME };
            if (!isActive) {
                payload.emoji = PLANET_EMOJI;
                payload.tipe  = 'Planet Tata Surya';
            }

            const res = await fetch(FAV_API, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(payload)
            });
            const data = await res.json();

            if (data.success) {
                setFavActive(!isActive);
                showFavToast(!isActive
                    ? `${PLANET_EMOJI} ${PLANET_NAME} disimpan ke favorit!`
                    : `${PLANET_NAME} dihapus dari favorit`,
                    !isActive ? 'success' : 'remove'
                );
                // Sync localStorage agar halaman favorit.php ikut update
                syncLocalStorage(!isActive);
            } else {
                showFavToast(data.msg || 'Terjadi kesalahan', 'warn');
            }
        } catch(e) {
            showFavToast('Gagal terhubung ke server', 'warn');
        }

        btn.disabled = false;
    }

    function syncLocalStorage(add) {
        const KEY = 'kosmikFavorit';
        let favs = JSON.parse(localStorage.getItem(KEY) || '[]');
        if (add) {
            if (!favs.find(f => f.name === PLANET_NAME && f.category === 'planet')) {
                favs.unshift({
                    id: Date.now(),
                    name: PLANET_NAME,
                    emoji: PLANET_EMOJI,
                    type: 'Planet Tata Surya',
                    category: 'planet',
                    addedAt: new Date().toLocaleDateString('id-ID')
                });
            }
        } else {
            favs = favs.filter(f => !(f.name === PLANET_NAME && f.category === 'planet'));
        }
        localStorage.setItem(KEY, JSON.stringify(favs));
    }

    function showFavToast(msg, type = 'success') {
        const existing = document.querySelector('.fav-toast');
        if (existing) existing.remove();
        const colors = {
            success: 'linear-gradient(to right, #a855f7, #64d9ff)',
            remove:  'linear-gradient(to right, #6b7280, #9ca3af)',
            warn:    'linear-gradient(to right, #f59e0b, #ef4444)'
        };
        const t = document.createElement('div');
        t.className = 'fav-toast';
        t.style.cssText = `
            position:fixed;bottom:30px;right:30px;
            background:${colors[type]};color:white;
            padding:14px 24px;border-radius:14px;font-size:15px;
            z-index:9999;box-shadow:0 5px 25px rgba(168,85,247,0.4);
            animation:favToastIn 0.3s ease;pointer-events:none;
        `;
        t.textContent = msg;
        document.body.appendChild(t);
        if (!document.querySelector('#favToastStyle')) {
            const s = document.createElement('style');
            s.id = 'favToastStyle';
            s.textContent = '@keyframes favToastIn{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}';
            document.head.appendChild(s);
        }
        setTimeout(() => t.remove(), 2800);
    }

    // ── Init ─────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
        checkFavStatus();
    });
    </script>
</body>

</html>