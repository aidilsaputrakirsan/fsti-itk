# Dokumentasi Website FSTI ITK

Dokumen ini disiapkan untuk **serah terima pengelolaan website fakultas** kepada PIC berikutnya, supaya pengelolaan konten maupun pengembangan bisa dilanjutkan tanpa harus bertanya ke pengembang sebelumnya.

## Mulai dari mana?

| Kalau Anda... | Baca |
|---|---|
| PIC konten (admin yang mengisi berita, prestasi, dll.) | [02 – Panduan Admin](02-panduan-admin.md) |
| Ingin memahami cara kerja sistem secara umum | [01 – Alur Sistem](01-alur-sistem.md) |
| Developer yang akan memperbaiki atau menambah fitur | [01 – Alur Sistem](01-alur-sistem.md), lalu [03 – Pengembangan & Deploy](03-pengembangan-dan-deploy.md) |

Detail teknis yang lebih dalam (struktur folder lengkap, tech stack, skema database) ada di [ARCHITECTURE.md](../ARCHITECTURE.md) di root repo.

## Ringkasan sistem

- **Isinya:** website profil resmi Fakultas Sains dan Teknologi Informasi ITK, terdiri dari **halaman publik** dan **panel admin** untuk mengelola semua kontennya.
- **Teknologi:** Laravel 12 (PHP) + Inertia.js + Vue 3 (TypeScript) + Tailwind CSS, database MySQL.
- **Repo:** `github.com/aidilsaputrakirsan/fsti-itk`, branch utama `main`.

## Checklist serah terima

Isi dan centang bersama PIC lama dan PIC baru.

**Identitas**

| | Nama | Kontak |
|---|---|---|
| PIC lama / pengembang | _(isi)_ | _(isi)_ |
| PIC baru – konten | _(isi)_ | _(isi)_ |
| PIC baru – teknis | _(isi)_ | _(isi)_ |
| Tanggal serah terima | _(isi)_ | |

**Akses yang diserahkan.** Serahkan lewat jalur aman, jangan ditulis di dokumen ini.

- [ ] Akun **Super Admin** website production
- [ ] Akses repo GitHub (minimal hak *write*)
- [ ] Akses server/VPS (SSH) bagi PIC teknis
- [ ] Salinan file `.env` production (disimpan aman, bukan di repo)
- [ ] Lokasi backup database dan folder `storage/app/public` (file upload)

**Yang perlu dilakukan PIC baru**

- [ ] Login sebagai Super Admin, buat akun admin untuk tiap pengelola konten (menu **Kelola Akun Admin**)
- [ ] Ganti password Super Admin setelah serah terima
- [ ] Coba setup lokal sesuai [03 – Pengembangan & Deploy](03-pengembangan-dan-deploy.md)
- [ ] Baca bagian "Catatan & pekerjaan tertunda" di dokumen 03

## Menjaga dokumen ini

Setiap kali ada **modul/menu baru** atau **alur deploy berubah**, perbarui dokumen terkait dalam pull request yang sama dengan perubahan kodenya.
