# Arsitektur Teknis - Website FSTI ITK

Dokumen ini menjelaskan arsitektur teknis dari website FSTI ITK secara mendalam, mencakup arsitektur backend, frontend, database, dan infrastruktur.

## Daftar Isi

- [Overview Arsitektur](#overview-arsitektur)
- [Tech Stack](#tech-stack)
- [Arsitektur Backend](#arsitektur-backend)
- [Arsitektur Frontend](#arsitektur-frontend)
- [Database Design](#database-design)
- [Routing & API](#routing--api)
- [Authentication & Authorization](#authentication--authorization)
- [File Storage](#file-storage)
- [Build & Deployment](#build--deployment)
- [Diagram Arsitektur](#diagram-arsitektur)

---

## Overview Arsitektur

Website FSTI ITK menggunakan arsitektur **monolithic full-stack** dengan pendekatan **Server-Side Rendering (SSR)** melalui Inertia.js. Arsitektur ini menggabungkan kekuatan Laravel sebagai backend dengan Vue.js sebagai frontend dalam satu aplikasi terintegrasi.

```
┌─────────────────────────────────────────────────────────────────┐
│                         CLIENT (Browser)                         │
├─────────────────────────────────────────────────────────────────┤
│  Vue.js 3 + Inertia.js Client + Tailwind CSS + GSAP/AOS        │
└─────────────────────────────────────────────────────────────────┘
                              │ HTTP/HTTPS
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                      WEB SERVER (Apache/Nginx)                   │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                    APPLICATION (Laravel 12)                      │
├─────────────────────────────────────────────────────────────────┤
│  ┌───────────┐  ┌───────────┐  ┌───────────┐  ┌──────────────┐ │
│  │  Routes   │→ │Middleware │→ │Controllers│→ │ Inertia.js   │ │
│  └───────────┘  └───────────┘  └───────────┘  └──────────────┘ │
│        │              │              │               │          │
│        ▼              ▼              ▼               ▼          │
│  ┌───────────┐  ┌───────────┐  ┌───────────┐  ┌──────────────┐ │
│  │  Sanctum  │  │  Breeze   │  │  Models   │  │ Vue Pages    │ │
│  │   Auth    │  │   Auth    │  │ (Eloquent)│  │ (SSR Props)  │ │
│  └───────────┘  └───────────┘  └───────────┘  └──────────────┘ │
└─────────────────────────────────────────────────────────────────┘
                              │
                              ▼
┌─────────────────────────────────────────────────────────────────┐
│                    DATABASE (MySQL/PostgreSQL)                   │
└─────────────────────────────────────────────────────────────────┘
```

### Karakteristik Utama

| Aspek | Pendekatan |
|-------|------------|
| **Rendering** | Server-Side Rendering via Inertia.js |
| **State Management** | Props dari server + Vue Reactivity |
| **Routing** | Server-side (Laravel) + Client-side navigation (Inertia) |
| **API Style** | Inertia Protocol (bukan REST tradisional) |
| **Authentication** | Session-based dengan Laravel Sanctum |

---

## Tech Stack

### Backend Stack

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **PHP** | 8.2+ | Runtime bahasa pemrograman |
| **Laravel** | 12.0 | Web application framework |
| **Inertia.js** | 2.0 | Bridge antara Laravel dan Vue |
| **Laravel Sanctum** | 4.0 | API & SPA authentication |
| **Laravel Breeze** | 2.3 | Authentication scaffolding |
| **Eloquent ORM** | - | Database abstraction layer |
| **Maatwebsite Excel** | 1.1 | Import/Export Excel |
| **Ziggy** | 2.0 | Laravel routes di JavaScript |

### Frontend Stack

| Teknologi | Versi | Fungsi |
|-----------|-------|--------|
| **Vue.js** | 3.4 | Reactive UI framework |
| **TypeScript** | 5.6 | Static type checking |
| **Vite** | 7.0 | Build tool & dev server |
| **Tailwind CSS** | 3.2 | Utility-first CSS framework |
| **Inertia.js Vue 3** | 2.0 | Vue adapter untuk Inertia |
| **Tiptap** | 3.3 | Rich text editor |
| **GSAP** | 3.13 | Animation library |
| **AOS** | 2.3 | Scroll animation library |
| **Axios** | 1.11 | HTTP client |
| **Lodash** | 4.17 | Utility functions |
| **Lucide Vue** | 0.541 | Icon library |
| **Heroicons** | 2.2 | Icon library |

### Development Tools

| Tool | Fungsi |
|------|--------|
| **Vite** | Hot Module Replacement (HMR) |
| **vue-tsc** | Vue TypeScript compiler |
| **PostCSS** | CSS transformations |
| **Autoprefixer** | CSS vendor prefixes |
| **PHPUnit** | PHP unit testing |
| **Laravel Pint** | PHP code style fixer |
| **Laravel IDE Helper** | IDE autocomplete support |
| **Concurrently** | Run multiple processes |

---

## Arsitektur Backend

### Struktur Direktori

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                    # Admin panel controllers
│   │   │   ├── PostController.php
│   │   │   ├── AchievementsController.php
│   │   │   ├── UserController.php
│   │   │   ├── StaffController.php
│   │   │   ├── PpidController.php
│   │   │   ├── AlumniController.php
│   │   │   ├── IntegrityZoneController.php
│   │   │   ├── InternalServiceController.php
│   │   │   ├── SatisfactionSurveyController.php
│   │   │   └── StaticPageController.php
│   │   ├── Auth/                     # Authentication controllers
│   │   │   ├── AuthenticatedSessionController.php
│   │   │   ├── ConfirmablePasswordController.php
│   │   │   ├── EmailVerificationNotificationController.php
│   │   │   ├── EmailVerificationPromptController.php
│   │   │   ├── NewPasswordController.php
│   │   │   ├── PasswordController.php
│   │   │   ├── PasswordResetLinkController.php
│   │   │   ├── RegisteredUserController.php
│   │   │   └── VerifyEmailController.php
│   │   ├── Controller.php            # Base controller
│   │   ├── ProfileController.php     # User profile
│   │   ├── PublicPostController.php
│   │   ├── PublicAchievementController.php
│   │   ├── PublicProfileController.php
│   │   └── PublicAdditionalController.php
│   ├── Middleware/
│   │   └── HandleInertiaRequests.php # Inertia middleware
│   └── Requests/                     # Form request validation
├── Models/
│   ├── User.php                      # User authentication
│   ├── Post.php                      # News/articles
│   ├── Achievement.php               # Student achievements
│   ├── Staff.php                     # Staff/lecturers
│   ├── PpidDocument.php              # Transparency documents
│   ├── IntegrityZone.php             # Integrity zone content
│   ├── AlumniTracer.php              # Alumni tracking
│   ├── SatisfactionSurvey.php        # User feedback
│   ├── InternalService.php           # Service links
│   └── StaticPage.php                # Static content
└── Providers/
    └── AppServiceProvider.php
```

### Controller Pattern

Controllers mengikuti pattern RESTful dengan method standar:

```php
class PostController extends Controller
{
    public function index()      // GET    /admin/posts
    public function create()     // GET    /admin/posts/create
    public function store()      // POST   /admin/posts
    public function show($id)    // GET    /admin/posts/{id}
    public function edit($id)    // GET    /admin/posts/{id}/edit
    public function update($id)  // PUT    /admin/posts/{id}
    public function destroy($id) // DELETE /admin/posts/{id}
}
```

### Inertia Response Pattern

```php
use Inertia\Inertia;

// Rendering Vue page dengan props
return Inertia::render('Admin/Posts/Index', [
    'posts' => $posts,
    'filters' => $request->only(['search', 'category']),
]);

// Redirect dengan flash message
return redirect()
    ->route('admin.posts.index')
    ->with('success', 'Post created successfully.');
```

### Model Relationships

```php
// User Model
class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password', 'is_superadmin'];
    protected $hidden = ['password', 'remember_token'];
}

// Post Model
class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'excerpt',
        'image', 'category', 'status', 'views', 'published_at'
    ];

    // Accessor untuk URL gambar
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}

// Achievement Model
class Achievement extends Model
{
    protected $fillable = [
        'student_name', 'nim', 'program_studi', 'achievement_name',
        'category', 'level', 'year', 'organizer', 'proof', 'photo'
    ];
}
```

---

## Arsitektur Frontend

### Struktur Direktori

```
resources/js/
├── app.ts                    # Entry point aplikasi
├── bootstrap.ts              # Bootstrap configuration
├── Components/               # Reusable components
│   ├── Navbar.vue
│   ├── Footer.vue
│   ├── Banner.vue
│   ├── ArticleCard.vue
│   ├── AchievementCard.vue
│   ├── LanguageSwitcher.vue
│   ├── Button.vue
│   ├── Input.vue
│   ├── Dropdown.vue
│   ├── Modal.vue
│   └── ...
├── Layouts/                  # Layout templates
│   ├── PublicLayout.vue      # Layout untuk halaman publik
│   ├── AdminLayout.vue       # Layout untuk admin panel
│   ├── AuthenticatedLayout.vue
│   └── GuestLayout.vue
├── Pages/                    # Page components
│   ├── Home.vue
│   ├── Admin/
│   │   ├── Dashboard/
│   │   │   └── Index.vue
│   │   ├── Posts/
│   │   │   ├── Index.vue
│   │   │   ├── Create.vue
│   │   │   └── Edit.vue
│   │   ├── Achievements/
│   │   ├── Users/
│   │   ├── Staff/
│   │   ├── Ppid/
│   │   ├── IntegrityZones/
│   │   ├── Alumni/
│   │   ├── SatisfactionSurveys/
│   │   ├── InternalServices/
│   │   └── StaticPages/
│   ├── Public/
│   │   ├── Berita/
│   │   │   ├── Index.vue
│   │   │   └── Show.vue
│   │   ├── Prestasi/
│   │   │   └── Index.vue
│   │   ├── Profil/
│   │   │   ├── VisiMisi.vue
│   │   │   ├── BaganOrganisasi.vue
│   │   │   ├── Dosen.vue
│   │   │   ├── TenagaKependidikan.vue
│   │   │   ├── PimpinanFakultas.vue
│   │   │   ├── PimpinanJurusan.vue
│   │   │   ├── PimpinanProdi.vue
│   │   │   └── PimpinanLaboratorium.vue
│   │   ├── ProgramStudi/
│   │   ├── Alumni/
│   │   ├── PPID/
│   │   ├── ZonaIntegritas/
│   │   ├── Survei/
│   │   ├── Layanan/
│   │   └── Kontak.vue
│   └── Auth/
│       ├── Login.vue
│       ├── Register.vue
│       ├── ForgotPassword.vue
│       └── ResetPassword.vue
└── types/                    # TypeScript definitions
    ├── index.d.ts
    └── global.d.ts
```

### App Entry Point

```typescript
// resources/js/app.ts
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { ZiggyVue } from 'ziggy-js';
import AOS from 'aos';
import 'aos/dist/aos.css';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
});

// Initialize AOS
AOS.init({
    duration: 800,
    easing: 'ease-in-out',
    once: true,
});
```

### Component Pattern

```vue
<!-- Vue 3 Composition API dengan TypeScript -->
<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

// Props dari Inertia
interface Props {
    posts: Post[];
    filters: {
        search?: string;
        category?: string;
    };
}

const props = defineProps<Props>();

// Reactive state
const searchQuery = ref(props.filters.search || '');

// Form handling dengan Inertia
const form = useForm({
    title: '',
    content: '',
    category: '',
});

// Submit form
const submit = () => {
    form.post(route('admin.posts.store'));
};

// Client-side navigation
const goToPage = (page: number) => {
    router.get(route('berita.index'), { page }, { preserveState: true });
};
</script>

<template>
    <PublicLayout>
        <div class="container mx-auto px-4">
            <!-- Content -->
        </div>
    </PublicLayout>
</template>
```

### Layout System

```vue
<!-- PublicLayout.vue -->
<script setup lang="ts">
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue';
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <Navbar />
        <LanguageSwitcher />

        <main class="flex-grow">
            <slot />
        </main>

        <Footer />
    </div>
</template>
```

### Animation Integration

```vue
<script setup lang="ts">
import { onMounted, ref } from 'vue';
import gsap from 'gsap';

const heroRef = ref<HTMLElement | null>(null);

onMounted(() => {
    // GSAP Animation
    gsap.from(heroRef.value, {
        opacity: 0,
        y: 50,
        duration: 1,
        ease: 'power2.out'
    });
});
</script>

<template>
    <!-- AOS Animation -->
    <div data-aos="fade-up" data-aos-delay="100">
        Content with scroll animation
    </div>

    <!-- GSAP Animation -->
    <div ref="heroRef">
        Content with GSAP animation
    </div>
</template>
```

---

## Database Design

### Entity Relationship Diagram (ERD)

```
┌──────────────┐     ┌──────────────┐     ┌──────────────────┐
│    users     │     │    posts     │     │   achievements   │
├──────────────┤     ├──────────────┤     ├──────────────────┤
│ id (PK)      │     │ id (PK)      │     │ id (PK)          │
│ name         │     │ title        │     │ student_name     │
│ email        │     │ slug         │     │ nim              │
│ password     │     │ content      │     │ program_studi    │
│ is_superadmin│     │ excerpt      │     │ achievement_name │
│ created_at   │     │ image        │     │ category         │
│ updated_at   │     │ category     │     │ level            │
└──────────────┘     │ status       │     │ year             │
                     │ views        │     │ organizer        │
                     │ published_at │     │ proof            │
                     │ created_at   │     │ photo            │
                     │ updated_at   │     │ created_at       │
                     └──────────────┘     │ updated_at       │
                                          └──────────────────┘

┌──────────────────┐     ┌──────────────────┐     ┌────────────────────┐
│  ppid_documents  │     │ integrity_zones  │     │   alumni_tracers   │
├──────────────────┤     ├──────────────────┤     ├────────────────────┤
│ id (PK)          │     │ id (PK)          │     │ id (PK)            │
│ title            │     │ title            │     │ name               │
│ category         │     │ content          │     │ graduation_year    │
│ file_path        │     │ type             │     │ program_studi      │
│ description      │     │ created_at       │     │ current_job        │
│ created_at       │     │ updated_at       │     │ company            │
│ updated_at       │     └──────────────────┘     │ feedback           │
└──────────────────┘                              │ created_at         │
                                                  │ updated_at         │
                                                  └────────────────────┘

┌──────────────────────┐     ┌────────────────────┐     ┌──────────────┐
│ satisfaction_surveys │     │ internal_services  │     │    staff     │
├──────────────────────┤     ├────────────────────┤     ├──────────────┤
│ id (PK)              │     │ id (PK)            │     │ id (PK)      │
│ name                 │     │ name               │     │ name         │
│ email                │     │ url                │     │ nip/nidn     │
│ service_type         │     │ description        │     │ position     │
│ rating               │     │ icon               │     │ department   │
│ feedback             │     │ is_active          │     │ education    │
│ created_at           │     │ created_at         │     │ photo        │
│ updated_at           │     │ updated_at         │     │ email        │
└──────────────────────┘     └────────────────────┘     │ type         │
                                                        │ created_at   │
┌──────────────────┐                                    │ updated_at   │
│  static_pages    │                                    └──────────────┘
├──────────────────┤
│ id (PK)          │
│ slug             │
│ title            │
│ content          │
│ created_at       │
│ updated_at       │
└──────────────────┘
```

### Migration Files

```
database/migrations/
├── 0001_01_01_000000_create_users_table.php
├── 0001_01_01_000001_create_cache_table.php
├── 0001_01_01_000002_create_jobs_table.php
├── 2025_09_01_143545_create_posts_table.php
├── 2025_09_01_173618_create_achievements_table.php
├── 2025_12_12_230427_create_additional_modules_tables.php
├── 2025_12_13_023729_add_is_superadmin_to_users_table.php
└── 2025_12_13_030031_create_profile_tables.php
```

---

## Routing & API

### Route Groups

```php
// routes/web.php

// 1. Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/berita', [PublicPostController::class, 'index'])->name('berita.index');
Route::get('/berita/{post:slug}', [PublicPostController::class, 'show'])->name('berita.show');
Route::get('/prestasi', [PublicAchievementController::class, 'index'])->name('prestasi.index');

// Profile routes
Route::prefix('profil')->group(function () {
    Route::get('/visi-misi', [PublicProfileController::class, 'visiMisi']);
    Route::get('/bagan-organisasi', [PublicProfileController::class, 'baganOrganisasi']);
    Route::get('/dosen', [PublicProfileController::class, 'dosen']);
    // ... more profile routes
});

// Additional modules (public)
Route::get('/ppid', [PublicAdditionalController::class, 'ppid']);
Route::get('/zona-integritas', [PublicAdditionalController::class, 'zonaIntegritas']);
Route::get('/alumni', [PublicAdditionalController::class, 'alumni']);
Route::get('/survei-kepuasan', [PublicAdditionalController::class, 'survei']);
Route::post('/survei-kepuasan', [PublicAdditionalController::class, 'storeSurvei']);
Route::get('/layanan-internal', [PublicAdditionalController::class, 'layanan']);

// Language switching
Route::get('lang/{locale}', function ($locale) {
    session(['locale' => $locale]);
    return redirect()->back();
})->name('lang.switch');

// 2. Admin Routes (authenticated)
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resource routes (CRUD)
    Route::resource('/posts', AdminPostController::class);
    Route::resource('/achievements', AchievementsController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/staff', StaffController::class);
    Route::resource('/ppid', PpidController::class);
    Route::resource('/integrity-zones', IntegrityZoneController::class);
    Route::resource('/alumni', AlumniController::class);
    Route::resource('/satisfaction-surveys', SatisfactionSurveyController::class);
    Route::resource('/internal-services', InternalServiceController::class);
    Route::resource('/static-pages', StaticPageController::class)->only(['index', 'edit', 'update']);

    // Custom routes
    Route::post('/achievements/import', [AchievementsController::class, 'import']);
    Route::get('/achievements/export', [AchievementsController::class, 'export']);
});

// 3. Authentication Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
```

### Inertia Request Flow

```
1. User clicks link
       │
       ▼
2. Inertia intercepts (if same domain)
       │
       ▼
3. XHR request to Laravel
       │
       ▼
4. Laravel processes request
       │
       ▼
5. Controller returns Inertia::render()
       │
       ▼
6. JSON response with component & props
       │
       ▼
7. Inertia swaps Vue component
       │
       ▼
8. Vue reactively updates DOM
```

---

## Authentication & Authorization

### Authentication Flow

```
┌─────────────┐      ┌─────────────┐      ┌─────────────┐
│   Login     │ ──▶  │   Breeze    │ ──▶  │   Sanctum   │
│    Form     │      │  Validate   │      │   Session   │
└─────────────┘      └─────────────┘      └─────────────┘
                                                 │
                                                 ▼
┌─────────────┐      ┌─────────────┐      ┌─────────────┐
│   Access    │ ◀──  │  Middleware │ ◀──  │   Cookie    │
│   Granted   │      │    Check    │      │   Stored    │
└─────────────┘      └─────────────┘      └─────────────┘
```

### Middleware Stack

```php
// Middleware yang digunakan
'auth'      => Authenticate::class,           // Check authentication
'verified'  => EnsureEmailIsVerified::class,  // Check email verified
'guest'     => RedirectIfAuthenticated::class, // Redirect if logged in
```

### User Roles

```php
// User Model
class User extends Authenticatable
{
    // Superadmin check
    public function isSuperAdmin(): bool
    {
        return $this->is_superadmin === true;
    }
}

// Usage in controller
if (!auth()->user()->isSuperAdmin()) {
    abort(403, 'Unauthorized action.');
}
```

---

## File Storage

### Storage Configuration

```php
// config/filesystems.php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

### File Upload Pattern

```php
// Controller
public function store(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    // Store file
    $path = $request->file('image')->store('posts', 'public');

    // Save to database
    Post::create([
        'image' => $path,
        // ...
    ]);
}
```

### Storage Structure

```
storage/app/public/
├── posts/              # Post images
├── achievements/       # Achievement photos & proofs
├── staff/              # Staff photos
├── ppid/               # PPID documents
└── ...
```

---

## Build & Deployment

### Vite Configuration

```javascript
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,  // Hot reload
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});
```

### TypeScript Configuration

```json
// tsconfig.json
{
    "compilerOptions": {
        "target": "ESNext",
        "module": "ESNext",
        "moduleResolution": "bundler",
        "strict": true,
        "jsx": "preserve",
        "isolatedModules": true,
        "esModuleInterop": true,
        "skipLibCheck": true,
        "noEmit": true,
        "paths": {
            "@/*": ["./resources/js/*"],
            "ziggy-js": ["./vendor/tightenco/ziggy"]
        }
    },
    "include": [
        "resources/js/**/*.ts",
        "resources/js/**/*.vue",
        "resources/js/types/**/*.d.ts"
    ]
}
```

### Build Process

```bash
# Development
npm run dev          # Start Vite dev server with HMR

# Production
npm run build        # 1. Type check (vue-tsc)
                     # 2. Build assets (vite build)
                     # 3. Generate manifest.json
```

### Output Structure

```
public/build/
├── assets/
│   ├── app-[hash].js           # Main bundle
│   ├── app-[hash].css          # Main styles
│   ├── Home-[hash].js          # Page chunk
│   ├── AdminLayout-[hash].js   # Layout chunk
│   └── ...                     # Other chunks
└── manifest.json               # Asset manifest
```

### Deployment Commands

```bash
# Production deployment
composer install --optimize-autoloader --no-dev
npm ci
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## Diagram Arsitektur

### Request Lifecycle

```
┌─────────────────────────────────────────────────────────────────────┐
│                           REQUEST LIFECYCLE                          │
└─────────────────────────────────────────────────────────────────────┘

  Browser                  Laravel                    Vue.js
     │                        │                          │
     │  1. HTTP Request       │                          │
     │──────────────────────▶│                          │
     │                        │                          │
     │                        │  2. Route Matching       │
     │                        │────────┐                 │
     │                        │        │                 │
     │                        │◀───────┘                 │
     │                        │                          │
     │                        │  3. Middleware           │
     │                        │────────┐                 │
     │                        │        │                 │
     │                        │◀───────┘                 │
     │                        │                          │
     │                        │  4. Controller           │
     │                        │────────┐                 │
     │                        │        │                 │
     │                        │◀───────┘                 │
     │                        │                          │
     │                        │  5. Inertia::render()    │
     │                        │────────────────────────▶│
     │                        │                          │
     │                        │  6. JSON Response        │
     │  ◀─────────────────────│◀─────────────────────── │
     │                        │                          │
     │  7. Update DOM         │                          │
     │────────┐               │                          │
     │        │               │                          │
     │◀───────┘               │                          │
     │                        │                          │
```

### Component Hierarchy

```
App
├── PublicLayout
│   ├── Navbar
│   │   └── LanguageSwitcher
│   ├── [Page Content]
│   │   ├── Banner
│   │   ├── ArticleCard
│   │   ├── AchievementCard
│   │   └── ...
│   └── Footer
│
└── AdminLayout
    ├── Sidebar
    │   └── Navigation
    ├── Header
    │   └── UserDropdown
    └── [Page Content]
        ├── DataTable
        ├── Form Components
        │   ├── Input
        │   ├── Select
        │   ├── Tiptap Editor
        │   └── FileUpload
        └── Modal
```

---

## Performance Considerations

### Frontend Optimization

| Teknik | Implementasi |
|--------|--------------|
| **Code Splitting** | Vite automatic chunking per page |
| **Lazy Loading** | Dynamic imports untuk pages |
| **Tree Shaking** | ES modules + Vite |
| **Asset Hashing** | Cache busting via manifest |
| **CSS Purging** | Tailwind CSS purge unused styles |

### Backend Optimization

| Teknik | Implementasi |
|--------|--------------|
| **Route Caching** | `php artisan route:cache` |
| **Config Caching** | `php artisan config:cache` |
| **View Caching** | `php artisan view:cache` |
| **Query Optimization** | Eager loading relationships |
| **Database Indexing** | Index on frequently queried columns |

---

## Security Measures

| Layer | Protection |
|-------|------------|
| **Application** | CSRF tokens, XSS protection, SQL injection prevention |
| **Authentication** | Bcrypt password hashing, session management |
| **Authorization** | Middleware guards, role-based access |
| **Transport** | HTTPS enforcement, secure cookies |
| **Input** | Form request validation, file type restrictions |

---

*Dokumen ini terakhir diperbarui: Januari 2025*
