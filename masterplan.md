# B2B Marketplace MVP — Execution Masterplan

**Status:** Planning Phase  
**Target Launch:** MVP ready for production deployment  
**Portfolio Goal:** Demonstrate real backend architecture, multi-role systems, commerce logic, and DevOps

---

## Project Definition

**What:** A B2B-ready multi-vendor marketplace (Laravel + MySQL)  
**Who:** Buyers, Sellers, Admin  
**What They Do:**
- **Buyers:** Browse, search, add to cart, checkout, track orders
- **Sellers:** Create products, manage variants/stock, fulfill orders
- **Admin:** Manage users, moderate products, view orders, set commission rates

**Why It Matters:** Demonstrates production-grade architecture, relational modeling, authorization, and deployment competence.

---

## Phase 1: Foundation — Database & Architecture

### 1.1 Setup & Planning
- [ ] Initialize Laravel 11 project structure
- [ ] Set up Docker Compose (Nginx, PHP-FPM, MySQL, MeiliSearch)
- [ ] Create git repository with .gitignore, README
- [ ] Design ER diagram (finalize table relationships)
- [ ] Document API contract (endpoints, request/response shapes)

### 1.2 Database Schema
- [ ] Create migrations:
  - `users` (id, name, email, password, role, created_at)
  - `sellers` (user_id, shop_name, description, created_at)
  - `products` (id, seller_id, title, description, status, created_at)
  - `product_variants` (id, product_id, sku, price, stock, attributes_json, created_at)
  - `product_images` (product_id, url, sort_order)
  - `carts` (user_id, created_at)
  - `cart_items` (cart_id, product_variant_id, qty)
  - `orders` (buyer_id, seller_id, total, status, created_at)
  - `order_items` (order_id, product_variant_id, qty, price_snapshot)
  - `commissions` (order_id, seller_id, rate, amount)
  - `admin_logs` (actor_id, action, target_id, target_type, timestamp)
- [ ] Add soft deletes to users, products
- [ ] Add indexes on foreign keys and search columns (seller_id, product_id, user_id, status)
- [ ] Write database seeding for test data

### 1.3 Core Models & Relationships
- [ ] Create Eloquent models with proper relationships
- [ ] Define scopes (active products, pending orders, etc.)
- [ ] Add computed properties (order total, commission amount)
- [ ] Set up casts for JSON attributes and enums

---

## Phase 2: Authentication & Authorization

### 2.1 User Management
- [ ] Set up Laravel Sanctum for API authentication
- [ ] Create User model with role attribute
- [ ] Create Seller model (seller profile linked to user)
- [ ] Implement role seeding (buyer, seller, admin)
- [ ] Create authentication controllers (register, login, logout)

### 2.2 Authorization Layer
- [ ] Create Laravel Policies:
  - `ProductPolicy` (seller can edit own products, admin moderates)
  - `OrderPolicy` (buyer/seller/admin access levels)
  - `SellerPolicy` (seller can manage own store)
- [ ] Add authorization middleware
- [ ] Document role-based route protection

### 2.3 Testing
- [ ] Unit tests for role assignment
- [ ] Feature tests for auth endpoints
- [ ] Feature tests for policy-based access denial

---

## Phase 3: Core Business Logic — Service Layer

### 3.1 Product Management Service
- [ ] Create `ProductService` class
  - Create product with variants
  - Upload and associate images
  - Update stock and price
  - Archive/delete products (soft delete)
- [ ] Validation rules for SKU, price, stock
- [ ] Transaction handling for multi-step operations

### 3.2 Cart & Order Service
- [ ] Create `CartService` class
  - Add/remove items
  - Update quantities
  - Get cart total (with validation of stock/pricing)
- [ ] Create `OrderService` class
  - Create order from cart
  - Validate stock availability
  - Create price snapshots
  - Deduct inventory (transactional)
  - Calculate commission
  - Clear buyer cart
- [ ] Error handling (out of stock, price mismatch, cart empty)

