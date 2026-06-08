-- ================================================================
--  DATABASE   : penjelajah_kosmik
--  Versi      : 2.0 (Final & Lengkap)
--  Dibuat     : Disesuaikan penuh dengan kode proyek website
--               Penjelajah Kosmik (PHP + JavaScript)
--
--  DESKRIPSI FITUR YANG DICAKUP :
--    1. Login / Daftar Pengguna  → Tabel: users, sesi_login
--    2. Kuis Tata Surya           → Tabel: hasil_kuis, detail_jawaban_kuis
--    3. Kalkulator Planet         → Tabel: riwayat_kalkulator,
--                                           hasil_kalkulator_per_planet
--    4. Favorit Kosmikku          → Tabel: favorit_kosmik
--
--  FILE YANG MENGGUNAKAN DATABASE INI :
--    config.php        → Konfigurasi koneksi (host, user, pass, dbname)
--    auth_api.php      → Fitur login, register, reset_password
--    favorit_api.php   → Fitur add, remove, check, list favorit
--    db.js             → Layer abstraksi JS untuk memanggil auth_api.php
--    kuis.js           → Logika kuis & hasil skor
--    kalkulator.js     → Kalkulasi berat di planet & BMI
--    favorit.js        → Sync favorit DB ↔ localStorage
--
--  CARA IMPORT :
--    Melalui phpMyAdmin : Import → pilih file .sql ini → Go
--    Melalui terminal   : mysql -u root -p < penjelajah_kosmik_database.sql
-- ================================================================

-- ----------------------------------------------------------------
-- Buat database (jika belum ada) & pilih database
-- ----------------------------------------------------------------
CREATE DATABASE IF NOT EXISTS `penjelajah_kosmik`
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE `penjelajah_kosmik`;

-- ================================================================
-- TABEL 1 : users
-- ----------------------------------------------------------------
-- Menyimpan data akun semua pengguna website.
-- Dipakai oleh  : auth_api.php  (action: login, register, reset_password)
--                 db.js         (fungsi: login, register, resetPassword)
--
-- Kolom penting :
--   username    → unik, dipakai sebagai kredensial login
--   password    → di-hash bcrypt via password_hash() PHP
--   role        → 'user' (default) atau 'admin'
--   nama_lengkap→ ditampilkan di navbar setelah login
-- ================================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id`            INT UNSIGNED         NOT NULL AUTO_INCREMENT          COMMENT 'Primary key, ID unik pengguna',
  `nama_lengkap`  VARCHAR(100)         NOT NULL                         COMMENT 'Nama lengkap pengguna (ditampilkan di navbar)',
  `username`      VARCHAR(50)          NOT NULL                         COMMENT 'Username unik untuk login',
  `password`      VARCHAR(255)         NOT NULL                         COMMENT 'Password ter-hash menggunakan bcrypt (password_hash PHP)',
  `role`          ENUM('user','admin') NOT NULL DEFAULT 'user'          COMMENT 'Hak akses: user = pengguna biasa, admin = administrator',
  `created_at`    DATETIME             NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Waktu akun dibuat (register)',
  `updated_at`    DATETIME             NOT NULL DEFAULT CURRENT_TIMESTAMP
                                        ON UPDATE CURRENT_TIMESTAMP     COMMENT 'Waktu terakhir data akun diperbarui',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_username` (`username`)
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Tabel akun pengguna – dipakai fitur Login & Register';


