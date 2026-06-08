<?php
/**
 * auth_api.php — Penjelajah Kosmik
 * Endpoint REST-JSON untuk operasi autentikasi:
 *   - login
 *   - register
 *   - reset_password
 *
 * Dipanggil oleh db.js (fetch POST dengan body JSON).
 */

header('Content-Type: application/json; charset=utf-8');

require_once 'config.php';

// ── Koneksi MySQL ────────────────────────────────────────────
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'DB_CONNECTION_FAILED']);
    exit;
}
$conn->set_charset('utf8mb4');

// ── Baca body JSON ────────────────────────────────────────────
$body = json_decode(file_get_contents('php://input'), true);
if (!$body || !isset($body['action'])) {
    http_response_code(400);
    echo json_encode(['error' => 'BAD_REQUEST']);
    exit;
}

$action = $body['action'];

// ── Router ────────────────────────────────────────────────────
switch ($action) {

    // ── LOGIN ──────────────────────────────────────────────────
    case 'login':
        $username = trim($body['username'] ?? '');
        $password = $body['password'] ?? '';

        if (!$username || !$password) {
            echo json_encode(['error' => 'FIELD_REQUIRED']);
            break;
        }

        $stmt = $conn->prepare(
            "SELECT id, nama_lengkap, username, password, role FROM users WHERE username = ? LIMIT 1"
        );
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $res  = $stmt->get_result();
        $user = $res->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password'])) {
            // Kembalikan data user (tanpa password)
            unset($user['password']);
            echo json_encode(['user' => $user]);
        } else {
            echo json_encode(['user' => null]);
        }
        break;

    // ── REGISTER ───────────────────────────────────────────────
    case 'register':
        $nama     = trim($body['nama_lengkap'] ?? '');
        $username = trim($body['username'] ?? '');
        $password = $body['password'] ?? '';

        if (!$nama || !$username || !$password) {
            echo json_encode(['error' => 'FIELD_REQUIRED']);
            break;
        }

        // Cek username sudah dipakai
        $chk = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
        $chk->bind_param('s', $username);
        $chk->execute();
        $chk->store_result();
        if ($chk->num_rows > 0) {
            $chk->close();
            echo json_encode(['error' => 'USERNAME_TAKEN']);
            break;
        }
        $chk->close();

        // Simpan user baru
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $ins  = $conn->prepare(
            "INSERT INTO users (nama_lengkap, username, password, role) VALUES (?, ?, ?, 'user')"
        );
        $ins->bind_param('sss', $nama, $username, $hash);
        if ($ins->execute()) {
            echo json_encode(['success' => true, 'user_id' => $conn->insert_id]);
        } else {
            echo json_encode(['error' => 'INSERT_FAILED']);
        }
        $ins->close();
        break;

    // ── RESET PASSWORD ─────────────────────────────────────────
    case 'reset_password':
        $username     = trim($body['username'] ?? '');
        $new_password = $body['new_password'] ?? '';

        if (!$username || !$new_password) {
            echo json_encode(['error' => 'FIELD_REQUIRED']);
            break;
        }

        // Cari user
        $find = $conn->prepare("SELECT id, role FROM users WHERE username = ? LIMIT 1");
        $find->bind_param('s', $username);
        $find->execute();
        $res  = $find->get_result();
        $user = $res->fetch_assoc();
        $find->close();

        if (!$user) {
            echo json_encode(['error' => 'USER_NOT_FOUND']);
            break;
        }
        if ($user['role'] === 'admin') {
            echo json_encode(['error' => 'CANNOT_RESET_ADMIN']);
            break;
        }

        $hash = password_hash($new_password, PASSWORD_BCRYPT);
        $upd  = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $upd->bind_param('si', $hash, $user['id']);
        if ($upd->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'UPDATE_FAILED']);
        }
        $upd->close();
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'UNKNOWN_ACTION']);
        break;
}

$conn->close();
?>
