# Scholarpeep - Project Specification

## Project Overview

**One-sentence pitch:** A comprehensive scholarship discovery and management platform where students can search, filter, save, and track scholarship opportunities globally while institutions can sponsor their scholarships for premium visibility.

**Target Users:**
- Students seeking scholarships (undergraduate, masters, PhD, high school)
- Educational institutions and scholarship providers (sponsors)
- Platform administrators

**Primary Goal:** Connect students with relevant scholarship opportunities while generating revenue through a tiered sponsorship model.

---

## Core Features (Must Haves)

### 1. Scholarship Discovery
- **Global search** with auto-complete and typo tolerance
- **Advanced filtering** by country, education level, field of study, scholarship type, award amount, and deadline
- **Smart sorting** by relevance, deadline, award amount, and date added
- **Sponsorship tiers** with visual differentiation (Standard, Featured, Premium)
- **SEO-optimized URLs** for all scholarship pages (`/scholarships/{slug}`)

### 2. User Authentication & Dashboard
- **Social login** via Google and Facebook (Laravel Socialite)
- **Email verification** required before saving scholarships
- **Personal dashboard** showing saved scholarships organized by status (Saved, Applied, Pending, Accepted, Rejected)
- **Requirements tracker** with completion checkboxes and progress indicators
- **Preferences system** for personalized scholarship matching

### 3. Notification System
- **Email notifications** for new matching scholarships
- **Deadline reminders** sent X days before scholarship closes
- **Frequency control** (Instant, Daily Digest, Weekly Digest)
- **Preference center** for managing notification types

### 4. Admin Panel (Filament 5)
- **Complete CRUD** for scholarships with relationships
- **Bulk import/export** via CSV
- **Analytics dashboard** with views, clicks, CTR metrics
- **User management** with activity tracking
- **Content management** for blog posts and resources
- **Sponsorship management** with automatic expiration

### 5. Sponsorship System
- **Three tiers:** Standard (free), Featured ($75/month), Premium ($250/month)
- **Visual badges** and enhanced card styling for paid tiers
- **Premium carousel** on homepage with auto-rotation
- **Strategic placement** in search results (top positions for Premium)
- **Analytics tracking** for sponsorship performance

---

## Data Model

### Core Entities

**Scholarship**
- Title, description, eligibility criteria
- Award amount and currency
- Application URL (external)
- Primary deadline or rolling status
- Provider name and logo (Premium only)
- Sponsorship tier with start/end dates
- SEO fields (slug, meta title, meta description)
- Analytics (views_count, clicks_count, applications_count)

**Country, EducationLevel, FieldOfStudy, ScholarshipType**
- Simple reference tables with name and slug
- Many-to-many relationships with Scholarship

**ScholarshipDeadline**
- Multiple deadlines per scholarship
- Deadline type (uses `DeadlineType` enum: application, early_decision, regular, final, round_1, round_2, round_3)
- Date and description

**ScholarshipRequirement**
- Requirement type (uses `RequirementType` enum: document, essay, recommendation_letter, transcript, test_score, portfolio, interview, other)
- Title, description, required/optional flag
- Order for display

**Tenant (User)**
- Name, email, password (nullable for social auth)
- Social provider IDs (google_id, facebook_id)
- Avatar URL

**SavedScholarship**
- Links tenant to scholarship
- Status (uses `ScholarshipStatus` enum: saved, applied, pending, accepted, rejected)
- Private notes field
- Unique constraint per user-scholarship pair

**SavedScholarshipRequirement**
- Links saved scholarship to requirement
- Completion tracking with timestamp
- Private notes per requirement

**TenantPreference**
- Saved filter preferences (countries, levels, fields, types stored as JSON)
- Notification toggles and frequency (uses `NotificationFrequency` enum: instant, daily, weekly)
- Deadline reminder days (1-30)

---

## User Flows

