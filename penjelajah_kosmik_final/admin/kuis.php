<?php
session_start();
require_once 'auth_check.php';
require_once '../config.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
$conn->set_charset('utf8mb4');

// Pastikan tabel soal_kuis ada
$conn->query("CREATE TABLE IF NOT EXISTS `soal_kuis` (
  `id`                  INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tingkat_kesulitan`   ENUM('mudah','sedang','sulit') NOT NULL,
  `pertanyaan`          TEXT NOT NULL,
  `opsi_a`              VARCHAR(255) NOT NULL,
  `opsi_b`              VARCHAR(255) NOT NULL,
  `opsi_c`              VARCHAR(255) NOT NULL,
  `opsi_d`              VARCHAR(255) NOT NULL,
  `jawaban_benar`       TINYINT UNSIGNED NOT NULL COMMENT '0=A, 1=B, 2=C, 3=D',
  `icon`                VARCHAR(10) DEFAULT '🌌',
  `penjelasan`          TEXT,
  `created_at`          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

$msg = ''; $msg_type = '';

// Tambah soal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'tambah') {
    $level  = $_POST['level'];
    $q      = trim($_POST['pertanyaan']);
    $a      = trim($_POST['opsi_a']);
    $b      = trim($_POST['opsi_b']);
    $c      = trim($_POST['opsi_c']);
    $d      = trim($_POST['opsi_d']);
    $ans    = (int)$_POST['jawaban_benar'];
    $icon   = trim($_POST['icon']) ?: '🌌';
    $expl   = trim($_POST['penjelasan']);

    $stmt = $conn->prepare("INSERT INTO soal_kuis (tingkat_kesulitan,pertanyaan,opsi_a,opsi_b,opsi_c,opsi_d,jawaban_benar,icon,penjelasan) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param('ssssssiis', $level,$q,$a,$b,$c,$d,$ans,$icon,$expl);
    $stmt->execute();
    $msg = 'Soal berhasil ditambahkan!'; $msg_type = 'success';
}

// Hapus soal
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $conn->query("DELETE FROM soal_kuis WHERE id=".(int)$_GET['hapus']);
    $msg = 'Soal berhasil dihapus!'; $msg_type = 'success';
}

// Edit soal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit') {
    $id   = (int)$_POST['edit_id'];
    $level = $_POST['level'];
    $q    = trim($_POST['pertanyaan']);
    $a    = trim($_POST['opsi_a']);
    $b    = trim($_POST['opsi_b']);
    $c    = trim($_POST['opsi_c']);
    $d    = trim($_POST['opsi_d']);
    $ans  = (int)$_POST['jawaban_benar'];
    $icon = trim($_POST['icon']) ?: '🌌';
    $expl = trim($_POST['penjelasan']);

    $stmt = $conn->prepare("UPDATE soal_kuis SET tingkat_kesulitan=?,pertanyaan=?,opsi_a=?,opsi_b=?,opsi_c=?,opsi_d=?,jawaban_benar=?,icon=?,penjelasan=? WHERE id=?");
    $stmt->bind_param('ssssssiisi', $level,$q,$a,$b,$c,$d,$ans,$icon,$expl,$id);
    $stmt->execute();
    $msg = 'Soal berhasil diperbarui!'; $msg_type = 'success';
}

$filter = $_GET['level'] ?? 'semua';
$where  = $filter !== 'semua' ? "WHERE tingkat_kesulitan='$filter'" : '';
$soal   = $conn->query("SELECT * FROM soal_kuis $where ORDER BY tingkat_kesulitan, id");

$conn->close();

$label = ['A','B','C','D'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Soal Kuis — Admin</title>
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
<?php include 'sidebar.php'; ?>

<main class="admin-main">
  <div class="admin-header">
    <h1>🧠 Kelola Soal Kuis</h1>
    <p>Tambah, edit, dan hapus soal kuis tata surya.</p>
  </div>

  <?php if ($msg): ?>
  <div class="alert alert-<?= $msg_type ?> show"><?= $msg ?></div>
  <?php endif; ?>

  <!-- Filter + Tambah -->
  <div style="display:flex; gap:10px; align-items:center; margin-bottom:20px; flex-wrap:wrap;">
    <div style="display:flex; gap:8px;">
      <?php foreach(['semua','mudah','sedang','sulit'] as $lv): ?>
      <a href="?level=<?= $lv ?>" class="btn <?= $filter===$lv ? 'btn-primary' : '' ?>" style="<?= $filter!==$lv ? 'background:rgba(255,255,255,0.05);border:1px solid var(--color-border);color:var(--color-text-muted);' : '' ?>">
        <?= ucfirst($lv) ?>
      </a>
      <?php endforeach; ?>
    </div>
    <button class="btn btn-primary" onclick="document.getElementById('modalTambah').classList.add('show')" style="margin-left:auto;">➕ Tambah Soal</button>
  </div>

  <!-- Tabel Soal -->
  <div class="table-card">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Level</th>
          <th>Pertanyaan</th>
          <th>Jawaban Benar</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=1; while($row=$soal->fetch_assoc()): $opts=[$row['opsi_a'],$row['opsi_b'],$row['opsi_c'],$row['opsi_d']]; ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><span class="badge badge-<?= $row['tingkat_kesulitan'] ?>"><?= ucfirst($row['tingkat_kesulitan']) ?></span></td>
          <td><?= $row['icon'] ?> <?= htmlspecialchars(mb_substr($row['pertanyaan'],0,60)).(mb_strlen($row['pertanyaan'])>60?'...':'') ?></td>
          <td><strong><?= $label[$row['jawaban_benar']] ?>. <?= htmlspecialchars($opts[$row['jawaban_benar']]) ?></strong></td>
          <td style="display:flex;gap:6px;">
            <button class="btn btn-primary btn-sm" onclick='openEdit(<?= json_encode($row) ?>)'>✏️ Edit</button>
            <a href="?hapus=<?= $row['id'] ?>&level=<?= $filter ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus soal ini?')">🗑️</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</main>

<!-- Modal Tambah -->
<div class="modal-overlay" id="modalTambah">
  <div class="modal">
    <h2>➕ Tambah Soal Kuis</h2>
    <form method="POST">
      <input type="hidden" name="action" value="tambah">
      <div class="form-grid">
        <div class="form-group">
          <label>Tingkat Kesulitan</label>
          <select name="level" class="form-control" required>
            <option value="mudah">Mudah</option>
            <option value="sedang">Sedang</option>
            <option value="sulit">Sulit</option>
          </select>
        </div>
        <div class="form-group">
          <label>Icon (emoji)</label>
          <input type="text" name="icon" class="form-control" placeholder="🌌" maxlength="5">
        </div>
      </div>
      <div class="form-group">
        <label>Pertanyaan</label>
        <textarea name="pertanyaan" class="form-control" required placeholder="Tulis pertanyaan di sini..."></textarea>
      </div>
      <?php foreach(['a'=>'A','b'=>'B','c'=>'C','d'=>'D'] as $k=>$v): ?>
      <div class="form-group">
        <label>Opsi <?= $v ?></label>
        <input type="text" name="opsi_<?= $k ?>" class="form-control" required placeholder="Pilihan <?= $v ?>">
      </div>
      <?php endforeach; ?>
      <div class="form-group">
        <label>Jawaban Benar</label>
        <select name="jawaban_benar" class="form-control" required>
          <option value="0">A</option>
          <option value="1">B</option>
          <option value="2">C</option>
          <option value="3">D</option>
        </select>
      </div>
      <div class="form-group">
        <label>Penjelasan (opsional)</label>
        <textarea name="penjelasan" class="form-control" placeholder="Penjelasan jawaban..."></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="document.getElementById('modalTambah').classList.remove('show')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Soal</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal-overlay" id="modalEdit">
  <div class="modal">
    <h2>✏️ Edit Soal</h2>
    <form method="POST">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" name="edit_id" id="editId">
      <div class="form-grid">
        <div class="form-group">
          <label>Tingkat Kesulitan</label>
          <select name="level" id="editLevel" class="form-control">
            <option value="mudah">Mudah</option>
            <option value="sedang">Sedang</option>
            <option value="sulit">Sulit</option>
          </select>
        </div>
        <div class="form-group">
          <label>Icon</label>
          <input type="text" name="icon" id="editIcon" class="form-control" maxlength="5">
        </div>
      </div>
      <div class="form-group">
        <label>Pertanyaan</label>
        <textarea name="pertanyaan" id="editQ" class="form-control" required></textarea>
      </div>
      <?php foreach(['a'=>'A','b'=>'B','c'=>'C','d'=>'D'] as $k=>$v): ?>
      <div class="form-group">
        <label>Opsi <?= $v ?></label>
        <input type="text" name="opsi_<?= $k ?>" id="editOpsi<?= strtoupper($k) ?>" class="form-control" required>
      </div>
      <?php endforeach; ?>
      <div class="form-group">
        <label>Jawaban Benar</label>
        <select name="jawaban_benar" id="editAns" class="form-control">
          <option value="0">A</option><option value="1">B</option><option value="2">C</option><option value="3">D</option>
        </select>
      </div>
      <div class="form-group">
        <label>Penjelasan</label>
        <textarea name="penjelasan" id="editExpl" class="form-control"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="document.getElementById('modalEdit').classList.remove('show')">Batal</button>
        <button type="submit" class="btn btn-primary">Update Soal</button>
      </div>
    </form>
  </div>
</div>

<script>
function openEdit(row) {
  document.getElementById('editId').value    = row.id;
  document.getElementById('editLevel').value = row.tingkat_kesulitan;
  document.getElementById('editIcon').value  = row.icon;
  document.getElementById('editQ').value     = row.pertanyaan;
  document.getElementById('editOpsiA').value = row.opsi_a;
  document.getElementById('editOpsiB').value = row.opsi_b;
  document.getElementById('editOpsiC').value = row.opsi_c;
  document.getElementById('editOpsiD').value = row.opsi_d;
  document.getElementById('editAns').value   = row.jawaban_benar;
  document.getElementById('editExpl').value  = row.penjelasan || '';
  document.getElementById('modalEdit').classList.add('show');
}
</script>
</body>
</html>
