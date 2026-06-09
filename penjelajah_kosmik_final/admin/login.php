<?php
session_start();
require_once '../config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    $conn->set_charset('utf8mb4');

    $stmt = $conn->prepare("SELECT id, nama_lengkap, password, role FROM users WHERE username = ? LIMIT 1");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res  = $stmt->get_result();
    $user = $res->fetch_assoc();
    $stmt->close();
    $conn->close();

    if ($user && $user['role'] === 'admin' && password_verify($password, $user['password'])) {
        $_SESSION['admin_id']   = $user['id'];
        $_SESSION['admin_nama'] = $user['nama_lengkap'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Username atau password salah, atau bukan akun admin!';
    }
}

// Jika sudah login redirect
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin — Penjelajah Kosmik</title>
  <link rel="stylesheet" href="css/admin.css">
  <style>
    body { display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    .login-box {
      width: 100%; max-width: 400px;
      background: var(--color-bg-card);
      border: 1px solid var(--color-border);
      border-radius: 16px;
      padding: 36px;
    }
    .login-logo { text-align: center; margin-bottom: 28px; }
    .login-logo .icon { font-size: 2.5rem; }
    .login-logo h1 { font-family: var(--font-heading); font-size: 1.3rem; color: var(--color-accent); margin-top: 8px; }
    .login-logo p { font-size: 0.85rem; color: var(--color-text-muted); }
    .error-msg { background: rgba(232,91,91,0.12); border: 1px solid rgba(232,91,91,0.3); color: #e85b5b; padding: 10px 14px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 16px; }
    .btn-block { width: 100%; justify-content: center; padding: 12px; font-size: 0.95rem; }
  </style>
</head>
<body>
  <div class="login-box">
    <div class="login-logo">
      <div class="icon">🛸</div>
      <h1>Panel Admin</h1>
      <p>Penjelajah Kosmik</p>
    </div>

    <?php if ($error): ?>
      <div class="error-msg"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label>Username Admin</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>
      <button type="submit" class="btn btn-primary btn-block">🔐 Login sebagai Admin</button>
    </form>

    <div style="text-align:center; margin-top:20px;">
      <a href="../login.php" style="font-size:0.82rem; color:var(--color-text-muted);">← Kembali ke halaman utama</a>
    </div>
  </div>
</body>
</html>
