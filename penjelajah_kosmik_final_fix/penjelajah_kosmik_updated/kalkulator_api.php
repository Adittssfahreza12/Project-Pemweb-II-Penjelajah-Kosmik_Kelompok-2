<?php
/**
 * kalkulator_api.php — Penjelajah Kosmik
 * Menyimpan riwayat kalkulator planet ke database.
 * Action: save
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'config.php';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'DB_CONNECTION_FAILED', 'msg' => $conn->connect_error]);
    exit;
}
$conn->set_charset('utf8mb4');

$body = json_decode(file_get_contents('php://input'), true);
if (!$body || !isset($body['action'])) {
    http_response_code(400);
    echo json_encode(['error' => 'BAD_REQUEST']);
    exit;
}

if ($body['action'] !== 'save') {
    http_response_code(400);
    echo json_encode(['error' => 'UNKNOWN_ACTION']);
    exit;
}

$user_id = isset($body['user_id']) ? (int)$body['user_id'] : 0;
$berat_badan_kg = isset($body['berat_badan_kg']) ? (float)$body['berat_badan_kg'] : 0;
$tinggi_badan_cm = isset($body['tinggi_badan_cm']) ? (int)$body['tinggi_badan_cm'] : 0;
$jenis_kelamin = trim($body['jenis_kelamin'] ?? '');
$bmi_bumi = isset($body['bmi_bumi']) ? (float)$body['bmi_bumi'] : 0;
$kategori_bmi = trim($body['kategori_bmi'] ?? '');
$planet_results = isset($body['planet_results']) && is_array($body['planet_results']) ? $body['planet_results'] : [];

if (!$user_id || !$berat_badan_kg || !$tinggi_badan_cm || !$jenis_kelamin || !$kategori_bmi) {
    echo json_encode(['error' => 'FIELD_REQUIRED']);
    exit;
}

$allowed_gender = ['pria', 'wanita'];
if (!in_array($jenis_kelamin, $allowed_gender, true)) {
    echo json_encode(['error' => 'INVALID_GENDER']);
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO riwayat_kalkulator
     (user_id, berat_badan_kg, tinggi_badan_cm, jenis_kelamin, bmi_bumi, kategori_bmi)
     VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param('idisds', $user_id, $berat_badan_kg, $tinggi_badan_cm, $jenis_kelamin, $bmi_bumi, $kategori_bmi);

if (!$stmt->execute()) {
    echo json_encode(['error' => 'INSERT_FAILED', 'msg' => $stmt->error]);
    $stmt->close();
    $conn->close();
    exit;
}

$riwayat_id = $conn->insert_id;
$stmt->close();

if (!empty($planet_results)) {
    $detail = $conn->prepare(
        "INSERT INTO hasil_kalkulator_per_planet
         (riwayat_id, nama_planet, emoji_planet, gravitasi, berat_di_planet)
         VALUES (?, ?, ?, ?, ?)"
    );

    foreach ($planet_results as $planet) {
        $nama_planet = trim($planet['nama_planet'] ?? '');
        $emoji_planet = trim($planet['emoji_planet'] ?? '🪐');
        $gravitasi = isset($planet['gravitasi']) ? (float)$planet['gravitasi'] : 0;
        $berat_di_planet = isset($planet['berat_di_planet']) ? (float)$planet['berat_di_planet'] : 0;

        if (!$nama_planet) {
            continue;
        }

        $detail->bind_param('issdd', $riwayat_id, $nama_planet, $emoji_planet, $gravitasi, $berat_di_planet);
        $detail->execute();
    }

    $detail->close();
}

echo json_encode([
    'success' => true,
    'riwayat_id' => $riwayat_id,
    'msg' => 'Riwayat kalkulator tersimpan'
]);

$conn->close();
?>
