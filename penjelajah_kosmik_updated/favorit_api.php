<?php
/**
 * favorit_api.php — Penjelajah Kosmik
 * Endpoint REST-JSON untuk operasi favorit planet di database.
 * Actions: add, remove, check, list
 *
 * Semua request via POST dengan body JSON: { action, user_id, ... }
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

// ── Koneksi MySQL ────────────────────────────────────────────
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'DB_CONNECTION_FAILED', 'msg' => $conn->connect_error]);
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

$action  = $body['action'];
$user_id = isset($body['user_id']) ? (int)$body['user_id'] : 0;

if (!$user_id) {
    http_response_code(401);
    echo json_encode(['error' => 'UNAUTHORIZED', 'msg' => 'user_id diperlukan']);
    exit;
}

switch ($action) {

    // ── ADD PLANET FAVORIT ────────────────────────────────────
    case 'add':
        $nama  = $conn->real_escape_string(trim($body['nama']  ?? ''));
        $emoji = $conn->real_escape_string(trim($body['emoji'] ?? '⭐'));
        $tipe  = $conn->real_escape_string(trim($body['tipe']  ?? 'Planet'));
        $isi   = isset($body['isi']) ? $conn->real_escape_string(trim($body['isi'])) : null;

        if (!$nama) {
            echo json_encode(['error' => 'NAMA_KOSONG']);
            exit;
        }

        // Cek apakah sudah ada
        $cek = $conn->query("SELECT id FROM favorit_kosmik WHERE user_id = $user_id AND kategori = 'planet' AND nama = '$nama' LIMIT 1");
        if ($cek && $cek->num_rows > 0) {
            echo json_encode(['success' => false, 'msg' => 'Sudah ada di favorit', 'exists' => true]);
            exit;
        }

        $isi_val = $isi ? "'$isi'" : 'NULL';

        $sql = "INSERT INTO favorit_kosmik (user_id, kategori, nama, emoji, tipe, isi)
                VALUES ($user_id, 'planet', '$nama', '$emoji', '$tipe', $isi_val)";

        if ($conn->query($sql)) {
            echo json_encode(['success' => true, 'id' => $conn->insert_id, 'msg' => "$nama berhasil disimpan ke favorit!"]);
        } else {
            echo json_encode(['error' => 'INSERT_FAILED', 'msg' => $conn->error]);
        }
        break;

    // ── REMOVE PLANET FAVORIT ─────────────────────────────────
    case 'remove':
        $nama = $conn->real_escape_string(trim($body['nama'] ?? ''));
        if (!$nama) {
            echo json_encode(['error' => 'NAMA_KOSONG']);
            exit;
        }

        $sql = "DELETE FROM favorit_kosmik WHERE user_id = $user_id AND kategori = 'planet' AND nama = '$nama' LIMIT 1";
        if ($conn->query($sql)) {
            $removed = $conn->affected_rows > 0;
            echo json_encode(['success' => true, 'removed' => $removed, 'msg' => "$nama dihapus dari favorit"]);
        } else {
            echo json_encode(['error' => 'DELETE_FAILED', 'msg' => $conn->error]);
        }
        break;

    // ── CHECK STATUS FAVORIT ──────────────────────────────────
    case 'check':
        $nama = $conn->real_escape_string(trim($body['nama'] ?? ''));
        if (!$nama) {
            echo json_encode(['error' => 'NAMA_KOSONG']);
            exit;
        }

        $res = $conn->query("SELECT id FROM favorit_kosmik WHERE user_id = $user_id AND kategori = 'planet' AND nama = '$nama' LIMIT 1");
        $isFav = ($res && $res->num_rows > 0);
        echo json_encode(['success' => true, 'is_favorit' => $isFav]);
        break;

    // ── LIST SEMUA FAVORIT USER ───────────────────────────────
    case 'list':
        $res = $conn->query(
            "SELECT id, kategori, nama, emoji, tipe, isi, berat_di_planet, berat_di_bumi,
                    DATE_FORMAT(ditambahkan_pada, '%d %M %Y') AS tanggal
             FROM favorit_kosmik
             WHERE user_id = $user_id
             ORDER BY ditambahkan_pada DESC"
        );

        $favs = [];
        while ($row = $res->fetch_assoc()) {
            $favs[] = $row;
        }
        echo json_encode(['success' => true, 'data' => $favs, 'total' => count($favs)]);
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'UNKNOWN_ACTION']);
        break;
}

$conn->close();
?>
