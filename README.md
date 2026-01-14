# 🥟 TEAMZ4K – Dimsayku

## 📌 Deskripsi Proyek
**TEAMZ4K – Dimsayku** adalah aplikasi manajemen tugas dan operasional UMKM berbasis **Laravel** yang dirancang untuk membantu digitalisasi proses bisnis usaha dimsum. Aplikasi ini mendukung pengelolaan tugas harian, data produk, serta alur kerja operasional secara terstruktur dan efisien.

Proyek ini dikembangkan menggunakan standar pengembangan perangkat lunak modern dengan menerapkan konsep **CRUD (Create, Read, Update, Delete)**, **Eloquent ORM**, **Form Validation**, **Controller**, dan **Database Migration**.  
Pengembangan aplikasi ini merupakan bagian dari tugas mata kuliah **Web Framework & Rekayasa Perangkat Lunak**, dengan fokus pada penerapan **arsitektur perangkat lunak yang baik**, **kolaborasi tim**, serta **implementasi CI/CD dan deployment berbasis cloud**.

---

## 👥 Anggota Tim
| Nama Lengkap | NIM |
| :--- | :--- |
| **Agus Saputra Hamzah** | 2310120018 |
| **Khairan Noor Fadhlillah** | 2310120022 |
| **Zinedine Izaaz** | 2310120014 |

---

## 🚀 Fitur & Implementasi Laravel
Aplikasi ini mengimplementasikan fitur inti Laravel sebagai berikut:

- **Arsitektur Dasar:** Routing, View, dan Controller  
- **Templating Engine:** Blade Template (layouting & reusable components)  
- **Frontend:** Bootstrap / Tailwind CSS  
- **Database Management:** Migration, Eloquent ORM, Collection  
- **Business Logic:** Form Processing, Form Validation, CRUD  
- **Security & Middleware:** Authentication, Middleware, Policy, Session  
- **Advanced Feature:** File Upload (integrasi dengan Cloudinary)

---

## 🏗️ Dokumentasi CI/CD & Deployment  
*(Latihan Week 12)*

### 1. Arsitektur CI/CD Pipeline
Pipeline CI/CD dibangun menggunakan **GitHub Actions** sebagai orkestrator. Alur kerja dimulai dari pengembangan lokal, dilanjutkan dengan push ke feature branch, kemudian divalidasi melalui **Pull Request** sebelum di-merge ke branch utama.

---

### 2. Workflow GitHub Actions
Konfigurasi workflow berada pada folder `.github/workflows/` dengan detail sebagai berikut:

- **Trigger:**  
  Pipeline berjalan otomatis saat terdapat Pull Request ke branch `main` atau `staging`.

- **Runner:**  
  Menggunakan environment `ubuntu-latest`.

- **Langkah Utama:**
  1. **Checkout Code** – Mengambil source code terbaru dari repository  
  2. **Setup PHP & Dependencies** – Instalasi PHP 8.2 dan Composer  
  3. **Environment Preparation** – Menyalin `.env.example` dan generate `APP_KEY`  
  4. **Automated Testing** – Menjalankan `php artisan test` menggunakan SQLite `:memory:` untuk memastikan fitur CRUD dan validasi berjalan dengan baik sebelum merge

---

### 3. Branching Strategy
Tim menerapkan strategi branching kolaboratif sebagai berikut:

- `main` → Branch produksi yang stabil dan telah melalui proses review  
- `staging` → Branch integrasi untuk pengujian internal tim sebelum rilis  
- `feature/update-title` → Contoh branch fitur untuk perubahan spesifik (Latihan Week 12)  
- `fix-total` → Branch untuk perbaikan bug dan konsolidasi fitur utama  

---

### 4. Deployment Staging & Production
Deployment aplikasi dilakukan menggunakan **Vercel** dengan serverless runtime:

- **Staging Environment**  
  Terhubung langsung dengan branch `staging`. Setiap perubahan akan otomatis dideploy ke URL staging untuk proses Quality Assurance (QA).

- **Production Environment**  
  Terhubung dengan branch `main`. Deployment hanya dilakukan setelah kode dinyatakan stabil dan Pull Request disetujui oleh Ketua Tim.

---

### 5. Mekanisme Rollback
Untuk menjaga stabilitas aplikasi, disiapkan dua mekanisme rollback:

- **Vercel Rollback**  
  Menggunakan fitur *Instant Rollback* pada dashboard Vercel untuk mengembalikan aplikasi ke versi deployment terakhir yang sukses.

- **Git Revert / Reset**  
  Menggunakan perintah `git revert <commit_hash>` untuk membatalkan commit bermasalah, yang kemudian akan memicu redeploy otomatis.

---

## 🌐 Akses Aplikasi
- 🧪 **Staging URL (Vercel)**  
  https://dimsaykuu-git-staging-zinedineizaazs-projects.vercel.app/

- 🚀 **Production URL (Vercel)**  
  https://dimsaykuu.vercel.app/

---

## ▶️ Video Demo
📺 **YouTube – Demo & Dokumentasi Aplikasi**  
https://youtu.be/PIzHsRK0GaA?si=E_dmeoGA8DzcaE9u


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

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
