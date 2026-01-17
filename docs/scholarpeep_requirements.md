# Scholarpeep - Complete Project Requirements Document

## 1. Executive Summary

**Project Name:** Scholarpeep

**Project Type:** Web-based Scholarship Discovery and Management Platform

**Objective:** Create a comprehensive scholarship search platform where students can discover, filter, save, and track scholarship opportunities globally. The platform will generate revenue through a tiered sponsorship model, affiliate programs, and advertising space.

**Target Users:** 
- Students seeking scholarships (undergraduate, masters, PhD, high school)
- Educational institutions and scholarship providers (sponsors)
- Administrators (platform management)

---

## 2. Technical Stack

### **Backend**
- Framework: Laravel (latest stable version)
- Admin Panel: Filament 3.x
- Database: MySQL/PostgreSQL
- Queue System: Redis (for email notifications and background jobs)
- Search: Laravel Scout with Meilisearch or Algolia (for fast, typo-tolerant search)

### **Frontend**
- Blade templates with Alpine.js & Livewire, OR
- Vue.js/React SPA (choose based on team preference)
- CSS: Tailwind CSS
- Icons: Heroicons or Lucide

### **Authentication**
- Laravel Socialite (Google and Facebook OAuth)
- Email verification required
- Password reset functionality

### **Infrastructure**
- Hosting: AWS, DigitalOcean, or Laravel Forge + Vultr
- CDN: Cloudflare
- Email: AWS SES, Mailgun, or SendGrid
- File Storage: AWS S3 or DigitalOcean Spaces

### **Third-party Integrations**
- Google Analytics 4
- Google Search Console
- Cloudflare (free tier for CDN and basic DDoS protection)
- Brevo API (email delivery and marketing)

---

## 3. Enum Classes Structure

Before diving into database schema, the application will use PHP Enum classes instead of database enum types for better maintainability and type safety.

### **3.1 Enum Classes Location**

All enum classes will be located in `app/Enums/` directory.

### **3.2 Enum Classes**

#### **app/Enums/DeadlineType.php**
```php
<?php

namespace App\Enums;

enum DeadlineType: string
{
    case APPLICATION = 'application';
    case EARLY_DECISION = 'early_decision';
    case REGULAR = 'regular';
    case FINAL = 'final';
    case ROUND_1 = 'round_1';
    case ROUND_2 = 'round_2';
    case ROUND_3 = 'round_3';

    public function label(): string
    {
        return match($this) {
            self::APPLICATION => 'Application',
            self::EARLY_DECISION => 'Early Decision',
            self::REGULAR => 'Regular',
            self::FINAL => 'Final',
            self::ROUND_1 => 'Round 1',
            self::ROUND_2 => 'Round 2',
            self::ROUND_3 => 'Round 3',
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
```

#### **app/Enums/RequirementType.php**
```php
<?php

namespace App\Enums;

enum RequirementType: string
{
    case DOCUMENT = 'document';
    case ESSAY = 'essay';
    case RECOMMENDATION_LETTER = 'recommendation_letter';
    case TRANSCRIPT = 'transcript';
    case TEST_SCORE = 'test_score';
    case PORTFOLIO = 'portfolio';
    case INTERVIEW = 'interview';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::DOCUMENT => 'Document',
            self::ESSAY => 'Essay',
            self::RECOMMENDATION_LETTER => 'Recommendation Letter',
            self::TRANSCRIPT => 'Transcript',
            self::TEST_SCORE => 'Test Score',
            self::PORTFOLIO => 'Portfolio',
            self::INTERVIEW => 'Interview',
            self::OTHER => 'Other',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::DOCUMENT => 'file-02',
            self::ESSAY => 'file-edit',
            self::RECOMMENDATION_LETTER => 'mail-01',
            self::TRANSCRIPT => 'certificate-01',
            self::TEST_SCORE => 'file-check-02',
            self::PORTFOLIO => 'folder-open',
            self::INTERVIEW => 'user-multiple',
            self::OTHER => 'file-attachment-02',
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
```

#### **app/Enums/ScholarshipStatus.php**
```php
<?php

namespace App\Enums;

enum ScholarshipStatus: string
{
    case SAVED = 'saved';
    case APPLIED = 'applied';
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match($this) {
            self::SAVED => 'Saved',
            self::APPLIED => 'Applied',
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::SAVED => 'gray',
            self::APPLIED => 'blue',
            self::PENDING => 'yellow',
            self::ACCEPTED => 'green',
            self::REJECTED => 'red',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::SAVED => 'bookmark',
            self::APPLIED => 'sent-01',
            self::PENDING => 'time-02',
            self::ACCEPTED => 'checkbox-check',
            self::REJECTED => 'cancel-01',
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
```

#### **app/Enums/SponsorshipTier.php**
```php
<?php

namespace App\Enums;

enum SponsorshipTier: string
{
    case STANDARD = 'standard';
    case FEATURED = 'featured';
    case PREMIUM = 'premium';

    public function label(): string
    {
        return match($this) {
            self::STANDARD => 'Standard',
            self::FEATURED => 'Featured',
            self::PREMIUM => 'Premium Sponsored',
        };
    }

    public function price(): float
    {
        return match($this) {
            self::STANDARD => 0,
            self::FEATURED => 75.00,
            self::PREMIUM => 250.00,
        };
    }

    public function color(): string
    {
        return match($this) {
            self::STANDARD => 'gray',
            self::FEATURED => 'yellow',
            self::PREMIUM => 'purple',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::STANDARD => '',
            self::FEATURED => 'bg-gradient-to-r from-yellow-400 to-yellow-600 text-white',
            self::PREMIUM => 'bg-gradient-to-r from-purple-500 to-purple-700 text-white',
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
```

#### **app/Enums/NotificationFrequency.php**
```php
<?php

namespace App\Enums;

enum NotificationFrequency: string
{
    case INSTANT = 'instant';
    case DAILY = 'daily';
    case WEEKLY = 'weekly';

    public function label(): string
    {
        return match($this) {
            self::INSTANT => 'Instant (as they happen)',
            self::DAILY => 'Daily Digest',
            self::WEEKLY => 'Weekly Digest',
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
```

#### **app/Enums/ResourceType.php**
```php
<?php

namespace App\Enums;

enum ResourceType: string
{
    case GUIDE = 'guide';
    case TEMPLATE = 'template';
    case CHECKLIST = 'checklist';
    case VIDEO = 'video';
    case EXTERNAL_LINK = 'external_link';

    public function label(): string
    {
        return match($this) {
            self::GUIDE => 'Guide',
            self::TEMPLATE => 'Template',
            self::CHECKLIST => 'Checklist',
            self::VIDEO => 'Video',
            self::EXTERNAL_LINK => 'External Link',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::GUIDE => 'book-02',
            self::TEMPLATE => 'file-download-02',
            self::CHECKLIST => 'task-01',
            self::VIDEO => 'video-camera',
            self::EXTERNAL_LINK => 'link-external',
        };
    }

    public static function toArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
```

---

## 4. Database Schema

### **Core Tables**

#### **scholarships**
- id (primary key)
- title (string)
- description (text)
- eligibility_criteria (text, nullable)
- award_amount (decimal, nullable)
- currency (string, nullable)
- application_url (string)
- primary_deadline (date, nullable)
- is_rolling (boolean, default: false)
- provider_name (string)
- provider_logo (string, nullable) - for premium sponsors
- is_active (boolean, default: true)
- featured (boolean, default: false)
- sponsorship_tier (string, default: 'standard') - uses SponsorshipTier enum
- sponsorship_start_date (date, nullable)
- sponsorship_end_date (date, nullable)
- views_count (integer, default: 0)
- clicks_count (integer, default: 0)
- applications_count (integer, default: 0) - tracked via affiliate clicks
- slug (string, unique) - for SEO-friendly URLs
- meta_title (string, nullable)
- meta_description (text, nullable)
- created_at, updated_at
- Indexes: primary_deadline, is_active, featured, sponsorship_tier, slug

#### **countries**
- id
- name (string)
- code (string, 3 chars, ISO code)
- created_at, updated_at

#### **education_levels**
- id
- name (string) - e.g., "High School", "Undergraduate", "Masters", "PhD"
- slug (string, unique)
- created_at, updated_at

#### **fields_of_study**
- id
- name (string) - e.g., "Computer Science", "Medicine", "Business"
- slug (string, unique)
- parent_id (foreign key, nullable) - for subcategories
- created_at, updated_at

#### **scholarship_types**
- id
- name (string) - e.g., "Merit-based", "Need-based", "Athletic", "Minority"
- slug (string, unique)
- description (text, nullable)
- created_at, updated_at

### **Pivot Tables**

#### **scholarship_country**
- scholarship_id (foreign key)
- country_id (foreign key)
- Primary key: [scholarship_id, country_id]

#### **scholarship_education_level**
- scholarship_id (foreign key)
- education_level_id (foreign key)
- Primary key: [scholarship_id, education_level_id]

#### **scholarship_field_of_study**
- scholarship_id (foreign key)
- field_of_study_id (foreign key)
- Primary key: [scholarship_id, field_of_study_id]

#### **scholarship_scholarship_type**
- scholarship_id (foreign key)
- scholarship_type_id (foreign key)
- Primary key: [scholarship_id, scholarship_type_id]

### **Supporting Tables**

