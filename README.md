# MarketFlow: Production-Grade B2B Multi-Vendor Platform

A high-performance, multi-role B2B marketplace engineered with Laravel 11. This project demonstrates industrial-grade architecture, featuring a decoupled service layer, complex relational modeling, and a premium UI/UX designed for global commerce.

---

## Architectural Highlights

- **Service-Oriented Architecture:** Business logic is encapsulated in a dedicated Service Layer, keeping controllers thin, testable, and reusable.
- **Multi-Role RBAC:** Granular authorization system for Buyers, Sellers, and Administrators using Laravel Policies.
- **Robust Commerce Logic:** Real-time stock management, transactional order processing, and automatic commission calculations.
- **Scalable Infrastructure:** Fully containerized with Docker, optimized Nginx configuration, and MeiliSearch-ready indexing.
- **Modern UI/UX:** Built with Tailwind CSS and Alpine.js, following premium SaaS design principles.

---

## Key Features

### Seller Hub
- **Product Wizard:** 3-step intuitive product launch flow with dynamic variant management (SKU, Price, Attributes).
- **Media Engine:** Modern file upload system with instant frontend previews and secure backend storage.
- **Inventory Control:** Real-time stock tracking across multiple product variants.
- **Order Management:** Professional fulfillment dashboard with reliable status tracking.

### Buyer Experience
- **Advanced Discovery:** High-speed product browsing with category filtering and price-based sorting.
- **Smart Cart:** Seamless shopping experience with live stock validation.
- **Order Tracking:** Detailed order history and status updates for end-to-end transparency.

### Admin Command Center
- **Platform Analytics:** Global oversight of revenue, user growth, and catalog size.
- **Moderation Tools:** Ability to verify new sellers, suspend users, and moderate product listings.

---

## Tech Stack

| Layer | Technology |
|---|---|
| **Backend** | Laravel 11 (PHP 8.2), MySQL 8.0 |
| **Frontend** | Tailwind CSS, Alpine.js, Blade |
| **Security** | Laravel Sanctum (Token Auth), RBAC Policies |
| **DevOps** | Docker, Docker Compose, Nginx |
| **Testing** | PHPUnit (Feature & Unit Tests) |

---

## Local Installation

### Prerequisites
- Docker & Docker Compose
- Git

### Setup
1. **Clone & Enter**
   ```bash
   git clone <repo-url>
   cd b2b-marketplace
   ```

2. **Initialize Environment**
   ```bash
   cp .env.example .env
   ```

3. **Launch Stack**
   ```bash
   docker-compose up -d
   docker-compose exec app composer install
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate --seed
   ```

4. **Set Permissions**
   ```bash
   chmod -R 777 storage bootstrap/cache
   ```

**Access:** http://localhost  
**Admin Login:** admin@marketflow.com / password

---

## Testing
The core commerce and authentication flows are protected by a comprehensive feature test suite.
```bash
docker-compose exec app ./vendor/bin/phpunit
```

---

## Project Roadmap
For a detailed breakdown of the planning and execution phases, please refer to the Masterplan.

---

**Developed as a portfolio project to showcase professional software engineering standards.**
