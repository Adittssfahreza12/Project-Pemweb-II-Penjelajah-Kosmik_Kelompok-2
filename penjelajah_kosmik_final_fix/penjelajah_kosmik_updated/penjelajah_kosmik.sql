-- ============================================================
--  DATABASE : penjelajah_kosmik
--  Versi     : 1.0
--  Deskripsi : Database lengkap untuk website Penjelajah Kosmik
--              Mencakup: Users, Kuis, Kalkulator, Favorit
-- ============================================================

CREATE DATABASE IF NOT EXISTS `penjelajah_kosmik`
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE `penjelajah_kosmik`;

-- ============================================================
-- TABEL 1 : users
-- Menyimpan data akun pengguna (Login / Register)
-- ============================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id`           INT UNSIGNED     NOT NULL AUTO_INCREMENT,
  `nama_lengkap` VARCHAR(100)     NOT NULL COMMENT 'Nama lengkap pengguna',
  `username`     VARCHAR(50)      NOT NULL UNIQUE COMMENT 'Username unik untuk login',
  `password`     VARCHAR(255)     NOT NULL COMMENT 'Password ter-hash (bcrypt / password_hash PHP)',
  `role`         ENUM('user','admin') NOT NULL DEFAULT 'user',
  `created_at`   DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   DATETIME         NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Tabel akun pengguna – dipakai fitur Login & Register';

-- ============================================================
-- TABEL 2 : hasil_kuis
-- Menyimpan hasil/skor setiap kali pengguna menyelesaikan kuis
-- ============================================================
CREATE TABLE IF NOT EXISTS `hasil_kuis` (
    `id`                INT UNSIGNED                      NOT NULL AUTO_INCREMENT,
  `user_id`           INT UNSIGNED                      NOT NULL,
  `tingkat_kesulitan` ENUM('mudah','sedang','sulit')     NOT NULL COMMENT 'Level kuis yang dimainkan',
  `total_soal`        TINYINT UNSIGNED                  NOT NULL DEFAULT 10,
  `jawaban_benar`     TINYINT UNSIGNED                  NOT NULL DEFAULT 0,
  `jawaban_salah`     TINYINT UNSIGNED                  NOT NULL DEFAULT 0,
  `skor`              SMALLINT UNSIGNED                 NOT NULL DEFAULT 0 COMMENT 'Poin yang dikumpulkan (perhitungan berbasis waktu)',
  `persentase`        DECIMAL(5,2)                      NOT NULL DEFAULT 0.00 COMMENT 'Persen jawaban benar (0.00 – 100.00)',
  `waktu_main`        DATETIME                          NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Kapan kuis diselesaikan',
  PRIMARY KEY (`id`),
  KEY `fk_kuis_user` (`user_id`),
  KEY `idx_kuis_user_waktu` (`user_id`, `waktu_main`),
  CONSTRAINT `fk_kuis_user`
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Tabel riwayat & hasil kuis tata surya per pengguna';

-- ============================================================
-- TABEL 3 : detail_jawaban_kuis  (opsional – breakdown per soal)
-- Menyimpan detail jawaban setiap soal dalam satu sesi kuis
-- ============================================================
CREATE TABLE IF NOT EXISTS `detail_jawaban_kuis` (
    `id`              INT UNSIGNED   NOT NULL AUTO_INCREMENT,
  `hasil_kuis_id`   INT UNSIGNED   NOT NULL,
  `nomor_soal`      TINYINT UNSIGNED NOT NULL COMMENT 'Urutan soal ke-1 s/d ke-10',
  `pertanyaan`      TEXT           NOT NULL COMMENT 'Teks pertanyaan yang ditampilkan',
  `jawaban_pilihan` TINYINT UNSIGNED NOT NULL DEFAULT 255 COMMENT 'Indeks jawaban yang dipilih user (0–3, 255 jika timeout)',
  `jawaban_benar`   TINYINT UNSIGNED NOT NULL COMMENT 'Indeks jawaban yang benar (0–3)',
  `adalah_benar`    TINYINT(1)     NOT NULL DEFAULT 0 COMMENT '1 = benar, 0 = salah/timeout',
  `sisa_waktu`      TINYINT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Detik tersisa saat menjawab',
  PRIMARY KEY (`id`),
  KEY `fk_detail_hasil` (`hasil_kuis_id`),
  CONSTRAINT `fk_detail_hasil`
    FOREIGN KEY (`hasil_kuis_id`) REFERENCES `hasil_kuis`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Detail jawaban per soal dalam satu sesi kuis';

-- ============================================================
-- TABEL 4 : riwayat_kalkulator
-- Menyimpan setiap kali pengguna menghitung berat di planet
-- ============================================================
CREATE TABLE IF NOT EXISTS `riwayat_kalkulator` (
    `id`              INT UNSIGNED            NOT NULL AUTO_INCREMENT,
  `user_id`         INT UNSIGNED            NOT NULL,
  `berat_badan_kg`  DECIMAL(6,2)            NOT NULL COMMENT 'Berat badan input pengguna (kg)',
  `tinggi_badan_cm` SMALLINT UNSIGNED       NOT NULL COMMENT 'Tinggi badan input pengguna (cm)',
  `jenis_kelamin`   ENUM('pria','wanita')   NOT NULL,
  `bmi_bumi`        DECIMAL(5,2)            NOT NULL COMMENT 'BMI yang dihitung di Bumi',
  `kategori_bmi`    VARCHAR(30)             NOT NULL COMMENT 'Kurus / Normal / Gemuk / Obesitas',
  `dihitung_pada`   DATETIME                NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_kalk_user` (`user_id`),
  CONSTRAINT `fk_kalk_user`
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Riwayat perhitungan kalkulator planet per pengguna';