#### **scholarship_deadlines**
- id
- scholarship_id (foreign key)
- deadline_type (string) - uses DeadlineType enum
- deadline_date (date)
- description (string, nullable)
- is_priority (boolean, default: false)
- created_at, updated_at
- Index: [scholarship_id, deadline_date]

#### **scholarship_requirements**
- id
- scholarship_id (foreign key)
- requirement_type (string) - uses RequirementType enum
- title (string)
- description (text, nullable)
- is_required (boolean, default: true)
- order (integer, default: 0)
- created_at, updated_at
- Index: scholarship_id

### **User/Tenant Tables**

#### **tenants** (users)
- id
- name (string)
- email (string, unique)
- password (string, nullable) - nullable for social auth
- email_verified_at (timestamp, nullable)
- google_id (string, nullable)
- facebook_id (string, nullable)
- avatar (string, nullable)
- remember_token
- created_at, updated_at

#### **saved_scholarships**
- id
- tenant_id (foreign key)
- scholarship_id (foreign key)
- status (string, default: 'saved') - uses ScholarshipStatus enum
- notes (text, nullable)
- created_at, updated_at
- Unique: [tenant_id, scholarship_id]
- Indexes: tenant_id, status

#### **saved_scholarship_requirements**
- id
- saved_scholarship_id (foreign key)
- scholarship_requirement_id (foreign key)
- is_completed (boolean, default: false)
- completed_at (timestamp, nullable)
- notes (text, nullable)
- created_at, updated_at
- Index: saved_scholarship_id

#### **tenant_preferences**
- id
- tenant_id (foreign key, unique)
- country_ids (json, nullable)
- education_level_ids (json, nullable)
- field_of_study_ids (json, nullable)
- scholarship_type_ids (json, nullable)
- notify_new_scholarships (boolean, default: true)
- notify_deadlines (boolean, default: true)
- notification_frequency (string, default: 'daily') - uses NotificationFrequency enum
- deadline_reminder_days (integer, default: 7)
- created_at, updated_at

### **Analytics Tables**

#### **scholarship_views**
- id
- scholarship_id (foreign key)
- tenant_id (foreign key, nullable)
- ip_address (string, 45 chars)
- user_agent (text, nullable)
- referrer (string, nullable)
- created_at (timestamp only)
- Indexes: scholarship_id, created_at

#### **affiliate_clicks**
- id
- scholarship_id (foreign key)
- tenant_id (foreign key, nullable)
- ip_address (string, 45 chars)
- created_at (timestamp only)
- Indexes: scholarship_id, created_at

### **Content Management Tables**

#### **blog_posts**
- id
- title (string)
- slug (string, unique)
- content (longtext)
- excerpt (text, nullable)
- featured_image (string, nullable)
- author_id (foreign key to tenants/admins)
- is_published (boolean, default: false)
- published_at (timestamp, nullable)
- meta_title (string, nullable)
- meta_description (text, nullable)
- views_count (integer, default: 0)
- created_at, updated_at
- Indexes: slug, is_published, published_at

#### **resources**
- id
- title (string)
- description (text)
- resource_type (string) - uses ResourceType enum
- file_path (string, nullable)
- external_url (string, nullable)
- is_active (boolean, default: true)
- created_at, updated_at

#### **reviews**
- id
- scholarship_id (foreign key)
- tenant_id (foreign key)
- rating (integer, 1-5)
- title (string, nullable)
- comment (text, nullable)
- is_verified (boolean, default: false) - for users who got the scholarship
- is_approved (boolean, default: false) - admin moderation
- helpful_count (integer, default: 0)
- created_at, updated_at
- Indexes: scholarship_id, is_approved

#### **success_stories**
- id
- tenant_id (foreign key)
- scholarship_id (foreign key, nullable)
- title (string)
- story (text)
- student_name (string)
- student_photo (string, nullable)
- university (string, nullable)
- country (string, nullable)
- is_featured (boolean, default: false)
- is_approved (boolean, default: false)
- created_at, updated_at
- Index: is_approved, is_featured

---

## 4. Core Features & Functionality

### **4.1 User Authentication & Authorization**

#### **Registration/Login**
- Social authentication (Google, Facebook) via Laravel Socialite
- Traditional email/password registration (optional)
- Email verification required before saving scholarships
- Password reset via email (for email/password users)
- "Remember me" functionality

#### **User Roles**
- **Student/Tenant**: Regular users who search and save scholarships
- **Admin**: Platform administrators with full access to Filament panel
- **Content Manager** (optional): Limited admin access for blog/content management

#### **Account Management**
- Profile editing (name, email, avatar)
- Password change
- Account deletion with data export option (GDPR compliance)
- Notification preferences

---

### **4.2 Scholarship Discovery & Search**

#### **Homepage**
- Hero section with prominent search bar
- Quick filter buttons (Popular Countries, Education Levels, Fields)
- Premium Sponsored Carousel (3 scholarships, auto-rotate every 30 seconds)
- Featured Scholarships Grid (6 scholarships)
- Latest Scholarships section
- Blog/Resources preview section
- Success Stories carousel
- Newsletter signup form (footer)

#### **Search Functionality**
- **Global search bar**: Search by scholarship name, provider, or keywords
- **Auto-complete**: Suggest scholarships, fields, countries as user types
- **Typo tolerance**: Use Meilisearch/Algolia for fuzzy matching
- **Recent searches**: Show last 5 searches for logged-in users (stored in session/browser)
- **Search suggestions**: "Students also searched for..."

#### **Advanced Filters** (Sidebar/Mobile Drawer)
- **Country**: Multi-select dropdown with search
- **Education Level**: Checkboxes (High School, Undergraduate, Masters, PhD)
- **Field of Study**: Multi-select with parent/child categories
- **Scholarship Type**: Checkboxes (Merit-based, Need-based, etc.)
- **Award Amount**: Range slider (e.g., $1,000 - $50,000+)
- **Deadline**: Date range picker or quick options (This month, Next 3 months, etc.)
- **Application Status**: Rolling vs Fixed deadline

#### **Search Results Page**
- **Layout**: Grid or List view toggle
- **Sorting Options**:
  - Relevance (default)
  - Deadline (soonest first)
  - Award Amount (highest first)
  - Newest added
- **Result Display**:
  - Premium Sponsored (Top 2, full-width cards with gradient, logo, "Sponsored" badge)
  - Featured scholarships (Every 3-5 results, gold badge, subtle highlight)
  - Regular scholarships
- **Pagination**: Load more (infinite scroll) or traditional pagination
- **Active filters**: Show applied filters as removable tags
- **Results count**: "Showing X of Y scholarships"

#### **Scholarship Card (Search Results)**
- Scholarship title
- Provider name
- Award amount (if available)
- Primary deadline or "Rolling"
- Countries available (flags or text)
- Education level icons
- Quick save button (heart icon)
- Sponsorship badge (if Featured/Premium)
- Provider logo (for Premium only)
- Hover effect: Quick preview of eligibility

---

### **4.3 Scholarship Detail Page**

#### **URL Structure**
- SEO-friendly: `/scholarships/{slug}`
- Example: `/scholarships/fulbright-masters-scholarship-usa-2025`

#### **Page Sections**

**Header**
- Scholarship title (H1)
- Provider name with logo (if Premium)
- Sponsorship badge (Featured/Premium)
- Award amount (prominent display)
- Primary deadline with countdown timer (if within 30 days)
- Save button (heart icon, shows saved count)
- Share buttons (Facebook, Twitter, LinkedIn, WhatsApp, Copy Link)
- Apply Now CTA button (tracks affiliate click)

**Overview**
- Full description
- Eligibility criteria (formatted list)
- Countries available (flags + names)
- Education levels
- Fields of study
- Scholarship types (badges)

**Deadlines**
- Table showing all deadlines with type and date
- Visual timeline if multiple rounds

**Requirements**
- Categorized list (Documents, Essays, Recommendations, etc.)
- Each requirement with title, description, required/optional badge
- For logged-in users with saved scholarship: Checkboxes to mark completed

**Application Process**
- Step-by-step guide (if available)
- External link to official application

**Reviews & Ratings** (Phase 2 - Community Features)
- Average rating (stars)
- Total review count
- Verified reviews (from users who got the scholarship) highlighted
- Sort by: Most helpful, Most recent, Highest/Lowest rating
- "Write a review" button (only for users who saved it)

**Related Scholarships**
- 4-6 similar scholarships based on:
  - Same country
  - Same education level
  - Same field of study
  - Same scholarship type

**Sidebar** (Desktop) / Below Content (Mobile)
- Quick facts box (Amount, Deadline, Level, etc.)
- Provider information
- "Need help with your application?" CTA (affiliate link to essay services, etc.)
- Ad space

#### **SEO Optimization**
- Dynamic meta title: "{Scholarship Name} - {Amount} | Scholarpeep"
- Meta description: First 160 chars of description + deadline
- Open Graph tags for social sharing
- Schema.org structured data (ScholarshipPosting type)
- Canonical URL
- Alt text for all images

---

### **4.4 User Dashboard (Logged-in Users)**

#### **My Scholarships** (Main Dashboard)

**Tabs**:
1. **Saved** (default): All saved scholarships
2. **Applied**: Scholarships user has applied to
3. **Pending**: Awaiting results
4. **Accepted**: Successful applications
5. **Rejected**: Unsuccessful applications

