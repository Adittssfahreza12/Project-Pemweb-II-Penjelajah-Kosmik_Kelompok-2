<?php
// Dipanggil di awal setiap halaman admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
