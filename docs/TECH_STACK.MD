# Technology Stack - Scholarpeep

## Framework & Core

### Backend Framework
- **Laravel 12.x** (latest stable)
- **Reason:** Mature ecosystem, excellent documentation, built-in features (auth, queues, scheduling), Eloquent ORM
- **Installation:** `composer create-project laravel/laravel scholarpeep`

### Frontend Architecture
- **Blade Templates** (Laravel's templating engine)
- **Livewire 3** for reactive components
- **Alpine.js** for lightweight JavaScript interactions
- **Reason:** Monolithic architecture, no separate API needed, faster development, better SEO out of the box
- **Installation:** 
  ```bash
  composer require livewire/livewire
  npm install alpinejs
  ```

### Admin Panel
- **Filament 5.x** (latest version)
- **Reason:** Rapid admin panel development, beautiful UI, extensive plugin ecosystem
- **Features Used:** Dashboard, Resources, Actions, Notifications, Widgets
- **Installation:** `composer require filament/filament:"^5.0"`

---

## Styling & UI

### CSS Framework
- **Tailwind CSS v5** (or latest v4.x)
- **Configuration:** Custom color palette, utility-first approach
- **Reason:** Utility-first, highly customizable, excellent performance
- **Installation:** 
  ```bash
  npm install -D tailwindcss@latest postcss autoprefixer
  npx tailwindcss init -p
  ```

### Icon Library
- **Hugeicons**
- **Implementation:** SVG components stored in `resources/views/components/icons/`
- **Reason:** Modern design, comprehensive set, free tier available
- **Usage:** `<x-icon name="bookmark" class="w-5 h-5" />`

### Component Patterns
- **Blade Components** for reusable UI elements
- **Livewire Components** for interactive features
- **Alpine.js** for dropdowns, modals, tabs, carousels
- **No class components** - functional components only

---

## Database & Storage

### Database
- **MySQL 8.0+** (or PostgreSQL if preferred) - WE WILL USE SQLITE FOR NOW (LOCAL DEVELOPMENT)
- **Reason:** Reliable, performant, Hostinger support
- **Connection:** PDO with Laravel Eloquent ORM
- **Charset:** utf8mb4 for emoji support

### Enum Implementation
- **PHP 8.2+ Enum Classes** (not database enums)
- **Location:** `app/Enums/`
- **Reason:** Type safety, refactorable, IDE support, no database schema changes
- **Example:**
  ```php
  enum SponsorshipTier: string {
      case STANDARD = 'standard';
      case FEATURED = 'featured';
      case PREMIUM = 'premium';
  }
  ```

### File Storage
- **Local:** `storage/app/public` for development
- **Production Images:** Cloudinary (free tier: 25GB storage, 25GB bandwidth)
- **Reason:** Automatic optimization, transformations, CDN delivery
- **Integration:** Cloudinary PHP SDK
- **Backup:** Manual exports to external storage

### Caching
- **Development:** File-based cache
- **Production:** Redis (when on VPS)
- **Use cases:** Query results, API responses, session storage, queue management

---

## Authentication & Authorization

### User Authentication
- **Laravel Fortify** for authentication (built-in with Laravel 12)
- **Laravel Socialite** for OAuth (Google, Facebook)
- **Email Verification:** Laravel's built-in verification
- **Password Reset:** Laravel's built-in reset functionality
- **Session Driver:** Database (for scalability)

### Authorization
- **Laravel Policies** for model-level permissions
- **Filament Roles & Permissions** for admin panel access
- **Gates:** For simple authorization checks

---

## Search & Discovery

### Search Engine
- **Phase 1 (MVP):** Laravel Scout with Database driver
- **Phase 2+:** Meilisearch (cloud or self-hosted)
- **Reason:** Full-text search, typo tolerance, fast results, affordable
- **Fallback:** Database LIKE queries with indexes

### Filtering
- **Query Builder** with dynamic WHERE clauses
- **Eloquent Relationships** for eager loading
- **Indexes:** On frequently queried columns (deadline, sponsorship_tier, is_active)

---

## Email & Notifications

### Email Provider
- **Brevo (formerly Sendinblue)**
- **Free Tier:** 300 emails/day (9,000/month)
- **Features:** Transactional emails, marketing campaigns, templates, webhooks
- **Integration:** Brevo PHP SDK
- **Upgrade Path:** Lite plan ($25/month) for 20,000 emails

### Queue System
- **Development:** Database queue driver
- **Production:** Redis queue driver
- **Workers:** Supervisor for production
- **Reason:** Asynchronous email sending, background jobs, scheduled tasks

### Notification Types
- New matching scholarships (frequency-based)
- Deadline reminders (scheduled)
- Status confirmations
- Daily/weekly digests

---

## Infrastructure & Deployment

### Hosting
- **Provider:** Hostinger
- **Phase 1:** Business Hosting ($3.99-7.99/month) for up to 10K visitors
- **Phase 2+:** VPS KVM 2 ($11.99/month) - 2 vCPU, 4GB RAM, 100GB NVMe
- **Reason:** Affordable, good performance, easy setup, Laravel-friendly

### Server Requirements
- PHP 8.2+
- MySQL 8.0+
- Composer 2.x
- Node.js 20+
- Git
- SSL certificate (free via Let's Encrypt)

### CDN
- **Cloudflare** (free tier)
- **Features:** Global CDN, DDoS protection, caching, SSL, page rules
- **Integration:** DNS management, proxy through Cloudflare

### Asset Compilation
- **Vite** (Laravel 11 default)
- **Build Command:** `npm run build`
- **Development:** `npm run dev` with hot reload
- **Output:** Versioned assets for cache busting

---

## Third-Party Services

### Analytics
- **Google Analytics 4** - User behavior, conversions
- **Google Search Console** - Search performance, indexing
- **Implementation:** GA4 tracking code in layout, custom events via JavaScript

### Error Tracking
- **Sentry** (free tier: 5K events/month)
- **Features:** Error tracking, performance monitoring, release tracking
- **Integration:** `composer require sentry/sentry-laravel`

### Uptime Monitoring
- **UptimeRobot** (free tier: 50 monitors, 5-min intervals)
- **Alerts:** Email, SMS (paid), webhook

### Spam Protection
- **Google reCAPTCHA v3** (invisible)
- **Use cases:** Registration, contact forms, review submissions
- **Integration:** `composer require google/recaptcha`

---

## Development Tools

### Version Control
- **Git** with **GitHub** (or GitLab/Bitbucket)
- **Branching Strategy:** Git Flow (main, develop, feature branches)
- **Commits:** Conventional Commits format

### Local Development
- **Laravel Herd** (macOS) or **Laragon** (Windows)
- **Alternative:** Laravel Sail (Docker-based)
- **Database:** MySQL in container or local install

### Code Quality
- **Laravel Pint** for code formatting (PSR-12 standard)
- **PHPStan** for static analysis (optional, Level 5+)
- **PHP_CodeSniffer** for style checking (optional)

### Testing
- **PHPUnit** (or **Pest**) for unit and feature tests
- **Laravel Dusk** for browser tests
- **Coverage Target:** 70% minimum, 100% for critical features

### CI/CD
- **GitHub Actions** (free for public repos, 2000 min/month for private)
- **Pipeline:** Test → Build → Deploy
- **Deployment:** SSH or webhook-based deploy script

---

## API & Integrations

### Internal API
- **Not required for MVP** (Blade + Livewire handles everything)
- **Future:** Laravel Sanctum for mobile app authentication

### External APIs
- **Google OAuth 2.0** - Social login
- **Facebook Login** - Social login
- **Brevo API** - Email sending
- **Cloudinary API** - Image uploads and transformations
- **Google Analytics API** - Custom reporting (future)

---

## Security

### Application Security
- **HTTPS Only** - Force SSL in production
- **CSRF Protection** - Laravel's built-in middleware
- **XSS Prevention** - Blade's `{{ }}` escaping, `{!! !!}` only when safe
- **SQL Injection Prevention** - Eloquent ORM, parameterized queries
- **Rate Limiting** - API routes, login attempts
- **Password Hashing** - bcrypt (Laravel default)

### Environment Security
- **Environment Variables** - `.env` file (never committed)
- **Sensitive Data** - Encrypted at rest if needed
- **File Upload Validation** - Type, size, mime type checks
- **Regular Updates** - Security patches applied immediately

---

## Monitoring & Logging

### Application Logs
- **Laravel Log** - `storage/logs/laravel.log`
- **Channels:** Single, daily, stack
- **Level:** Error and above in production

### Centralized Logging (Optional)
- **Papertrail** (free tier: 50 MB/month, 7-day retention)
- **Integration:** Monolog handler

### Performance Monitoring
- **Laravel Telescope** (development only)
- **Reason:** Debug queries, requests, exceptions, jobs
- **Installation:** `composer require laravel/telescope --dev`

### Server Monitoring
- **Hostinger Control Panel** - CPU, memory, disk usage
- **Alerts:** High resource usage notifications

---

## Strict Development Rules

### DO NOT Use
- ❌ **localStorage or sessionStorage** in Blade/Livewire - use server sessions
- ❌ **Database enum types** - use PHP Enum classes with string columns
- ❌ **Class components** - use functional components only
- ❌ **Plain CSS files** - use Tailwind utility classes only
- ❌ **jQuery** - use Alpine.js or vanilla JavaScript
- ❌ **Inline styles** - use Tailwind classes

### ALWAYS Use
- ✅ **Eloquent ORM** - never raw SQL (except complex queries)
- ✅ **Blade Components** - for reusable UI elements
- ✅ **Livewire Components** - for reactive features
- ✅ **Alpine.js** - for simple interactions
- ✅ **Enum Classes** - for all enumerated values
- ✅ **Type Hints** - on all function parameters and returns
- ✅ **Early Returns** - for cleaner code
- ✅ **Try-Catch** - wrap all external API calls

### Naming Conventions
- **Models:** PascalCase, singular (`Scholarship`, `Tenant`)
- **Controllers:** PascalCase with suffix (`ScholarshipController`)
- **Livewire Components:** PascalCase (`SavedScholarships`)
- **Routes:** kebab-case (`/saved-scholarships`)
- **Database Tables:** snake_case, plural (`saved_scholarships`)
- **Database Columns:** snake_case (`sponsorship_tier`)
- **Blade Views:** kebab-case (`scholarship-card.blade.php`)
- **CSS Classes:** kebab-case (Tailwind default)
- **JavaScript Variables:** camelCase (`scholarshipId`)
- **PHP Variables:** camelCase (`$savedScholarship`)
- **Constants:** SCREAMING_SNAKE_CASE (`MAX_UPLOAD_SIZE`)

---

## Performance Optimization

### Database
- **Indexes** on frequently queried columns
- **Eager Loading** to prevent N+1 queries
- **Chunk Queries** for large datasets (digests, reports)
- **Query Optimization** with `explain` analysis

### Frontend
- **Lazy Load Images** with `loading="lazy"`
- **Defer Non-Critical JS** with `defer` attribute
- **Inline Critical CSS** for above-the-fold content
- **Minify Assets** via Vite in production
- **WebP Images** with JPEG/PNG fallbacks

### Caching Strategy
- **Config Cache:** `php artisan config:cache` in production
- **Route Cache:** `php artisan route:cache` in production
- **View Cache:** `php artisan view:cache` in production
- **Query Cache:** Redis for frequent queries
- **HTTP Cache:** Cloudflare for static assets

---

## Scalability Considerations

### Current Architecture
- **Monolithic** - Single Laravel application
- **Suitable For:** Up to 50K monthly active users

### Future Scaling Options
- **Database:** Read replicas, connection pooling
- **Cache:** Redis cluster, Memcached
- **Queue:** Separate queue workers, Redis queue
- **Search:** Dedicated Meilisearch server
- **CDN:** Serve all static assets via Cloudflare
- **Horizontal Scaling:** Multiple application servers with load balancer

---

*This tech stack prioritizes simplicity, cost-effectiveness, and developer experience while maintaining scalability for future growth. All technology choices align with Laravel ecosystem best practices.*