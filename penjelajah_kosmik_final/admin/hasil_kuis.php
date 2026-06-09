<?php
session_start();
require_once 'auth_check.php';
require_once '../config.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
$conn->set_charset('utf8mb4');

$filter = $_GET['level'] ?? 'semua';
$where  = $filter !== 'semua' ? "WHERE h.tingkat_kesulitan='$filter'" : '';

$hasil = $conn->query("
  SELECT h.*, u.nama_lengkap, u.username
  FROM hasil_kuis h
  JOIN users u ON u.id = h.user_id
  $where
  ORDER BY h.waktu_main DESC
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hasil Kuis — Admin</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<main class="admin-main">
  <div class="admin-header">
    <h1>📝 Hasil Kuis Pengguna</h1>
    <p>Semua riwayat sesi kuis yang telah dimainkan.</p>
  </div>

  <!-- Filter -->
  <div style="display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap;">
    <?php foreach(['semua','mudah','sedang','sulit'] as $lv): ?>
    <a href="?level=<?= $lv ?>" class="btn <?= $filter===$lv ? 'btn-primary' : '' ?>" style="<?= $filter!==$lv ? 'background:rgba(255,255,255,0.05);border:1px solid var(--color-border);color:var(--color-text-muted);' : '' ?>">
      <?= ucfirst($lv) ?>
    </a>
    <?php endforeach; ?>
  </div>

  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Pengguna</th>
          <th>Level</th>
          <th>Benar</th>
          <th>Salah</th>
          <th>Skor</th>
          <th>Persentase</th>
          <th>Predikat</th>
          <th>Waktu</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; while($row=$hasil->fetch_assoc()): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td>
            <?= htmlspecialchars($row['nama_lengkap']) ?><br>
            <small style="color:var(--color-text-muted);">@<?= htmlspecialchars($row['username']) ?></small>
          </td>
          <td><span class="badge badge-<?= $row['tingkat_kesulitan'] ?>"><?= ucfirst($row['tingkat_kesulitan']) ?></span></td>
          <td style="color:var(--color-success);">✅ <?= $row['jawaban_benar'] ?></td>
          <td style="color:var(--color-danger);">❌ <?= $row['jawaban_salah'] ?></td>
          <td><strong><?= $row['skor'] ?></strong></td>
          <td><?= number_format($row['persentase'],1) ?>%</td>
          <td><?= htmlspecialchars($row['predikat'] ?? '-') ?></td>
          <td><?= date('d M Y, H:i', strtotime($row['waktu_main'])) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>
</body>
</html>
