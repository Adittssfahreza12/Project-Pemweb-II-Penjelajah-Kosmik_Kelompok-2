<?php
/**
 * kuis_api.php — Penjelajah Kosmik
 * Menyimpan hasil kuis dan detail jawaban ke database.
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
$tingkat_kesulitan = trim($body['tingkat_kesulitan'] ?? '');
$total_soal = isset($body['total_soal']) ? (int)$body['total_soal'] : 0;
$jawaban_benar = isset($body['jawaban_benar']) ? (int)$body['jawaban_benar'] : 0;
$jawaban_salah = isset($body['jawaban_salah']) ? (int)$body['jawaban_salah'] : 0;
$skor = isset($body['skor']) ? (int)$body['skor'] : 0;
$persentase = isset($body['persentase']) ? (float)$body['persentase'] : 0;
$details = isset($body['details']) && is_array($body['details']) ? $body['details'] : [];

$allowed_levels = ['mudah', 'sedang', 'sulit'];
if (!$user_id || !$tingkat_kesulitan || !in_array($tingkat_kesulitan, $allowed_levels, true)) {
    echo json_encode(['error' => 'FIELD_REQUIRED']);
    exit;
}

if ($total_soal <= 0) {
    $total_soal = count($details) ?: 10;
}

$stmt = $conn->prepare(
    "INSERT INTO hasil_kuis
     (user_id, tingkat_kesulitan, total_soal, jawaban_benar, jawaban_salah, skor, persentase)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param('isiiiid', $user_id, $tingkat_kesulitan, $total_soal, $jawaban_benar, $jawaban_salah, $skor, $persentase);

if (!$stmt->execute()) {
    echo json_encode(['error' => 'INSERT_FAILED', 'msg' => $stmt->error]);
    $stmt->close();
    $conn->close();
    exit;
}

$hasil_id = $conn->insert_id;
$stmt->close();

if (!empty($details)) {
    $detailStmt = $conn->prepare(
        "INSERT INTO detail_jawaban_kuis
         (hasil_kuis_id, nomor_soal, pertanyaan, jawaban_pilihan, jawaban_benar, adalah_benar, sisa_waktu)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    foreach ($details as $detail) {
        $nomor_soal = isset($detail['nomor_soal']) ? (int)$detail['nomor_soal'] : 0;
        $pertanyaan = trim($detail['pertanyaan'] ?? '');
        $jawaban_pilihan = isset($detail['jawaban_pilihan']) ? (int)$detail['jawaban_pilihan'] : 255;
        $jawaban_benar = isset($detail['jawaban_benar']) ? (int)$detail['jawaban_benar'] : 0;
        $adalah_benar = !empty($detail['adalah_benar']) ? 1 : 0;
        $sisa_waktu = isset($detail['sisa_waktu']) ? (int)$detail['sisa_waktu'] : 0;

        if (!$nomor_soal || !$pertanyaan) {
            continue;
        }

        $detailStmt->bind_param(
            'iisiiii',
            $hasil_id,
            $nomor_soal,
            $pertanyaan,
            $jawaban_pilihan,
            $jawaban_benar,
            $adalah_benar,
            $sisa_waktu
        );
        $detailStmt->execute();
    }

    $detailStmt->close();
}

echo json_encode([
    'success' => true,
    'hasil_id' => $hasil_id,
    'msg' => 'Hasil kuis tersimpan'
]);

$conn->close();
?>