-- ================================================================
-- TABEL 2 : sesi_login
-- ----------------------------------------------------------------
-- Menyimpan token sesi untuk fitur "Ingat Saya" (opsional).
-- Referensi kode : db.js → setSession / getSession (sessionStorage),
--                  logout.php → menghapus sesi.
--
-- Kolom penting :
--   token       → string acak unik, disimpan di cookie browser
--   expired_at  → batas waktu token (contoh: 30 hari ke depan)
-- ================================================================
CREATE TABLE IF NOT EXISTS `sesi_login` (
  `id`          INT UNSIGNED  NOT NULL AUTO_INCREMENT          COMMENT 'Primary key sesi',
  `user_id`     INT UNSIGNED  NOT NULL                         COMMENT 'FK ke users.id – pemilik sesi ini',
  `token`       VARCHAR(255)  NOT NULL                         COMMENT 'Token acak unik yang disimpan di cookie browser',
  `expired_at`  DATETIME      NOT NULL                         COMMENT 'Waktu kadaluarsa token sesi',
  `created_at`  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Waktu token dibuat',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_token` (`token`),
  KEY `idx_sesi_user` (`user_id`),
  KEY `idx_sesi_expired` (`expired_at`),
  CONSTRAINT `fk_sesi_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Tabel sesi login – dipakai fitur Ingat Saya (opsional)';


-- ================================================================
-- TABEL 3 : hasil_kuis
-- ----------------------------------------------------------------
-- Menyimpan ringkasan/skor setiap kali pengguna menyelesaikan kuis.
-- Referensi kode : kuis.js
--   → fungsi showResults()  : correctCount, wrongCount, score, pct
--   → variabel              : currentDifficulty ('mudah'/'sedang'/'sulit')
--   → soal per sesi         : 10 soal (allQuestions[level].slice(0,10))
--   → timer per soal        : 15 detik (TIME_LIMIT = 15)
--   → poin                  : Math.ceil(timeLeft / TIME_LIMIT * 10)
--
-- Kolom penting :
--   tingkat_kesulitan → level kuis yang dipilih pengguna
--   skor              → total poin berbasis sisa waktu
--   persentase        → (jawaban_benar / total_soal) * 100
-- ================================================================
CREATE TABLE IF NOT EXISTS `hasil_kuis` (
  `id`                  INT UNSIGNED                   NOT NULL AUTO_INCREMENT  COMMENT 'Primary key sesi kuis',
  `user_id`             INT UNSIGNED                   NOT NULL                 COMMENT 'FK ke users.id – pengguna yang main kuis',
  `tingkat_kesulitan`   ENUM('mudah','sedang','sulit') NOT NULL                 COMMENT 'Level kuis yang dimainkan (sesuai kuis.js: currentDifficulty)',
  `total_soal`          TINYINT UNSIGNED               NOT NULL DEFAULT 10      COMMENT 'Jumlah soal dalam satu sesi (default 10 sesuai kuis.js)',
  `jawaban_benar`       TINYINT UNSIGNED               NOT NULL DEFAULT 0       COMMENT 'Jumlah jawaban benar (correctCount di kuis.js)',
  `jawaban_salah`       TINYINT UNSIGNED               NOT NULL DEFAULT 0       COMMENT 'Jumlah jawaban salah + timeout (wrongCount di kuis.js)',
  `skor`                SMALLINT UNSIGNED              NOT NULL DEFAULT 0       COMMENT 'Total poin terkumpul (score di kuis.js – berbasis sisa waktu)',
  `persentase`          DECIMAL(5,2)                   NOT NULL DEFAULT 0.00    COMMENT 'Persen jawaban benar: (jawaban_benar/total_soal)*100',
  `predikat`            VARCHAR(30)                    NULL                     COMMENT 'Predikat hasil: Luar Biasa/Hebat/Cukup Baik/Jangan Menyerah (dari kuis.js showResults)',
  `waktu_main`          DATETIME                       NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Waktu kuis diselesaikan',
  PRIMARY KEY (`id`),
  KEY `idx_kuis_user`        (`user_id`),
  KEY `idx_kuis_user_waktu`  (`user_id`, `waktu_main`),
  KEY `idx_kuis_level`       (`tingkat_kesulitan`),
  CONSTRAINT `fk_kuis_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Ringkasan hasil kuis tata surya per sesi per pengguna';


-- ================================================================
-- TABEL 4 : detail_jawaban_kuis
-- ----------------------------------------------------------------
-- Menyimpan detail jawaban tiap soal dalam satu sesi kuis.
-- Referensi kode : kuis.js
--   → selectAnswer(idx) : jawaban_pilihan = idx, jawaban_benar = q.ans
--   → timeExpired()     : adalah_benar = 0, sisa_waktu = 0
--   → TIME_LIMIT = 15   : sisa_waktu maksimal 15 detik
--   → q.q               : teks pertanyaan
--   → q.opts            : array pilihan jawaban
--
-- Kolom penting :
--   nomor_soal      → urutan 1–10
--   jawaban_pilihan → indeks opsi yang dipilih user (0–3), atau -1 jika timeout
--   jawaban_benar   → indeks opsi yang benar (q.ans di kuis.js)
--   adalah_benar    → 1 jika benar, 0 jika salah/timeout
--   sisa_waktu      → detik tersisa saat user menjawab (timeLeft)
-- ================================================================
CREATE TABLE IF NOT EXISTS `detail_jawaban_kuis` (
  `id`                INT UNSIGNED     NOT NULL AUTO_INCREMENT  COMMENT 'Primary key detail jawaban',
  `hasil_kuis_id`     INT UNSIGNED     NOT NULL                 COMMENT 'FK ke hasil_kuis.id – sesi kuis mana',
  `nomor_soal`        TINYINT UNSIGNED NOT NULL                 COMMENT 'Urutan soal ke-1 s/d ke-10 dalam sesi ini',
  `pertanyaan`        TEXT             NOT NULL                 COMMENT 'Teks pertanyaan yang ditampilkan (q.q dari kuis.js)',
  `opsi_jawaban`      JSON             NULL                     COMMENT 'Array 4 pilihan jawaban JSON (q.opts dari kuis.js)',
  `jawaban_pilihan`   TINYINT          NOT NULL DEFAULT -1      COMMENT 'Indeks opsi yang dipilih user (0–3), -1 jika timeout',
  `jawaban_benar`     TINYINT UNSIGNED NOT NULL                 COMMENT 'Indeks opsi yang benar (q.ans dari kuis.js)',
  `adalah_benar`      TINYINT(1)       NOT NULL DEFAULT 0       COMMENT '1 = jawaban benar, 0 = salah atau timeout',
  `sisa_waktu`        TINYINT UNSIGNED NOT NULL DEFAULT 0       COMMENT 'Detik sisa saat menjawab (timeLeft di kuis.js, 0–15)',
  `poin_didapat`      TINYINT UNSIGNED NOT NULL DEFAULT 0       COMMENT 'Poin yang didapat untuk soal ini (Math.ceil(timeLeft/15*10))',
  PRIMARY KEY (`id`),
  KEY `idx_detail_hasil`   (`hasil_kuis_id`),
  KEY `idx_detail_nomor`   (`hasil_kuis_id`, `nomor_soal`),
  CONSTRAINT `fk_detail_hasil`
    FOREIGN KEY (`hasil_kuis_id`)
    REFERENCES `hasil_kuis` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Detail jawaban per soal dalam satu sesi kuis';


-- ================================================================
-- TABEL 5 : riwayat_kalkulator
-- ----------------------------------------------------------------
-- Menyimpan setiap sesi perhitungan kalkulator planet.
-- Referensi kode : kalkulator.js
--   → calculate()        : userWeight, userHeight, gender, bmi, bmiCat
--   → getBMICategory()   : Kurus (<18.5), Normal (<25), Gemuk (<30), Obesitas (≥30)
--   → setGender()        : 'pria' atau 'wanita'
--   → adjustValue()      : input berat (1–300 kg), tinggi (50–300 cm)
--
-- Kolom penting :
--   berat_badan_kg  → input dari weightInput (userWeight)
--   tinggi_badan_cm → input dari heightInput (userHeight)
--   bmi_bumi        → (berat / (tinggi/100)²) dibulatkan 1 desimal
--   kategori_bmi    → hasil getBMICategory() : Kurus/Normal/Gemuk/Obesitas
-- ================================================================
CREATE TABLE IF NOT EXISTS `riwayat_kalkulator` (
  `id`               INT UNSIGNED          NOT NULL AUTO_INCREMENT  COMMENT 'Primary key sesi kalkulator',
  `user_id`          INT UNSIGNED          NOT NULL                 COMMENT 'FK ke users.id – pengguna yang menghitung',
  `berat_badan_kg`   DECIMAL(6,2)          NOT NULL                 COMMENT 'Berat badan input user dalam kg (1–300)',
  `tinggi_badan_cm`  SMALLINT UNSIGNED     NOT NULL                 COMMENT 'Tinggi badan input user dalam cm (50–300)',
  `jenis_kelamin`    ENUM('pria','wanita') NOT NULL                 COMMENT 'Gender yang dipilih (setGender() di kalkulator.js)',
  `bmi_bumi`         DECIMAL(5,2)          NOT NULL                 COMMENT 'Nilai BMI dihitung di Bumi (berat / tinggiM²)',
  `kategori_bmi`     VARCHAR(30)           NOT NULL                 COMMENT 'Kategori BMI: Kurus / Normal / Gemuk / Obesitas',
  `dihitung_pada`    DATETIME              NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Waktu pengguna menekan tombol Hitung',
  PRIMARY KEY (`id`),
  KEY `idx_kalk_user`        (`user_id`),
  KEY `idx_kalk_user_waktu`  (`user_id`, `dihitung_pada`),
  CONSTRAINT `fk_kalk_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Riwayat sesi perhitungan kalkulator planet per pengguna';


-- ================================================================
-- TABEL 6 : hasil_kalkulator_per_planet
-- ----------------------------------------------------------------
-- Detail berat pengguna di setiap planet dalam satu sesi hitung.
-- Referensi kode : kalkulator.js
--   → konstanta planets[] : 10 benda langit (Matahari s/d Neptunus)
--   → weightOnPlanet      : (userWeight * p.gravity / 9.81).toFixed(1)
--   → p.gravity           : gravitasi permukaan dalam m/s²
--   → p.emoji, p.type     : tampilan kartu planet
--
-- Data 10 planet dari kalkulator.js :
--   Matahari  (☀️, 274 m/s²)   | Merkurius (⚫, 3.7 m/s²)
--   Venus     (🟡, 8.87 m/s²)  | Bumi      (🌍, 9.81 m/s²)
--   Bulan     (🌕, 1.62 m/s²)  | Mars      (🔴, 3.72 m/s²)
--   Jupiter   (🟠, 24.79 m/s²) | Saturnus  (🪐, 10.44 m/s²)
--   Uranus    (🔵, 8.69 m/s²)  | Neptunus  (💙, 11.15 m/s²)
-- ================================================================
CREATE TABLE IF NOT EXISTS `hasil_kalkulator_per_planet` (
  `id`               INT UNSIGNED  NOT NULL AUTO_INCREMENT  COMMENT 'Primary key baris hasil planet',
  `riwayat_id`       INT UNSIGNED  NOT NULL                 COMMENT 'FK ke riwayat_kalkulator.id – sesi kalkulator mana',
  `nama_planet`      VARCHAR(30)   NOT NULL                 COMMENT 'Nama benda langit (p.name di kalkulator.js)',
  `emoji_planet`     VARCHAR(10)   NOT NULL                 COMMENT 'Emoji planet (p.emoji di kalkulator.js)',
  `tipe_planet`      VARCHAR(50)   NOT NULL                 COMMENT 'Jenis benda langit (p.type di kalkulator.js)',
  `gravitasi`        DECIMAL(7,2)  NOT NULL                 COMMENT 'Gravitasi permukaan planet dalam m/s² (p.gravity)',
  `gravitasi_relatif` DECIMAL(5,2) NOT NULL                 COMMENT 'Gravitasi relatif terhadap Bumi (p.gravityRel)',
  `berat_di_planet`  DECIMAL(8,2)  NOT NULL                 COMMENT 'Hasil perhitungan berat user di planet ini (kg)',
  PRIMARY KEY (`id`),
  KEY `idx_planet_riwayat`  (`riwayat_id`),
  KEY `idx_planet_nama`     (`nama_planet`),
  CONSTRAINT `fk_planet_riwayat`
    FOREIGN KEY (`riwayat_id`)
    REFERENCES `riwayat_kalkulator` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Berat pengguna di tiap planet dalam satu sesi kalkulator';


-- ================================================================
-- TABEL 7 : favorit_kosmik
-- ================================================================
-- Menyimpan koleksi favorit pengguna: planet (dari kalkulator)
-- dan fakta kosmik (manual dari halaman favorit).
--
-- Referensi kode :
--   favorit_api.php  → action: add, remove, check, list
--   favorit.js       → syncFromDB(), addManualFact(), removeFav()
--   kalkulator.js    → toggleFavFromCalc() : kategori = 'planet'
--   favorit.php      → Halaman tampilan koleksi favorit
--
-- Perbedaan kategori :
--   'planet' → ditambahkan dari kalkulator via toggleFavFromCalc()
--              kolom berat_di_planet & berat_di_bumi terisi
--              disimpan ke DB via favorit_api.php (add/remove)
--   'fakta'  → ditambahkan manual dari favorit.php via addManualFact()
--              kolom isi terisi, berat NULL
--              saat ini disimpan di localStorage (bisa dikembangkan ke DB)
--
-- Kolom penting (dari query di favorit_api.php) :
--   kategori, nama, emoji, tipe, isi, berat_di_planet, berat_di_bumi
--   DATE_FORMAT(ditambahkan_pada, '%d %M %Y') AS tanggal
-- ================================================================
CREATE TABLE IF NOT EXISTS `favorit_kosmik` (
  `id`                INT UNSIGNED              NOT NULL AUTO_INCREMENT  COMMENT 'Primary key item favorit',
  `user_id`           INT UNSIGNED              NOT NULL                 COMMENT 'FK ke users.id – pemilik favorit ini',
  `kategori`          ENUM('planet','fakta')    NOT NULL                 COMMENT 'Jenis favorit: planet (dari kalkulator) atau fakta (manual)',
  `nama`              VARCHAR(100)              NOT NULL                 COMMENT 'Nama planet atau judul fakta kosmik',
  `emoji`             VARCHAR(10)               NOT NULL DEFAULT '⭐'    COMMENT 'Emoji representasi (p.emoji / factEmojiInput)',
  `tipe`              VARCHAR(50)               NULL                     COMMENT 'Tipe benda (p.type): Planet Gas Raksasa, Planet Terestrial, dll.',
  `isi`               TEXT                      NULL                     COMMENT 'Isi/deskripsi fakta kosmik (NULL jika kategori planet)',
  -- Kolom khusus untuk favorit planet (dari kalkulator)
  `berat_di_planet`   DECIMAL(8,2)              NULL                     COMMENT 'Berat user di planet ini dalam kg (weightOnPlanet)',
  `berat_di_bumi`     DECIMAL(8,2)              NULL                     COMMENT 'Berat referensi user di Bumi dalam kg (weightOnEarth)',
  `ditambahkan_pada`  DATETIME                  NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Waktu item ditambahkan ke favorit',
  PRIMARY KEY (`id`),
  KEY `idx_favorit_user`     (`user_id`),
  KEY `idx_favorit_kategori` (`user_id`, `kategori`),
  KEY `idx_favorit_nama`     (`user_id`, `nama`),
  CONSTRAINT `fk_favorit_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_unicode_ci
  COMMENT='Koleksi favorit kosmik (planet & fakta) per pengguna';


-- ================================================================
-- DATA AWAL (SEED DATA)
-- ================================================================

-- ----------------------------------------------------------------
-- Akun Admin Default
-- ----------------------------------------------------------------
-- Username : admin
-- Password : admin123
-- PENTING  : Ganti hash ini dengan hasil PHP di server kamu:
--            echo password_hash('admin123', PASSWORD_BCRYPT);
-- ----------------------------------------------------------------
INSERT INTO `users` (`nama_lengkap`, `username`, `password`, `role`)
VALUES (
  'Administrator',
  'admin',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
  'admin'
);

-- ----------------------------------------------------------------
-- Akun Pengguna Contoh (untuk testing)
-- ----------------------------------------------------------------
-- Username : kosmik_explorer
-- Password : explorer123
-- ----------------------------------------------------------------
INSERT INTO `users` (`nama_lengkap`, `username`, `password`, `role`)
VALUES (
  'Penjelajah Kosmik',
  'kosmik_explorer',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
  'user'
);

-- ----------------------------------------------------------------
-- Contoh data hasil kuis (untuk pengguna ID 2 = kosmik_explorer)
-- ----------------------------------------------------------------
INSERT INTO `hasil_kuis`
  (`user_id`, `tingkat_kesulitan`, `total_soal`, `jawaban_benar`, `jawaban_salah`, `skor`, `persentase`, `predikat`)
VALUES
  (2, 'mudah',  10,  9, 1,  82, 90.00, 'Luar Biasa!'),
  (2, 'sedang', 10,  7, 3,  61, 70.00, 'Hebat!'),
  (2, 'sulit',  10,  5, 5,  44, 50.00, 'Cukup Baik!');

-- ----------------------------------------------------------------
-- Contoh data riwayat kalkulator (untuk pengguna ID 2)
-- ----------------------------------------------------------------
INSERT INTO `riwayat_kalkulator`
  (`user_id`, `berat_badan_kg`, `tinggi_badan_cm`, `jenis_kelamin`, `bmi_bumi`, `kategori_bmi`)
VALUES
  (2, 65.00, 170, 'pria', 22.49, 'Normal');

-- ----------------------------------------------------------------
-- Contoh hasil kalkulator per planet (untuk riwayat ID 1)
-- (Berdasarkan berat 65 kg, gravitasi dari kalkulator.js)
-- ----------------------------------------------------------------
INSERT INTO `hasil_kalkulator_per_planet`
  (`riwayat_id`, `nama_planet`, `emoji_planet`, `tipe_planet`, `gravitasi`, `gravitasi_relatif`, `berat_di_planet`)
VALUES
  (1, 'Matahari',  '☀️',  'Bintang',            274.00, 27.97, 1814.91),
  (1, 'Merkurius', '⚫',  'Planet Terestrial',    3.70,  0.38,   24.50),
  (1, 'Venus',     '🟡',  'Planet Terestrial',    8.87,  0.91,   58.75),
  (1, 'Bumi',      '🌍',  'Planet Terestrial',    9.81,  1.00,   65.00),
  (1, 'Bulan',     '🌕',  'Satelit Bumi',         1.62,  0.17,   10.73),
  (1, 'Mars',      '🔴',  'Planet Terestrial',    3.72,  0.38,   24.64),
  (1, 'Jupiter',   '🟠',  'Planet Gas Raksasa',  24.79,  2.53,  164.17),
  (1, 'Saturnus',  '🪐',  'Planet Gas Raksasa',  10.44,  1.07,   69.14),
  (1, 'Uranus',    '🔵',  'Planet Es Raksasa',    8.69,  0.89,   57.54),
  (1, 'Neptunus',  '💙',  'Planet Es Raksasa',   11.15,  1.14,   73.84);

-- ----------------------------------------------------------------
-- Contoh data favorit planet (untuk pengguna ID 2)
-- ----------------------------------------------------------------
INSERT INTO `favorit_kosmik`
  (`user_id`, `kategori`, `nama`, `emoji`, `tipe`, `isi`, `berat_di_planet`, `berat_di_bumi`)
VALUES
  (2, 'planet', 'Saturnus', '🪐', 'Planet Gas Raksasa', NULL, 69.14, 65.00),
  (2, 'planet', 'Mars',     '🔴', 'Planet Terestrial',  NULL, 24.64, 65.00),
  (2, 'fakta',  'Fakta Bima Sakti', '🌌', 'Fakta Kosmik',
   'Galaksi Bima Sakti diperkirakan memiliki 100–400 miliar bintang dan berdiameter sekitar 100.000 tahun cahaya.',
   NULL, NULL);


-- ================================================================
-- RINGKASAN STRUKTUR DATABASE
-- ================================================================
--
--  ┌─────────────────────────────────────────────────────────┐
--  │              DIAGRAM RELASI ANTAR TABEL                 │
--  ├─────────────────────────────────────────────────────────┤
--  │                                                         │
--  │   users (id) ──────┬──── sesi_login (user_id)          │
--  │                    │                                    │
--  │                    ├──── hasil_kuis (user_id)           │
--  │                    │         └── detail_jawaban_kuis    │
--  │                    │              (hasil_kuis_id)       │
--  │                    │                                    │
--  │                    ├──── riwayat_kalkulator (user_id)   │
--  │                    │         └── hasil_kalkulator_       │
--  │                    │              per_planet             │
--  │                    │              (riwayat_id)           │
--  │                    │                                    │
--  │                    └──── favorit_kosmik (user_id)       │
--  │                                                         │
--  └─────────────────────────────────────────────────────────┘
--
--  Total Tabel    : 7 tabel
--  Total Kolom    : ±55 kolom keseluruhan
--  Relasi FK      : 6 Foreign Key (semua CASCADE DELETE + UPDATE)
--  Data Awal      : 2 user + 3 hasil kuis + 1 riwayat kalkulator
--                   10 hasil per planet + 3 item favorit
--
-- ================================================================
-- SELESAI — penjelajah_kosmik_database.sql v2.0
-- ================================================================
