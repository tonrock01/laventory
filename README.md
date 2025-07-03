
# Laventory

Laventory is an inventory management system built with Laravel 12. It provides tools for managing products, categories, stock logs, users, and integrates with Telegram for notifications. The project is structured for scalability and maintainability, following Laravel best practices.

## Features
- Product and category management
- Stock logging and notifications
- User authentication and roles
- RESTful API endpoints
- Activity logging
- Telegram integration for alerts
- Versioning and auditing

## Getting Started

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL or compatible database

### Installation
1. Clone the repository:
   ```sh
   git clone https://github.com/tonrock01/laventory.git
   cd laventory
   ```
2. Copy `.env.example` to `.env` and update environment variables as needed.
3. Obtain a Telegram bot token and set `TELEGRAM_BOT_TOKEN` in your `.env` file.
4. Install PHP dependencies:
   ```sh
   composer install
   ```
5. Install Node.js dependencies:
   ```sh
   npm install
   ```
6. Generate the application key:
   ```sh
   php artisan key:generate
   ```
7. Run database migrations:
   ```sh
   php artisan migrate
   ```
8. Generate Passport encryption keys:
   ```sh
   php artisan passport:keys
   ```
9. Create a personal access client for Passport:
   ```sh
   php artisan passport:client --personal
   ```
10. Seed the database:
   ```sh
   php artisan db:seed CategorySeeder
   php artisan db:seed PermissionSeeder
   php artisan db:seed RoleSeeder
   php artisan db:seed AdminSeeder
   ```
11. Start the development server and queue worker:
   ```sh
   php artisan serve
   php artisan queue:work
   ```
12. Open your browser and navigate to [http://localhost:8000/api/docs#/](http://localhost:8000/api/docs#/) to test the API endpoints.