# 03 – Pengembangan & Deploy

Panduan untuk **PIC teknis / developer**.

## Kebutuhan

| | Versi |
|---|---|
| PHP | 8.2+ (lokal disarankan 8.4) |
| Composer | 2.x |
| Node.js | 22 (lihat `.nvmrc`) |
| MySQL | 8.0 (production). Jangan pakai fitur khusus MySQL 9 |

## Setup lokal

```bash
git clone https://github.com/aidilsaputrakirsan/fsti-itk.git
cd fsti-itk

composer install
cp .env.example .env          # sesuaikan DB_* dan APP_URL
php artisan key:generate

# buat database kosong "fsti_itk" di MySQL, lalu:
php artisan migrate --seed
php artisan storage:link

npm install
npm run build                 # atau `npm run dev` untuk hot reload
```

Jalankan dengan `php artisan serve` (→ `http://localhost:8000`), atau lewat Laravel Herd/Valet (→ `http://fsti-itk.test`).

**Akun hasil seeder (hanya untuk lokal):**

| Peran | Email | Password |
|---|---|---|
| Super Admin | `superadmin@fsti.itk.ac.id` | `superadmin123` |
| Admin | `admin@fsti.itk.ac.id` | `admin123` |

> Password production **berbeda** dan diserahkan lewat jalur aman. Jangan jalankan `db:seed` di production.

**Data seeder yang tidak ada di repo.** Dua file berisi data pribadi sengaja tidak di-commit (lihat `.gitignore`):

- `database/seeders/assets/alumni/data_alumni.csv`: data alumni
- `database/seeders/assets/research/sinta_data.json`: data SINTA dosen

Tanpa kedua file itu, `AlumniSeeder`, `ResearchSeeder`, dan `CommunityServiceSeeder` hanya menampilkan pesan dan dilewati, sementara seeder lain tetap jalan. Minta file-nya ke PIC lama kalau memang dibutuhkan.

## Struktur kode, versi singkat

```
app/Http/Controllers/Admin/    controller panel admin (CRUD)
app/Http/Controllers/Public/   controller halaman publik (read-only)
app/Models/                    model Eloquent, satu per tabel
database/migrations/           skema database
database/seeders/              data awal + aset (gambar/PDF)
resources/js/Pages/Admin/      halaman Vue admin
resources/js/Pages/Public/     halaman Vue publik
resources/js/Components/       komponen bersama (Navbar, Banner, form, dll.)
resources/js/Layouts/          AdminLayout (sidebar), PublicLayout
routes/web.php                 semua route (admin di atas, publik di bawah)
routes/auth.php                login, reset password (registrasi dimatikan)
tests/Feature/                 test otomatis
```

## Resep: menambah modul konten baru

Modul **Mitra KP/Magang** bisa dijadikan contoh lengkap. Urutannya:

1. **Migration:** `php artisan make:migration create_<nama>_table`
2. **Model:** `app/Models/<Nama>.php`, isi `$fillable` dan `$casts`
3. **Controller admin:** `app/Http/Controllers/Admin/<Nama>Controller.php` (index, create, store, edit, update, destroy, plus validasi)
4. **Controller publik:** `app/Http/Controllers/Public/Public<Nama>Controller.php`
5. **Route** di `routes/web.php`:
   - admin: `Route::resource(...)` di dalam grup `admin`
   - publik: `Route::get(...)` di bagian bawah
6. **Halaman Vue:** `Pages/Admin/<Nama>/{Index,Create,Edit}.vue` dan `Pages/Public/<Nama>/Index.vue`
7. **Menu:**
   - sidebar admin di `resources/js/Layouts/AdminLayout.vue`
   - navbar publik di `resources/js/Components/Navbar.vue`
8. **Test:** `tests/Feature/<Nama>Test.php`
9. **Dokumentasi:** tambahkan baris ke tabel menu di [02 – Panduan Admin](02-panduan-admin.md) dan tabel modul di [01 – Alur Sistem](01-alur-sistem.md)

File Mitra KP/Magang sebagai contoh:

```
database/migrations/2026_11_26_150000_create_internship_partners_table.php
app/Models/InternshipPartner.php
app/Http/Controllers/Admin/InternshipPartnerController.php
app/Http/Controllers/Public/PublicInternshipPartnerController.php
resources/js/Components/InternshipPartnerForm.vue
resources/js/Pages/Admin/InternshipPartners/{Index,Create,Edit}.vue
resources/js/Pages/Public/InternshipPartners/Index.vue
tests/Feature/InternshipPartnerTest.php
```

**Catatan upload file di form Edit:** Inertia harus mengirim lewat `POST` dengan `_method: 'put'` dan `forceFormData: true`, karena PHP tidak membaca file dari request `PUT` biasa.

## Testing

```bash
php artisan test
npm run build      # sekaligus type-check TypeScript (vue-tsc)
```

Test memakai SQLite in-memory (`phpunit.xml`), jadi tidak menyentuh database lokal.

## Alur Git

- Branch utama: `main`, yang menjadi sumber deploy production.
- Kerjakan fitur di branch terpisah (misalnya `feat/mitra-kp-magang`), lalu buka pull request ke `main`.
- Jangan commit `.env`, dump database, atau file data pribadi.

## Deploy ke production

Sesuaikan `<folder-app>` dan versi PHP dengan server.

```bash
cd ~/apps/<folder-app>
git pull

# hanya kalau composer.lock berubah
composer install --no-dev --optimize-autoloader

# kalau ada migration baru
php artisan migrate --force

# kalau ada perubahan di resources/js atau CSS
npm ci && npm run build

php artisan optimize
```

> Kalau server punya beberapa versi PHP, panggil versi yang benar secara eksplisit, misalnya `php8.4 artisan migrate --force`.

**Sebelum `migrate --force`**, backup database dulu. **Rollback** migration terakhir: `php artisan migrate:rollback --step=1`.

**Pengaturan `.env` production yang penting:** `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://<domain>`, kredensial `DB_*`.

## Backup

Yang wajib dibackup rutin:

1. **Database** MySQL
2. **Folder `storage/app/public`**: semua file upload admin. Tidak ada di git
3. File **`.env`** production

## Catatan & pekerjaan tertunda

Hal-hal yang diketahui per serah terima ini, untuk dilanjutkan PIC teknis:

- **3 test bawaan gagal** sejak sebelum serah terima: `AuthenticationTest` (login & logout) dan `ExampleTest`. Ini masalah di test-nya, bukan di fitur login. `ExampleTest` tidak memakai `RefreshDatabase`, dan redirect yang diharapkan `AuthenticationTest` tidak sesuai.
- **Riwayat git lama** masih berisi file data alumni/SINTA yang sekarang sudah di-ignore. Kalau repo dibuat publik, pertimbangkan membersihkan riwayatnya.
- `public/build/manifest.json` masih ter-track di git walaupun folder `public/build` di-ignore. File ini selalu ikut berubah setiap build.
- Bundle `vue3-apexcharts` lebih dari 500 kB. Bisa dioptimasi dengan lazy-load kalau performa jadi masalah.
