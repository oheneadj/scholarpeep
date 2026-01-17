# Design System - Scholarpeep

## Design Principles

1. **Clean & Minimal** - Focus on content, avoid visual clutter
2. **Trust & Professionalism** - Use blue as primary color for credibility
3. **Motivational** - Bright accents for positive reinforcement
4. **Accessible** - WCAG 2.1 AA compliance minimum (4.5:1 contrast ratio)
5. **Mobile-First** - Optimize for mobile before desktop

---

## Color Palette

### Primary Colors
Used for main actions, links, and brand identity.

```css
/* Deep Blue - Main brand color */
--color-primary-50: #eff6ff
--color-primary-100: #dbeafe
--color-primary-200: #bfdbfe
--color-primary-300: #93c5fd
--color-primary-400: #60a5fa
--color-primary-500: #3b82f6  /* Base primary */
--color-primary-600: #2563eb  /* Buttons, headers */
--color-primary-700: #1d4ed8  /* Hover states */
--color-primary-800: #1e40af
--color-primary-900: #1e3a8a
--color-primary-950: #172554
```

**Tailwind Classes:** `bg-primary-600`, `text-primary-700`, `border-primary-500`

**Usage:**
- Primary buttons: `bg-primary-600 hover:bg-primary-700`
- Links: `text-primary-600 hover:text-primary-700`
- Active nav items: `bg-primary-50 text-primary-700`
- Focus rings: `ring-primary-500`

### Secondary Colors

```css
/* Success Green - Positive actions */
--color-success-500: #22c55e
--color-success-600: #16a34a  /* Default */
--color-success-700: #15803d  /* Hover */

/* Warning Orange - Deadlines, urgency */
--color-warning-500: #f59e0b
--color-warning-600: #d97706  /* Default */
--color-warning-700: #b45309  /* Hover */

/* Purple - Premium tier */
--color-purple-500: #a855f7
--color-purple-600: #9333ea  /* Default */
--color-purple-700: #7e22ce  /* Hover */

/* Gold/Yellow - Featured tier */
--color-gold-400: #fbbf24
--color-gold-500: #f59e0b  /* Default */
--color-gold-600: #d97706  /* Hover */
```

**Usage:**
- Success: Save buttons (`bg-success-600`), success messages, checkmarks
- Warning: Deadline badges (`bg-warning-500`), urgent notifications
- Purple: Premium sponsorship badges (`bg-purple-600`)
- Gold: Featured scholarship badges (`bg-gold-500`)

### Neutral Colors

```css
/* Grays - Text and backgrounds */
--color-gray-50: #f9fafb   /* Lightest background */
--color-gray-100: #f3f4f6  /* Card backgrounds */
--color-gray-200: #e5e7eb  /* Borders */
--color-gray-300: #d1d5db  /* Disabled states */
--color-gray-400: #9ca3af  /* Placeholders */
--color-gray-500: #6b7280  /* Secondary text */
--color-gray-600: #4b5563  /* Body text */
--color-gray-700: #374151  /* Headings */
--color-gray-800: #1f2937  /* Dark headings */
--color-gray-900: #111827  /* Darkest text */
--color-white: #ffffff     /* Main background */
```

**Usage:**
- Main background: `bg-white`
- Card backgrounds: `bg-gray-50` or `bg-gray-100`
- Borders: `border-gray-200`
- Body text: `text-gray-600`
- Headings: `text-gray-800` or `text-gray-900`
- Secondary text: `text-gray-500`

### Semantic Colors

```css
/* Error Red */
--color-error-500: #ef4444
--color-error-600: #dc2626
--color-error-700: #b91c1c

/* Info Blue */
--color-info-500: #3b82f6
--color-info-600: #2563eb
--color-info-700: #1d4ed8
```

**Usage:**
- Error: Form validation errors, delete confirmations
- Info: Informational notices, tooltips

---

## Typography

### Font Families

**Primary (UI):**
```css
font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', sans-serif;
```

**Headings (Optional differentiation):**
```css
font-family: 'Poppins', 'Inter', system-ui, sans-serif;
```

**Monospace (Code/Numbers):**
```css
font-family: 'JetBrains Mono', 'Courier New', monospace;
```

### Font Scale

```css
/* Tailwind Text Sizes */
text-xs: 0.75rem (12px)    /* Captions, badges */
text-sm: 0.875rem (14px)   /* Small text, metadata */
text-base: 1rem (16px)     /* Body text */
text-lg: 1.125rem (18px)   /* Large body */
text-xl: 1.25rem (20px)    /* Small headings */
text-2xl: 1.5rem (24px)    /* H3, card titles */
text-3xl: 1.875rem (30px)  /* H2 */
text-4xl: 2.25rem (36px)   /* H1, page titles */
text-5xl: 3rem (48px)      /* Hero headings */
```

