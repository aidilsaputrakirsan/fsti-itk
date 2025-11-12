# Website FSTI ITK

<div align="center">
  <img src="public/images/logofsti.png" alt="Logo FSTI ITK" width="200"/>

  <h3>Website Resmi Fakultas Sains dan Teknologi Informasi</h3>
  <h4>Institut Teknologi Kalimantan</h4>

  [![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![Vue.js](https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vue.js&logoColor=4FC08D)](https://vuejs.org)
  [![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
</div>

---

## 📋 Deskripsi

Website resmi Fakultas Sains dan Teknologi Informasi (FSTI) Institut Teknologi Kalimantan (ITK) adalah platform digital yang dirancang untuk menyediakan informasi lengkap tentang fakultas, program studi, civitas academica, berita, dan prestasi mahasiswa. Website ini menggabungkan antarmuka publik yang informatif dengan sistem manajemen konten untuk administrator.

## ✨ Fitur Utama

### 🌐 Halaman Publik

#### 1. **Beranda**
   - Statistik fakultas (jumlah mahasiswa, dosen, program studi)
   - Berita terkini
   - Highlights prestasi
   - Animasi interaktif dengan GSAP

#### 2. **Profil Fakultas**
   - **Visi & Misi** - Visi, misi, dan tujuan FSTI
   - **Bagan Organisasi** - Struktur organisasi fakultas
   - **Pimpinan Fakultas** - Dekan dan Wakil Dekan
   - **Pimpinan Jurusan** - Kepala Jurusan
   - **Pimpinan Program Studi** - Ketua Program Studi
   - **Pimpinan Laboratorium** - Kepala Laboratorium

#### 3. **Civitas Academica**
   - **Dosen** - Direktori lengkap dosen dengan:
     - Filter berdasarkan jurusan
     - Informasi detail (email, NIDN, pendidikan)
     - Foto dan profil
   - **Tenaga Kependidikan** - Informasi staff administrasi

#### 4. **Program Studi**
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

#### 5. **Berita**
   - Artikel dan berita terkini
   - Fitur pencarian
   - Kategori berita
   - View counter
   - Gambar dan konten rich media

#### 6. **Prestasi Mahasiswa**
   - Dashboard statistik prestasi
   - Filter berdasarkan:
     - Kategori (Akademik/Non-Akademik)
     - Tingkat (Internasional/Nasional)
     - Tahun
   - Form pelaporan prestasi (Google Forms integration)
   - Detail prestasi dengan foto

#### 7. **Kontak**
   - Informasi kontak fakultas
   - Form kontak
   - Integrasi media sosial (Instagram, TikTok)
   - Link ke portal layanan mahasiswa

#### 8. **Multi-bahasa**
   - Bahasa Indonesia
   - Bahasa Inggris

### 🔐 Halaman Admin

#### 1. **Dashboard**
   - Statistik konten
   - Overview sistem

#### 2. **Manajemen Berita**
   - **Create** - Buat artikel/berita baru
   - **Read** - Lihat daftar berita
   - **Update** - Edit berita yang ada
   - **Delete** - Hapus berita
   - Status publikasi (Draft/Terbitkan)
   - View tracking
   - Kategori management
   - Search & filtering

#### 3. **Manajemen Pengguna**
   - Autentikasi (Login/Register)
   - Update profil
   - Change password
   - Email verification
   - Password reset

## 🛠️ Teknologi

### Backend
- **Framework**: Laravel (PHP)
- **Server**: Apache
- **Routing**: RESTful API
- **Authentication**: Laravel Sanctum/Breeze

### Frontend
- **Framework**: Vue.js 3 (Composition API)
- **Build Tool**: Vite
- **Styling**: Tailwind CSS
- **Icons**: Lucide Vue Next (v0.541.0)
- **Animation**: GSAP (v3.13.0)
- **Utilities**: Lodash

### Database
- MySQL / PostgreSQL

## 📁 Struktur Direktori

```
fsti-itk/
├── public/                      # Web root directory
│   ├── index.php               # Laravel entry point
│   ├── .htaccess               # Apache configuration
│   ├── robots.txt              # SEO configuration
│   ├── favicon.ico             # Site favicon
│   ├── build/                  # Compiled frontend assets
│   │   ├── assets/             # JS/CSS bundles (~71 files)
│   │   │   ├── app-*.js        # Main application bundle
│   │   │   ├── app-*.css       # Main stylesheet
│   │   │   ├── PublicLayout-*.js
│   │   │   ├── AdminLayout-*.js
│   │   │   ├── Home-*.js
│   │   │   ├── Dosen-*.js
│   │   │   └── ... (page components)
│   │   └── manifest.json       # Asset manifest
│   └── images/                 # Static images (~31 files)
│       ├── logofsti.png
│       ├── background-banner.png
│       ├── bagan-organisasi.webp
│       ├── dosen/              # Lecturer photos
│       ├── prodi/              # Study program assets
│       ├── pimpinan-fakultas/  # Faculty leadership
│       ├── pimpinan-jurusan/   # Department leadership
│       ├── pimpinan-prodi/     # Program leadership
│       └── pimpinan-laboratorium/ # Lab leadership
├── app/                        # Application logic (gitignored)
├── routes/                     # Route definitions (gitignored)
├── resources/                  # Views & frontend source (gitignored)
├── database/                   # Database migrations (gitignored)
├── config/                     # Configuration files (gitignored)
└── storage/                    # File storage (gitignored)
```

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.1
- Composer
- Node.js >= 18.x
- NPM atau Yarn
- MySQL/PostgreSQL
- Apache/Nginx

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd fsti-itk
   ```

2. **Install dependencies PHP**
   ```bash
   composer install
   ```

3. **Install dependencies JavaScript**
   ```bash
   npm install
   # atau
   yarn install
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
   # Untuk development:
   npm run dev
   ```

9. **Jalankan server**
   ```bash
   php artisan serve
   ```

10. **Akses aplikasi**

    Buka browser dan akses: `http://localhost:8000`

## 🔧 Konfigurasi

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

## 💻 Development

### Menjalankan Development Server

```bash
# Terminal 1: Laravel backend
php artisan serve

# Terminal 2: Vite frontend (hot reload)
npm run dev
```

### Build untuk Production

```bash
npm run build
php artisan optimize
```

### Coding Standards

- **PHP**: PSR-12
- **JavaScript**: ESLint
- **Vue**: Vue 3 Style Guide

## 🧪 Testing

```bash
# Run PHP tests
php artisan test

# Run JavaScript tests
npm run test
```

## 📦 Deployment

### Production Checklist

1. ✅ Set `APP_ENV=production` di `.env`
2. ✅ Set `APP_DEBUG=false` di `.env`
3. ✅ Generate production key: `php artisan key:generate`
4. ✅ Build assets: `npm run build`
5. ✅ Optimize: `php artisan optimize`
6. ✅ Migrate database: `php artisan migrate --force`
7. ✅ Set proper file permissions
8. ✅ Configure web server (Apache/Nginx)
9. ✅ Setup SSL certificate
10. ✅ Configure backup system

### Server Requirements

- PHP >= 8.1
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

## 🔐 Keamanan

- ✅ CSRF Protection (Laravel)
- ✅ XSS Protection
- ✅ SQL Injection Protection (Eloquent ORM)
- ✅ Authentication & Authorization
- ✅ Password Hashing (bcrypt)
- ✅ HTTPS Ready
- ✅ Rate Limiting

### Melaporkan Kerentanan

Jika Anda menemukan kerentanan keamanan, silakan laporkan melalui email ke: security@fsti.itk.ac.id

## 🌟 Fitur Unggulan

### Animasi GSAP
Website menggunakan GSAP 3.13.0 untuk animasi yang smooth dan profesional:
- Scroll-triggered animations
- Timeline animations
- Easing functions
- CSS animations

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

## 🔗 Link Penting

- **Website FSTI**: [https://fsti.itk.ac.id](https://fsti.itk.ac.id)
- **Instagram**: [@fsti.itk](https://instagram.com/fsti.itk)
- **TikTok**: [@fsti.itk](https://tiktok.com/@fsti.itk)
- **Portal Layanan**: [https://layanan-fsti.myst-tech.com/](https://layanan-fsti.myst-tech.com/)
- **Form Lapor Prestasi**: [Google Form](https://docs.google.com/forms/d/e/1FAIpQLSfaToVEnR6vnZSTggEbH_IfAVbOpuPf1aCirsNTRb3m8aFL-Q/viewform)
- **Website ITK**: [https://itk.ac.id](https://itk.ac.id)

## 👥 Tim Pengembang

**Fakultas Sains dan Teknologi Informasi**
Institut Teknologi Kalimantan

## 📄 Lisensi

[Tentukan lisensi proyek Anda]

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan buat Pull Request atau buka Issue untuk saran dan perbaikan.

### Cara Berkontribusi

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📞 Kontak

**Fakultas Sains dan Teknologi Informasi**
Institut Teknologi Kalimantan

Website: [https://fsti.itk.ac.id](https://fsti.itk.ac.id)
Email: fsti@itk.ac.id

---

<div align="center">
  <p>Made with ❤️ by FSTI ITK Team</p>
  <p>© 2024 Fakultas Sains dan Teknologi Informasi - Institut Teknologi Kalimantan</p>
</div>
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
