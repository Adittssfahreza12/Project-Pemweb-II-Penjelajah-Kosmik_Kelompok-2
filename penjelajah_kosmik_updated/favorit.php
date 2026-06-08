<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Favorit — Penjelajah Kosmik</title>
  <link rel="stylesheet" href="css/global.css" />
  <link rel="stylesheet" href="css/navbar.css" />
  <link rel="stylesheet" href="css/favorit.css" />
</head>
<body>

  <?php include 'navbar.php'; ?>

  <main class="page-wrapper">
    <div class="container">

      <div class="favorit-header">
        <p class="hero-eyebrow">✦ Koleksiku</p>
        <h1>Favorit <span class="accent">Kosmikku</span></h1>
        <p class="favorit-desc">Koleksi planet dan fakta favoritmu tersimpan di sini!</p>
      </div>

      <div class="stats-bar" id="statsBar">
        <div class="stat-item">
          <span class="stat-num" id="totalFav">0</span>
          <span class="stat-label">Total Favorit</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
          <span class="stat-num" id="planetCount">0</span>
          <span class="stat-label">Planet</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat-item">
          <span class="stat-num" id="factCount">0</span>
          <span class="stat-label">Fakta</span>
        </div>
      </div>

      <div class="controls-bar">
        <div class="search-wrap">
          <span>🔍</span>
          <input type="text" id="searchInput" placeholder="Cari favorit..." oninput="filterFavs()" />
        </div>
        <div class="filter-btns">
          <button class="filter-btn active" onclick="filterByCategory('semua', this)">🌟 Semua</button>
          <button class="filter-btn" onclick="filterByCategory('planet', this)">🪐 Planet</button>
          <button class="filter-btn" onclick="filterByCategory('fakta', this)">💡 Fakta</button>
        </div>
        <button class="clear-btn" onclick="confirmClearAll()">🗑️ Hapus Semua</button>
      </div>

      <div id="favsContainer"></div>

      <div class="empty-state hidden" id="emptyState">
        <div class="empty-icon">🌌</div>
        <h2>Belum Ada Favorit</h2>
        <p>Mulai jelajahi dan simpan planet atau fakta favoritmu!</p>
        <div class="empty-actions">
          <a href="kalkulator.php" class="btn-secondary">🪐 Kalkulator Planet</a>
          <a href="funzone.php" class="btn-secondary">💡 Zona Edukasi</a>
          <a href="kuis.php" class="btn-secondary">🎮 Kuis</a>
        </div>
      </div>

      <div class="quick-add-section">
        <h2>Tambah Fakta Favorit</h2>
        <p>Catat fakta kosmik menarik yang kamu temukan!</p>
        <div class="add-form">
          <div class="add-form-row">
            <input type="text" id="factTitleInput" placeholder="Judul fakta..." maxlength="60" />
            <input type="text" id="factEmojiInput" placeholder="Emoji" maxlength="4" class="emoji-input" />
          </div>
          <textarea id="factBodyInput" placeholder="Tulis fakta kosmik favoritmu di sini..." rows="3" maxlength="300"></textarea>
          <button class="btn-primary add-btn" onclick="addManualFact()">⭐ Simpan ke Favorit</button>
        </div>
      </div>

    </div>
  </main>

  <div class="modal-overlay hidden" id="confirmModal">
    <div class="confirm-card">
      <div style="font-size:48px;margin-bottom:16px">🗑️</div>
      <h2>Hapus Semua Favorit?</h2>
      <p>Tindakan ini tidak bisa dibatalkan.</p>
      <div class="confirm-btns">
        <button class="confirm-yes" onclick="clearAll()">Ya, Hapus Semua</button>
        <button class="confirm-no" onclick="closeConfirm()">Batal</button>
      </div>
    </div>
  </div>

  <script src="navbar.js"></script>
  <script src="favorit.js"></script>
</body>
</html>