### 3.3 Commission & Fulfillment
- [ ] Create `CommissionService`
  - Calculate seller commission per order
  - Store commission record
- [ ] Create `FulfillmentService`
  - Update order status (pending → shipped → completed)
  - Audit trail of status changes
- [ ] Testing for edge cases (concurrent orders, low stock)

---

## Phase 4: API Endpoints

### 4.1 Authentication Endpoints
```
POST   /api/auth/register      → Create account (buyer or seller role selectable)
POST   /api/auth/login         → Issue token
POST   /api/auth/logout        → Revoke token
GET    /api/user               → Current user profile
```

### 4.2 Product Endpoints (Buyer)
```
GET    /api/products           → List products (paginated, searchable)
GET    /api/products/{id}      → Product details + variants
GET    /api/products/search    → Search by title, seller
```

### 4.3 Product Endpoints (Seller)
```
POST   /api/seller/products           → Create product
PATCH  /api/seller/products/{id}      → Edit product
DELETE /api/seller/products/{id}      → Archive product
POST   /api/seller/products/{id}/images → Upload images
GET    /api/seller/products           → List own products
```

### 4.4 Cart Endpoints
```
GET    /api/cart               → Get cart contents
POST   /api/cart/items         → Add to cart
PATCH  /api/cart/items/{id}    → Update quantity
DELETE /api/cart/items/{id}    → Remove from cart
DELETE /api/cart               → Clear cart
```

### 4.5 Order Endpoints (Buyer)
```
POST   /api/orders             → Create order (from cart, mock checkout)
GET    /api/orders             → List buyer's orders
GET    /api/orders/{id}        → Order details
```

### 4.6 Order Endpoints (Seller)
```
GET    /api/seller/orders      → List received orders
PATCH  /api/seller/orders/{id} → Update order status (pending→shipped→completed)
GET    /api/seller/orders/{id} → Order details
```

### 4.7 Admin Endpoints
```
GET    /api/admin/users        → List users
PATCH  /api/admin/users/{id}   → Edit user or suspend seller
GET    /api/admin/products     → Review flagged/pending products
GET    /api/admin/orders       → Platform-wide orders
GET    /api/admin/commissions  → Commission reports
GET    /api/admin/logs         → Audit trail
```

### 4.8 Implementation
- [ ] Create API resource classes (ProductResource, OrderResource, etc.)
- [ ] Create request validation classes (StoreProductRequest, CheckoutRequest, etc.)
- [ ] Implement error response handling (consistent JSON error format)
- [ ] Add API documentation (inline comments or Swagger)

---

## Phase 5: Frontend Views

### 5.1 Public Pages (Blade + Tailwind)
- [ ] **Home/Browse Products**
  - Product grid with search/filter
  - Product card component
- [ ] **Product Detail Page**
  - Product info, images carousel
  - Variant selector (SKU, price, stock status)
  - Add to cart button
- [ ] **Search Results**
  - Filter by price, seller, etc.
  - Pagination

### 5.2 Buyer Pages
- [ ] **Cart Page**
  - Cart items table
  - Update quantities
  - Proceed to checkout button
- [ ] **Checkout Page (Mock)**
  - Order summary
  - Confirm button
  - Order placed confirmation + order ID
- [ ] **Orders Page**
  - List of buyer orders
  - Order status tracking
  - Order detail view

### 5.3 Seller Pages
- [ ] **Seller Dashboard**
  - Quick stats (products, orders, revenue)
  - Recent orders list
- [ ] **Products Management**
  - List products table
  - Edit/delete actions
  - Create new product form
- [ ] **Product Editor Form**
  - Title, description, images
  - Variant table (SKU, price, stock)
  - Add variant button
- [ ] **Orders to Fulfill**
  - Received orders list
  - Status update dropdown (pending → shipped → completed)

### 5.4 Admin Pages
- [ ] **Admin Dashboard**
  - User count, product count, orders count
  - Recent activity
