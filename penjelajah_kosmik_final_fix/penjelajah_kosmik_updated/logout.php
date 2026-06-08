<?php
/**
 * logout.php — Penjelajah Kosmik
 * Menghapus sesi server-side (jika ada) lalu mengarahkan ke login.php.
 */
session_start();
session_unset();
session_destroy();

// Hapus cookie remember-me jika ada
if (isset($_COOKIE['pk_remember'])) {
    setcookie('pk_remember', '', time() - 3600, '/');
}

header('Location: login.php');
exit;
?>