### Anonymous User → Registered User
1. User lands on homepage with hero search and featured scholarships
2. Searches or applies filters to find relevant scholarships
3. Views scholarship detail page
4. Attempts to save scholarship → prompted to register
5. Registers via Google/Facebook or email
6. Confirms email (if email registration)
7. Returns to scholarship and saves it
8. Redirected to dashboard showing saved scholarship
9. Sets preferences for future notifications
10. Receives email alerts for new matches and approaching deadlines

### Registered User Daily Flow
1. Logs in via social auth
2. Views dashboard with saved scholarships organized by status
3. Filters by deadline or field of study
4. Opens saved scholarship to track progress
5. Marks requirements as completed
6. Updates status from "Saved" to "Applied"
7. Receives confirmation email
8. Continues searching for additional scholarships
9. Receives daily digest email with new matches

### Admin Content Management Flow
1. Admin logs into Filament panel
2. Views dashboard with key metrics (views, clicks, CTR)
3. Navigates to Scholarships resource
4. Clicks "Create" and fills comprehensive form
5. Adds multiple deadlines and requirements
6. Sets sponsorship tier (Featured or Premium) with dates
7. Configures SEO fields (auto-generated, editable)
8. Publishes scholarship or schedules publication
9. Monitors performance via analytics charts
10. Bulk imports additional scholarships via CSV
11. Manages user reviews and blog content
12. Tracks sponsorship revenue and expiring sponsorships

---

## Technical Implementation Notes

### Enum Classes (PHP 8.2+)
All enumerated values use PHP Enum classes stored in `app/Enums/`:
- `DeadlineType` - Scholarship deadline types with label() method
- `RequirementType` - Application requirement types with label() and icon() methods
- `ScholarshipStatus` - User scholarship statuses with label(), color(), and icon() methods
- `SponsorshipTier` - Sponsorship levels with label(), price(), color(), and badgeClass() methods
- `NotificationFrequency` - Email frequency options with label() method
- `ResourceType` - Resource categories with label() and icon() methods

**Database Implementation:** String columns instead of database enum types for flexibility. Models use enum casting: `protected $casts = ['sponsorship_tier' => SponsorshipTier::class]`

### Livewire Components Architecture
Located in `app/Livewire/` with organized subdirectories:
- `Auth/` - Login, Register, SocialLogin
- `Scholarships/` - Search, Card, Detail, Filters, SaveButton, Related
- `Dashboard/` - SavedScholarships, StatusUpdate, RequirementsTracker, Calendar
- `User/` - ProfileForm, PreferencesForm, NotificationSettings
- `Blog/` - List, Post, RelatedPosts
- `Shared/` - SearchBar, Pagination, Newsletter

**Key Features:**
- Real-time search with `wire:model.debounce`
- URL query string sync for shareable filtered URLs
- Optimistic UI updates for save/unsave actions
- Loading states with `wire:loading`
- Lazy loading for performance

### Email Infrastructure
- **Provider:** Brevo (free tier: 300 emails/day)
- **Queue system:** Database queue initially, Redis for production
- **Email types:** 
  - New matching scholarships (frequency-based)
  - Deadline reminders (7 days before by default)
  - Status confirmations
  - Daily/weekly digests
- **Implementation:** Queue jobs with scheduled tasks via Laravel Scheduler

### Search & Filtering
- **Phase 1:** Laravel Scout with database driver
- **Phase 2+:** Meilisearch for typo tolerance and speed
- **Filters:** Multi-select with Alpine.js dropdowns
- **Sorting:** Relevance, deadline, amount, newest
- **Performance:** Indexed columns, eager loading, Redis caching

### SEO Strategy
- **Dynamic meta tags** per scholarship with templates
- **Schema.org markup** (ScholarshipPosting type)
- **XML sitemap** auto-generated on publish/update
- **Clean URLs** with slug-based routing
- **Open Graph tags** for social sharing
- **Canonical URLs** to prevent duplication
- **Breadcrumb navigation** with structured data

---

## Success Metrics