- [ ] **Manage Users**
  - User table with role/status
  - Edit, suspend, delete actions
- [ ] **Manage Products**
  - Flagged products queue
  - Moderation actions
- [ ] **Commissions Report**
  - Orders with commission breakdown
  - Export to CSV (optional)

### 5.5 Styling & UX
- [ ] Set up Tailwind CSS configuration
- [ ] Create layout template (header, footer, nav)
- [ ] Responsive design (mobile, tablet, desktop)
- [ ] Use Alpine.js for modals, dropdowns, form interactivity

---

## Phase 6: Testing

### 6.1 Unit Tests
- [ ] OrderService order creation logic
- [ ] CommissionService calculations
- [ ] CartService quantity validation
- [ ] Product variant stock deduction

### 6.2 Feature Tests
- [ ] Buyer registration and login
- [ ] Seller registration with shop profile
- [ ] Product creation flow (seller)
- [ ] Add product to cart flow
- [ ] Checkout and order creation flow
- [ ] Order status updates (seller)
- [ ] Admin user suspension
- [ ] Authorization denial tests (buyer cannot edit seller products, etc.)

### 6.3 API Tests
- [ ] All endpoints return correct status codes
- [ ] Request validation rejects invalid data
- [ ] Response payloads match contract
- [ ] Token auth works for protected routes

### 6.4 Security Tests
- [ ] CSRF protection on web forms
- [ ] Rate limiting on login (optional but recommended)
- [ ] Prevent privilege escalation (user cannot promote self to admin)
- [ ] SQL injection prevention (via Eloquent ORM)

---

## Phase 7: Deployment & DevOps

### 7.1 Docker Setup
- [ ] Create Dockerfile for Laravel app
- [ ] Create docker-compose.yml
  - Laravel service (PHP-FPM)
  - Nginx reverse proxy
  - MySQL database
  - MeiliSearch (optional)
- [ ] Nginx configuration for routing
- [ ] Environment configuration (.env.example, secrets management)

### 7.2 Local Development
- [ ] Test all services run via `docker-compose up`
- [ ] Test database migrations run on startup
- [ ] Test API endpoints via Postman or similar
- [ ] Ensure local development is reproducible

