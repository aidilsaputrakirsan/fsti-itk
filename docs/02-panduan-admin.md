# 02 – Panduan Admin (Pengelola Konten)

Panduan ini untuk PIC yang **mengisi dan memperbarui konten** website. Tidak perlu kemampuan pemrograman.

## Masuk ke panel admin

1. Buka `https://<domain-website>/login`
2. Masuk dengan email dan password yang diberikan Super Admin.
3. Setelah login, Anda masuk ke **Dashboard** (`/admin/dashboard`). Semua menu ada di sidebar kiri.

> Tidak ada halaman daftar akun publik. Kalau butuh akun baru, minta ke **Super Admin**.

## Peta menu admin → halaman publik

Gunakan tabel ini untuk mencari "kalau mau mengubah bagian X di website, saya edit di mana?".

| Menu admin | Sub-menu | Mengubah halaman publik |
|---|---|---|
| **Profil Fakultas** | Kelola Tentang Fakultas | `/profil/tentang`, `/profil/struktur-organisasi`, sebagian Beranda |
| | Kelola Civitas Akademika | `/profil/dosen`, `/profil/tenaga-kependidikan` |
| | Kelola Kerjasama | `/kerjasama` |
| | Kelola Kontak | `/kontak` dan **footer di semua halaman** |
| **Program Studi** | Kelola Program Studi | `/prodi/<nama-prodi>` dan menu navbar Program Studi |
| | Kelola Jurusan | Pengelompokan prodi per jurusan |
| **Kemahasiswaan** | Kelola Daftar Prestasi | `/prestasi` dan highlight di Beranda |
| | Kelola Portal Layanan | `/layanan-internal` |
| | Kelola Kegiatan | `/kegiatan-mahasiswa` |
| | Kelola Beasiswa | `/beasiswa` |
| | **Kelola Mitra KP/Magang** | `/mitra-kp-magang` |
| **Kelola Alumni** | Kelola Data Alumni | `/alumni` |
| | Kelola Testimoni Alumni | Testimoni alumni di halaman alumni/Beranda |
| **Informasi** | Kelola Agenda | `/agenda-fakultas` |
| | Kelola Berita | `/berita` dan Berita Terbaru di Beranda |
| | Kelola Kategori Berita | Kategori/filter di `/berita` |
| | Kelola Pengumuman | `/pengumuman` |
| **PPID** | Kelola Dokumen PPID, Kategori | `/ppid` |
| **Zona Integritas (ZI)** | Kelola Halaman ZI, Dokumen ZI | `/zona-integritas` |
| | Kelola Survei Kepuasan | `/survei-kepuasan` |
| **Riset** | Kelola Penelitian | `/penelitian` |
| | Kelola Pengabdian kepada Masyarakat | `/pengabdian` |
| **Kelola Akun Admin** _(Super Admin saja)_ | – | Tidak tampil di publik |

## Pola umum setiap menu

Hampir semua menu bekerja sama:

1. **Halaman daftar:** tabel data, kotak pencarian, tombol **Tambah**, serta **Edit** / **Hapus** di tiap baris.
2. **Form tambah/edit:** kolom bertanda <span style="color:red">*</span> wajib diisi. Kalau ada yang salah, pesan merah muncul di bawah kolomnya.
3. Setelah **Simpan**, Anda kembali ke daftar dengan notifikasi hijau.
4. **Hapus** selalu meminta konfirmasi dan **tidak bisa dibatalkan**.

**Aturan file upload** (logo, foto): JPG, PNG, atau WEBP, maksimal 2MB, kecuali disebut lain di form. Kompres gambar besar dulu supaya website tetap cepat.

**Berita:** status **Draft** belum tampil di publik, **Terbitkan** langsung tampil.

## Contoh: Kelola Mitra KP/Magang

Menu ini berisi daftar perusahaan/instansi tempat mahasiswa FSTI **pernah** melaksanakan Kerja Praktik atau Magang. Tujuannya sebagai referensi bagi mahasiswa yang sedang mencari tempat. Ini **bukan** daftar lowongan.

| Kolom | Keterangan |
|---|---|
| Nama Mitra * | Nama resmi, misalnya "PT Pertamina Hulu Indonesia" |
| Bidang Usaha * | Pilih dari saran yang muncul bila sudah ada, supaya filter publik tidak dobel (misalnya "Perbankan" vs "Bank") |
| Lokasi * | Kota/provinsi, misalnya "Balikpapan, Kalimantan Timur". Gunakan format yang sama untuk semua data |
| Jenis * | Kerja Praktik, Magang, atau KP & Magang. "KP & Magang" muncul di kedua filter publik |
| Prodi | Prodi yang mahasiswanya pernah KP/magang di sana. Dipakai untuk filter mahasiswa |
| Website, Logo | Opsional |
| Status | Hilangkan centang **Tampilkan di halaman publik** untuk menyembunyikan tanpa menghapus |

## Khusus Super Admin: mengelola akun

Menu **Kelola Akun Admin** hanya terlihat oleh Super Admin.

- **Tambah admin:** isi nama, email, dan password. Akun baru selalu berperan Admin biasa.
- **Edit:** ubah nama/email, atau isi password baru untuk reset password.
- **Hapus:** akun Super Admin tidak bisa dihapus, dan Anda tidak bisa menghapus akun sendiri.
- Saat pengelola berganti, **hapus akun pengelola lama** dan buatkan akun untuk yang baru. Jangan berbagi satu akun.

## Kalau ada masalah

| Gejala | Kemungkinan penyebab |
|---|---|
| Gambar tidak muncul setelah upload | File terlalu besar/format salah, atau masalah storage di server → hubungi PIC teknis |
| Muncul halaman "403" | Menu tersebut khusus Super Admin |
| Muncul halaman "419 Page Expired" | Sesi login habis. Muat ulang halaman, lalu login lagi |
| Muncul "500 Server Error" | Error di server → catat waktu & langkahnya, kirim ke PIC teknis |
