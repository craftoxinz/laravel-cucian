# 🧺 Cucian.id — Sistem Manajemen Laundry


### Langkah Instalasi

```bash
# 1. Clone repository
git clone https://github.com/craftoxinz/laravel-cucian.git
cd laravel-cucian

# 2. Install dependencies
composer install

# 3. Copy file environment
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Setup database di .env
DB_DATABASE=laundry_db
DB_USERNAME=root
DB_PASSWORD=

# 6. Jalankan migration & seeder
php artisan migrate:fresh --seed

# 7. Jalankan server
php artisan serve
```

Buka browser: `http://127.0.0.1:8000`

---
## 👤 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@laundryku.com | Admin123 |
| Kasir | kasir@laundryku.com | Kasir123 |

---
```
## 📁 Struktur Folder
laundry-app/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # AuthController, OrderController, dll
│   │   └── Middleware/      # RoleMiddleware
│   └── Models/              # User, Order, Pelanggan, dll
├── database/
│   ├── migrations/          # Struktur tabel
│   └── seeders/             # Data awal
├── resources/
│   └── views/               # Blade templates (Tabler UI)
└── routes/
└── web.php                  # Route aplikasi
```
---

### 📸 Screenshot

> Dashboard

<img width="1870" height="926" alt="image" src="https://github.com/user-attachments/assets/d7ebdce0-8df7-43f5-b150-26d99238e483" />

> Order

<img width="1918" height="927" alt="image" src="https://github.com/user-attachments/assets/0fd6a12d-64de-45d9-ba43-030e309d1805" />

>Laporan

<img width="1918" height="927" alt="image" src="https://github.com/user-attachments/assets/8e43747a-d70b-454e-8399-abb6ae915187" />

---
