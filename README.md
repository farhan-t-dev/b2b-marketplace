# B2B Marketplace MVP

A production-grade multi-vendor marketplace platform built with Laravel 11, Docker, and MySQL.

## ✨ Features

- **Multi-role system**: Buyer, Seller, Admin
- **Product variants** with SKU, price, and inventory management
- **Shopping cart** with real-time updates
- **Order lifecycle** management (pending → confirmed → shipped → delivered)
- **Commission tracking** for sellers
- **Search and filtering** (ready for MeiliSearch)
- **REST API** with token authentication
- **Docker Compose** for local development and production
- **Fully tested** with unit, feature, and API tests

## 🏗️ Tech Stack

- **Backend**: Laravel 11 + PHP 8.2
- **Database**: MySQL 8.0
- **API**: REST + Laravel Sanctum
- **Search**: MeiliSearch (optional)
- **Frontend**: Blade + Tailwind CSS + Alpine.js
- **Infrastructure**: Docker + Nginx
- **Testing**: PHPUnit + Laravel Testing
- **CI/CD**: GitHub Actions ready

## 📋 Quick Start

### Prerequisites

- Docker & Docker Compose
- Git

### Local Setup

1. **Clone the repository**
   ```bash
   git clone <repo-url>
   cd MarketPlace
   ```

2. **Copy environment file**
   ```bash
   cp .env.example .env
   ```

3. **Run setup script**
   ```bash
   chmod +x setup.sh
   ./setup.sh
   ```

4. **Access the application**
   - Web: http://localhost
   - API: http://localhost/api
   - Meilisearch: http://localhost:7700

### Docker Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f app

# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed

# Run tests
docker-compose exec app php artisan test

# Access Laravel tinker
docker-compose exec app php artisan tinker
```

## 📚 Project Structure

```
MarketPlace/
├── app/
│   ├── Models/              # Eloquent models
│   ├── Http/
│   │   ├── Controllers/     # API controllers
│   │   ├── Requests/        # Form requests
│   │   └── Resources/       # API resources
│   ├── Services/            # Business logic layer
│   └── Policies/            # Authorization policies
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/             # Database seeders
├── routes/
│   ├── api.php              # API routes
│   └── web.php              # Web routes
├── tests/
│   ├── Unit/                # Unit tests
│   └── Feature/             # Feature tests
├── docker/
│   └── nginx/               # Nginx configuration
├── docker-compose.yml       # Docker Compose config
├── Dockerfile               # Laravel app container
└── masterplan.md            # Full project plan
```

## 🗄️ Database Schema

### Core Tables

- `users` - User accounts (buyers, sellers, admins)
- `sellers` - Seller profiles with shop information
- `products` - Product listings
- `product_variants` - Product variants (SKU, price, stock)
- `product_images` - Product images with sorting
- `carts` - Shopping carts (1 per user)
- `cart_items` - Items in cart
- `orders` - Orders from buyers to sellers
- `order_items` - Items in orders (with price snapshots)
- `commissions` - Commission tracking for sellers
- `admin_logs` - Audit trail

## 🔐 Authentication & Authorization

### User Roles

- **Buyer**: Browse, search, cart, checkout, track orders
- **Seller**: Create products, manage inventory, fulfill orders, view commissions
- **Admin**: Manage users, moderate products, view platform analytics

### Security

- CSRF protection on web forms
- Token authentication via Laravel Sanctum
- Role-based access control via Policies
- Input validation on all endpoints
- SQL injection prevention via Eloquent ORM

## 📡 API Endpoints

### Auth
```
POST   /api/auth/register
POST   /api/auth/login
POST   /api/auth/logout
GET    /api/user
```

### Products
```
GET    /api/products                    (list, paginated)
GET    /api/products/{id}               (details with variants)
GET    /api/products/search?q=keyword   (full-text search)
```

### Seller Products
```
POST   /api/seller/products             (create)
PATCH  /api/seller/products/{id}        (update)
DELETE /api/seller/products/{id}        (archive)
POST   /api/seller/products/{id}/images (upload images)
```

### Cart
```
GET    /api/cart
POST   /api/cart/items
PATCH  /api/cart/items/{id}
DELETE /api/cart/items/{id}
```

### Orders
```
POST   /api/orders                      (create order)
GET    /api/orders                      (buyer's orders)
GET    /api/orders/{id}

GET    /api/seller/orders               (received orders)
PATCH  /api/seller/orders/{id}          (update status)
```

### Admin
```
GET    /api/admin/users
PATCH  /api/admin/users/{id}
GET    /api/admin/orders
GET    /api/admin/commissions
```

## 🧪 Testing

```bash
# Run all tests
docker-compose exec app php artisan test

# Run specific test suite
docker-compose exec app php artisan test tests/Feature/OrderTest.php

# Generate coverage report
docker-compose exec app php artisan test --coverage
```

## 📦 Development

### Creating Models
```bash
docker-compose exec app php artisan make:model ModelName -m
```

### Creating Controllers
```bash
docker-compose exec app php artisan make:controller Api/ProductController --resource
```

### Running Migrations
```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan migrate:rollback
docker-compose exec app php artisan migrate:refresh --seed
```

## 🚀 Deployment

See [Masterplan](masterplan.md) for full deployment strategy and roadmap.

## 📝 License

This project is licensed under the MIT License.

---

**Built with ❤️ as a portfolio project demonstrating real backend engineering, multi-role systems, and production-grade architecture.**
