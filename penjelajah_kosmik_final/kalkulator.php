<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kalkulator Planet — Penjelajah Kosmik</title>
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="stylesheet" href="css/kalkulator.css" />
</head>
<body>

  <div id="heroStars" style="position:fixed;inset:0;z-index:0;pointer-events:none;"></div>

  <?php include 'navbar.php'; ?>

  <main class="page-wrapper">
    <div class="container">

      <div class="kalkulator-header">
        <p class="hero-eyebrow">✦ Eksplorasi Gravitasi</p>
        <h1>Kalkulator <span class="accent">Planet</span></h1>
        <p class="kalkulator-desc">Berapa berat badanmu jika berdiri di planet lain?</p>
      </div>

      <div class="calculator-wrapper">

        <div class="input-panel">
          <h2>Data Dirimu</h2>

          <div class="form-group">
            <label>Berat Badan (kg)</label>
            <div class="input-row">
              <button class="adj-btn" onclick="adjustValue('weight', -1)">−</button>
              <input type="number" id="weightInput" value="60" min="1" max="300" />
              <button class="adj-btn" onclick="adjustValue('weight', 1)">+</button>
            </div>
          </div>

          <div class="form-group">
            <label>Tinggi Badan (cm)</label>
            <div class="input-row">
              <button class="adj-btn" onclick="adjustValue('height', -1)">−</button>
              <input type="number" id="heightInput" value="170" min="50" max="300" />
              <button class="adj-btn" onclick="adjustValue('height', 1)">+</button>
            </div>
          </div>

          <div class="form-group">
            <label>Jenis Kelamin</label>
            <div class="gender-select">
              <button class="gender-btn active" onclick="setGender('pria', this)">👨 Pria</button>
              <button class="gender-btn" onclick="setGender('wanita', this)">👩 Wanita</button>
            </div>
          </div>

          <button class="btn-primary btn-calc" onclick="calculate()">🚀 Hitung Sekarang</button>

          <div class="bmi-display hidden" id="bmiDisplay">
            <div class="bmi-label">BMI di Bumi</div>
            <div class="bmi-value" id="bmiValue">—</div>
            <div class="bmi-cat" id="bmiCat">—</div>
          </div>
        </div>

        <div class="results-panel" id="resultsPanel">
          <div class="results-placeholder">
            <div class="placeholder-icon">🔭</div>
            <p>Masukkan data dirimu dan klik<br><strong>Hitung Sekarang!</strong></p>
          </div>
        </div>

      </div>

      <div class="modal-overlay hidden" id="modalOverlay" onclick="closeModal()">
        <div class="modal-card" onclick="event.stopPropagation()">
          <button class="modal-close" onclick="closeModal()">✕</button>
          <div class="modal-planet-icon" id="modalIcon"></div>
          <h2 id="modalName"></h2>
          <div class="modal-stats" id="modalStats"></div>
          <div class="modal-fact" id="modalFact"></div>
        </div>
      </div>

      <div class="info-section">
        <h2>Bagaimana cara kerjanya?</h2>
        <p>Berat badanmu di planet lain ditentukan oleh <strong>gravitasi permukaan</strong> planet tersebut. Rumusnya sederhana: <strong>Berat di Planet = Massa (kg) × Gravitasi Planet (m/s²)</strong>.</p>
        <div class="info-cards-row">
          <div class="info-mini-card">
            <span>🪐</span>
            <strong>Gravitasi Terbesar</strong>
            <p>Jupiter (24,8 m/s²)</p>
          </div>
          <div class="info-mini-card">
            <span>🌑</span>
            <strong>Gravitasi Terkecil</strong>
            <p>Merkurius (3,7 m/s²)</p>
          </div>
          <div class="info-mini-card">
            <span>🌍</span>
            <strong>Gravitasi Bumi</strong>
            <p>9,8 m/s² (referensi)</p>
          </div>
        </div>
      </div>

    </div>
  </main>

  <script src="navbar.js"></script>
  <script src="kalkulator.js"></script>
</body>
</html>