**Features**:
- Filter by deadline, country, education level
- Sort by deadline, date saved, amount
- Bulk actions: Change status, delete
- Status badges with color coding
- Quick actions: View details, Change status, Delete, Add notes

**Scholarship Card (Dashboard)**
- Same basic info as search results
- Status indicator
- Days until deadline
- Progress bar for requirements completion
- Notes preview (if added)
- Last updated timestamp

#### **Requirements Tracker** (Per Scholarship)
- Checklist of all requirements
- Mark as completed with date/time stamp
- Add private notes per requirement
- Overall completion percentage
- Upload documents (optional feature for Phase 2)

#### **Calendar View** (Optional)
- Month view showing all saved scholarship deadlines
- Color-coded by status
- Click to view scholarship details
- Export to Google Calendar, iCal

#### **Profile & Preferences**

**Profile Tab**:
- Name, email, avatar
- Account created date
- Total scholarships saved/applied

**Preferences Tab**:
- Match Preferences:
  - Countries (multi-select)
  - Education levels (checkboxes)
  - Fields of study (multi-select)
  - Scholarship types (checkboxes)
- Email Notifications:
  - New matching scholarships (toggle)
  - Deadline reminders (toggle)
  - Newsletter (toggle)
- Notification Frequency:
  - Instant (as they happen)
  - Daily Digest (one email per day at 8 AM user's timezone)
  - Weekly Digest (Monday 8 AM)
- Deadline Reminder:
  - Slider: 1-30 days before deadline
  - Default: 7 days

**Notification Settings**:
- Toggle for each notification type
- Preview of email templates
- Test notification button

---

### **4.5 Notification System**

#### **Email Notifications**

**New Matching Scholarships**:
- Triggered when: New scholarship is published that matches user's preferences
- Frequency: Based on user preference (Instant/Daily/Weekly)
- Content:
  - Subject: "🎓 {X} New Scholarships Match Your Profile"
  - Scholarship cards with CTA to view
  - Link to update preferences
- Daily Digest Template:
  - Grouped by education level or country
  - Up to 10 scholarships per email
- Weekly Digest Template:
  - Summary of new scholarships from past week
  - Top 5 most relevant + "View all X scholarships"

**Deadline Reminders**:
- Triggered when: X days before scholarship deadline (based on user preference)
- Frequency: Once per scholarship at set interval (7 days default)
- Content:
  - Subject: "⏰ Deadline Alert: {Scholarship Name} - {X} Days Left"
  - Scholarship details
  - Requirements completion status
  - CTA to view requirements
  - "Apply Now" button

**Status Updates** (Optional):
- When user changes scholarship status to "Applied", send confirmation email
- Include next steps, tips for awaiting results

#### **In-App Notifications** (Optional Phase 2)
- Bell icon in header with unread count
- Dropdown showing recent notifications
- Types: New matches, deadline reminders, system announcements

#### **Email Infrastructure**
- Queue-based system (Laravel Queue with Redis)
- Rate limiting to prevent spam
- Unsubscribe link in all emails
- Email preference center (one-click unsubscribe by type)
- Email tracking (opens, clicks) via SendGrid/Mailgun webhooks

---

### **4.6 Admin Panel (Filament)**

#### **Dashboard**

**Key Metrics Cards**:
- Total Scholarships (Active/Inactive)
- Total Users
- Scholarships Added This Month
- Total Views (30 days)
- Total Clicks (30 days)
- Click-Through Rate (CTR)
- Revenue This Month (from sponsorships)

**Charts**:
- Scholarship views over time (line chart, last 30 days)
- Application clicks over time (line chart, last 30 days)
- Top 10 scholarships by views (bar chart)
- Top 10 scholarships by clicks (bar chart)
- User registrations over time (line chart)
- Traffic sources (pie chart)

**Recent Activity**:
- Latest scholarships added
- Latest user registrations
- Latest reviews (if approved)
- Expiring sponsorships (alert if within 7 days)

#### **Scholarships Management**

**List View**:
- Table with columns:
  - ID
  - Title
  - Provider
  - Sponsorship Tier (badge with color)
  - Status (Active/Inactive toggle)
  - Deadline
  - Views
  - Clicks
  - CTR
  - Created Date
  - Actions (View, Edit, Delete)
- Filters:
  - Sponsorship tier
  - Status
  - Country
  - Education level
  - Field of study
  - Date range
- Search by title, provider
- Bulk actions:
  - Change tier
  - Activate/Deactivate
  - Export selected
- Export all to CSV

**Create/Edit Form**:

*Basic Information Tab*:
- Title (required)
- Slug (auto-generated, editable)
- Provider Name (required)
- Provider Logo (upload, for Premium tier)
- Description (rich text editor)
- Eligibility Criteria (rich text editor)
- Award Amount (number)
- Currency (dropdown: USD, EUR, GBP, etc.)
- Application URL (required)
- Is Rolling (toggle)
- Primary Deadline (date picker, if not rolling)

*Categorization Tab*:
- Countries (multi-select, searchable)
- Education Levels (checkboxes)
- Fields of Study (multi-select with parent/child)
- Scholarship Types (checkboxes)

*Deadlines Tab*:
- Repeater field to add multiple deadlines
- Each deadline:
  - Type (dropdown)
  - Date (date picker)
  - Description (text)
  - Is Priority (toggle)

*Requirements Tab*:
- Repeater field to add requirements
- Each requirement:
  - Type (dropdown)
  - Title (text)
  - Description (textarea)
  - Is Required (toggle)
  - Order (number, for sorting)

*Sponsorship Tab*:
- Sponsorship Tier (select: Standard, Featured, Premium)
- Start Date (date picker)
- End Date (date picker)
- Notes (for internal tracking)

*SEO Tab*:
- Meta Title (auto-filled from title, editable)
- Meta Description (auto-filled from description excerpt, editable)
- Character counters for both

*Status & Publishing*:
- Is Active (toggle)
- Scheduled Publish Date (datetime picker, optional)
- Created At (display only)
- Last Updated (display only)

**Bulk Import**:
- Upload CSV file
- Map CSV columns to database fields
- Preview import (first 10 rows)
- Validation errors displayed
- Import in background job with progress indicator
- Email notification when import completes

**Bulk Export**:
- Select scholarships (all or filtered)
- Choose fields to export
- Download CSV

#### **Users Management**

**List View**:
- Table with columns:
  - ID
  - Name
  - Email
  - Verified (badge)
  - Auth Provider (Google/Facebook icon)
  - Saved Scholarships Count
  - Registered Date
  - Actions (View, Edit, Delete)
- Filters:
  - Verified status
  - Auth provider
  - Registration date range
- Search by name, email
- Export to CSV

**View User**:
- User details
- Saved scholarships list with status
- Preferences
- Activity log (optional)
- Actions: Send email, Suspend, Delete

#### **Countries, Education Levels, Fields, Types Management**

**Simple CRUD for each**:
- List view with search
- Create/Edit forms
- Delete with confirmation (check if in use)
- Bulk actions

#### **Reviews Management** (Phase 2)

**List View**:
- Table with columns:
  - User
  - Scholarship
  - Rating (stars)
  - Comment preview
  - Verified (badge)
  - Approved (toggle)
  - Date
  - Actions (View, Approve/Reject, Delete)
- Filters:
  - Approval status
  - Verified status
  - Rating
  - Date range
- Approve/Reject bulk actions

#### **Blog Management**

**List View**:
- Table with columns:
  - Title
  - Author
  - Status (Published/Draft)
  - Published Date
  - Views
  - Actions (View, Edit, Delete)
- Filters: Status, Author, Date range
- Search by title

**Create/Edit Form**:
- Title (required)
- Slug (auto-generated)
- Content (rich text editor with media uploads)
- Excerpt (textarea, auto-filled from content)
- Featured Image (upload)
- Author (select from admins)
- Categories/Tags (optional)
- SEO fields (meta title, description)
- Publish Status (toggle)
- Scheduled Publish Date (datetime picker)

#### **Resources Management**

**List View**:
- Table with resource type, title, type, active status
- CRUD operations

**Create/Edit Form**:
- Title, Description
- Resource Type (dropdown)
- File upload or External URL
- Is Active (toggle)

#### **Success Stories Management**

**List View**:
- Table with student name, title, featured, approved
- Filters: Approval status, Featured
- Approve/Reject/Feature actions

#### **Analytics & Reports**

**Scholarship Performance**:
- Detailed view for each scholarship:
  - Total views, unique views
  - Total clicks, unique clicks
  - CTR calculation
  - Views/Clicks over time (chart)
  - Top referrers
  - Geographic breakdown (if tracking IP)
  - Device breakdown (desktop/mobile/tablet)

**Global Analytics**:
- Total platform views, clicks
- Most popular scholarships (table)
- Most popular countries, fields, education levels
- User growth chart
- Conversion funnel (View → Click → Save → Apply)

**Sponsorship Revenue**:
- Table of active sponsorships with tier, dates, monthly revenue
- Revenue over time (chart)
- Expiring sponsorships alert
- Revenue by tier (pie chart)

**Export Reports**:
- Date range selector
- Export scholarship performance to PDF/CSV
- Schedule automated reports (email to admin weekly/monthly)

#### **Settings**

**General Settings**:
- Site name, tagline
- Contact email
- Social media links
- Maintenance mode toggle

**SEO Settings**:
- Default meta title template
- Default meta description template
- Google Analytics ID
- Google Search Console verification code
- Sitemap generation (auto/manual trigger)

**Email Settings**:
- SMTP configuration (if not in .env)
- Default "from" email and name
- Email template customization (logo, colors, footer)

**Notification Settings**:
- Enable/disable notification types globally
- Default notification frequency
- Email sending limits (per hour/day)

**Sponsorship Settings**:
- Tier pricing (informational, not used for payment processing initially)
- Maximum sponsored scholarships per search page
- Carousel rotation interval (seconds)

---

### **4.7 Blog & Resources Section**

#### **Blog**

**Blog Homepage** (`/blog`):
- Featured post (large card)
- Grid of recent posts (6-9 posts)
- Categories filter (sidebar or tabs)
- Search functionality
- Pagination

**Blog Post Page** (`/blog/{slug}`):
- Post title (H1)
- Author name, photo, publish date
- Featured image
- Content (formatted)
- Share buttons
- Related posts (3-4)
- Comments section (optional Phase 2, or use Disqus)
- Sidebar: Recent posts, categories, newsletter signup

**Categories**: Scholarship Tips, Application Essays, Financial Aid, Study Abroad, Career Advice, Success Stories

#### **Resources** (`/resources`)

**Resources Page**:
- Filterable list by resource type
- Card layout with icon, title, description
- Download/View button
- Search functionality

**Resource Types**:
- **Guides**: PDF downloads (e.g., "Complete Scholarship Application Guide")
- **Templates**: Essay templates, CV templates
- **Checklists**: Application checklist, document checklist
- **Videos**: Embedded YouTube videos (tips, interviews)
- **External Links**: Curated links to useful sites

---

### **4.8 Community Features** (Phase 2/3)

#### **Reviews & Ratings**

**Add Review** (Scholarship Detail Page):
- Star rating (1-5, required)
- Title (optional)
- Comment (required, max 500 words)
- "I received this scholarship" checkbox (marks as verified)
- Submit for moderation

**Review Moderation**:
- Admin approves/rejects in Filament panel
- Verified reviews get special badge
- Spam/inappropriate content filtered

**Display**:
- Average rating at top of scholarship page
- Sort reviews by helpful, recent, rating
- "Helpful" voting (thumbs up, requires login)

#### **Success Stories**

**Submit Story** (User Dashboard):
- Form with fields: Title, Story, Name, Photo, University, Country, Scholarship (optional)
- Submit for moderation

**Display**:
- Dedicated success stories page (`/success-stories`)
- Featured stories on homepage carousel
- Filter by country, field, scholarship
- Individual story page with full content

---

### **4.9 Sponsorship System**

#### **Tier Structure** (Defined in 4.6)

**Standard (Free)**:
- Regular search placement
- No special badges
- Basic analytics (views only)

**Featured ($75/month per scholarship)**:
- Gold "Featured" badge
- Top 5 results rotation
- Enhanced card styling
- Homepage carousel inclusion
- Enhanced analytics (views, clicks, CTR)

**Premium ($250/month for up to 5 scholarships)**:
- Purple "Sponsored" badge with gradient
- Fixed top 2 positions
- Prominent card design
- Provider logo display
- Dedicated institution profile page
- Homepage banner
- Advanced analytics dashboard
- Email newsletter inclusion
- Priority support

#### **Display Logic**

**Search Results Page**:
```
[Premium #1 - Full width]
[Premium #2 - Full width]
[Featured - Regular card with badge]
[Regular]
[Featured - Regular card with badge]
[Regular]
[Regular]
[Featured - Regular card with badge]
... (continue mixing)
```

**Homepage**:
- Premium Carousel: 3 scholarships, auto-rotate every 30 seconds
- Featured Grid: 6 scholarships

**Rotation**:
- Premium: If more than 2 active, rotate positions 1-2 every 24 hours
- Featured: Rotate every 12 hours, appear every 3-5 results
- Algorithm: Relevance score × Tier weight × Rotation time

#### **Admin Management**:
- Set tier when creating/editing scholarship
- Set start/end dates
- Automatic expiration (scholarship reverts to Standard after end date)
- Email notification to admin 7 days before expiration
- Revenue tracking per tier

---

### **4.10 SEO & Performance**

#### **SEO Optimization**

**On-Page SEO**:
- Semantic HTML5 structure
- Proper heading hierarchy (H1 → H6)
- Alt text for all images
- Internal linking (related scholarships, blog posts)
- Breadcrumb navigation
- Clean, descriptive URLs

**Meta Tags**:
- Dynamic meta titles and descriptions per page
- Open Graph tags (og:title, og:description, og:image, og:url)
- Twitter Card tags
- Canonical URLs

**Structured Data** (Schema.org):
- ScholarshipPosting schema for scholarships
- Organization schema for homepage
- BlogPosting schema for blog posts
- BreadcrumbList schema

**Technical SEO**:
- XML Sitemap:
  - Auto-generated on scholarship publish/update
  - Separate sitemaps for scholarships, blog, static pages
  - Submitted to Google Search Console
- Robots.txt:
  - Allow all (except admin panel, user dashboard)
- 301 Redirects for changed URLs
- 404 error page with search and helpful links
- Pagination: rel="prev" and rel="next" tags

**Performance**:
- Lazy loading images
- Cloudflare CDN for static assets
- Image optimization (compress, WebP format with fallbacks)
- Minify CSS/JS
- Browser caching headers
- Database query optimization (eager loading, indexes)
- Redis caching for frequently accessed data

**Lighthouse Score Targets**:
- Performance: 90+
- Accessibility: 95+
- Best Practices: 95+
- SEO: 100

#### **Google Analytics 4 Integration**

**Events to Track**:
- page_view (automatic)
- search (query, filters applied, results count)
- scholarship_view (scholarship_id, title, tier)
- scholarship_click (scholarship_id, title, tier, position)
- scholarship_save (scholarship_id, title)
- user_register (method: google/facebook/email)
- filter_apply (filter_type, filter_value)
- sort_change (sort_by)
- share_content (method, scholarship_id)

**Custom Dimensions**:
- User Type (Logged in / Guest)
- Sponsorship Tier (Standard / Featured / Premium)
- Country Filter Applied
- Education Level Filter Applied

**Conversion Goals**:
- Scholarship application click (primary)
- User registration
- Scholarship save
- Email signup

**Dashboard Setup**:
- Real-time overview
- Acquisition report (traffic sources)
- Engagement report (top pages, events)
- Scholarship performance (custom report)
- Conversion funnel (View → Click → Save → Apply)

---

### **4.11 Internationalization (Phase 3)**

**Supported Languages**:
- English (default)
- Spanish
- French
- German
- Arabic
- Chinese (Simplified)
- Portuguese

**Implementation**:
- Laravel localization
- Language switcher in header
- Store user preference in session/database
- Translate UI elements, emails, static content
- Scholarships remain in original language (or add translation fields in future)

**SEO for Multiple Languages**:
- Hreflang tags
- Language-specific URLs (e.g., `/es/scholarships/`)
- Separate sitemaps per language

---

## 5. User Flows

### **5.1 Anonymous User Flow**

1. **Lands on homepage**
2. **Sees hero with search bar** and featured scholarships
3. **Types search query or applies filters**
4. **Views search results** with Featured/Premium scholarships at top
5. **Clicks on scholarship** → Views detail page
6. **Clicks "Apply Now"** → Redirected to external application (affiliate click tracked)
7. **Attempts to save scholarship** → Prompted to register/login
8. **Registers via Google/Facebook**
9. **Email verification** → Confirms email
10. **Returns to scholarship detail** → Saves scholarship
11. **Redirected to dashboard** → Sees saved scholarship
12. **Explores more scholarships** → Saves multiple
13. **Sets preferences** → Receives email notifications

### **5.2 Registered User Flow**

1. **Logs in via Google/Facebook**
2. **Lands on dashboard or homepage**
3. **Searches for scholarships**
4. **Saves scholarships of interest**
5. **Views dashboard** → Sees all saved scholarships
6. **Clicks on saved scholarship** → Views detail
7. **Marks requirements as completed** → Tracks progress
8. **Changes status to "Applied"** → Receives confirmation email
9. **Receives deadline reminder email** → Returns to dashboard
10. **Updates status to "Accepted"** → Optionally writes review/success story
11. **Receives new scholarship matches** → Views via email or dashboard notification

### **5.3 Admin Flow**

1. **Logs into Filament admin panel**
2. **Views dashboard** → Sees key metrics and charts
3. **Navigates to Scholarships** → Lists all scholarships
4. **Clicks "Create"** → Fills out scholarship form
5. **Adds deadlines and requirements** → Saves scholarship
6. **Sets sponsorship tier** → Sets Featured or Premium with dates
7. **Publishes or schedules** → Scholarship goes live
8. **Views analytics** → Checks performance
9. **Bulk imports scholarships** → Uploads CSV
10. **Manages reviews** → Approves/rejects user reviews
11. **Creates blog post** → Publishes content
12. **Checks sponsorship revenue** → Views reports

---

## 6. Design & UI/UX

### **6.1 Design Principles**

- **Clean & Minimal**: Focus on content, avoid clutter
- **Trust & Professionalism**: Use blue as primary color for credibility
- **Motivational**: Bright accents (green, gold) for positive actions
- **Accessible**: WCAG 2.1 AA compliance minimum
- **Mobile-First**: Optimize for mobile before desktop

### **6.2 Color Palette**

**Primary Colors**:
- Deep Blue: `#2563EB` - Buttons, links, headers
- Bright Blue: `#3B82F6` - Hover states, active elements

**Secondary Colors**:
- Success Green: `#10B981` - Save buttons, success messages
- Warning Orange: `#F59E0B` - Deadlines, urgency indicators
- Purple: `#8B5CF6` - Premium sponsorship badges

**Neutral Colors**:
- Dark Gray: `#1F2937` - Primary text
- Medium Gray: `#6B7280` - Secondary text
- Light Gray: `#F3F4F6` - Backgrounds, dividers
- White: `#FFFFFF` - Main background

**Semantic Colors**:
- Error Red: `#EF4444`
- Info Blue: `#3B82F6`
- Warning Yellow: `#F59E0B`
- Success Green: `#10B981`

### **6.3 Typography**

**Font Families**:
- **Headers**: Inter or Poppins (600/700 weight)
- **Body**: Inter or System UI (400/500 weight)
- **Monospace**: JetBrains Mono (for code, if needed)

**Scale**:
- H1: 2.5rem (40px) - Page titles
- H2: 2rem (32px) - Section headers
- H3: 1.5rem (24px) - Card titles
- Body: 1rem (16px) - Main text
- Small: 0.875rem (14px) - Captions, metadata

### **6.4 Component Library**

**Buttons**:
- Primary: Blue background, white text, rounded
- Secondary: White background, blue border, blue text
- Success: Green background, white text
- Outline: Transparent background, colored border

**Cards**:
- Standard: White background, subtle shadow, rounded corners
- Featured: Gold border, subtle glow
- Premium: Gradient border, prominent shadow, larger

**Forms**:
- Inputs: Border on focus, error states, helper text
- Labels: Above inputs, required asterisk
- Validation: Inline errors below fields

**Badges**:
- Featured: Gold background, dark text
- Sponsored: Purple gradient, white text
- Status badges: Color-coded by status
- Verified: Green checkmark icon

**Icons**:
- Use Heroicons or Lucide
- Consistent size (20px or 24px)
- Use sparingly for clarity

### **6.5 Responsive Breakpoints**

- Mobile: < 640px
- Tablet: 640px - 1024px
- Desktop: > 1024px
- Large Desktop: > 1280px

**Mobile Considerations**:
- Hamburger menu for navigation
- Filter drawer (slide from left/bottom)
- Stacked layout for scholarship cards
- Touch-friendly buttons (min 44x44px)
- Simplified scholarship cards (fewer details)

---

## 7. Third-party Services & Integrations

### **7.1 Authentication**
- **Laravel Socialite**: Google OAuth, Facebook OAuth
- **Laravel Sanctum/Passport**: API authentication (if building SPA)

### **7.2 Email**
- **Provider**: Brevo (formerly Sendinblue)
- **Free Tier**: 300 emails/day (9,000/month)
- **Features**: Transactional emails, marketing emails, templates
- **API Integration**: Brevo PHP SDK
- **Webhooks**: Track opens, clicks, bounces, unsubscribes

### **7.3 Search**
- **Basic (Phase 1)**: Laravel Scout with database driver
- **Advanced (Phase 2+)**: Meilisearch (cloud or self-hosted) if budget allows
- **Features**: Full-text search, filters, sorting
- **Integration**: Laravel Scout

### **7.4 Storage**
- **Primary**: Local storage on Hostinger
- **Images**: Cloudinary free tier (25 credits/month, 25GB storage, 25GB bandwidth)
  - Automatic image optimization
  - On-the-fly transformations
  - CDN delivery
- **Alternative**: Cloudflare Images (if budget allows later)
- **Backup**: Manual backup to external storage (Google Drive, Dropbox)

### **7.5 CDN**
- **Cloudflare**: Free tier
- **Features**: DDoS protection, caching, SSL, page rules

### **7.6 Analytics**
- **Google Analytics 4**: User behavior, conversions
- **Google Search Console**: Search performance, indexing
- **Facebook Pixel** (optional): Retargeting ads

### **7.7 Payments** (Future - Phase 3)
- **Stripe** or **Paystack** (better for African markets): For processing sponsorship payments
- **Subscriptions**: Recurring billing for sponsorship tiers

### **7.8 Other**
- **reCAPTCHA v3**: Spam protection on forms (free)
- **Sentry**: Error tracking and monitoring (free tier: 5K events/month)
- **Laravel Debugbar**: Local debugging (dev environment only)

---

## 8. Security & Compliance

### **8.1 Security Measures**

**Application Security**:
- HTTPS only (SSL certificate)
- CSRF protection (Laravel default)
- XSS protection (escape all user input)
- SQL injection prevention (use Eloquent ORM, parameterized queries)
- Rate limiting on API routes and login attempts
- Password hashing (bcrypt, Laravel default)
- Two-factor authentication (optional Phase 2)

**Data Protection**:
- Environment variables for sensitive data (.env file)
- Database encryption for sensitive fields (if needed)
- Secure file uploads (validate type, size, scan for malware)
- Regular backups (database, files)

**Access Control**:
- Role-based permissions (Filament Policies)
- Admin panel accessible only to authorized users
- User data isolation (tenant-based queries)

### **8.2 GDPR Compliance** (if targeting EU users)

- Cookie consent banner
- Privacy policy page
- Terms of service page
- Data export functionality (users can download their data)
- Right to deletion (users can delete account and data)
- Data processing agreements with third-party services
- Clear opt-in for marketing emails

### **8.3 Accessibility**

- WCAG 2.1 AA compliance minimum
- Semantic HTML
- ARIA labels where needed
- Keyboard navigation support
- Focus indicators
- Screen reader testing
- Color contrast ratios (4.5:1 for text)

---

## 9. Testing Requirements

### **9.1 Automated Testing**

**Unit Tests**:
- Model relationships
- Business logic (e.g., deadline reminder logic)
- Helper functions

**Feature Tests**:
- User registration and login
- Scholarship search and filtering
- Saving scholarships
- Changing scholarship status
- Email notifications
- Admin CRUD operations

**Browser Tests** (Laravel Dusk):
- User flows (registration to applying)
- Search and filter interactions
- Responsive design
- Cross-browser compatibility (Chrome, Firefox, Safari, Edge)

### **9.2 Manual Testing**

- Usability testing with target users
- Mobile device testing (iOS, Android)
- Email rendering across clients (Gmail, Outlook, Apple Mail)
- Performance testing (load time, database queries)
- Security testing (penetration testing recommended)

### **9.3 Test Coverage Goal**

- Minimum 70% code coverage
- 100% coverage for critical features (auth, search, notifications)

---

## 10. Deployment & DevOps

### **10.1 Environments**

**Local Development**:
- Laravel Herd or Valet (macOS) / Laragon (Windows)
- MySQL 8.0+
- Node.js 20+ for asset compilation
- Composer 2.x

**Staging** (Optional):
- Subdomain on Hostinger (e.g., staging.scholarpeep.com)
- Separate database
- Mirror of production environment

**Production**:
- Hostinger VPS (KVM 2 or higher recommended)
  - 2 vCPU cores
  - 4GB RAM
  - 100GB NVMe Storage
  - ~$11.99/month
- OR Hostinger Business Hosting if traffic is low initially
- MySQL 8.0+
- PHP 8.2+
- Composer installed
- Node.js for building assets

### **10.2 Hostinger Setup**

**Server Requirements**:
- PHP 8.2 or higher
- MySQL 8.0+
- Composer
- Node.js 20+ & npm
- Git
- SSL certificate (free via Hostinger/Let's Encrypt)

**Recommended Hostinger Plan**:
- **Phase 1 (MVP)**: Business Hosting ($3.99-7.99/month)
  - 200 websites
  - 200GB storage
  - Unlimited bandwidth
  - Free domain
  - Free email
  - Good for up to 10K visitors/month
  
- **Phase 2+ (Growth)**: VPS KVM 2 ($11.99/month)
  - 2 vCPU
  - 4GB RAM
  - 100GB NVMe
  - 2TB bandwidth
  - Full root access
  - Better for 20K+ visitors/month

**Initial Setup Steps**:
1. Purchase Hostinger plan with domain
2. Install SSL certificate
3. Set up Git repository connection
4. Configure PHP version (8.2+)
5. Install Composer dependencies
6. Set up database
7. Configure environment variables
8. Run migrations
9. Build frontend assets
10. Set up cron jobs for Laravel scheduler
11. Configure Cloudflare DNS

### **10.3 CI/CD Pipeline**

**Version Control**: Git (GitHub, GitLab, or Bitbucket)

**CI/CD Tool**: GitHub Actions (free for public repos, 2000 minutes/month for private)

**Pipeline Steps**:
1. Code push to repository
2. Run automated tests (PHPUnit, Pest)
3. Code quality checks (Laravel Pint, PHPStan if configured)
4. Build assets (npm run build)
5. Deploy to staging (on `develop` branch push) - optional
6. Manual approval or automated
7. Deploy to production (on `main` branch push)

**Simple Deployment Script** (for Hostinger):
```bash
# deploy.sh
cd /path/to/application
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm install
npm run build
php artisan queue:restart
```

**Alternative**: Use Deployer (PHP deployment tool) for zero-downtime deployments

**Deployment Strategy**:
- Git-based deployment (push to deploy)
- Automated via webhook or GitHub Actions
- Database migrations run automatically (with backup first)
- Queue workers restarted if using supervisor
- Cache cleared after deployment

### **10.4 Monitoring & Maintenance**

**Application Monitoring**:
- Sentry for error tracking (free tier: 5K events/month)
- Uptime monitoring: UptimeRobot (free tier: 50 monitors, 5-min intervals)
- Hostinger's built-in monitoring tools

**Server Monitoring** (if using VPS):
- CPU, memory, disk usage via Hostinger control panel
- Set up alerts for high usage
- Monitor MySQL slow queries

**Database**:
- Regular backups via Hostinger's automatic backup (daily)
- Manual backup before major updates
- Monitor database size and optimize quarterly

**Logs**:
- Laravel logs stored locally
- Use Papertrail free tier (50 MB/month, 7-day retention) for centralized logging
- Error log monitoring via Sentry

**Regular Maintenance**:
- Laravel/package updates (monthly security check)
- Security patches (immediate)
- Database optimization (quarterly)
- Backup testing (quarterly)
- Check for broken links (monthly)

---

## 11. Livewire Components Structure

### **11.1 Component Organization**

Components will be organized in `app/Livewire/` with the following structure:

```
app/Livewire/
├── Auth/
│   ├── Login.php
│   ├── Register.php
│   └── SocialLogin.php
├── Scholarships/
│   ├── ScholarshipSearch.php
│   ├── ScholarshipCard.php
│   ├── ScholarshipDetail.php
│   ├── ScholarshipFilters.php
│   ├── SaveScholarshipButton.php
│   └── RelatedScholarships.php
├── Dashboard/
│   ├── SavedScholarships.php
│   ├── ScholarshipStatusUpdate.php
│   ├── RequirementsTracker.php
│   └── DeadlineCalendar.php
├── User/
│   ├── ProfileForm.php
│   ├── PreferencesForm.php
│   └── NotificationSettings.php
├── Blog/
│   ├── BlogList.php
│   ├── BlogPost.php
│   └── RelatedPosts.php
└── Shared/
    ├── SearchBar.php
    ├── Pagination.php
    └── Newsletter.php
```

### **11.2 Key Livewire Components**

#### **ScholarshipSearch Component**
- Real-time search with debounce
- Filter application
- Sorting
- Pagination
- URL query string sync
- Loading states

#### **ScholarshipFilters Component**
- Country multi-select
- Education level checkboxes
- Field of study multi-select
- Scholarship type checkboxes
- Award amount range
- Deadline range
- Clear filters button
- Active filters display

#### **SaveScholarshipButton Component**
- Toggle save/unsaved state
- Optimistic UI updates
- Authentication check
- Toast notifications
- Real-time saved count

#### **RequirementsTracker Component**
- Checklist with real-time updates
- Progress bar
- Mark complete/incomplete
- Add notes per requirement
- Local storage for offline capability

### **11.3 Alpine.js Usage**

Alpine.js will be used for:
- Dropdown menus
- Modals and dialogs
- Tabs and accordions
- Tooltips
- Mobile menu toggle
- Image carousels
- Form field interactions (show/hide password, etc.)
- Smooth scroll animations
- Countdown timers

### **11.4 Performance Optimization**

**Livewire Best Practices**:
- Use `wire:model.lazy` for non-critical inputs
- Implement `wire:model.debounce` for search inputs
- Use `wire:loading` states for better UX
- Lazy load components with `lazy` property
- Use `wire:key` for dynamic lists
- Implement query string for shareable filtered URLs

**Asset Optimization**:
- Vite for asset bundling
- Lazy load images with `loading="lazy"`
- Use WebP images with fallbacks
- Minify CSS and JS in production
- Inline critical CSS

---

## 12. Tailwind CSS v4 Configuration

### **12.1 Setup**

```javascript
// tailwind.config.js
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./app/Livewire/**/*.php",
    "./vendor/filament/**/*.blade.php",
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#eff6ff',
          100: '#dbeafe',
          200: '#bfdbfe',
          300: '#93c5fd',
          400: '#60a5fa',
          500: '#3b82f6',
          600: '#2563eb',
          700: '#1d4ed8',
          800: '#1e40af',
          900: '#1e3a8a',
          950: '#172554',
        },
        success: {
          50: '#f0fdf4',
          100: '#dcfce7',
          200: '#bbf7d0',
          300: '#86efac',
          400: '#4ade80',
          500: '#22c55e',
          600: '#16a34a',
          700: '#15803d',
          800: '#166534',
          900: '#14532d',
          950: '#052e16',
        },
        // Add other custom colors
      },
      fontFamily: {
        sans: ['Inter', 'system-ui', 'sans-serif'],
        heading: ['Poppins', 'Inter', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
```

### **12.2 Custom Utilities**

Create custom utilities in `resources/css/app.css`:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;

@layer components {
  .btn-primary {
    @apply bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors;
  }
  
  .btn-secondary {
    @apply bg-white text-primary-600 border border-primary-600 px-4 py-2 rounded-lg hover:bg-primary-50 transition-colors;
  }
  
  .card {
    @apply bg-white rounded-lg shadow-sm p-6;
  }
  
  .badge {
    @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
  }
  
  .badge-featured {
    @apply badge bg-gradient-to-r from-yellow-400 to-yellow-600 text-white;
  }
  
  .badge-premium {
    @apply badge bg-gradient-to-r from-purple-500 to-purple-700 text-white;
  }
}
```

---

## 13. Hugeicons Integration

### **13.1 Installation**

```bash
npm install @hugeicons/react
# or for Vue
npm install @hugeicons/vue
```

For Blade templates, use the SVG approach:

1. Download icon SVGs from Hugeicons
2. Store in `resources/views/components/icons/`
3. Create Blade components for commonly used icons

### **13.2 Icon Component Example**

```php
// resources/views/components/icon.blade.php
@props(['name', 'class' => 'w-5 h-5'])

@php
$iconPath = resource_path("views/components/icons/{$name}.blade.php");
@endphp

@if(file_exists($iconPath))
    <span {{ $attributes->merge(['class' => $class]) }}>
        @include("components.icons.{$name}")
    </span>
@endif
```

Usage in Blade:
```blade
<x-icon name="bookmark" class="w-6 h-6 text-gray-500" />
```

### **13.3 Commonly Used Icons**

Store these icons in `resources/views/components/icons/`:

- `bookmark.blade.php` - Save scholarship
- `search.blade.php` - Search bar
- `filter.blade.php` - Filter button
- `calendar.blade.php` - Deadlines
- `user.blade.php` - User menu
- `bell.blade.php` - Notifications
- `check-circle.blade.php` - Completed
- `x-circle.blade.php` - Error/Remove
- `arrow-right.blade.php` - Navigation
- `external-link.blade.php` - External links
- `file-02.blade.php` - Documents
- `mail-01.blade.php` - Email

Refer to enum classes for icon names used in requirement types and statuses.

---

## 14. Development Phases & Timeline

### **Phase 1: MVP (8-12 weeks)**

**Weeks 1-2: Setup & Core Models**
- Project setup (Laravel 11, Filament 5, Tailwind v4)
- Database migrations (without enum types)
- Create all Enum classes
- Eloquent models with relationships and casts
- Seeders for initial data (countries, education levels, fields, types)
- Laravel Breeze installation with Livewire
- Social authentication setup (Google, Facebook)

**Weeks 3-4: Admin Panel (Filament 5)**
- Dashboard with basic metrics and charts
- Scholarship CRUD with all relationships
- Countries, levels, fields, types management
- Bulk import/export CSV functionality
- User management
- Filament navigation and permissions

**Weeks 5-7: Public Frontend (Livewire + Alpine.js)**
- Homepage with hero section
- Featured scholarships carousel (Alpine.js)
- Search bar component (Livewire)
- Filter sidebar component (Livewire)
- Search results page with pagination
- Scholarship detail page
- Related scholarships component
- Responsive design (mobile-first)
- Hugeicons integration

**Weeks 8-9: User Dashboard**
- User registration flow with email verification
- Social login (Google/Facebook)
- User dashboard layout
- Saved scholarships list (Livewire component)
- Status update functionality
- Preferences form
- Profile management
- Notification settings

**Weeks 10-11: Notifications & Testing**
- Email templates (Brevo integration)
- Notification system (new matches, deadlines)
- Digest emails (daily/weekly via scheduled jobs)
- Comprehensive testing (Feature tests, Browser tests)
- Bug fixes and optimizations
- Performance testing

**Week 12: Deployment & Launch**
- Hostinger VPS/Business setup
- Cloudflare DNS configuration
- SSL certificate installation
- Production deployment
- Database migration and seeding
- SEO setup (sitemap, meta tags, robots.txt)
- Google Analytics integration
- Backup configuration
- Monitor and fix critical issues

**MVP Features**:
✅ Scholarship search with filters (Livewire + Alpine.js)
✅ User authentication (social login + email)
✅ Save and track scholarships
✅ Email notifications (Brevo)
✅ Admin panel (Filament 5) for management
✅ Responsive design with Tailwind v4
✅ Basic SEO
✅ Hugeicons throughout UI

### **Phase 2: Enhanced Features (6-8 weeks)**

**Weeks 13-14: Sponsorship System**
- Implement tier logic
- Enhanced scholarship cards for Featured/Premium
- Homepage carousel
- Rotation algorithm
- Admin sponsorship management

**Weeks 15-16: Advanced Analytics**
- Detailed scholarship performance
- Click tracking
- CTR calculations
- Revenue dashboard
- Export reports

**Weeks 17-18: Requirements Tracker**
- Scholarship requirements display
- User checklist for saved scholarships
- Completion tracking
- Progress indicators

**Weeks 19-20: Blog & Resources**
- Blog CMS (Filament)
- Blog frontend
- Resources section
- Rich text editor integration
- SEO for blog posts

**Phase 2 Features**:
✅ 3-tier sponsorship system
✅ Advanced analytics and reporting
✅ Requirements tracking
✅ Blog and resources section
✅ Enhanced email notifications (digest)

### **Phase 3: Community & Growth (8-10 weeks)**

**Weeks 21-23: Community Features**
- Reviews and ratings system
- Success stories submission
- Moderation workflow
- Display on scholarship pages

**Weeks 24-26: Internationalization**
- Multi-language support
- Translations for UI
- Language switcher
- Hreflang tags

**Weeks 27-28: Advanced Search & Discovery**
- Related scholarships algorithm
- "Students also viewed" feature
- Recent searches
- Search suggestions
- Advanced filters (range sliders, etc.)

**Weeks 29-30: Performance & Optimization**
- Caching strategy
- Database query optimization
- Image optimization
- Lighthouse score improvements
- Load testing

**Phase 3 Features**:
✅ Reviews and ratings
✅ Success stories
✅ Multi-language support
✅ Advanced search features
✅ Performance optimization

---

## 12. Success Metrics & KPIs

### **12.1 User Metrics**

- **User Registrations**: Target 1,000 users in first 3 months, 10,000 in year 1
- **Active Users**: Monthly active users (MAU) - target 40% of registered users
- **User Retention**: % of users who return within 30 days - target 50%
- **Average Saved Scholarships per User**: Target 5+

### **12.2 Engagement Metrics**

- **Search Queries**: Total searches per month - benchmark and grow
- **Scholarship Views**: Total views per month - target 10,000+ in first 3 months
- **Click-Through Rate (CTR)**: % of views that result in application clicks - target 15%+
- **Time on Site**: Average session duration - target 5+ minutes
- **Pages per Session**: Target 4+ pages

### **12.3 Conversion Metrics**

- **Scholarship Saves**: % of views that result in saves - target 10%+
- **Application Clicks**: Total affiliate clicks per month - target 1,000+ in first 3 months
- **Email Open Rate**: Target 25%+
- **Email Click Rate**: Target 5%+

### **12.4 Revenue Metrics**

- **Sponsorship Revenue**: Monthly recurring revenue from Featured/Premium tiers
  - Target: $5,000/month by month 6, $15,000/month by year 1
- **Affiliate Revenue**: Commission from application clicks
  - Depends on affiliate program, estimate $2-5 per click if monetized
- **Ad Revenue**: Display ads (if implemented)
  - Based on pageviews and CPM rates

### **12.5 SEO Metrics**

- **Organic Traffic**: % of traffic from search engines - target 50%+ by month 6
- **Keyword Rankings**: Number of keywords in top 10 - target 50+ by month 6
- **Backlinks**: Number of referring domains - target 50+ by year 1
- **Domain Authority**: Moz DA score - target 30+ by year 1

### **12.6 Performance Metrics**

- **Page Load Time**: Target < 2 seconds for homepage, < 3 seconds for detail pages
- **Lighthouse Score**: Performance 90+, SEO 100
- **Uptime**: Target 99.9% uptime
- **Error Rate**: < 0.1% of requests

---

## 13. Future Enhancements (Phase 4+)

### **13.1 Mobile App**
- Native iOS and Android apps
- Push notifications
- Offline mode (view saved scholarships)
- Biometric login

### **13.2 AI-Powered Matching**
- Machine learning algorithm for personalized recommendations
- Scholarship eligibility checker (user inputs profile, AI suggests matches)
- Essay review/feedback tool (partnership with AI writing assistant)

### **13.3 Application Management**
- In-platform application builder
- Document storage and management
- Essay drafting and version control
- Application timeline with automated reminders

### **13.4 Scholarship Provider Portal**
- Self-service portal for institutions to add scholarships
- Payment integration for sponsorships (Stripe subscriptions)
- Analytics dashboard for providers
- Applicant management (if moving toward full platform)

### **13.5 Community Enhancements**
- Forums or discussion boards
- Mentorship matching (past scholarship winners mentor applicants)
- Live Q&A with scholarship providers
- Webinars and virtual events

### **13.6 Aggregator Integration**
- API connections to scholarship aggregators
- Automated scraping with manual verification
- AI-based data extraction and categorization
- Duplicate detection

### **13.7 Premium User Features**
- Ad-free experience
- Advanced filters and saved searches
- Priority support
- Application deadline calendar sync
- Application tracking across multiple platforms

---

## 14. Budget Estimation

### **14.1 Development Costs** (Estimates)

**Phase 1 (MVP): $15,000 - $25,000**
- Backend developer: 300-400 hours @ $40-60/hour
- Frontend developer: 200-300 hours @ $35-50/hour
- UI/UX designer: 80-120 hours @ $40-60/hour
- QA/Testing: 80-100 hours @ $30-40/hour

**Phase 2: $10,000 - $15,000**
- Additional features: 200-300 hours @ $40-50/hour

**Phase 3: $12,000 - $18,000**
- Community features and i18n: 250-350 hours @ $40-50/hour

**Total Development: $37,000 - $58,000** for first year

### **14.2 Operational Costs** (Monthly)

**Infrastructure** (Hostinger):
- Business Hosting (initial): $3.99-7.99/month
- OR VPS KVM 2: $11.99/month (recommended for growth)
- Domain: $12/year (~$1/month) - often free first year
- SSL Certificate: Free (Let's Encrypt via Hostinger)
- **Total Hosting: $5-13/month**

**Services**:
- Email (Brevo): Free tier (300 emails/day = 9,000/month)
  - Lite plan if exceeding: $25/month (20,000 emails)
- Image Storage (Cloudinary): Free tier (25 GB storage, 25 GB bandwidth)
- CDN (Cloudflare): Free
- Google Analytics: Free
- Search Console: Free
- Sentry: Free tier (5K events/month)
  - Team plan if needed: $26/month
- UptimeRobot: Free tier (50 monitors)
- Papertrail (logs): Free tier (50 MB/month)
- **Total Services: $0-51/month**

**Total Monthly Operational**: $5-64/month (optimized for startup)

**Scaling Costs** (as you grow):
- Upgrade to VPS KVM 4 (8GB RAM): $23.99/month
- Brevo Lite plan: $25/month (20K emails)
- Meilisearch Cloud: $40+/month (if implementing advanced search)
- Cloudinary Pro: $89/month (if exceeding free tier)

**First Year Total**: 
- Months 1-6: ~$30-384/month (avg $32/month with free tiers)
- Months 7-12: ~$64-150/month (as services scale)
- **Average: $50-100/month operational**
- Plus development costs from 14.1

### **14.3 Revenue Projections** (Conservative)

**Month 3**:
- 10 Featured scholarships @ $75/month = $750
- 2 Premium institutions @ $250/month = $500
- **Total: $1,250/month**

**Month 6**:
- 25 Featured scholarships @ $75/month = $1,875
- 5 Premium institutions @ $250/month = $1,250
- Affiliate revenue: $500/month
- **Total: $3,625/month**

**Month 12**:
- 50 Featured scholarships @ $75/month = $3,750
- 10 Premium institutions @ $250/month = $2,500
- Affiliate revenue: $1,500/month
- Ad revenue: $500/month
- **Total: $8,250/month**

**Break-even**: Expected around month 6-8 with active sales efforts

---

## 15. Risks & Mitigation

### **15.1 Technical Risks**

**Risk: Poor search performance with large dataset**
- Mitigation: Use Meilisearch/Algolia from start, optimize database indexes, implement caching

**Risk: Email deliverability issues**
- Mitigation: Use reputable email service (SendGrid/Mailgun), authenticate domain (SPF, DKIM), monitor sender reputation

**Risk: Security vulnerabilities**
- Mitigation: Regular security audits, keep Laravel and packages updated, implement rate limiting, use HTTPS

### **15.2 Business Risks**

**Risk: Low user adoption**
- Mitigation: Strong SEO strategy, content marketing (blog), partnerships with educational institutions, social media presence (especially Facebook groups and WhatsApp), target African markets specifically

**Risk: Difficulty attracting sponsors**
- Mitigation: Build user base first (free tier), demonstrate value with analytics, offer free trial period for Featured tier, focus on local institutions initially

**Risk: Competition from established platforms**
- Mitigation: Focus on African markets and underserved regions, superior user experience, better filtering, community features, multi-language support

### **15.3 Operational Risks**

**Risk: Data quality (outdated scholarships)**
- Mitigation: Regular audits (monthly), automated deadline checks via scheduled jobs, user reporting system, eventually automate with aggregators

**Risk: Scaling issues**
- Mitigation: Start with Hostinger Business, upgrade to VPS as needed, use Cloudflare caching, optimize database queries, implement Redis caching when on VPS

**Risk: Email deliverability with Brevo free tier**
- Mitigation: Authenticate domain properly (SPF, DKIM, DMARC), monitor bounce rates, implement digest system to reduce email volume, upgrade to paid tier when exceeding 300/day

**Risk: Legal issues (GDPR, copyright)**
- Mitigation: Consult with legal counsel, implement GDPR compliance tools, only link to scholarships (don't copy full content)

---

## 17. Technical Implementation Notes

### **17.1 Enum Class Usage in Models**

**Example Model with Enum Casts**:

```php
<?php

namespace App\Models;

use App\Enums\SponsorshipTier;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $fillable = [
        'title',
        'sponsorship_tier',
        // ... other fields
    ];

    protected $casts = [
        'sponsorship_tier' => SponsorshipTier::class,
        'is_active' => 'boolean',
        'is_rolling' => 'boolean',
        'primary_deadline' => 'date',
        'award_amount' => 'decimal:2',
    ];

    // Usage in code:
    // $scholarship->sponsorship_tier->label() // "Featured"
    // $scholarship->sponsorship_tier->price() // 75.00
    // $scholarship->sponsorship_tier === SponsorshipTier::FEATURED // true
}
```

### **17.2 Filament Resource Enum Integration**

```php
<?php

namespace App\Filament\Resources;

use App\Enums\SponsorshipTier;
use Filament\Forms;
use Filament\Resources\Resource;

class ScholarshipResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('sponsorship_tier')
                ->label('Sponsorship Tier')
                ->options([
                    SponsorshipTier::STANDARD->value => SponsorshipTier::STANDARD->label(),
                    SponsorshipTier::FEATURED->value => SponsorshipTier::FEATURED->label(),
                    SponsorshipTier::PREMIUM->value => SponsorshipTier::PREMIUM->label(),
                ])
                ->default(SponsorshipTier::STANDARD->value)
                ->required(),
        ]);
    }
}
```

### **17.3 Livewire Component with Enums**

```php
<?php