### 7.3 VPS Deployment
- [ ] Choose VPS provider (DigitalOcean, Linode, AWS Lightsail)
- [ ] Set up SSH access and key-based auth
- [ ] Install Docker and Docker Compose on VPS
- [ ] Set up domain and DNS
- [ ] Configure HTTPS (Let's Encrypt SSL)
- [ ] Create deploy script (pull code, run migrations, restart containers)

### 7.4 CI/CD (GitHub Actions)
- [ ] Create workflow for automated testing
  - Run tests on push to main branch
  - Run linting checks
- [ ] Create workflow for deployment
  - On successful tests, SSH to VPS and run deploy script
  - Run migrations in production
  - Restart containers

### 7.5 Monitoring & Logging
- [ ] Configure application logging (Laravel logs to stdout for Docker)
- [ ] Set up basic error tracking (Sentry optional)
- [ ] Document how to check logs on VPS

---

## Phase 8: Documentation

### 8.1 Technical Documentation
- [ ] **Architecture.md** — System design, data flow, component diagram
- [ ] **API.md** — Full endpoint documentation, example requests/responses
- [ ] **Database.md** — Schema diagram, table descriptions
- [ ] **Deployment.md** — How to deploy to VPS, environment setup
- [ ] **Contributing.md** — Dev setup, testing, code style

### 8.2 README
- [ ] Project overview
- [ ] Quick start (local development with Docker)
- [ ] Features checklist
- [ ] Tech stack
- [ ] Deployment status / live link

### 8.3 Case Study (Portfolio)
- [ ] Problem statement and solution
- [ ] Architecture decisions and rationale
- [ ] Challenges faced and solutions
- [ ] Key metrics (load test results, coverage %, deployment time)
- [ ] Lessons learned

---

## Phase 2 — Future Enhancements (Not MVP)

- [ ] Stripe Connect split payments
- [ ] Email notifications via queue (Laravel Queues + Redis)
- [ ] Advanced search with MeiliSearch
- [ ] Automated refunds and returns
- [ ] Seller analytics dashboard
- [ ] Multi-tenant seller storefronts
- [ ] Mobile app (React Native / Flutter)

---

## Success Criteria — MVP Definition

✅ **Database**: Normalized schema with correct relationships, no data integrity issues.  
✅ **Auth**: Registration, login, role assignment, logout working cleanly.  
✅ **Buyer Flow**: Browse → Search → Add to Cart → Checkout → Order placed → Track status.  
✅ **Seller Flow**: Register → Create products with variants → Manage stock → View received orders → Update fulfillment status.  
✅ **Admin Tools**: View users, moderate products, view platform orders.  
✅ **API**: All core endpoints functional, validated, documented.  
✅ **Frontend**: Clean, responsive UI; no broken pages.  
✅ **Security**: CSRF protection, role-based access, input validation.  
✅ **Testing**: >70% code coverage, all critical flows tested.  
✅ **Deployment**: Running on VPS with HTTPS, automated deploy script working.  
✅ **Documentation**: Architecture, API docs, deployment guide, case study.

---

## Key Decisions & Rationale

| Decision | Why |
|----------|-----|
| **Laravel + MySQL** | Mature, well-documented, easy to showcase relational design |
| **Service Layer** | Keeps business logic testable and reusable, not buried in controllers |
| **Policies for Auth** | Cleaner and more scalable than gate checks scattered in routes |
| **Price Snapshots** | Preserves historical accuracy; orders remain valid if product price changes |
| **Transactional Checkout** | Ensures stock deduction and order creation are atomic |
| **Docker from Day 1** | Local dev matches production; proves DevOps competence |
| **Mock Checkout (Phase 1)** | Fast MVP delivery; Stripe Connect added in Phase 2 |

---

## Estimated Effort

| Phase | Duration | Notes |
|-------|----------|-------|
| 1. Database & Architecture | 3-4 days | Schema design, models, relationships |
| 2. Auth & Authorization | 2-3 days | User roles, policies, middleware |
| 3. Service Layer | 5-7 days | Complex business logic; needs careful testing |
| 4. API Endpoints | 4-5 days | Routes, requests, resources, error handling |
| 5. Frontend Views | 5-7 days | Forms, tables, responsive design |
| 6. Testing | 5-7 days | Unit, feature, API, security tests |
| 7. Deployment & DevOps | 3-4 days | Docker, VPS setup, CI/CD |
| 8. Documentation | 2-3 days | README, API docs, architecture, case study |
| **Total** | **~6-8 weeks** | Working full-time; adjust for part-time |

---

## Next Steps

1. **Read this masterplan** — Understand the phases and flow.
2. **Create project folder structure** — Organize as Laravel app + Docker files.
3. **Start Phase 1** — Database design and schema creation.
4. **Iterate** — Phase by phase, test each phase before moving on.
5. **Deploy early** — Get something live on VPS by Phase 7, even if incomplete.
6. **Document as you go** — Case studies and architecture notes are gold for portfolios.

---

## How to Track Progress

- Use this file as your checklist.
- Check items off as you complete them.
- When blocked, add notes in comments.
- At the end of each phase, validate against success criteria before moving on.

---

## Questions? Think Through These

- **Can I simplify Phase 1 for faster MVP?** Yes—start with buyer/seller flow only; admin comes later.
- **Do I need MeiliSearch?** No—basic SQL LIKE search is fine for MVP. Phase 2 feature.
- **Should I do Stripe Connect in Phase 1?** No—mock checkout is faster. Get architecture right first.
- **What if I get stuck?** Break it into smaller tasks. Test incrementally. Deploy often.

---

**Remember:** This is a **real product**, not a tutorial. Build it like you own it. The architecture, decisions, and deployment story matter more than perfection.

**Let's build something serious.**
