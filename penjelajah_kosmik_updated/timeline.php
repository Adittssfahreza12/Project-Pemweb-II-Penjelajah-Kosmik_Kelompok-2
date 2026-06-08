<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kronologi Penemuan — Penjelajah Kosmik</title>
  
  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/navbar.css">
  <link rel="stylesheet" href="css/timeline.css">
</head>
<body>

  <div class="stars-container" id="starsContainer"></div>

  <?php include 'navbar.php'; ?>

  <main class="page-wrapper">
    <div class="container container-timeline">
      
      <header class="timeline-header">
        <p class="hero-eyebrow">✦ Arsip Sejarah Astronomi</p>
        <h1>Timeline of <span class="accent">Discovery</span></h1>
        <p class="timeline-desc">Menelusuri jejak peradaban manusia dalam menemukan dan mengidentifikasi planet-planet di tata surya kita.</p>
      </header>

      <section class="timeline-wrapper">
        <div class="timeline-center-line"></div>

        <div class="timeline-item left">
          <div class="content card">
            <span class="time-badge">Prasejarah</span>
            <h3>Merkurius</h3>
            <p>Telah dikenal sejak ribuan tahun lalu oleh peradaban kuno bangsa Sumeria dan Babilonia melalui pengamatan mata telanjang.</p>
          </div>
        </div>

        <div class="timeline-item right">
          <div class="content card">
            <span class="time-badge">~3000 SM</span>
            <h3>Venus</h3>
            <p>Dikenal sebagai "Bintang Fajar" atau "Bintang Kejora". Tercatat dalam dokumentasi kuno sejak awal mula peradaban manusia berekspansi.</p>
          </div>
        </div>

        <div class="timeline-item left">
          <div class="content card">
            <span class="time-badge">Awal Kehidupan</span>
            <h3>Bumi</h3>
            <p>Planet tempat tinggal kita, disadari sebagai sebuah entitas dunia kosmik seiring berkembangnya ilmu navigasi dan pemetaan peradaban manusia.</p>
          </div>
        </div>

        <div class="timeline-item right">
          <div class="content card">
            <span class="time-badge">Mesir Kuno</span>
            <h3>Mars</h3>
            <p>Planet merah ini menarik perhatian para astronom Mesir kuno karena warnanya yang mencolok serta pergerakan retrogradanya yang unik di langit malam.</p>
          </div>
        </div>

        <div class="timeline-item left">
          <div class="content card">
            <span class="time-badge">>4000 Tahun Lalu</span>
            <h3>Jupiter</h3>
            <p>Raksasa gas ini telah diamati selama millennia. Penemuan revolusioner terjadi saat Galileo Galilei mengarahkan teleskopnya pada tahun 1610 dan menemukan 4 bulan utamanya.</p>
          </div>
        </div>

        <div class="timeline-item right">
          <div class="content card">
            <span class="time-badge">Babilonia</span>
            <h3>Saturnus</h3>
            <p>Ditemukan pertama kali oleh peradaban Babilonia dan dijuluki sebagai "bintang lambat" karena periode revolusinya mengitari matahari memakan waktu sangat lama.</p>
          </div>
        </div>

        <div class="timeline-item left">
          <div class="content card">
            <span class="time-badge-modern">1781</span>
            <h3>Uranus</h3>
            <p>Planet pertama yang tidak disadari di zaman kuno. Berhasil diidentifikasi secara resmi sebagai planet oleh <strong>William Herschel</strong> menggunakan bantuan teknologi teleskop rakitannya.</p>
          </div>
        </div>

        <div class="timeline-item right">
          <div class="content card">
            <span class="time-badge-modern">1846</span>
            <h3>Neptunus</h3>
            <p>Penemuan paling ikonik dalam sains. Keberadaannya diprediksi secara akurat lewat <strong>perhitungan matematika</strong> astronomi oleh Urbain Le Verrier sebelum akhirnya teropong Johann Galle melihatnya secara langsung.</p>
          </div>
        </div>

      </section>
    </div>
  </main>

  <script src="timeline.js"></script>
  <script src="navbar.js"></script>
  <script src="search.js"></script>
</body>
</html>