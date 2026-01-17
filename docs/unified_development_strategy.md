# Scholarpeep: Unified Development Strategy

This document synthesizes the project requirements from `docs/scholarpeep_requirements.md` with the existing implementation to create a high-performance, premium scholarship platform.

## 1. Core Architecture Reconcilliation

### 1.1 Model & Database Alignment
We will adopt the comprehensive schema from the requirements doc while preserving our enhanced data types (e.g., `decimal:2` for awards).

| Feature | Action | Strategy |
|---------|--------|----------|
| **User Model** | [MODIFY] | Add `google_id`, `facebook_id`, and `avatar` for Socialite support. |
| **Analytics** | [NEW] | Implement `scholarship_views` and `affiliate_clicks` tables for session-aware tracking. |
| **Blog & Content** | [NEW] | Create `blog_posts`, `resources`, `reviews`, and `success_stories` tables. |
| **Enums** | [KEEP OLD] | Stick to our `ScholarshipStatus` (Lifecycle) and `ApplicationStatus` (User-tracked) naming to avoid collisions. |

### 1.2 UX & Component Strategy
We will transition toward the modular component structure recommended in the requirements to improve maintainability.

- **Unified ScholarshipCard**: [DONE] Already centralized for Grid/List views.
- **ScholarshipFilters**: [TODO] Extract filters from `ScholarshipIndex` into a dedicated Livewire component.
- **Unified Search**: Integrate Meilisearch (Phase 2) but enhance current SQL search with typo-tolerance logic in the interim.

## 2. Immediate Implementation Roadmap (Phase 1.5)

### Task 1: User Identity Enhancements
- Add social auth fields to `users` table.
- Update `User` model with these fields and casts.

### Task 2: Granular Analytics Layer
- Create migrations for `scholarship_views` and `affiliate_clicks`.
- Implement background jobs/middleware to track these without blocking the main thread.

### Task 3: Content Foundation
- Implement the `blog_posts` and `resources` models/migrations.
- Basic Filament resources for these new models.

### Task 4: Advanced Discovery Logic
- Implement "Recently Viewed" scholarships (stored in session).
- Refine the "Students also viewed" recommendation logic based on Country/Level.

## 3. Design System Adherence
- **Tailwind v4**: Continue using the CSS-variable-first approach.
- **Hugeicons**: Ensure all icons used are from the Hugeicons set for visual consistency.
- **Deep Blue Theme**: Maintain the `#1e3a8a` primary palette and high border-radii.

## 4. Verification Plan
- Cross-reference every migration with the requirements doc.
- Performance audit for the new analytics tracking.
- Social Auth flow testing (Mocked/Local).
