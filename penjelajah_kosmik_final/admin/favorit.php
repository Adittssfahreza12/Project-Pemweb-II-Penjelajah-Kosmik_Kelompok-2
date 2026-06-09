<?php
session_start();
require_once 'auth_check.php';
require_once '../config.php';
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
$conn->set_charset('utf8mb4');

// Hapus item favorit
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $conn->query("DELETE FROM favorit_kosmik WHERE id=".(int)$_GET['hapus']);
}

$filter = $_GET['kategori'] ?? 'semua';
$where  = $filter !== 'semua' ? "WHERE f.kategori='$filter'" : '';

$favorit = $conn->query("
  SELECT f.*, u.nama_lengkap, u.username
  FROM favorit_kosmik f
  JOIN users u ON u.id = f.user_id
  $where
  ORDER BY f.ditambahkan_pada DESC
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Favorit — Admin</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<main class="admin-main">
  <div class="admin-header">
    <h1>⭐ Data Favorit Kosmik</h1>
    <p>Semua item favorit yang disimpan oleh pengguna.</p>
  </div>

  <!-- Filter -->
  <div style="display:flex; gap:8px; margin-bottom:20px;">
    <?php foreach(['semua','planet','fakta'] as $kat): ?>
    <a href="?kategori=<?= $kat ?>" class="btn <?= $filter===$kat ? 'btn-primary' : '' ?>" style="<?= $filter!==$kat ? 'background:rgba(255,255,255,0.05);border:1px solid var(--color-border);color:var(--color-text-muted);' : '' ?>">
      <?= ucfirst($kat) ?>
    </a>
    <?php endforeach; ?>
  </div>

  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Pengguna</th>
          <th>Kategori</th>
          <th>Nama / Judul</th>
          <th>Tipe</th>
          <th>Berat di Planet</th>
          <th>Ditambahkan</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; while($row=$favorit->fetch_assoc()): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td>
            <?= htmlspecialchars($row['nama_lengkap']) ?><br>
            <small style="color:var(--color-text-muted);">@<?= htmlspecialchars($row['username']) ?></small>
          </td>
          <td>
            <span class="badge <?= $row['kategori']==='planet' ? 'badge-user' : 'badge-admin' ?>">
              <?= ucfirst($row['kategori']) ?>
            </span>
          </td>
          <td><?= $row['emoji'] ?> <?= htmlspecialchars($row['nama']) ?></td>
          <td style="color:var(--color-text-muted); font-size:0.82rem;"><?= htmlspecialchars($row['tipe'] ?? '-') ?></td>
          <td>
            <?php if ($row['berat_di_planet']): ?>
              <?= $row['berat_di_planet'] ?> kg<br>
              <small style="color:var(--color-text-muted);">Bumi: <?= $row['berat_di_bumi'] ?> kg</small>
            <?php else: ?>
              <span style="color:var(--color-text-muted);">-</span>
            <?php endif; ?>
          </td>
          <td><?= date('d M Y', strtotime($row['ditambahkan_pada'])) ?></td>
          <td>
            <a href="?hapus=<?= $row['id'] ?>&kategori=<?= $filter ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus item favorit ini?')">🗑️</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>
</body>
</html>