### Font Weights

```css
font-light: 300      /* Rarely used */
font-normal: 400     /* Body text */
font-medium: 500     /* Emphasis, buttons */
font-semibold: 600   /* Subheadings, labels */
font-bold: 700       /* Headings, important text */
font-extrabold: 800  /* Hero text (rarely) */
```

### Line Heights

```css
leading-tight: 1.25    /* Headings */
leading-snug: 1.375    /* Subheadings */
leading-normal: 1.5    /* Body text */
leading-relaxed: 1.625 /* Long-form content */
leading-loose: 2       /* Rarely used */
```

### Typography Rules

**Headings:**
```html
<h1 class="text-4xl font-bold text-gray-900 leading-tight">
<h2 class="text-3xl font-bold text-gray-800 leading-tight">
<h3 class="text-2xl font-semibold text-gray-800 leading-snug">
<h4 class="text-xl font-semibold text-gray-700 leading-snug">
```

**Body Text:**
```html
<p class="text-base text-gray-600 leading-normal">
<p class="text-sm text-gray-500 leading-normal"> <!-- Secondary -->
```

**Links:**
```html
<a class="text-primary-600 hover:text-primary-700 underline">
```

**Labels:**
```html
<label class="text-sm font-medium text-gray-700">
```

---

## Spacing System

Use Tailwind's default spacing scale (4px base unit):

```css
/* Padding/Margin Scale */
p-0: 0px
p-1: 0.25rem (4px)
p-2: 0.5rem (8px)
p-3: 0.75rem (12px)
p-4: 1rem (16px)      /* Most common */
p-6: 1.5rem (24px)    /* Card padding */
p-8: 2rem (32px)      /* Section padding */
p-12: 3rem (48px)     /* Large sections */
p-16: 4rem (64px)     /* Hero sections */
```

### Spacing Guidelines

**Card Padding:** `p-6` (24px)
**Button Padding:** `px-4 py-2` (16px horizontal, 8px vertical)
**Section Spacing:** `py-12` or `py-16` (48-64px vertical)
**Element Spacing:** `space-y-4` or `gap-4` (16px between elements)
**Page Margins:** `mx-auto max-w-7xl px-4 sm:px-6 lg:px-8`

---

## Component Styles

### Buttons

**Primary Button:**
```html
<button class="bg-primary-600 text-white px-4 py-2 rounded-full font-medium hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
  Button Text
</button>
```

**Secondary Button:**
```html
<button class="bg-white text-primary-600 border border-primary-600 px-4 py-2 rounded-full font-medium hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors">
  Button Text
</button>
```

**Success Button:**
```html
<button class="bg-success-600 text-white px-4 py-2 rounded-full font-medium hover:bg-success-700 focus:outline-none focus:ring-2 focus:ring-success-500 focus:ring-offset-2 transition-colors">
  Save
</button>
```

**Outline Button:**
```html
<button class="bg-transparent text-gray-700 border border-gray-300 px-4 py-2 rounded-full font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-colors">
  Cancel
</button>
```

**Button Sizes:**
- Small: `px-3 py-1.5 text-sm`
- Medium (default): `px-4 py-2 text-base`
- Large: `px-6 py-3 text-lg`

**Icon Buttons:**
```html
<button class="p-2 text-gray-500 hover:text-gray-700 rounded-full hover:bg-gray-100 transition-colors">
  <x-icon name="bookmark" class="w-5 h-5" />
</button>
```

### Cards

**Standard Card:**
```html
<div class="bg-white rounded-lg shadow-200/50 p-6 hover:shadow-md transition-shadow">
  <!-- Card content -->
</div>
```

**Featured Card (Gold Border):**
```html
<div class="bg-white rounded-lg shadow-md p-6 border-2 border-gold-400 ring-2 ring-gold-200/50 hover:shadow-lg transition-all">
  <!-- Featured content -->
</div>
```

**Premium Card (Purple Gradient):**
```html
<div class="bg-white rounded-lg shadow-lg p-6 border-2 border-transparent bg-gradient-to-r from-purple-500 to-purple-700 bg-clip-border hover:shadow-xl transition-all">
  <div class="bg-white rounded-md p-6">
    <!-- Premium content -->
  </div>
</div>
```

