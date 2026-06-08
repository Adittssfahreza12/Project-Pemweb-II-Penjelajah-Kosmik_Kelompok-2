/**
 * db.js — Penjelajah Kosmik
 * Layer abstraksi database berbasis PHP API (fetch ke endpoint PHP).
 * Dipanggil oleh login.php untuk operasi: init, login, register, resetPassword, setSession.
 *
 * Semua operasi mengirim request ke auth_api.php yang bertugas
 * berkomunikasi dengan MySQL melalui config.php.
 */

const db = (() => {

  const API = 'auth_api.php';

  /* ── helpers ───────────────────────────────────────────── */
  async function _post(action, payload = {}) {
    const res = await fetch(API, {
      method : 'POST',
      headers: { 'Content-Type': 'application/json' },
      body   : JSON.stringify({ action, ...payload })
    });
    if (!res.ok) throw new Error('NETWORK_ERROR');
    const data = await res.json();
    if (data.error) throw new Error(data.error);
    return data;
  }

  /* ── public API ─────────────────────────────────────────── */

  /**
   * Inisialisasi — dipanggil saat DOMContentLoaded di login.php.
   * Cukup memastikan koneksi API bisa dijangkau.
   */
  async function init() {
    // Tidak ada tindakan khusus; koneksi dikelola sisi server.
    return true;
  }

  /**
   * Login pengguna.
   * @returns {object|null} Data user jika berhasil, null jika gagal.
   */
  async function login(username, password) {
    const data = await _post('login', { username, password });
    return data.user || null;
  }

  /**
   * Daftar pengguna baru.
   * Melempar error USERNAME_TAKEN jika username sudah dipakai.
   */
  async function register(nama_lengkap, username, password) {
    return await _post('register', { nama_lengkap, username, password });
  }

  /**
   * Reset password berdasarkan username.
   * Melempar error USER_NOT_FOUND atau CANNOT_RESET_ADMIN.
   */
  async function resetPassword(username, new_password) {
    return await _post('reset_password', { username, new_password });
  }

  /**
   * Simpan data sesi ke sessionStorage (diakses halaman lain).
   */
  function setSession(user) {
    sessionStorage.setItem('pk_user', JSON.stringify(user));
  }

  /**
   * Ambil data sesi user yang sedang login.
   * @returns {object|null}
   */
  function getSession() {
    const raw = sessionStorage.getItem('pk_user');
    return raw ? JSON.parse(raw) : null;
  }

  /**
   * Hapus sesi (Logout).
   */
  function clearSession() {
    sessionStorage.removeItem('pk_user');
  }

  return { init, login, register, resetPassword, setSession, getSession, clearSession };

})();
