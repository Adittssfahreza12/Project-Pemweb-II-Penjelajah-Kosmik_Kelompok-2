<?php
$current = basename($_SERVER['PHP_SELF']);
$admin_nama = $_SESSION['admin_nama'] ?? 'Admin';
?>
<aside class="sidebar">
  <a href="dashboard.php" class="sidebar-logo">
    🌌 Penjelajah Kosmik
    <span>Panel Admin</span>
  </a>

  <nav class="sidebar-nav">
    <a href="dashboard.php" class="<?= $current === 'dashboard.php' ? 'active' : '' ?>">
      <span class="nav-icon">📊</span> Dashboard
    </a>
    <a href="users.php" class="<?= $current === 'users.php' ? 'active' : '' ?>">
      <span class="nav-icon">👥</span> Kelola Pengguna
    </a>
    <a href="kuis.php" class="<?= $current === 'kuis.php' ? 'active' : '' ?>">
      <span class="nav-icon">🧠</span> Kelola Soal Kuis
    </a>
    <a href="hasil_kuis.php" class="<?= $current === 'hasil_kuis.php' ? 'active' : '' ?>">
      <span class="nav-icon">📝</span> Hasil Kuis
    </a>
    <a href="kalkulator.php" class="<?= $current === 'kalkulator.php' ? 'active' : '' ?>">
      <span class="nav-icon">🪐</span> Riwayat Kalkulator
    </a>
    <a href="favorit.php" class="<?= $current === 'favorit.php' ? 'active' : '' ?>">
      <span class="nav-icon">⭐</span> Data Favorit
    </a>
  </nav>

  <div class="sidebar-footer">
    Login sebagai:<br><strong><?= htmlspecialchars($admin_nama) ?></strong>
    <a href="logout.php">🚪 Keluar</a>
  </div>
</aside>