**Card with Image:**
```html
<div class="bg-white rounded-lg shadow-200/50 overflow-hidden hover:shadow-md transition-shadow">
  <img src="..." alt="..." class="w-full h-48 object-cover">
  <div class="p-6">
    <!-- Card content -->
  </div>
</div>
```

### Badges

**Standard Badge:**
```html
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
  Badge Text
</span>
```

**Status Badges:**
```html
<!-- Saved -->
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
  <x-icon name="bookmark" class="w-3 h-3 mr-1" />
  Saved
</span>

<!-- Applied -->
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
  <x-icon name="sent-01" class="w-3 h-3 mr-1" />
  Applied
</span>

<!-- Accepted -->
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
  <x-icon name="checkbox-check" class="w-3 h-3 mr-1" />
  Accepted
</span>
```

**Featured Badge (Gold Gradient):**
```html
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-gold-400 to-gold-600 text-white shadow-sm">
  ⭐ Featured
</span>
```

**Premium Badge (Purple Gradient):**
```html
<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-purple-500 to-purple-700 text-white shadow-md">
  👑 Premium Sponsored
</span>
```

### Forms

**Input Field:**
```html
<div class="space-y-1">
  <label for="email" class="block text-sm font-medium text-gray-700">
    Email
  </label>
  <input type="email" id="email" name="email" 
    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
    placeholder="you@example.com">
  <p class="text-xs text-gray-500">We'll never share your email.</p>
</div>
```

**Input with Error:**
```html
<div class="space-y-1">
  <label for="email" class="block text-sm font-medium text-gray-700">
    Email
  </label>
  <input type="email" id="email" name="email" 
    class="w-full px-3 py-2 border border-error-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-error-500 focus:border-transparent"
    placeholder="you@example.com">
  <p class="text-xs text-error-600">Please enter a valid email address.</p>
</div>
```

**Select Dropdown:**
```html
<div class="space-y-1">
  <label for="country" class="block text-sm font-medium text-gray-700">
    Country
  </label>
  <select id="country" name="country" 
    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
    <option>United States</option>
    <option>United Kingdom</option>
  </select>
</div>
```

**Checkbox:**
```html
<div class="flex items-center">
  <input type="checkbox" id="remember" name="remember" 
    class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
  <label for="remember" class="ml-2 text-sm text-gray-700">
    Remember me
  </label>
</div>
```

**Radio Buttons:**
```html
<div class="space-y-2">
  <div class="flex items-center">
    <input type="radio" id="instant" name="frequency" value="instant" 
      class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500">
    <label for="instant" class="ml-2 text-sm text-gray-700">
      Instant notifications
    </label>
  </div>
  <div class="flex items-center">
    <input type="radio" id="daily" name="frequency" value="daily" 
      class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500">
    <label for="daily" class="ml-2 text-sm text-gray-700">
      Daily digest
    </label>
  </div>
</div>
```

### Alerts & Notifications

**Success Alert:**
```html
<div class="bg-success-50 border border-success-200 text-success-800 px-4 py-3 rounded-lg flex items-start">
  <x-icon name="checkbox-check" class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5" />
  <div>
    <p class="font-medium">Success!</p>
    <p class="text-sm">Your scholarship has been saved.</p>
  </div>
</div>
```

**Error Alert:**
```html
<div class="bg-error-50 border border-error-200 text-error-800 px-4 py-3 rounded-lg flex items-start">
  <x-icon name="alert-circle" class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5" />
  <div>
    <p class="font-medium">Error</p>
    <p class="text-sm">Something went wrong. Please try again.</p>
  </div>
</div>
```

**Warning Alert:**
```html
<div class="bg-warning-50 border border-warning-200 text-warning-800 px-4 py-3 rounded-lg flex items-start">
  <x-icon name="alert-triangle" class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5" />
  <div>
    <p class="font-medium">Warning</p>
    <p class="text-sm">Deadline is in 3 days!</p>
  </div>
</div>
```

### Loading States

**Spinner:**
```html
<div class="flex items-center justify-center">
  <svg class="animate-spin h-8 w-8 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
  </svg>
</div>
```

**Skeleton Loader:**
```html
<div class="animate-pulse">
  <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
  <div class="h-4 bg-gray-200 rounded w-1/2 mb-2"></div>
  <div class="h-4 bg-gray-200 rounded w-5/6"></div>
</div>
```

---

## Layout Patterns

### Container
```html
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Content -->
</div>
```

**Container Sizes:**
- `max-w-7xl` - Default (1280px)
- `max-w-5xl` - Narrow content (1024px)
- `max-w-3xl` - Articles (768px)
- `max-w-screen-2xl` - Wide (1536px)

