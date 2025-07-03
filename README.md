
# Laventory

Laventory is an inventory management system built with Laravel and Vite. It provides tools for managing products, categories, stock logs, users, and integrates with Telegram for notifications. The project is structured for scalability and maintainability, following Laravel best practices.

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
   git clone <repository-url>
   cd laventory
   ```
2. Install PHP dependencies:
   ```sh
   composer install
   ```
3. Install Node.js dependencies:
   ```sh
   npm install
   ```
4. Copy the example environment file and configure:
   ```sh
   cp .env.example .env
   # Edit .env as needed
   ```
5. Generate application key:
   ```sh
   php artisan key:generate
   ```
6. Run migrations and seeders:
   ```sh
   php artisan migrate --seed
   ```
7. Build frontend assets:
   ```sh
   npm run build
   ```
8. Start the development server:
   ```sh
   php artisan serve
   ```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
This project is open-source and available under the [MIT license](LICENSE).
