# Kadellabs LMS - Setup Guide

This is a complete Learning Management System built with Laravel, PHP, MySQL, and Bootstrap.

## Prerequisites
- PHP 8.2+
- Composer
- MySQL/MariaDB
- Node.js & NPM

## Setup Instructions

1. **Clone/Download** the project to your local server directory (e.g., `htdocs` for XAMPP).
2. **Install PHP Dependencies**:
   ```bash
   composer install
   ```
3. **Install Node Dependencies & Build Assets**:
   ```bash
   npm install
   npm run build
   ```
4. **Configure Environment**:
   - Open `.env` and set your database credentials.
   - Create a database named `kadellabs_lms` in your MySQL server.
5. **Database Migration & Seeding**:
   - This will create all tables and sample data (Admin and Trainees).
   ```bash
   php artisan migrate --seed
   ```
6. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```
7. **Start the Server**:
   ```bash
   php artisan serve
   ```

## Default Login Credentials

### Admin
- **Email**: `admin@lms.com`
- **Password**: `password`

### Trainee
- **Email**: `trainee1@lms.com` or `trainee2@lms.com`
- **Password**: `password`

## Project Features
- **Admin**: Dashboard analytics, Trainee management, Course creation, Lesson organization (YouTube integration), Quiz creation (MCQs), Reports.
- **Trainee**: Dashboard, Course player with YouTube embed, Progress tracking, Quiz attempts, Result calculation, PDF Certificate download.

## Technology Stack
- **Backend**: Laravel (MVC), Eloquent ORM.
- **Frontend**: Blade, Bootstrap 5, Font Awesome.
- **PDF Generation**: barryvdh/laravel-dompdf.
- **Auth**: Laravel Breeze.