### Grid Layouts

**2-Column Grid:**
```html
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <!-- Items -->
</div>
```

**3-Column Grid:**
```html
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
  <!-- Items -->
</div>
```

**Sidebar Layout:**
```html
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
  <aside class="lg:col-span-1"><!-- Sidebar --></aside>
  <main class="lg:col-span-3"><!-- Main content --></main>
</div>
```

---

## Responsive Design

### Breakpoints

```css
/* Tailwind Default Breakpoints */
sm: 640px   /* Tablet portrait */
md: 768px   /* Tablet landscape */
lg: 1024px  /* Desktop */
xl: 1280px  /* Large desktop */
2xl: 1536px /* Extra large */
```

### Mobile-First Approach

```html
<!-- Mobile: Single column, Desktop: Two columns -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

<!-- Mobile: Small text, Desktop: Large text -->
<h1 class="text-2xl lg:text-4xl">

<!-- Mobile: Full width button, Desktop: Auto width -->
<button class="w-full md:w-auto">
```

### Touch Targets
**Minimum touch target size: 44x44px (11rem)**

```html
<!-- Good: Large enough for touch -->
<button class="p-3 min-h-[44px] min-w-[44px]">

<!-- Bad: Too small for touch -->
<button class="p-1">
```

---

## Accessibility Guidelines

### Color Contrast
- **Normal text:** 4.5:1 minimum
- **Large text (18px+):** 3:1 minimum
- **Interactive elements:** 3:1 against background

### Focus States
All interactive elements MUST have visible focus indicators:

```html
<button class="focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
```

### ARIA Labels
Use ARIA attributes for screen readers:

```html
<button aria-label="Save scholarship">
  <x-icon name="bookmark" class="w-5 h-5" />
</button>

<nav aria-label="Primary navigation">
  <!-- Nav items -->
</nav>
```

### Alt Text
All images MUST have descriptive alt text:

```html
<img src="logo.png" alt="Scholarpeep - Scholarship Discovery Platform">
```

---

## Icons (Hugeicons)

### Icon Sizes

```html
<!-- Small (16px) -->
<x-icon name="bookmark" class="w-4 h-4" />

<!-- Medium (20px) - Default -->
<x-icon name="bookmark" class="w-5 h-5" />

<!-- Large (24px) -->
<x-icon name="bookmark" class="w-6 h-6" />

<!-- Extra Large (32px) -->
<x-icon name="bookmark" class="w-8 h-8" />
```

### Commonly Used Icons

**Actions:**
- `bookmark` - Save/Unsave
- `search` - Search functionality
- `filter` - Filter panel
- `x` - Close/Remove
- `check` - Confirm/Complete

**Status:**
- `checkbox-check` - Completed/Accepted
- `time-02` - Pending
- `cancel-01` - Rejected
- `sent-01` - Applied

**Navigation:**
- `arrow-right` - Forward navigation
- `arrow-left` - Back navigation
- `chevron-down` - Dropdown indicator
- `menu` - Mobile menu

**Content:**
- `calendar` - Deadlines
- `mail-01` - Email
- `file-02` - Documents
- `link-external` - External links

---

## Animation & Transitions

### Duration
```css
transition-none: 0ms
transition-all: 150ms (default)
transition-colors: 150ms
transition-transform: 150ms
transition-opacity: 150ms
```

### Easing
```css
ease-linear
ease-in
ease-out
ease-in-out (default)
```

### Common Patterns

**Hover Effects:**
```html
<div class="hover:shadow-lg transition-shadow duration-200">
<button class="hover:bg-primary-700 transition-colors duration-150">
```

**Scale on Hover:**
```html
<div class="hover:scale-105 transition-transform duration-200">
```

**Fade In:**
```html
<div class="opacity-0 animate-fade-in">
```

---

## Design Don'ts

❌ **Never use plain CSS files** - Use Tailwind classes only
❌ **Never use inline styles** - Use utility classes
❌ **Never use more than 3 font families** - Stick to system
❌ **Never use custom shadows** - Use Tailwind defaults
❌ **Never use arbitrary values excessively** - Use design tokens
❌ **Never break accessibility** - Always include focus states and ARIA
❌ **Never ignore mobile** - Design mobile-first always
❌ **Never use emojis in production UI** - Use icons instead (badges are exception)

---

*This design system ensures visual consistency across the Scholarpeep platform. All components should follow these patterns unless there's a compelling reason to deviate, which should be documented.*