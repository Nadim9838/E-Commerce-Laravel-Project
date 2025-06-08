<h1 align="center">🛒 Nadim E-Commerce Project</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-9.x-red?style=for-the-badge&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/PHP-8.x-blue?style=for-the-badge&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-Database-lightblue?style=for-the-badge&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/Bootstrap-5-purple?style=for-the-badge&logo=bootstrap&logoColor=white" />
</p>

<p align="center">
  <b>A complete E-Commerce website built with Laravel</b> — supporting dynamic products, categories, shopping cart, checkout, and more.
</p>

---

## 🔧 Built With

- ⚙️ **Laravel** — Used Eloquent ORM, Middleware, Observers
- 🧠 **PHP** — Core backend logic
- 🎨 **HTML5, CSS3, Bootstrap 5** — Responsive design
- 💡 **JavaScript & jQuery** — Frontend interactivity
- 🔄 **Ajax** — For smooth data loading
- 🗃️ **MySQL** — Database system

---

## ✨ Key Features

- ✅ User Authentication & Registration
- ✅ Dynamic Product Listing
- ✅ Product Categories & Filtering
- ✅ Add to Cart, Update Quantity
- ✅ Checkout & Order Placement
- ✅ Admin Panel to Manage Products
- ✅ Laravel Middleware for Route Protection
- ✅ Observer to Monitor Model Events
- ✅ Responsive Design for All Devices

---

## 🛠️ Installation

Clone the project and run locally:

```bash
git clone https://github.com/nadim9838nadim9838/E-Commerce.git
cd E-Commerce

# Install dependencies
composer install

# Copy .env and generate key
cp .env.example .env
php artisan key:generate

# Set your DB credentials in .env, then run:
php artisan migrate

# Serve the app
php artisan serve
