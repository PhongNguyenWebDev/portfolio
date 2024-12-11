# Profile Phong Nguyen

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/PhongNguyenWebDev/laravel_inventory_management/actions">
    <img src="https://img.shields.io/github/workflow/status/PhongNguyenWebDev/laravel_inventory_management/tests" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

---

## 🚀 Giới thiệu

**Profile Phong Nguyen** là một ứng dụng Single Page Application (SPA) sử dụng **Vue.js** cho frontend và **Laravel** cho backend.

---

## 🛠️ Công nghệ sử dụng

### Backend
- **Laravel 11.x**  
- PHP >= 8.x  
- MySQL 8.0

### Frontend
- **Vue.js 3.x**  
- Vuex  
- Axios  
- TailwindCSS  

---
⚙️ ## Tính năng
- ✅ Dashboard CRUD
Thêm, sửa, xoá, xem dữ liệu thông qua Vue.js và Laravel REST API.
- ✅ Đăng nhập bảo mật
Dùng JWT và cookies HTTP-only.
- ✅ Quản lý thông tin social media
Thêm liên kết và quản lý thông tin dễ dàng.

---
```bash
git clone https://github.com/PhongNguyenWebDev/portfolio.git
cd portfolio
```
## Cài đặt Backend
# Di chuyển đến thư mục backend:
```bash
cd backend
```
# Cài đặt các dependencies Laravel:
```bash
composer install
```
# Sao chép .env.example và thiết lập:
```bash
cp .env.example .env
```
# Tạo key Laravel:
```bash
php artisan key:generate
```
# Chạy migrations:
```bash
php artisan migrate --seed
```
# Khởi động server Laravel:
```bash
php artisan serve
```
## Cài đặt Frontend
# Di chuyển đến thư mục frontend:
```bash
cd ../frontend
```
# Cài đặt các dependencies Vue.js:
```bash
npm install
```
# Khởi động Vue.js development server:
```bash
npm run dev
```
---
🔗 Truy cập ứng dụng:
- Backend: http://localhost:8000
- Frontend: http://localhost:5173

---

## 📂 Cấu trúc Dự án

```plaintext
laravel_inventory_management/
├── backend/                    # Laravel Backend
│   ├── app/
│   ├── database/
│   ├── routes/
│   └── ...
│
├── frontend/                   # Vue.js Frontend
│   ├── assets/
│   │   ├── tailwindcss/
│   │   └── images/
│   ├── components/
│   ├── views/
│   └── main.js
│
├── docker-compose.yml           # Docker configuration
├── README.md
└── ...
```
