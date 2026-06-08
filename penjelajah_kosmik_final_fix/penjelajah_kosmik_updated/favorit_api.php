<?php
/**
 * favorit_api.php — Penjelajah Kosmik
 * Endpoint REST-JSON untuk operasi favorit kosmik di database.
 * Actions: add, remove, remove_by_id, check, list, clear
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

function json_ok($payload = []) {
    echo json_encode(array_merge(['success' => true], $payload));
}

switch ($action) {

    // ── ADD FAVORIT ───────────────────────────────────────────
    case 'add':
        $kategori = strtolower(trim($body['kategori'] ?? 'planet'));
        if (!in_array($kategori, ['planet', 'fakta'], true)) {
            $kategori = 'planet';
        }

        $nama  = $conn->real_escape_string(trim($body['nama'] ?? ''));
        $emoji = $conn->real_escape_string(trim($body['emoji'] ?? '⭐'));
        $tipe  = $conn->real_escape_string(trim($body['tipe'] ?? ($kategori === 'fakta' ? 'Fakta Kosmik' : 'Planet')));
        $isi   = isset($body['isi']) ? $conn->real_escape_string(trim($body['isi'])) : null;

        $berat_di_planet = isset($body['berat_di_planet']) && $body['berat_di_planet'] !== ''
            ? (float)$body['berat_di_planet'] : null;
        $berat_di_bumi = isset($body['berat_di_bumi']) && $body['berat_di_bumi'] !== ''
            ? (float)$body['berat_di_bumi'] : null;

        if (!$nama) {
            echo json_encode(['error' => 'NAMA_KOSONG']);
            exit;
        }

        // Cek apakah sudah ada
        $cek = $conn->prepare("SELECT id FROM favorit_kosmik WHERE user_id = ? AND kategori = ? AND nama = ? LIMIT 1");
        $cek->bind_param('iss', $user_id, $kategori, $nama);
        $cek->execute();
        $cek->store_result();
        if ($cek->num_rows > 0) {
            $cek->close();
            echo json_encode(['success' => false, 'exists' => true, 'msg' => 'Sudah ada di favorit']);
            exit;
        }
        $cek->close();

        $stmt = $conn->prepare(
            "INSERT INTO favorit_kosmik
             (user_id, kategori, nama, emoji, tipe, isi, berat_di_planet, berat_di_bumi)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            'isssssdd',
            $user_id,
            $kategori,
            $nama,
            $emoji,
            $tipe,
            $isi,
            $berat_di_planet,
            $berat_di_bumi
        );

        if ($stmt->execute()) {
            json_ok(['id' => $conn->insert_id, 'msg' => "$nama berhasil disimpan ke favorit!"]);
        } else {
            echo json_encode(['error' => 'INSERT_FAILED', 'msg' => $stmt->error]);
        }
        $stmt->close();
        break;

    // ── REMOVE FAVORIT BY ID ──────────────────────────────────
    case 'remove_by_id':
        $id = isset($body['id']) ? (int)$body['id'] : 0;
        if (!$id) {
            echo json_encode(['error' => 'ID_KOSONG']);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM favorit_kosmik WHERE id = ? AND user_id = ? LIMIT 1");
        $stmt->bind_param('ii', $id, $user_id);
        if ($stmt->execute()) {
            json_ok(['removed' => $stmt->affected_rows > 0, 'msg' => 'Favorit berhasil dihapus']);
        } else {
            echo json_encode(['error' => 'DELETE_FAILED', 'msg' => $stmt->error]);
        }
        $stmt->close();
        break;

    // ── REMOVE FAVORIT BY NAME ────────────────────────────────
    case 'remove':
        $nama = $conn->real_escape_string(trim($body['nama'] ?? ''));
        $kategori = strtolower(trim($body['kategori'] ?? ''));
        if (!$nama) {
            echo json_encode(['error' => 'NAMA_KOSONG']);
            exit;
        }

        if ($kategori && in_array($kategori, ['planet', 'fakta'], true)) {
            $stmt = $conn->prepare("DELETE FROM favorit_kosmik WHERE user_id = ? AND kategori = ? AND nama = ? LIMIT 1");
            $stmt->bind_param('iss', $user_id, $kategori, $nama);
        } else {
            $stmt = $conn->prepare("DELETE FROM favorit_kosmik WHERE user_id = ? AND nama = ? LIMIT 1");
            $stmt->bind_param('is', $user_id, $nama);
        }

        if ($stmt->execute()) {
            json_ok(['removed' => $stmt->affected_rows > 0, 'msg' => "$nama dihapus dari favorit"]);
        } else {
            echo json_encode(['error' => 'DELETE_FAILED', 'msg' => $stmt->error]);
        }
        $stmt->close();
        break;

    // ── CHECK STATUS FAVORIT ──────────────────────────────────
    case 'check':
        $nama = $conn->real_escape_string(trim($body['nama'] ?? ''));
        $kategori = strtolower(trim($body['kategori'] ?? 'planet'));
        if (!$nama) {
            echo json_encode(['error' => 'NAMA_KOSONG']);
            exit;
        }

        $stmt = $conn->prepare("SELECT id FROM favorit_kosmik WHERE user_id = ? AND kategori = ? AND nama = ? LIMIT 1");
        $stmt->bind_param('iss', $user_id, $kategori, $nama);
        $stmt->execute();
        $res = $stmt->get_result();
        $isFav = ($res && $res->num_rows > 0);
        $stmt->close();

        json_ok(['is_favorit' => $isFav]);
        break;

    // ── LIST SEMUA FAVORIT USER ───────────────────────────────
    case 'list':
        $stmt = $conn->prepare(
            "SELECT id, kategori, nama, emoji, tipe, isi, berat_di_planet, berat_di_bumi,
                    DATE_FORMAT(ditambahkan_pada, '%d %M %Y') AS tanggal
             FROM favorit_kosmik
             WHERE user_id = ?
             ORDER BY ditambahkan_pada DESC"
        );
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        $favs = [];
        while ($row = $res->fetch_assoc()) {
            $favs[] = $row;
        }
        $stmt->close();

        json_ok(['data' => $favs, 'total' => count($favs)]);
        break;

    // ── CLEAR SEMUA FAVORIT ────────────────────────────────────
    case 'clear':
        $stmt = $conn->prepare("DELETE FROM favorit_kosmik WHERE user_id = ?");
        $stmt->bind_param('i', $user_id);
        if ($stmt->execute()) {
            json_ok(['cleared' => true, 'msg' => 'Semua favorit dihapus']);
        } else {
            echo json_encode(['error' => 'DELETE_FAILED', 'msg' => $stmt->error]);
        }
        $stmt->close();
        break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'UNKNOWN_ACTION']);
        break;
}

$conn->close();
?>