### User Engagement
- **Target:** 1,000 registered users in first 3 months
- **Active users:** 40% monthly active rate
- **Avg saved scholarships:** 5+ per user
- **Session duration:** 5+ minutes average

### Conversion Metrics
- **Save rate:** 10% of views result in saves
- **Click-through rate:** 15% of views result in application clicks
- **Email open rate:** 25%+
- **Email click rate:** 5%+

### Revenue Targets
- **Month 3:** $1,250/month (10 Featured, 2 Premium)
- **Month 6:** $3,625/month (25 Featured, 5 Premium + affiliates)
- **Month 12:** $8,250/month (50 Featured, 10 Premium + affiliates + ads)

### Performance Benchmarks
- **Page load:** < 2s homepage, < 3s detail pages
- **Lighthouse scores:** Performance 90+, SEO 100
- **Uptime:** 99.9%
- **Error rate:** < 0.1% of requests

---

## Nice to Haves (Future Phases)

### Phase 2 (Months 4-6)
- Requirements completion tracker with progress bars
- Blog and resources section with CMS
- Advanced analytics with CTR calculations
- Enhanced email digests with better templates

### Phase 3 (Months 7-12)
- Reviews and ratings system with moderation
- Success stories submission and display
- Multi-language support (Spanish, French, Arabic, Chinese, Portuguese, German)
- Performance optimization with Redis caching
- Related scholarships algorithm

### Phase 4+ (Year 2)
- Native mobile apps (iOS, Android)
- AI-powered scholarship matching
- In-platform application builder
- Scholarship provider self-service portal
- Community forums and mentorship
- Premium user tier (ad-free, advanced features)

---

## Constraints & Assumptions

### Technical Constraints
- **No database enum types** - use PHP Enum classes with string columns
- **No localStorage in artifacts** - use server sessions and database
- **Hostinger hosting** - optimize for shared/VPS environment
- **Brevo free tier** - max 300 emails/day, implement digest system

### Business Constraints
- **Initial budget:** Minimal operational costs (< $100/month)
- **Development time:** 12 weeks for MVP
- **Target market:** Focus on African markets and underserved regions
- **Data quality:** Manual curation initially, automated aggregation in future

### Assumptions
- Students will engage with email notifications
- Institutions will pay for premium placement
- Affiliate programs will provide meaningful revenue
- SEO will drive 50%+ organic traffic by month 6
- Users prefer email digest over instant notifications

---

## Risk Mitigation

### Technical Risks
- **Search performance:** Use Meilisearch, optimize queries, implement caching
- **Email deliverability:** Authenticate domain (SPF, DKIM), use reputable provider
- **Security:** Regular updates, rate limiting, HTTPS, input sanitization

### Business Risks
- **Low adoption:** Strong SEO, content marketing, social media presence, partnerships
- **Difficulty attracting sponsors:** Build user base first, demonstrate value, offer trials
- **Competition:** Focus on underserved markets, superior UX, community features

### Operational Risks
- **Data quality:** Monthly audits, automated deadline checks, user reporting
- **Scaling issues:** Start small, upgrade hosting as needed, optimize queries
- **Legal compliance:** GDPR tools, privacy policy, terms of service, legal consultation

---

## Definition of Done (MVP)

The MVP is complete when:
- ✅ Users can search and filter scholarships with Livewire
- ✅ Users can register via social auth and save scholarships
- ✅ Users receive email notifications for matches and deadlines
- ✅ Admins can manage all content via Filament 5 panel
- ✅ Sponsorship tiers display correctly with visual differentiation
- ✅ All pages are mobile-responsive with Tailwind v4
- ✅ SEO is configured (sitemap, meta tags, schema.org)
- ✅ Analytics tracking is active (GA4)
- ✅ Application is deployed to Hostinger with SSL
- ✅ Performance meets targets (< 3s page load)
- ✅ 100+ scholarships seeded with real data
- ✅ All automated tests pass (Feature + Browser)

---

*This specification serves as the single source of truth for the Scholarpeep project. All development decisions should align with this document. Last updated: 2026-01-16*