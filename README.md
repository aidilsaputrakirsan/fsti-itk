# Website FSTI ITK

<div align="center">
  <img src="public/images/logofsti.png" alt="Logo FSTI ITK" width="200"/>

  <h3>Website Resmi Fakultas Sains dan Teknologi Informasi</h3>
  <h4>Institut Teknologi Kalimantan</h4>

  [![Laravel](https://img.shields.io/badge/Laravel_12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![Vue.js](https://img.shields.io/badge/Vue.js_3-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D)](https://vuejs.org)
  [![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
  [![TypeScript](https://img.shields.io/badge/TypeScript-007ACC?style=for-the-badge&logo=typescript&logoColor=white)](https://www.typescriptlang.org)
</div>

---

## Deskripsi

Website resmi Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan (ITK) adalah platform digital yang dirancang untuk menyediakan informasi lengkap tentang fakultas, program studi, civitas academica, berita, dan prestasi mahasiswa. Website ini menggabungkan antarmuka publik yang informatif dengan sistem manajemen konten untuk administrator.

## Fitur Utama

### Halaman Publik

#### 1. Beranda
- Statistik fakultas (jumlah mahasiswa, dosen, program studi)
- Berita terkini
- Highlights prestasi mahasiswa
- Animasi interaktif dengan GSAP & AOS

#### 2. Profil Fakultas
- **Visi & Misi** - Visi, misi, dan tujuan FSTI
- **Bagan Organisasi** - Struktur organisasi fakultas
- **Pimpinan Fakultas** - Dekan dan Wakil Dekan
- **Pimpinan Jurusan** - Kepala Jurusan
- **Pimpinan Program Studi** - Ketua Program Studi
- **Pimpinan Laboratorium** - Kepala Laboratorium

#### 3. Civitas Academica
- **Dosen** - Direktori lengkap dosen dengan:
  - Filter berdasarkan jurusan
  - Informasi detail (email, NIDN, pendidikan)
  - Foto dan profil
- **Tenaga Kependidikan** - Informasi staff administrasi

#### 4. Program Studi
Informasi lengkap untuk 8 program studi:
- **Jurusan Teknik, Teknologi Informasi & Bisnis**
  - Teknik Elektro
  - Sistem Informasi
  - Informatika
  - Bisnis Digital
- **Jurusan Sains & Analitika Data**
  - Fisika
  - Matematika
  - Statistika
  - Ilmu Aktuaria

#### 5. Berita
- Artikel dan berita terkini
- Fitur pencarian
- Kategori berita
- View counter
- Gambar dan konten rich media

#### 6. Prestasi Mahasiswa
- Dashboard statistik prestasi
- Filter berdasarkan:
  - Kategori (Akademik/Non-Akademik)
  - Tingkat (Internasional/Nasional)
  - Tahun
- Form pelaporan prestasi (Google Forms integration)
- Detail prestasi dengan foto

#### 7. Modul Tambahan
- **PPID** - Pejabat Pengelola Informasi dan Dokumentasi (Transparansi)
- **Zona Integritas** - Informasi zona integritas fakultas
- **Alumni** - Tracer study dan informasi alumni
- **Survei Kepuasan** - Form feedback dari pengguna layanan
- **Layanan Internal** - Link ke portal layanan internal

#### 8. Kontak
- Informasi kontak fakultas
- Form kontak
- Integrasi media sosial (Instagram, TikTok)
- Link ke portal layanan mahasiswa

#### 9. Multi-bahasa
- Bahasa Indonesia
- Bahasa Inggris

### Halaman Admin

#### 1. Dashboard
- Statistik konten
- Overview sistem

#### 2. Manajemen Berita
- Create, Read, Update, Delete artikel/berita
- Rich text editor (Tiptap)
- Status publikasi (Draft/Terbitkan)
- View tracking
- Kategori management
- Search & filtering

#### 3. Manajemen Prestasi
- CRUD data prestasi mahasiswa
- Import/Export Excel
- Upload foto dan bukti prestasi

#### 4. Manajemen Staff & Dosen
- CRUD data staff/dosen
- Upload foto profil
- Informasi pendidikan dan jabatan

#### 5. Modul Tambahan
- **Dokumen PPID** - Manajemen dokumen transparansi
- **Zona Integritas** - Konten zona integritas
- **Alumni Tracer** - Data tracer study alumni
- **Survei Kepuasan** - Lihat hasil survei
- **Layanan Internal** - Manajemen link layanan

#### 6. Manajemen Pengguna
- Autentikasi (Login/Register)
- Update profil
- Change password
- Email verification
- Password reset
- Role management (Superadmin)

## Teknologi

### Backend
- **Framework**: Laravel 12 (PHP 8.2+)
- **Authentication**: Laravel Sanctum + Breeze
- **Database ORM**: Eloquent
- **Server-Side Rendering**: Inertia.js
- **File Storage**: Laravel Filesystem (public disk)
- **Excel Processing**: Maatwebsite Excel

### Frontend
- **Framework**: Vue.js 3 (Composition API)
- **Build Tool**: Vite 7.0
- **Type Checking**: TypeScript 5.6
- **Styling**: Tailwind CSS 3.2
- **Icons**: Lucide Vue Next, Heroicons
- **Rich Text Editor**: Tiptap 3.3
- **Animation**: GSAP 3.13, AOS 2.3
- **HTTP Client**: Axios
- **Utilities**: Lodash

### Database
- SQLite (Development)
- MySQL / PostgreSQL (Production)

> Untuk dokumentasi arsitektur teknis yang lebih detail, lihat [ARCHITECTURE.md](ARCHITECTURE.md)

## Struktur Direktori

```
fsti-itk/
├── app/                         # Logika aplikasi Laravel
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controller untuk admin panel
│   │   │   └── Public*.php     # Controller untuk halaman publik
│   │   ├── Middleware/         # Custom middleware
│   │   └── Requests/           # Form request validation
│   └── Models/                 # Eloquent models
├── config/                      # Konfigurasi Laravel
├── database/
│   ├── migrations/             # Database schema
│   ├── factories/              # Model factories
│   └── seeders/                # Database seeders
├── public/                      # Web root directory
│   ├── build/                  # Compiled frontend assets
│   │   ├── assets/             # JS/CSS bundles
│   │   └── manifest.json       # Asset manifest
│   └── images/                 # Static images
│       ├── dosen/              # Foto dosen
│       ├── prodi/              # Asset program studi
│       └── pimpinan-*/         # Foto pimpinan
├── resources/
│   ├── js/
│   │   ├── Components/         # Reusable Vue components
│   │   ├── Layouts/            # Layout templates
│   │   ├── Pages/              # Page components
│   │   │   ├── Admin/          # Admin pages
│   │   │   └── Public/         # Public pages
│   │   └── types/              # TypeScript definitions
│   └── css/                    # Stylesheets
├── routes/
│   ├── web.php                 # Web routes
│   └── auth.php                # Authentication routes
├── storage/                     # File storage & logs
├── tests/                       # PHPUnit tests
├── composer.json               # PHP dependencies
├── package.json                # Node.js dependencies
├── vite.config.js              # Vite configuration
├── tsconfig.json               # TypeScript configuration
└── tailwind.config.js          # Tailwind CSS configuration
```

## Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js >= 18.x
- NPM atau Yarn
- MySQL/PostgreSQL (untuk production)
- Apache/Nginx

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/aidilsaputrakirsan/fsti-itk.git
   cd fsti-itk
   ```

2. **Install dependencies PHP**
   ```bash
   composer install
   ```

3. **Install dependencies JavaScript**
   ```bash
   npm install
   ```

4. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Konfigurasi database**

   Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=fsti_itk
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Jalankan migrasi database**
   ```bash
   php artisan migrate
   ```

7. **Seed database (opsional)**
   ```bash
   php artisan db:seed
   ```

8. **Build frontend assets**
   ```bash
   npm run build
   ```

9. **Jalankan server**
   ```bash
   php artisan serve
   ```

10. **Akses aplikasi**

    Buka browser dan akses: `http://localhost:8000`

## Konfigurasi

### Apache Configuration

File `.htaccess` sudah dikonfigurasi untuk:
- URL rewriting
- Authorization header handling
- Redirect trailing slashes
- Route semua request ke `index.php`

### SEO Configuration

File `robots.txt` mengizinkan semua crawler untuk mengindeks website.

### Asset Management

Asset frontend dikelola melalui Vite dengan manifest di `public/build/manifest.json` yang menangani:
- Code splitting
- Cache busting
- Dependency tracking

## Development

### Menjalankan Development Server

**Cara 1: Manual (2 terminal)**
```bash
# Terminal 1: Laravel backend
php artisan serve

# Terminal 2: Vite frontend (hot reload)
npm run dev
```

**Cara 2: Menggunakan Composer Script (1 terminal)**
```bash
composer run dev
```
Script ini akan menjalankan: Laravel server, Queue listener, Pail logs, dan Vite secara bersamaan.

### Build untuk Production

```bash
npm run build
php artisan optimize
```

### Coding Standards

- **PHP**: PSR-12
- **JavaScript/TypeScript**: ESLint
- **Vue**: Vue 3 Style Guide

## Testing

```bash
# Run PHP tests
php artisan test

# Atau menggunakan composer script
composer run test
```

## Deployment

### Production Checklist

1. Set `APP_ENV=production` di `.env`
2. Set `APP_DEBUG=false` di `.env`
3. Generate production key: `php artisan key:generate`
4. Build assets: `npm run build`
5. Optimize: `php artisan optimize`
6. Migrate database: `php artisan migrate --force`
7. Set proper file permissions
8. Configure web server (Apache/Nginx)
9. Setup SSL certificate
10. Configure backup system

### Server Requirements

- PHP >= 8.2
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## Keamanan

- CSRF Protection (Laravel)
- XSS Protection
- SQL Injection Protection (Eloquent ORM)
- Authentication & Authorization
- Password Hashing (bcrypt)
- HTTPS Ready
- Rate Limiting

### Melaporkan Kerentanan

Jika Anda menemukan kerentanan keamanan, silakan laporkan melalui email ke: fsti@itk.ac.id

## Fitur Unggulan

### Animasi GSAP & AOS
Website menggunakan GSAP 3.13 dan AOS untuk animasi yang smooth dan profesional:
- Scroll-triggered animations
- Timeline animations
- Easing functions
- Fade-in effects

### Responsive Design
Desain responsif dengan breakpoint:
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

### Performance Optimization
- Code splitting untuk load time yang cepat
- Lazy loading untuk images
- Asset optimization dengan Vite
- Caching strategies

## Link Penting

- **Website FSTI**: [https://fsti.itk.ac.id](https://fsti.itk.ac.id)
- **Instagram**: [@fsti.itk](https://instagram.com/fsti.itk)
- **TikTok**: [@fsti.itk](https://tiktok.com/@fsti.itk)
- **Portal Layanan**: [https://layanan-fsti.myst-tech.com/](https://layanan-fsti.myst-tech.com/)
- **Form Lapor Prestasi**: [Google Form](https://docs.google.com/forms/d/e/1FAIpQLSfaToVEnR6vnZSTggEbH_IfAVbOpuPf1aCirsNTRb3m8aFL-Q/viewform)
- **Website ITK**: [https://itk.ac.id](https://itk.ac.id)

## Tim Pengembang

**Fakultas Sains dan Teknologi Informasi**
Institut Teknologi Kalimantan

## Lisensi

Hak Cipta 2025 Fakultas Sains dan Teknologi Informasi - Institut Teknologi Kalimantan.
Semua hak dilindungi undang-undang.

## Kontribusi

Kontribusi sangat diterima! Silakan buat Pull Request atau buka Issue untuk saran dan perbaikan.

### Cara Berkontribusi

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## Kontak

**Fakultas Sains dan Teknologi Informasi**
Institut Teknologi Kalimantan

- Website: [https://fsti.itk.ac.id](https://fsti.itk.ac.id)
- Email: fsti@itk.ac.id

---

<div align="center">
  <p>Made with by FSTI ITK Team</p>
  <p>2025 Fakultas Sains dan Teknologi Informasi - Institut Teknologi Kalimantan</p>
</div>