-- ============================================================
-- TABEL 5 : hasil_kalkulator_per_planet
-- Detail berat pengguna di setiap planet dalam satu sesi hitung
-- ============================================================
CREATE TABLE IF NOT EXISTS `hasil_kalkulator_per_planet` (
  `id`              INT UNSIGNED   NOT NULL AUTO_INCREMENT,
  `riwayat_id`      INT UNSIGNED   NOT NULL,
  `nama_planet`     VARCHAR(30)    NOT NULL COMMENT 'Merkurius, Venus, Bumi, dst.',
  `emoji_planet`    VARCHAR(10)    NOT NULL,
  `gravitasi`       DECIMAL(5,2)   NOT NULL COMMENT 'Gravitasi permukaan planet (m/s²)',
  `berat_di_planet` DECIMAL(8,2)   NOT NULL COMMENT 'Berat hasil perhitungan di planet tsb (kg)',
  PRIMARY KEY (`id`),
  KEY `fk_planet_riwayat` (`riwayat_id`),
  CONSTRAINT `fk_planet_riwayat`
    FOREIGN KEY (`riwayat_id`) REFERENCES `riwayat_kalkulator`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Berat pengguna di tiap planet dalam satu sesi kalkulator';

-- ============================================================
-- TABEL 6 : favorit_kosmik
-- Menyimpan item favorit pengguna (planet maupun fakta manual)
-- ============================================================
CREATE TABLE IF NOT EXISTS `favorit_kosmik` (
    `id`           INT UNSIGNED                 NOT NULL AUTO_INCREMENT,
  `user_id`      INT UNSIGNED                 NOT NULL,
  `kategori`     ENUM('planet','fakta')        NOT NULL COMMENT 'Jenis item favorit',
  `nama`         VARCHAR(100)                 NOT NULL COMMENT 'Nama planet atau judul fakta',
  `emoji`        VARCHAR(10)                  NOT NULL DEFAULT '⭐',
  `tipe`         VARCHAR(50)                  NULL     COMMENT 'Contoh: Planet Gas Raksasa',
  `isi`          TEXT                         NULL     COMMENT 'Deskripsi fakta (NULL jika planet)',
  -- kolom khusus planet (dari kalkulator)
  `berat_di_planet` DECIMAL(8,2)              NULL     COMMENT 'Berat user di planet tsb (kg)',
  `berat_di_bumi`   DECIMAL(8,2)              NULL     COMMENT 'Berat referensi di Bumi (kg)',
  `ditambahkan_pada` DATETIME                 NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_favorit_user` (`user_id`),
  KEY `idx_favorit_user_kat` (`user_id`, `kategori`),
  UNIQUE KEY `uq_favorit_user_kategori_nama` (`user_id`, `kategori`, `nama`),
  CONSTRAINT `fk_favorit_user`
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
  COMMENT='Koleksi favorit kosmik (planet & fakta) per pengguna';

-- ============================================================
-- DATA AWAL : Admin default
-- Password = "admin123" (hash bcrypt, ganti sesuai kebutuhan)
-- ============================================================
INSERT INTO `users` (`nama_lengkap`, `username`, `password`, `role`) VALUES
('Administrator', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- CATATAN: Hash di atas adalah contoh placeholder.
-- Hasilkan hash yang benar dengan: password_hash('admin123', PASSWORD_BCRYPT)

-- ============================================================
-- SELESAI
-- ============================================================
