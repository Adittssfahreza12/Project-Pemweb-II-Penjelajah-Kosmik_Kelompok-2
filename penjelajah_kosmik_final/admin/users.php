<?php
session_start();
require_once 'auth_check.php';
require_once '../config.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
$conn->set_charset('utf8mb4');

$msg = ''; $msg_type = '';

// Hapus user
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $conn->query("DELETE FROM users WHERE id=$id AND role='user'");
    $msg = 'Pengguna berhasil dihapus!';
    $msg_type = 'success';
}

// Reset password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_id'])) {
    $id  = (int)$_POST['reset_id'];
    $pw  = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=? AND role='user'");
    $stmt->bind_param('si', $pw, $id);
    $stmt->execute();
    $msg = 'Password berhasil direset!';
    $msg_type = 'success';
}

// Ambil semua user
$users = $conn->query("
  SELECT u.id, u.nama_lengkap, u.username, u.role, u.created_at,
         COUNT(DISTINCT h.id) AS total_kuis,
         COUNT(DISTINCT f.id) AS total_favorit
  FROM users u
  LEFT JOIN hasil_kuis h ON h.user_id = u.id
  LEFT JOIN favorit_kosmik f ON f.user_id = u.id
  WHERE u.role = 'user'
  GROUP BY u.id
  ORDER BY u.created_at DESC
");

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Pengguna — Admin</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<main class="admin-main">
  <div class="admin-header">
    <h1>👥 Kelola Pengguna</h1>
    <p>Daftar semua pengguna yang terdaftar di website.</p>
  </div>

  <?php if ($msg): ?>
  <div class="alert alert-<?= $msg_type ?> show"><?= $msg ?></div>
  <?php endif; ?>

  <div class="table-card">
    <div class="table-card-header">
      <h2>Semua Pengguna</h2>
    </div>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Lengkap</th>
          <th>Username</th>
          <th>Sesi Kuis</th>
          <th>Favorit</th>
          <th>Daftar Pada</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($row = $users->fetch_assoc()): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
          <td>@<?= htmlspecialchars($row['username']) ?></td>
          <td><?= $row['total_kuis'] ?></td>
          <td><?= $row['total_favorit'] ?></td>
          <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
          <td style="display:flex; gap:6px; flex-wrap:wrap;">
            <button class="btn btn-primary btn-sm" onclick="openReset(<?= $row['id'] ?>, '<?= htmlspecialchars($row['nama_lengkap']) ?>')">🔑 Reset PW</button>
            <a href="?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus pengguna ini?')">🗑️ Hapus</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<!-- Modal Reset Password -->
<div class="modal-overlay" id="modalReset">
  <div class="modal">
    <h2>🔑 Reset Password</h2>
    <p style="color:var(--color-text-muted); font-size:0.875rem; margin-bottom:16px;">Reset password untuk: <strong id="resetNama"></strong></p>
    <form method="POST">
      <input type="hidden" name="reset_id" id="resetId">
      <div class="form-group">
        <label>Password Baru</label>
        <input type="password" name="new_password" class="form-control" placeholder="Masukkan password baru" required minlength="6">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="closeReset()">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
function openReset(id, nama) {
  document.getElementById('resetId').value = id;
  document.getElementById('resetNama').textContent = nama;
  document.getElementById('modalReset').classList.add('show');
}
function closeReset() {
  document.getElementById('modalReset').classList.remove('show');
}
</script>
</body>
</html>
