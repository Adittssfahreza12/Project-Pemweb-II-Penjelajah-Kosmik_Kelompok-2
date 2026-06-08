<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Penjelajah Kosmik - Zona Edukasi</title>
  
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="stylesheet" href="css/funzone.css">
</head>
<body>

  <div class="stars-container" id="starsContainer"></div>

  <?php include 'navbar.php'; ?>

  <main class="page-wrapper">
    <div class="container container-funzone">
      
      <div class="funzone-hero">
        <p class="hero-eyebrow">✦ Ruang Pengetahuan</p>
        <h1>Fun <span class="accent">Zone</span></h1>
        <p class="funzone-desc">Temukan fakta-fakta menakjubkan dan luar biasa tentang Alam Semesta kita!</p>
      </div>

      <div class="fact-card card">
        <h2 class="fact-title">
          <span class="sparkle">✦</span>
          Fakta Seru Kosmik #<span id="factNumber" class="accent">2</span>
          <span class="sparkle">✦</span>
        </h2>
        
        <div class="fact-content" id="factContent">
          Bulan Jupiter, Ganymede, lebih besar daripada planet Merkurius dan merupakan bulan terbesar di Tata Surya kita.
        </div>
        
        <button class="next-btn" onclick="nextFact()">
          <span class="sparkle">✦</span>
          Fakta Kosmik Berikutnya
        </button>
        
        <div class="fact-counter">
          <span id="currentFact" class="accent">2</span> dari 15 fakta
        </div>
      </div>

      <div class="info-cards-grid">
        <div class="info-card card">
          <div class="info-card-number accent">15</div>
          <div class="info-card-title">Fakta Menakjubkan</div>
        </div>
        
        <div class="info-card card">
          <div class="infinity-symbol">∞</div>
          <div class="info-card-title">Misteri Eksplorasi</div>
        </div>
        
        <div class="info-card card">
          <div class="info-card-number accent">8</div>
          <div class="info-card-title">Planet Terjelajahi</div>
        </div>
      </div>

    </div>
  </main>

  <script src="funzone.js"></script>
  <script src="navbar.js"></script>
  <script src="search.js"></script>
</body>
</html>