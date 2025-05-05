# 📅 EasyBooking

**EasyBooking** is a modular and scalable reservation management system designed for businesses like restaurants, beauty salons, medical offices, coworking spaces, and more. Built for customization and resale, it offers a robust admin panel, a public booking portal, and a secure API backend.

---

## 🧱 Project Structure
```bash
easybooking/
├── admin/ → Frontend (Angular): Admin dashboard
├── api/ → Backend (Laravel): RESTful API
├── client/ → Frontend (Angular): Public booking interface
```
---

## 🚀 Tech Stack

| Layer          | Technology                 |
|----------------|----------------------------|
| Frontend       | Angular 17                 |
| Backend        | Laravel 11                 |
| Database       | MySQL / PostgreSQL         |
| Auth           | Laravel Sanctum / JWT      |
| Admin UI       | NG-ZORRO / Angular Material |
| Client UI      | TailwindCSS / Custom UI    |

---

## ⚙️ Quick Setup

### Clone the repository

```bash
git clone https://github.com/your-username/easybooking.git
cd easybooking
```
---

## 📦 Backend (Laravel API)
```bash
cd api
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```
Make sure to configure your .env file with the correct database credentials.

---

### 🌐 Frontend Admin
```bash
cd ../admin
npm install
ng serve --open
```
---

### 🌐 Frontend Client
```bash
cd ../client
npm install
ng serve --open
```
---

### 📚 MVP Features
- User authentication (login/register)
- Role management (admin/client)
- Service catalog browsing
- Booking with availability calendar
- Reviews and ratings
- Admin dashboard with stats
- Basic reporting

---

### 👥 User Roles
- **Admin**: Manage users, services, availability, reports
- **Client**: Browse, book, view history, write reviews
---

### 🎯 Vision
EasyBooking is built as a **plug-and-play** solution for any service-based business needing a reliable, modern booking system. Easily adaptable for different industries and business models.

---

### ✨ Authors
Developed by:
- Sebastian Zavala
- Jocelyn Llamas