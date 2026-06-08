<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<header class="navbar">
  <a href="home.php" class="navbar-logo">
    🌌 Penjelajah Kosmik
  </a>

  <nav class="navbar-links">
    <a href="home.php"          class="<?= $current_page === 'home.php'         ? 'active' : '' ?>">Beranda</a>
    <a href="planet.php"        class="<?= $current_page === 'planet.php'       ? 'active' : '' ?>">Daftar Planet</a>   
    <a href="orbit.php"         class="<?= $current_page === 'orbit.php'        ? 'active' : '' ?>">Simulasi Orbit</a>
    <a href="funzone.php"       class="<?= $current_page === 'funzone.php'      ? 'active' : '' ?>">Zona Edukasi</a>
    <a href="timeline.php"      class="<?= $current_page === 'timeline.php'     ? 'active' : '' ?>">Kronologi</a>
    <a href="kuis.php"          class="<?= $current_page === 'kuis.php'         ? 'active' : '' ?>">Kuis</a>
    <a href="kalkulator.php"    class="<?= $current_page === 'kalkulator.php'   ? 'active' : '' ?>">Kalkulator</a>
    <a href="favorit.php"       class="<?= $current_page === 'favorit.php'      ? 'active' : '' ?>">⭐ Favorit</a>
    <a href="#" onclick="doLogout()" class="navbar-login">🚪 Logout</a>
  </nav>

  <button class="navbar-hamburger" id="navHamburger" aria-label="Toggle menu">
    <span></span>
    <span></span>
    <span></span>
  </button>
</header>

<script>
function doLogout() {
  sessionStorage.removeItem('pk_user');
  localStorage.removeItem('pk_remember');
  window.location.href = 'login.php';
}
</script>