namespace App\Livewire\Dashboard;

use App\Enums\ScholarshipStatus;
use Livewire\Component;

class SavedScholarships extends Component
{
    public $statusFilter = null;

    public function mount()
    {
        // Can use enum values directly
        $this->statusFilter = ScholarshipStatus::SAVED->value;
    }

    public function render()
    {
        $scholarships = auth()->user()
            ->savedScholarships()
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->get();

        return view('livewire.dashboard.saved-scholarships', [
            'scholarships' => $scholarships,
            'statuses' => ScholarshipStatus::cases(), // Pass all enum cases to view
        ]);
    }
}
```

### **17.4 Blade Template with Enums**

```blade
<div>
    <!-- Status Filter -->
    <select wire:model.live="statusFilter">
        <option value="">All Statuses</option>
        @foreach($statuses as $status)
            <option value="{{ $status->value }}">
                {{ $status->label() }}
            </option>
        @endforeach
    </select>

    <!-- Display scholarships with status badges -->
    @foreach($scholarships as $scholarship)
        <div class="card">
            <h3>{{ $scholarship->scholarship->title }}</h3>
            <span class="badge badge-{{ $scholarship->status->color() }}">
                <x-icon :name="$scholarship->status->icon()" class="w-4 h-4" />
                {{ $scholarship->status->label() }}
            </span>
        </div>
    @endforeach
