# Sistem Manajemen Alumni TPL SV IPB

[![Laravel](https://img.shields.io/badge/Laravel-12.30.1-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4.0+-blue.svg)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

Sistem manajemen alumni yang komprehensif untuk Program Studi Teknologi Pangan dan Veteriner (TPL SV) Institut Pertanian Bogor (IPB). Platform ini dirancang untuk memperkuat jaringan alumni, memfasilitasi komunikasi, dan mendukung pengembangan karir alumni.

## 🎯 Fitur Utama

### 👥 Manajemen Alumni
- **Registrasi Alumni**: Sistem registrasi dengan verifikasi OTP via email
- **Profil Lengkap**: Data pribadi, riwayat pendidikan, dan karir
- **Update Data**: Fitur untuk memperbarui informasi alumni secara berkala
- **Foto Profil**: Upload dan manajemen foto profil

### 📊 Dashboard Admin
- **Dashboard Statistik**: Ringkasan data alumni, informasi, dan alumni berprestasi
- **Manajemen Alumni**: CRUD lengkap untuk data alumni
- **Manajemen Informasi**: Publikasi berita, pengumuman, dan informasi penting
- **Kategori Informasi**: Sistem kategorisasi untuk mengorganisir konten
- **Alumni Berprestasi**: Showcase prestasi dan pencapaian alumni

### 🌐 Portal Publik
- **Landing Page**: Halaman utama dengan statistik dan navigasi
- **Informasi Terkini**: Berita, pengumuman, dan update dari kampus
- **Profil Alumni Berprestasi**: Galeri alumni yang telah berprestasi
- **Tentang Kami**: Informasi tentang program studi dan universitas
- **FAQ**: Pertanyaan umum dan jawaban

### 🔐 Sistem Autentikasi
- **Login Multi-Role**: Admin dan Alumni
- **Verifikasi OTP**: Sistem keamanan dengan kode OTP via email
- **Reset Password**: Fitur lupa password dengan verifikasi
- **Session Management**: Manajemen sesi yang aman

## 🏗️ Arsitektur & Teknologi

### Backend Framework
- **Laravel 12.30.1**: Framework PHP modern dengan fitur MVC
- **PHP 8.2+**: Bahasa pemrograman utama
- **MySQL**: Database relasional untuk penyimpanan data

### Frontend Technologies
- **TailwindCSS 4.0+**: Framework CSS utility-first
- **Vite**: Build tool modern untuk development
- **Feather Icons**: Icon library yang ringan
- **Alpine.js**: JavaScript framework untuk interaktivitas

### Key Packages & Libraries

#### PHP Dependencies
```json
{
  "laravel/framework": "^12.0",
  "laravel/sanctum": "^4.0",
  "laravel/tinker": "^2.10.1"
}
```

#### Development Dependencies
```json
{
  "fakerphp/faker": "^1.23",
  "laravel/pail": "^1.2.2",
  "laravel/pint": "^1.24",
  "laravel/sail": "^1.41",
  "mockery/mockery": "^1.6",
  "nunomaduro/collision": "^8.6",
  "phpunit/phpunit": "^11.5.3"
}
```

#### Frontend Dependencies
```json
{
  "tailwindcss": "^4.0.0",
  "vite": "^7.0.4",
  "axios": "^1.11.0",
  "feather-icons": "^4.29.2",
  "concurrently": "^9.0.1"
}
```

## 📁 Struktur Proyek

```
alumni_sv_tpl_be/
├── app/
│   ├── Http/Controllers/
│   │   ├── Web/
│   │   │   ├── Admin/          # Controller admin panel
│   │   │   ├── Alumni/         # Controller fitur alumni
│   │   │   └── UserGuest/      # Controller halaman publik
│   │   └── Api/                # API controllers
│   ├── Models/                 # Eloquent models
│   ├── Mail/                   # Email templates
│   └── Providers/              # Service providers
├── database/
│   ├── migrations/             # Database migrations
│   ├── factories/              # Model factories
│   └── seeders/                # Database seeders
├── public/                     # Public assets
├── resources/
│   ├── css/                    # Stylesheets
│   ├── js/                     # JavaScript files
│   ├── views/                  # Blade templates
│   └── images/                 # Static images
├── routes/
│   ├── web.php                 # Web routes
│   └── api.php                 # API routes
├── tests/                      # Test files
└── config/                     # Configuration files
```

## 🚀 Instalasi & Setup

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & npm
- MySQL 8.0+
- Git

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/eicheich/alumni_sv_tpl_be.git
cd alumni_sv_tpl_be
```

2. **Install PHP Dependencies**
```bash
composer install
```

3. **Install Node Dependencies**
```bash
npm install
```

4. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Database Configuration**
Edit file `.env` dan konfigurasikan database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alumni_sv_tpl_be
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. **Database Migration & Seeding**
```bash
php artisan migrate
php artisan db:seed
```

7. **Build Assets**
```bash
npm run build
# atau untuk development
npm run dev
```

8. **Start Development Server**
```bash
php artisan serve
```

## 📊 Alur Sistem

### 1. Registrasi Alumni
```
User mengakses halaman registrasi
    ↓
Input NIM/NIP untuk validasi
    ↓
Sistem kirim OTP ke email
    ↓
Verifikasi OTP
    ↓
Lengkapi profil (data pribadi, pendidikan, karir)
    ↓
Registrasi berhasil
```

### 2. Login & Autentikasi
```
User input email & password
    ↓
Sistem validasi kredensial
    ↓
Redirect berdasarkan role (Admin/Alumni)
    ↓
Akses dashboard sesuai role
```

### 3. Manajemen Data Alumni
```
Alumni login ke sistem
    ↓
Update profil & foto
    ↓
Tambah riwayat pendidikan
    ↓
Tambah pengalaman karir
    ↓
Data tersimpan di database
```

### 4. Admin Management
```
Admin login ke panel admin
    ↓
Kelola data alumni (CRUD)
    ↓
Publikasikan informasi
    ↓
Kelola kategori informasi
    ↓
Manage alumni berprestasi
```

## 🔗 API Endpoints

### Public API
```http
GET /api/alumni/{id} - Get alumni profile by ID
```

### Admin API (Under Development)
```http
POST /api/v1/admin/login - Admin authentication
```

## 🎨 Tema & Styling

### Color Scheme
- **Primary**: Purple (#7C3AED - #8B5CF6)
- **Secondary**: Purple variants (darker tones)
- **Accent**: White, Gray tones
- **Success**: Green tones
- **Error**: Red tones

### Design Principles
- **Responsive**: Mobile-first approach
- **Accessible**: WCAG compliant
- **Modern**: Clean, minimal design
- **Consistent**: Unified color scheme and typography

## 🧪 Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter TestName

# Run with coverage
php artisan test --coverage
```

### Test Structure
```
tests/
├── Feature/          # Feature tests
└── Unit/            # Unit tests
```

## 📈 Performance & Optimization

### Caching Strategy
- **View Cache**: Blade template caching
- **Route Cache**: Route caching untuk production
- **Config Cache**: Configuration caching

### Asset Optimization
- **Vite Build**: Modern bundling dengan code splitting
- **Image Optimization**: Responsive images
- **Lazy Loading**: Progressive loading

## 🔒 Keamanan

### Authentication & Authorization
- **Laravel Sanctum**: API token authentication
- **Role-based Access**: Admin vs Alumni permissions
- **OTP Verification**: Email-based verification
- **Password Hashing**: Bcrypt hashing

### Data Protection
- **Encrypted IDs**: URL parameter encryption
- **CSRF Protection**: Cross-site request forgery protection
- **Input Validation**: Comprehensive validation rules
- **SQL Injection Prevention**: Eloquent ORM protection

## 📚 Dokumentasi API

### Authentication Endpoints

#### Login
```http
POST /auth/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "password"
}
```

#### Register
```http
POST /auth/register
Content-Type: application/json

{
  "nim": "123456789",
  "email": "user@example.com"
}
```

#### OTP Verification
```http
POST /auth/verify-otp
Content-Type: application/json

{
  "otp_code": "123456"
}
```

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Development Guidelines
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation
- Use meaningful commit messages

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Tim Pengembang

- **Project Lead**: Eicheich
- **Institution**: Institut Pertanian Bogor (IPB)
- **Program**: Teknologi Pangan dan Veteriner (TPL SV)

## 🙏 Acknowledgments

- Laravel Framework Community
- Institut Pertanian Bogor (IPB)
- Program Studi TPL SV
- Alumni TPL SV IPB

## 📞 Support

Untuk pertanyaan atau dukungan teknis, silakan hubungi tim pengembang atau buat issue di repository ini.

---

**Dibangun dengan ❤️ untuk komunitas alumni TPL SV IPB**
