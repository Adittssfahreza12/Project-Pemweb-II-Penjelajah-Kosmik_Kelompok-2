<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Planet — Penjelajah Kosmik</title>
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="stylesheet" href="css/planet.css" />
</head>
<body>

  <?php include 'navbar.php'; ?>

  <main class="page-wrapper">
    <div class="container">

      <div class="planet-page-header">
        <p class="hero-eyebrow">✦ Tata Surya Kita</p>
        <h1>Daftar <span class="accent">Planet</span></h1>
        <p class="planet-page-desc">Pilih planet untuk menjelajahi detail, fakta unik, dan data ilmiahnya.</p>
      </div>

      <div class="planet-grid" id="planetGrid">

        <?php
        $planets = [
          ['slug' => 'matahari',  'name' => 'Matahari',  'img' => 'assets/matahari.png',  'desc' => 'Bintang di pusat tata surya kita yang memberikan cahaya dan kehangatan untuk semua planet.'],
          ['slug' => 'merkurius', 'name' => 'Merkurius', 'img' => 'assets/merkurius.png', 'desc' => 'Planet terkecil dan terdekat dengan Matahari dengan suhu ekstrem.'],
          ['slug' => 'venus',     'name' => 'Venus',     'img' => 'assets/venus.png',     'desc' => 'Planet terpanas dengan atmosfer tebal yang menjebak panas seperti efek rumah kaca.'],
          ['slug' => 'bumi',      'name' => 'Bumi',      'img' => 'assets/bumi.png',      'desc' => 'Rumah kita, satu-satunya planet yang diketahui memiliki kehidupan.'],
          ['slug' => 'mars',      'name' => 'Mars',      'img' => 'assets/mars.png',      'desc' => 'Planet merah dengan gunung berapi terbesar di tata surya.'],
          ['slug' => 'jupiter',   'name' => 'Jupiter',   'img' => 'assets/jupiter.png',   'desc' => 'Planet terbesar dengan badai raksasa yang telah berlangsung ratusan tahun.'],
          ['slug' => 'saturnus',  'name' => 'Saturnus',  'img' => 'assets/saturnus.png',  'desc' => 'Planet cantik dengan cincin es dan batu yang menakjubkan.'],
          ['slug' => 'uranus',    'name' => 'Uranus',    'img' => 'assets/uranus.png',    'desc' => 'Raksasa es biru yang berotasi miring hampir horizontal.'],
          ['slug' => 'neptunus',  'name' => 'Neptunus',  'img' => 'assets/neptunus.png',  'desc' => 'Planet terjauh dengan angin terkencang di tata surya.'],
        ];

        foreach ($planets as $planet): ?>
          <div class="planet-card">
            <div class="planet-card-img">
              <img src="<?= $planet['img'] ?>" alt="<?= $planet['name'] ?>" />
            </div>
            <h3><?= $planet['name'] ?></h3>
            <p><?= $planet['desc'] ?></p>
            <a href="planet_detail.php?name=<?= $planet['slug'] ?>" class="btn-planet">
              Pelajari Lebih Lanjut
            </a>
          </div>
        <?php endforeach; ?>

      </div>
    </div>
  </main>

  <script src="navbar.js"></script>
</body>
</html>