</div>
```

### **17.5 Queue Jobs for Email Notifications**

```php
<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Enums\NotificationFrequency;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendScholarshipDigest implements ShouldQueue
{
    use Queueable;

    public function handle()
    {
        $frequency = NotificationFrequency::DAILY;
        
        Tenant::whereHas('preferences', function ($query) use ($frequency) {
            $query->where('notification_frequency', $frequency->value)
                  ->where('notify_new_scholarships', true);
        })->chunk(100, function ($tenants) {
            foreach ($tenants as $tenant) {
                // Send digest email
            }
        });
    }
}
```

### **17.6 Scheduled Tasks**

```php
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Daily digest at 8 AM
        $schedule->job(new \App\Jobs\SendScholarshipDigest)
            ->dailyAt('08:00');

        // Weekly digest every Monday at 8 AM
        $schedule->job(new \App\Jobs\SendWeeklyDigest)
            ->weeklyOn(1, '08:00');

        // Deadline reminders - check every day
        $schedule->job(new \App\Jobs\SendDeadlineReminders)
            ->dailyAt('09:00');

        // Expire sponsorships
        $schedule->command('scholarships:expire-sponsorships')
            ->daily();

        // Generate sitemap
        $schedule->command('sitemap:generate')
            ->daily();
    }
}
```

---

## 18. Conclusion & Next Steps

This document outlines a comprehensive plan for building **Scholarpeep**, a scholarship discovery and management platform using **Laravel 11**, **Livewire 3**, **Alpine.js**, **Filament 5**, **Tailwind CSS v4**, and **Hugeicons**, hosted on **Hostinger**.

### **Key Technical Decisions**:
- ✅ **Frontend**: Blade + Livewire 3 + Alpine.js (no separate SPA)
- ✅ **Admin Panel**: Filament 5 with full CRUD and analytics
- ✅ **Styling**: Tailwind CSS v4 with custom components
- ✅ **Icons**: Hugeicons for consistent UI
- ✅ **Hosting**: Hostinger (Business or VPS)
- ✅ **Email**: Brevo free tier (scalable)
- ✅ **Storage**: Cloudinary free tier for images
- ✅ **CDN**: Cloudflare free tier
- ✅ **Database**: MySQL 8.0+ with string columns for enums
- ✅ **Enums**: PHP Enum classes (no database enums)

### **Project Phases**:

1. **Phase 1 (MVP - 12 weeks)**: Core search, user dashboard, admin panel, notifications
2. **Phase 2 (6-8 weeks)**: Sponsorship system, advanced analytics, blog, requirements tracker
3. **Phase 3 (8-10 weeks)**: Community features, internationalization, performance optimization

### **Budget Overview**:
- **Development**: $37,000 - $58,000 (first year)
- **Monthly Operational**: $5-64/month initially, $50-150/month at scale
- **Break-even Target**: Month 6-8
- **Revenue Target**: $8,250/month by month 12

### **Recommended Next Steps**:

1. ✅ **Review & Approve**: Review this document, make final adjustments
2. ✅ **Assemble Team**: Hire or contract Laravel developer (Livewire experience preferred)
3. ✅ **Project Setup**: 
   - Initialize Laravel 11 project
   - Install Filament 5
   - Install Livewire 3
   - Configure Tailwind v4
   - Set up Git repository
4. ✅ **Infrastructure Setup**:
   - Purchase Hostinger plan + domain
   - Set up Cloudflare account
   - Create Brevo account and configure
   - Set up Cloudinary account
5. ✅ **Create Enum Classes**: Implement all 6 enum classes first
6. ✅ **Database Setup**: Run migrations (no enum types), seed initial data
7. ✅ **Design Phase**: Create wireframes and mockups for key pages
8. ✅ **Sprint Planning**: Break down Phase 1 into 2-week sprints
9. ✅ **Development Kickoff**: Begin Week 1 tasks
10. ✅ **Weekly Reviews**: Progress reviews, adjust timeline as needed

### **Critical Success Factors**:
- Strong SEO from day one (meta tags, sitemap, schema.org)
- Focus on African markets and underserved regions
- Build user base before aggressive sponsorship sales
- Excellent user experience (fast, mobile-friendly, intuitive)
- Regular content updates (blog, resources)
- Active social media presence (Facebook, WhatsApp groups)
- Email list building from launch

### **Questions or Clarifications**:

If you need any clarification on:
- Specific Livewire component implementation
- Filament 5 customization
- Tailwind v4 configuration
- Hostinger deployment process
- Enum class patterns
- Or any other technical details

Please let me know. This document serves as the blueprint for development and can be shared directly with your development team.

**Ready to start building Scholarpeep with Laravel + Livewire + Filament!** 🎓🚀

---

## Appendix A: Quick Reference

### **Tech Stack Summary**
| Component | Technology |
|-----------|-----------|
| Backend Framework | Laravel 11.x |
| Frontend | Blade + Livewire 3 + Alpine.js |
| Admin Panel | Filament 5.x |
| Styling | Tailwind CSS v4 |
| Icons | Hugeicons |
| Database | MySQL 8.0+ |
| Hosting | Hostinger (Business/VPS) |
| Email | Brevo (free tier) |
| Storage | Cloudinary (free tier) |
| CDN | Cloudflare (free tier) |
| Search | Scout + Database (basic) |
| Queue | Database/Redis |

### **Enum Classes**
1. `DeadlineType` - Scholarship deadline types
2. `RequirementType` - Application requirement types
3. `ScholarshipStatus` - Saved scholarship statuses
4. `SponsorshipTier` - Sponsorship levels
5. `NotificationFrequency` - Email frequency options
6. `ResourceType` - Resource categories

### **Key URLs**
- Homepage: `/`
- Search: `/scholarships`
- Detail: `/scholarships/{slug}`
- Dashboard: `/dashboard`
- Blog: `/blog`
- Resources: `/resources`
- Admin: `/admin` (Filament)

### **Important Commands**
```bash
# Development
php artisan serve
npm run dev

# Testing
php artisan test

# Deployment
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build

# Scheduled tasks (add to cron)
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```