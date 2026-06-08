<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Simulasi Orbit — Penjelajah Kosmik</title>
  
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="stylesheet" href="css/orbit.css" />
</head>
<body>

  <div class="stars-container" id="starsContainer"></div>

  <?php include 'navbar.php'; ?>

  <main class="page-wrapper">
    <div class="container container-orbit">
      
      <section class="orbit-header">
        <h1>Orbit <span class="accent">Tata Surya</span></h1>
        <p class="orbit-desc">Jelajahi tarian revolusi planet-planet mengelilingi Matahari.</p>
      </section>

      <div class="universe-viewport">
        <div class="sun-center"></div>

        <div class="orbit-line line-mercury"></div>
        <div class="orbit-line line-venus"></div>
        <div class="orbit-line line-earth"></div>
        <div class="orbit-line line-mars"></div>
        <div class="orbit-line line-jupiter"></div>
        <div class="orbit-line line-saturn"></div>
        <div class="orbit-line line-uranus"></div>
        <div class="orbit-line line-neptune"></div>

        <div class="planet-object mercury"></div>
        <div class="planet-object venus"></div>
        <div class="planet-object earth"></div>
        <div class="planet-object mars"></div>
        <div class="planet-object jupiter"></div>
        <div class="planet-object saturn"></div>
        <div class="planet-object uranus"></div>
        <div class="planet-object neptune"></div>
      </div>

    </div>
  </main>

  <script src="orbit.js"></script>
  <script src="navbar.js"></script>
</body>
</html>