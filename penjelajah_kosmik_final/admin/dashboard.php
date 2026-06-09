<?php
session_start();
require_once 'auth_check.php';
require_once '../config.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
$conn->set_charset('utf8mb4');

// Statistik
$total_users    = $conn->query("SELECT COUNT(*) c FROM users WHERE role='user'")->fetch_assoc()['c'];
$total_kuis     = $conn->query("SELECT COUNT(*) c FROM hasil_kuis")->fetch_assoc()['c'];
$total_kalkul   = $conn->query("SELECT COUNT(*) c FROM riwayat_kalkulator")->fetch_assoc()['c'];
$total_favorit  = $conn->query("SELECT COUNT(*) c FROM favorit_kosmik")->fetch_assoc()['c'];

// 5 pengguna terbaru
$users_terbaru = $conn->query("SELECT nama_lengkap, username, created_at FROM users WHERE role='user' ORDER BY created_at DESC LIMIT 5");

// 5 hasil kuis terbaru
$kuis_terbaru = $conn->query("
  SELECT u.nama_lengkap, h.tingkat_kesulitan, h.skor, h.jawaban_benar, h.total_soal, h.waktu_main
  FROM hasil_kuis h
  JOIN users u ON u.id = h.user_id
  ORDER BY h.waktu_main DESC LIMIT 5
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin — Penjelajah Kosmik</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<main class="admin-main">
  <div class="admin-header">
    <h1>📊 Dashboard</h1>
    <p>Selamat datang, <?= htmlspecialchars($_SESSION['admin_nama']) ?>! Berikut ringkasan data website.</p>
  </div>

  <!-- Statistik -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-icon">👥</div>
      <div>
        <div class="stat-label">Total Pengguna</div>
        <div class="stat-value"><?= $total_users ?></div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon">🧠</div>
      <div>
        <div class="stat-label">Sesi Kuis</div>
        <div class="stat-value"><?= $total_kuis ?></div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon">🪐</div>
      <div>
        <div class="stat-label">Sesi Kalkulator</div>
        <div class="stat-value"><?= $total_kalkul ?></div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon">⭐</div>
      <div>
        <div class="stat-label">Data Favorit</div>
        <div class="stat-value"><?= $total_favorit ?></div>
      </div>
    </div>
  </div>

  <!-- Pengguna Terbaru -->
  <div class="table-card">
    <div class="table-card-header">
      <h2>👥 Pengguna Terbaru</h2>
      <a href="users.php" class="btn btn-primary btn-sm">Lihat Semua</a>
    </div>
    <table>
      <thead>
        <tr>
          <th>Nama</th>
          <th>Username</th>
          <th>Daftar Pada</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $users_terbaru->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
          <td>@<?= htmlspecialchars($row['username']) ?></td>
          <td><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></td>
        </tr>
        <?php endwhile; ?>
        <?php if ($users_terbaru->num_rows === 0): ?>
        <tr><td colspan="3" class="empty-state">Belum ada pengguna</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Hasil Kuis Terbaru -->
  <div class="table-card">
    <div class="table-card-header">
      <h2>🧠 Hasil Kuis Terbaru</h2>
      <a href="hasil_kuis.php" class="btn btn-primary btn-sm">Lihat Semua</a>
    </div>
    <table>
      <thead>
        <tr>
          <th>Pengguna</th>
          <th>Level</th>
          <th>Benar</th>
          <th>Skor</th>
          <th>Waktu</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $kuis_terbaru->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
          <td><span class="badge badge-<?= $row['tingkat_kesulitan'] ?>"><?= ucfirst($row['tingkat_kesulitan']) ?></span></td>
          <td><?= $row['jawaban_benar'] ?>/<?= $row['total_soal'] ?></td>
          <td><strong><?= $row['skor'] ?></strong></td>
          <td><?= date('d M Y', strtotime($row['waktu_main'])) ?></td>
        </tr>
        <?php endwhile; ?>
        <?php if ($kuis_terbaru->num_rows === 0): ?>
        <tr><td colspan="5" class="empty-state">Belum ada data kuis</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>
</body>
</html>
