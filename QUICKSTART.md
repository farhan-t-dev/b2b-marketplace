# 🎯 Quick Command Reference

## Get Started Immediately

### 1. **Build & Start Docker**
```bash
cd ~/work-files/Web\ Developer\ journey/showcase-projects/MarketPlace
docker-compose up -d
```

### 2. **Install Dependencies**
```bash
docker-compose exec app composer install
```

### 3. **Generate App Key**
```bash
docker-compose exec app php artisan key:generate
```

### 4. **Run Migrations** (Create all tables)
```bash
docker-compose exec app php artisan migrate
```

### 5. **Seed Database** (Test data)
```bash
docker-compose exec app php artisan db:seed
```

### 6. **Access the App**
- **Web**: http://localhost
- **API**: http://localhost/api
- **Meilisearch**: http://localhost:7700

---

## Essential Commands

### Development
```bash
# View logs
docker-compose logs -f app

# Access Laravel console
docker-compose exec app php artisan tinker

# Create new model with migration
docker-compose exec app php artisan make:model ModelName -m

# Create controller
docker-compose exec app php artisan make:controller Api/ControllerName

# Run tests
docker-compose exec app php artisan test

# Reset database
docker-compose exec app php artisan migrate:fresh --seed
```

### Docker
```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View container status
docker-compose ps

# Rebuild containers
docker-compose build

# Shell into app container
docker-compose exec app /bin/bash
```

### Git
```bash
# View commits
git log --oneline

# Current status
git status

# Create new branch
git checkout -b feature/name

# Commit changes
git add . && git commit -m "message"

# Push to remote
git push origin main
```

---

## Database

### Tables Created
1. `users` - User accounts
2. `sellers` - Seller profiles
3. `products` - Product listings
4. `product_variants` - SKU, price, stock
5. `product_images` - Images with sorting
6. `carts` - Shopping carts
7. `cart_items` - Cart line items
8. `orders` - Orders
9. `order_items` - Order line items
10. `commissions` - Commission tracking
11. `admin_logs` - Audit trail

### Check Database
```bash
# MySQL shell
docker-compose exec db mysql -umarketplace -ppassword marketplace

# Laravel Tinker
docker-compose exec app php artisan tinker
> User::all()
> Product::with('variants')->first()
```

---

## What's Next?

From **masterplan.md**:

- [ ] **Phase 2**: Authentication & Authorization
  - User registration (buyer/seller/admin roles)
  - Login with token auth
  - Role-based policies

- [ ] **Phase 3**: Service Layer
  - OrderService (checkout logic)
  - CartService (add/remove)
  - ProductService (CRUD)

- [ ] **Phase 4**: API Endpoints
  - Auth routes
  - Product routes
  - Cart routes
  - Order routes

- [ ] **Phase 5**: Frontend Views
  - Product browse
  - Cart page
  - Checkout
  - Order tracking

- [ ] **Phase 6**: Testing
  - Unit tests
  - Feature tests
  - API tests

- [ ] **Phase 7**: Deployment
  - Docker to VPS
  - HTTPS setup
  - CI/CD with GitHub Actions

---

## Project Structure

```
MarketPlace/
├── app/
│   ├── Models/              ✅ 15 models defined
│   ├── Http/
│   │   ├── Controllers/     (empty, ready for build)
│   │   ├── Requests/        (empty, ready for build)
│   │   └── Resources/       (empty, ready for build)
│   ├── Services/            (empty, ready for build)
│   └── Policies/            (empty, ready for build)
├── database/
│   ├── migrations/          ✅ 11 migrations
│   └── seeders/             (empty, ready for build)
├── routes/
│   ├── api.php              ✅ Basic routes
│   └── web.php              ✅ Basic routes
├── tests/
│   ├── Unit/                (empty, ready for tests)
│   └── Feature/             (empty, ready for tests)
├── docker/
│   └── nginx/conf.d/        ✅ App config
├── docker-compose.yml       ✅ Services
├── Dockerfile               ✅ PHP 8.2
├── composer.json            ✅ Dependencies
├── .env.example             ✅ Environment
├── setup.sh                 ✅ One-command setup
├── masterplan.md            ✅ Full roadmap
├── README.md                ✅ Quick start
└── INIT_SUMMARY.md          ✅ What's done
```

---

## Git Status

```
Branch: main
Commits: 2
  ✓ 🚀 Initial project setup: Phase 1 foundation
  ✓ 📖 Add initialization summary
```

---

**Ready to build Phase 2? Open masterplan.md and start coding!**
