# Stock Management System

Date: 2025-06-29

# Overview

A Laravel-based Stock Management System to manage stock items, procurements, and purchase orders with role-based access control and audit trail logging.

The `users` table includes a `role` column (e.g., `Admin`, `Manager`, `Staff`) to distinguish between user types.

Only authenticated users with the appropriate role are allowed to access certain routes via middleware.

Laravel's built-in authentication system is used.

  - Some UI `screenshots` of the system are included in the `screenshots/` folder for reference.

# Features & Improvements

  - Follows Service and Repository Pattern for clean, maintainable architecture.
  - Custom RoleMiddleware restricts access to staff and Manager-specific routes.
  - Only users with the roles Admin or Manager are authorized to approve procurement requests.
  - Upon approval, the system automatically generates a corresponding Purchase Order (PO) linked to the approved procurement.
  - Role-based Access Control using Laravel middleware.
  - Responsive Dashboard with proper Bootstrap navbar toggle for mobile.
  - Advanced Filtering on data:
    Status,Customer name (search),Date range,Sort (ASC, DESC)
  - Auto-submitting filters using jQuery.
  - Reset Button clears filter query params.
  - Color-coded status badges (e.g., Opened, Pending).
  - Responsive tables using Bootstrap .table-responsive.
  - Audit Trail logs stock and procurement changes.


---

# Installation Instructions

git clone https://github.com/harsha198805/Stock-Management-System.git

cd Stock-Management-System

composer install

npm install

npm run build

cp .env.example .env

php artisan key:generate

Set DB connection details

php artisan migrate

php artisan db:seed

php artisan serve

System login link

http://127.0.0.1:8000/login

Admin username = admin@example.com

password = 12345678

Manager username = manager@example.com

password = 12345678

Staff Ussername = staff@example.com

password = 12345678