<?php
session_start();
require_once 'auth_check.php';
require_once '../config.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
$conn->set_charset('utf8mb4');

$riwayat = $conn->query("
  SELECT r.*, u.nama_lengkap, u.username
  FROM riwayat_kalkulator r
  JOIN users u ON u.id = r.user_id
  ORDER BY r.dihitung_pada DESC
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Kalkulator — Admin</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<main class="admin-main">
  <div class="admin-header">
    <h1>🪐 Riwayat Kalkulator Planet</h1>
    <p>Semua data sesi perhitungan berat planet oleh pengguna.</p>
  </div>

  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Pengguna</th>
          <th>Berat (kg)</th>
          <th>Tinggi (cm)</th>
          <th>Kelamin</th>
          <th>BMI</th>
          <th>Kategori BMI</th>
          <th>Dihitung Pada</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; while($row=$riwayat->fetch_assoc()): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td>
            <?= htmlspecialchars($row['nama_lengkap']) ?><br>
            <small style="color:var(--color-text-muted);">@<?= htmlspecialchars($row['username']) ?></small>
          </td>
          <td><?= $row['berat_badan_kg'] ?> kg</td>
          <td><?= $row['tinggi_badan_cm'] ?> cm</td>
          <td><?= ucfirst($row['jenis_kelamin']) ?></td>
          <td><?= $row['bmi_bumi'] ?></td>
          <td>
            <?php
              $cat = $row['kategori_bmi'];
              $color = match($cat) {
                'Normal'  => 'var(--color-success)',
                'Kurus'   => 'var(--color-warning)',
                'Gemuk'   => 'var(--color-warning)',
                'Obesitas'=> 'var(--color-danger)',
                default   => 'var(--color-text)'
              };
            ?>
            <span style="color:<?= $color ?>; font-weight:600;"><?= $cat ?></span>
          </td>
          <td><?= date('d M Y, H:i', strtotime($row['dihitung_pada'])) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>
</body>
</html>
