# Courier API - Laravel Project

REST API sederhana untuk manajemen data kurir menggunakan Laravel.

---

# Clone Repository

Untuk mengambil project dari GitHub:

```bash
git clone https://github.com/Arin1206/courier-api.git
````

Masuk ke folder project:

```bash
cd courier-api
```

---

# Install Dependencies

Install dependency Laravel:

```bash
composer install
```

---

# Setup Environment

Copy file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

# Setup Database

Buat database untuk development:

```sql
CREATE DATABASE courier_backend;
```

Buat database untuk testing:

```sql
CREATE DATABASE courier_test;
```

Edit file `.env`:

```env
DB_DATABASE=courier_backend
DB_USERNAME=root
DB_PASSWORD=
```

Untuk testing Laravel akan menggunakan `.env.testing`:

```env
DB_DATABASE=courier_test
DB_USERNAME=root
DB_PASSWORD=
```

---

# Migration Database

Jalankan migration:

```bash
php artisan migrate
```

Untuk reset database:

```bash
php artisan migrate:fresh
```

---

# Menjalankan Server

Jalankan server Laravel:

```bash
php artisan serve
```

Akses API:

```
http://127.0.0.1:8000/api/couriers
```

---

# API Endpoints

Base URL:

```
/api/couriers
```

---

## Get all couriers

```http
GET /api/couriers
```

Query Parameters:

* search=budi+agung → search berdasarkan nama
* level=2,3 → filter berdasarkan level
* sort=registered_at → sorting berdasarkan tanggal

---

## Show courier

```http
GET /api/couriers/{courier}
```

---

## Create courier

```http
POST /api/couriers
```

Example request:

```json
{
  "name": "J&T Express",
  "email": "jnt@test.com",
  "phone": "08999999999",
  "level": 3,
  "registered_at": "2024-01-01",
  "is_active": true
}
```

---

## Update courier

```http
PUT /api/couriers/{courier}
```

---

## Delete courier

```http
DELETE /api/couriers/{courier}
```

---

# Feature Testing

Jalankan semua test:

```bash
php artisan test
```

atau:

```bash
vendor/bin/phpunit
```

---

# Test Coverage

* Create courier
* Update courier
* Delete courier
* Show courier
* List courier (pagination)
* Search courier (multi keyword)
* Filter by level (2,3)
* Sort by registered_at
* Validation test

# Postman
```bash
https://www.postman.com/api-testing-4937/courier-backend/collection/l1ou9qn/crud-courier?action=share&creator=33479345&active-environment=33479345-cc213d6e-bfc8-4644-8823-8ab7b9924724
```
---

# Tech Stack

* Laravel 10+
* MySQL
* PHPUnit
* Eloquent ORM
