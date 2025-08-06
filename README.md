# 📘 Sistem Absensi Sekolah - Front-End

Proyek ini merupakan antarmuka front-end untuk sistem absensi siswa berbasis web menggunakan **PHP** dan **Tailwind CSS**. Semua halaman sudah disiapkan agar dapat langsung diintegrasikan dengan backend dan database.

---

## 📁 Struktur File dan Fungsinya

| File                          | Fungsi                                                                                                |
| ----------------------------- | ----------------------------------------------------------------------------------------------------- |
| `dashboard.php`               | Halaman utama. Menampilkan data statistik siswa, absensi hari ini, dan grafik absensi dengan Chart.js |
| `data_siswa.php`              | Tabel untuk menampilkan data semua siswa. Siap diisi dari database                                    |
| `kelas_jurusan.php`           | Halaman dengan tab "Kelas" dan "Jurusan", dinamis tanpa reload                                        |
| `laporan.php`                 | Menampilkan data absensi berdasarkan dropdown bulan dan kelas                                         |
| `landing.php`                 | Form absensi siswa. Diakses dari tombol "Absen Siswa" di dashboard                                    |
| `sidebar.php`                 | Navigasi sidebar yang di-include di semua halaman utama                                               |
| `logout_modal.php`            | Modal logout dengan tombol "Iya" dan "Tidak"                                                          |
| `images-removebg-preview.png` | Logo sekolah untuk sidebar                                                                            |

---

## 💡 Fitur Utama

* 🔹 Layout responsif dengan Tailwind CSS (via CDN)
* 🔹 Statistik absensi menggunakan **Chart.js** (line chart)
* 🔹 Navigasi sidebar dengan highlight halaman aktif otomatis
* 🔹 Komponen modal konfirmasi logout universal
* 🔹 Dropdown untuk filter laporan absensi berdasarkan bulan dan kelas
* 🔹 Halaman input absensi siswa siap pakai

---

## 🔗 Integrasi Backend yang Dibutuhkan

| Bagian Front-End            | Integrasi Backend yang Diperlukan                                                      |
| --------------------------- | -------------------------------------------------------------------------------------- |
| Dashboard (`dashboard.php`) | Hitung jumlah siswa dan kelas dari DB. Kirim data absensi 10 hari terakhir ke Chart.js |
| Data Siswa                  | Ambil seluruh data siswa dari database dan tampilkan                                   |
| Kelas & Jurusan             | Ambil data berdasarkan tab yang aktif. Bisa pakai AJAX                                 |
| Laporan                     | Filter berdasarkan bulan & kelas. Ambil data dari DB sesuai pilihan                    |
| Absen Siswa                 | Terima input barcode/NIS dan proses absensi siswa secara real-time                     |
| Logout                      | Jalankan session destroy di backend jika klik "Iya" pada modal                         |

---

## 🔧 Cara Menjalankan (Front-End)

1. Pastikan Anda menjalankan project ini di local server (XAMPP, Laragon, dll.)
2. Tempatkan semua file di dalam folder proyek (misalnya `absensi/`)
3. Akses via browser seperti `http://localhost/absensi/dashboard.php`

---

## 📌 Catatan

* Semua halaman front-end **tidak mengandung proses database secara langsung**, hanya tampilan dan struktur HTML/CSS
* Komponen sidebar dan modal dibuat terpisah agar bisa digunakan ulang di semua halaman
* Semua halaman menggunakan **Tailwind CSS** dan **Chart.js** via CDN (tidak perlu instalasi tambahan)

---

## 👨‍💻 Developer Notes untuk Backend

* Untuk setiap bagian yang membutuhkan data, Anda bisa meletakkan query PHP langsung di dalam blok konten yang sesuai
* Semua halaman siap diberi logic `if ($_POST)` atau `if ($_GET)` tanpa konflik CSS/HTML
* Gunakan struktur include (`sidebar.php`, `logout_modal.php`) agar tidak perlu tulis ulang layout

---

## 🧠 Saran Pengembangan Lanjutan

* Autentikasi login dengan session
* Upload foto siswa & preview
* Laporan dalam format PDF atau cetak langsung
* Dashboard admin & pengguna berbeda

---

Silakan lanjutkan pengembangan backend dengan struktur ini. Semua file sudah siap pakai dan konsisten.

Sip
