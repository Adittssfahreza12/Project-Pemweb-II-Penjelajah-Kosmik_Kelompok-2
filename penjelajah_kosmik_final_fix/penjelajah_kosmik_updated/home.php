<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Penjelajah Kosmik</title>
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/home.css" />
</head>
<body>


  <main class="page-wrapper">
    <section class="hero">
      <div class="hero-bg">
        <div class="hero-stars" id="heroStars"></div>
      </div>

      <div class="hero-content">
        <p class="hero-eyebrow">✦ Selamat Datang</p>
        <h1>Jelajahi <span class="accent">Tata Surya</span></h1>
        <p class="hero-desc">
          Dari Matahari yang terik hingga tepi es Neptunus, temukan setiap
          planet dari dekat melalui pengalaman belajar interaktif dan visual
          yang dirancang untuk menjelajahi tata surya kita.
        </p>
        <div class="hero-actions">
          <a href="planet.php" class="btn-primary">Mulai Belajar</a>
        </div>
      </div>
    </section>
  </main>

  <script src="home.js"></script>
  <script>
    // Cek sesi — jika belum login, arahkan ke login.php
    (function () {
      const user = sessionStorage.getItem('pk_user');
      if (!user) {
        window.location.href = 'login.php';
      }
    })();
  </script>
</body>
</html>
