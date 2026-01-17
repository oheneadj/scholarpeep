# Coding Rules & Standards - Scholarpeep

**Purpose:** This document defines the coding standards, conventions, and best practices for the Scholarpeep project. All code must adhere to these rules.

---

## General Principles

1. **Code for Humans** - Write code that is easy to read and understand
2. **Follow Conventions** - Consistency is more important than personal preference
3. **Be Explicit** - Avoid magic and implicit behavior when possible
4. **Fail Fast** - Detect and report errors early
5. **Don't Repeat Yourself (DRY)** - Extract common logic into reusable functions
6. **Keep It Simple (KISS)** - Simple solutions are easier to maintain
7. **Test Everything** - Write tests for all new features and bug fixes

---

## PHP / Laravel Standards

### PSR Compliance
- **Follow PSR-12** for code style (enforced by Laravel Pint)
- **Follow PSR-4** for autoloading
- Run `./vendor/bin/pint` before every commit

### Naming Conventions

#### Classes
```php
// Models: PascalCase, singular
class Scholarship extends Model {}
class Tenant extends Model {}

// Controllers: PascalCase with suffix
class ScholarshipController extends Controller {}

// Livewire Components: PascalCase
class SavedScholarships extends Component {}

// Jobs: PascalCase, descriptive verb
class SendDeadlineReminder implements ShouldQueue {}

// Enums: PascalCase
enum SponsorshipTier: string {}
```

#### Methods and Functions
```php
// camelCase for methods
public function getActiveScholarships() {}
public function saveScholarship(Scholarship $scholarship) {}

// Boolean methods start with "is", "has", "can", "should"
public function isActive(): bool {}
public function hasDeadline(): bool {}
public function canApply(): bool {}

// Query scopes: camelCase with "scope" prefix
public function scopeActive($query) {}
public function scopeFeatured($query) {}
```

#### Variables
```php
// camelCase for variables
$scholarshipId = 1;
$savedScholarships = [];
$isActive = true;

// Descriptive names, avoid abbreviations
// Good
$scholarshipDeadline = '2024-12-31';

// Bad
$schDl = '2024-12-31';
$sd = '2024-12-31';
```

#### Constants
```php
// SCREAMING_SNAKE_CASE
const MAX_UPLOAD_SIZE = 5242880; // 5MB
const DEFAULT_DEADLINE_REMINDER_DAYS = 7;
```

### Type Hints & Return Types

**Always use type hints** on parameters and return types:

```php
// Good ✅
public function findScholarship(int $id): ?Scholarship
{
    return Scholarship::find($id);
}

public function getActiveScholarships(): Collection
{
    return Scholarship::where('is_active', true)->get();
}

// Bad ❌
public function findScholarship($id)
{
    return Scholarship::find($id);
}
```

**Nullable types:**
```php
// Use nullable return types when appropriate
public function getScholarshipDeadline(): ?Carbon
{
    return $this->primary_deadline;
}

// Use nullable parameters with default
public function filterByCountry(?int $countryId = null): Builder
{
    // ...
}
```

### Early Returns

**Prefer early returns** over nested conditionals:

```php
// Good ✅
public function saveScholarship(Scholarship $scholarship): bool
{
    if (!auth()->check()) {
        return false;
    }

    if ($scholarship->exists) {
        return false;
    }

    auth()->user()->savedScholarships()->create([
        'scholarship_id' => $scholarship->id,
        'status' => ScholarshipStatus::SAVED,
    ]);

    return true;
}

// Bad ❌
public function saveScholarship(Scholarship $scholarship): bool
{
    if (auth()->check()) {
        if (!$scholarship->exists) {
            auth()->user()->savedScholarships()->create([
                'scholarship_id' => $scholarship->id,
                'status' => ScholarshipStatus::SAVED,
            ]);
            return true;
        }
    }
    return false;
}
```

### Eloquent Best Practices

#### Always Use Eloquent Relationships
```php
// Good ✅
$scholarship->countries;
$scholarship->deadlines;
$user->savedScholarships;

// Bad ❌
DB::table('countries')
    ->join('scholarship_country', 'countries.id', '=', 'scholarship_country.country_id')
    ->where('scholarship_country.scholarship_id', $scholarshipId)
    ->get();
```

#### Eager Load to Prevent N+1
```php
// Good ✅
$scholarships = Scholarship::with(['countries', 'educationLevels', 'deadlines'])
    ->paginate(20);

// Bad ❌
$scholarships = Scholarship::paginate(20);
// Then accessing $scholarship->countries in loop (N+1 query)
```

#### Use Query Scopes
```php
// Define in model
public function scopeActive($query)
{
    return $query->where('is_active', true);
}

public function scopeFeatured($query)
{
    return $query->where('sponsorship_tier', SponsorshipTier::FEATURED);
}

// Use in queries
Scholarship::active()->featured()->get();
```

#### Use Enum Casts
```php
// In model
protected $casts = [
    'sponsorship_tier' => SponsorshipTier::class,
    'status' => ScholarshipStatus::class,
];

// Usage
$scholarship->sponsorship_tier = SponsorshipTier::PREMIUM;
$scholarship->sponsorship_tier->label(); // "Premium Sponsored"
$scholarship->sponsorship_tier->price(); // 250.00
```

### Error Handling

#### Wrap External API Calls in Try-Catch
```php
// Good ✅
try {
    $response = Http::post('https://api.brevo.com/v3/smtp/email', [
        'to' => [['email' => $user->email]],
        'subject' => 'Welcome to Scholarpeep',
    ]);

    if (!$response->successful()) {
        Log::error('Brevo API error', ['response' => $response->json()]);
        return false;
    }

    return true;
} catch (\Exception $e) {
    Log::error('Failed to send email', ['error' => $e->getMessage()]);
    return false;
}

// Bad ❌
$response = Http::post('https://api.brevo.com/v3/smtp/email', [
    'to' => [['email' => $user->email]],
    'subject' => 'Welcome to Scholarpeep',
]);
```

#### Validate All User Input
```php
// Controller
public function store(Request $request)
{
    $validated = $request->validate([
        'scholarship_id' => 'required|exists:scholarships,id',
        'notes' => 'nullable|string|max:1000',
    ]);

    // Use $validated, never $request->all()
    auth()->user()->savedScholarships()->create($validated);
}
```

### Avoid Using
- ❌ `DB::raw()` unless absolutely necessary
- ❌ `$request->all()` - use validated data
- ❌ Global variables
- ❌ `extract()` function
- ❌ `eval()` function
- ❌ Short PHP tags (`<?`)

---

## Livewire Standards

### Component Structure
```php
<?php

namespace App\Livewire\Scholarships;

use Livewire\Component;
use Livewire\WithPagination;

class ScholarshipSearch extends Component
{
    use WithPagination;

    // Public properties (wire-able)
    public string $search = '';
    public array $filters = [];

    // Protected properties (internal state)
    protected $queryString = ['search', 'filters'];

    // Computed properties
    public function getResultsProperty()
    {
        return Scholarship::search($this->search)
            ->filter($this->filters)
            ->paginate(20);
    }

    // Actions
    public function resetFilters()
    {
        $this->filters = [];
        $this->resetPage();
    }

    // Render
    public function render()
    {
        return view('livewire.scholarships.scholarship-search', [
            'results' => $this->results,
        ]);
    }
}
```

### Property Rules
- **Public properties:** Synced with frontend, must be wire-able types (string, int, bool, array)
- **Protected properties:** Internal state only
- **Computed properties:** Use `getPropertyNameProperty()` method

### Wire Model Best Practices
```blade
<!-- Use debounce for search inputs -->
<input wire:model.debounce.300ms="search" />

<!-- Use lazy for non-critical inputs -->
<input wire:model.lazy="notes" />

<!-- Use live for real-time updates -->
<input wire:model.live="activeTab" />
```

### Loading States
```blade
<!-- Show spinner while loading -->
<div wire:loading class="spinner">Loading...</div>

<!-- Disable button while action is running -->
<button wire:click="save" wire:loading.attr="disabled">
    Save
</button>

<!-- Target specific actions -->
<div wire:loading.delay wire:target="search">
    Searching...
</div>
```

### Performance
- Use `wire:key` for dynamic lists to prevent re-rendering issues
- Avoid passing large objects to Livewire components
- Use `lazy` property for components that don't need immediate load
- Chunk large datasets with `chunk()` method

---

## Blade Templates

### File Naming
```
resources/views/
├── scholarships/
│   ├── index.blade.php
│   ├── show.blade.php
│   └── _card.blade.php (partials use underscore)
├── components/
│   ├── button.blade.php
│   ├── card.blade.php
│   └── icons/
│       ├── bookmark.blade.php
│       └── search.blade.php
└── livewire/
    └── scholarships/
        └── scholarship-search.blade.php
```

### Component Usage
```blade
<!-- Blade Components -->
<x-button color="primary">Click Me</x-button>
<x-card title="Scholarship Title">
    Content here
</x-card>

<!-- Livewire Components -->
<livewire:scholarships.scholarship-search />
@livewire('scholarships.scholarship-search')
```

### Escaping Output
```blade
<!-- Escape by default (prevents XSS) -->
{{ $scholarship->title }}

<!-- Only use raw when you're CERTAIN it's safe -->
{!! $scholarship->formatted_description !!}

<!-- NEVER do this with user input -->
{!! $user->bio !!} <!-- ❌ XSS vulnerability -->
```

### Control Structures
```blade
<!-- Use Blade directives, not PHP tags -->

<!-- Good ✅ -->
@if($scholarship->isActive())
    <span class="badge">Active</span>
@endif

@foreach($scholarships as $scholarship)
    <x-scholarship-card :scholarship="$scholarship" />
@endforeach

@unless(auth()->check())
    <a href="/login">Login</a>
@endunless

<!-- Bad ❌ -->
<?php if($scholarship->isActive()): ?>
    <span class="badge">Active</span>
<?php endif; ?>
```

### Authorization
```blade
<!-- Check permissions in views -->
@can('update', $scholarship)
    <button>Edit</button>
@endcan

@auth
    <a href="/dashboard">Dashboard</a>
@endauth

@guest
    <a href="/login">Login</a>
@endguest
```

---

## Tailwind CSS Standards

### NO Plain CSS Files
- ❌ **Never create custom CSS files** (e.g., `custom.css`)
- ✅ **Always use Tailwind utility classes**
- ✅ **Use `@layer components` in `app.css` for reusable patterns only**

### Class Organization
**Order classes** by function for readability:

```html
<!-- Layout → Sizing → Spacing → Typography → Colors → Effects → States -->
<div class="
    flex items-center justify-between
    w-full h-16
    px-4 py-2
    text-base font-medium
    bg-white text-gray-900
    rounded-lg shadow-sm
    hover:bg-gray-50 hover:shadow-md
    transition-all
">
```

### Responsive Design
**Mobile-first approach:**

```html
<!-- Base (mobile) → sm → md → lg → xl -->
<div class="
    text-sm
    md:text-base
    lg:text-lg
    px-2
    md:px-4
    lg:px-6
">
```

### Component Extraction
**Extract repeated patterns to Blade components:**

```blade
<!-- resources/views/components/button.blade.php -->
@props(['color' => 'primary', 'type' => 'button'])

<button type="{{ $type }}" {{ $attributes->merge([
    'class' => match($color) {
        'primary' => 'bg-primary-600 text-white hover:bg-primary-700',
        'secondary' => 'bg-white text-primary-600 border border-primary-600 hover:bg-primary-50',
        default => 'bg-gray-100 text-gray-700 hover:bg-gray-200'
    } . ' px-4 py-2 rounded-lg font-medium transition-colors'
]) }}>
    {{ $slot }}
</button>
```

### Avoid Arbitrary Values
```html
<!-- Bad ❌ -->
<div class="text-[13px] mt-[23px]">

<!-- Good ✅ -->
<div class="text-sm mt-6">
```

---

## Alpine.js Guidelines

### Component Structure
```html
<div x-data="{ 
    open: false,
    activeTab: 'saved'
}">
    <!-- Alpine directives -->
    <button @click="open = !open">Toggle</button>
    
    <div x-show="open" x-transition>
        Content
    </div>
</div>
```

### Common Patterns

**Dropdown:**
```html
<div x-data="{ open: false }" @click.outside="open = false">
    <button @click="open = !open">
        Menu
    </button>
    
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        Dropdown content
    </div>
</div>
```

**Tabs:**
```html
<div x-data="{ activeTab: 'saved' }">
    <button @click="activeTab = 'saved'" 
            :class="{ 'active': activeTab === 'saved' }">
        Saved
    </button>
    
    <div x-show="activeTab === 'saved'">
        Saved content
    </div>
</div>
```

**Modal:**
```html
<div x-data="{ showModal: false }">
    <button @click="showModal = true">Open Modal</button>
    
    <div x-show="showModal" 
         x-transition
         @click.self="showModal = false"
         class="fixed inset-0 bg-black bg-opacity-50">
        <div class="bg-white rounded-lg p-6">
            Modal content
        </div>
    </div>
</div>
```

### Best Practices
- Use Alpine for **simple interactions** (dropdowns, modals, tabs)
- Use Livewire for **data-driven interactions** (search, forms, CRUD)
- Keep Alpine component logic **simple** - complex logic belongs in Livewire
- Use `@click.prevent` to prevent default form submission
- Use `@click.outside` to close dropdowns/modals

---

## Database Standards

### Migration Best Practices
```php
// Good ✅
Schema::create('scholarships', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description');
    $table->string('sponsorship_tier')->default('standard'); // String, not enum
    $table->boolean('is_active')->default(true);
    $table->date('primary_deadline')->nullable();
    $table->timestamps();
    
    // Add indexes
    $table->index('is_active');
    $table->index('primary_deadline');
    $table->index('sponsorship_tier');
});

// Bad ❌
Schema::create('scholarships', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('description');
    $table->enum('sponsorship_tier', ['standard', 'featured', 'premium']); // Don't use enum
    // Missing indexes
});
```

### Foreign Keys
```php
// Always use cascading deletes where appropriate
$table->foreignId('scholarship_id')
    ->constrained()
    ->onDelete('cascade');

// Use nullOnDelete for soft dependencies
$table->foreignId('author_id')
    ->nullable()
    ->constrained('users')
    ->nullOnDelete();
```

### Indexes
**Add indexes for:**
- Foreign keys
- Columns used in WHERE clauses frequently
- Columns used in ORDER BY
- Unique constraints

```php
// Single column index
$table->index('is_active');

// Composite index
$table->index(['scholarship_id', 'tenant_id']);

// Unique constraint
$table->unique('slug');
```

### Seeders
```php
// Good ✅
public function run()
{
    $countries = [
        ['name' => 'United States', 'code' => 'USA'],
        ['name' => 'United Kingdom', 'code' => 'GBR'],
        // ...
    ];

    foreach ($countries as $country) {
        Country::firstOrCreate(
            ['code' => $country['code']],
            $country
        );
    }
}

// Bad ❌
public function run()
{
    Country::create(['name' => 'United States', 'code' => 'USA']);
    Country::create(['name' => 'United Kingdom', 'code' => 'GBR']);
    // This will error if run twice
}
```

---

## Testing Standards

### File Structure
```
tests/
├── Feature/
│   ├── Auth/
│   │   ├── LoginTest.php
│   │   └── RegistrationTest.php
│   ├── Scholarships/
│   │   ├── SearchTest.php
│   │   └── SaveScholarshipTest.php
│   └── Dashboard/
│       └── SavedScholarshipsTest.php
└── Unit/
    ├── Enums/
    │   └── SponsorshipTierTest.php
    └── Models/
        └── ScholarshipTest.php
```

### Test Naming
```php
// Use descriptive test names with snake_case
public function test_user_can_save_scholarship()
{
    // Arrange
    $user = User::factory()->create();
    $scholarship = Scholarship::factory()->create();
    
    // Act
    $this->actingAs($user)
        ->post("/scholarships/{$scholarship->id}/save");
    
    // Assert
    $this->assertDatabaseHas('saved_scholarships', [
        'tenant_id' => $user->id,
        'scholarship_id' => $scholarship->id,
    ]);
}

public function test_guest_cannot_save_scholarship()
{
    // ...
}
```

### AAA Pattern
**Always follow Arrange-Act-Assert:**

```php
public function test_deadline_reminder_is_sent()
{
    // Arrange
    $user = User::factory()->create();
    $scholarship = Scholarship::factory()->create([
        'primary_deadline' => now()->addDays(7),
    ]);
    $user->savedScholarships()->create([
        'scholarship_id' => $scholarship->id,
    ]);
    
    // Act
    Artisan::call('send:deadline-reminders');
    
    // Assert
    Mail::assertSent(DeadlineReminderMail::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });
}
```

### Use Factories
```php
// Define factories for all models
class ScholarshipFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraphs(3, true),
            'sponsorship_tier' => SponsorshipTier::STANDARD,
            'is_active' => true,
        ];
    }
    
    // State modifiers
    public function featured()
    {
        return $this->state([
            'sponsorship_tier' => SponsorshipTier::FEATURED,
        ]);
    }
}

// Use in tests
Scholarship::factory()->featured()->create();
Scholarship::factory()->count(5)->create();
```

---

## Git Standards

### Commit Messages
**Use Conventional Commits format:**

```
<type>(<scope>): <subject>

<body>

<footer>
```

**Types:**
- `feat`: New feature
- `fix`: Bug fix
- `refactor`: Code refactoring
- `docs`: Documentation changes
- `style`: Code style changes (formatting)
- `test`: Adding or updating tests
- `chore`: Maintenance tasks

**Examples:**
```
feat(search): add auto-complete to search bar

fix(auth): resolve social login redirect issue

refactor(scholarships): extract search logic to service class

docs(readme): update installation instructions

test(auth): add tests for email verification flow
```

### Branch Naming
```
feature/search-autocomplete
fix/social-login-redirect
refactor/scholarship-search
docs/api-documentation
```

### Pull Request Guidelines
1. **Title:** Clear and descriptive
2. **Description:** Explain what and why, not how
3. **Link issues:** Reference related issues
4. **Tests:** Include test coverage
5. **Screenshots:** For UI changes
6. **Checklist:** Ensure all criteria met

---

## Security Rules

### Never Commit Secrets
- ❌ Never commit `.env` file
- ❌ Never commit API keys or passwords
- ❌ Never commit database credentials
- ✅ Use environment variables for all secrets
- ✅ Add `.env` to `.gitignore`

### Input Validation
```php
// Always validate and sanitize user input
$validated = $request->validate([
    'email' => 'required|email|max:255',
    'password' => 'required|min:8|confirmed',
]);

// Use prepared statements (Eloquent does this automatically)
User::where('email', $email)->first(); // ✅ Safe

// Never do this
DB::select("SELECT * FROM users WHERE email = '$email'"); // ❌ SQL injection
```

### CSRF Protection
```blade
<!-- All forms must have CSRF token -->
<form method="POST">
    @csrf
    <!-- form fields -->
</form>
```

### XSS Prevention
```blade
<!-- Escape output by default -->
{{ $user->name }} <!-- ✅ Escaped -->

<!-- Only use raw when you control the content -->
{!! $user->bio !!} <!-- ❌ Dangerous if user input -->
```

### File Upload Security
```php
// Validate file type and size
$request->validate([
    'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
]);

// Generate unique filename
$filename = Str::uuid() . '.' . $request->file('avatar')->extension();
```

---

## Performance Rules

### Query Optimization
```php
// Good ✅ - Eager load relationships
$scholarships = Scholarship::with(['countries', 'deadlines'])
    ->paginate(20);

// Bad ❌ - N+1 query problem
$scholarships = Scholarship::paginate(20);
foreach ($scholarships as $scholarship) {
    $scholarship->countries; // New query for each scholarship
}
```

### Caching
```php
// Cache expensive queries
$countries = Cache::remember('countries', now()->addDay(), function () {
    return Country::all();
});

// Clear cache when data changes
Country::created(function () {
    Cache::forget('countries');
});
```

### Asset Optimization
- Use Vite for asset bundling
- Lazy load images with `loading="lazy"`
- Minify CSS and JS in production
- Use WebP images with fallbacks

---

## Documentation Rules

### Code Comments
```php
// Use PHPDoc for classes and public methods
/**
 * Get active scholarships with related data.
 *
 * @param  array  $filters
 * @return \Illuminate\Database\Eloquent\Collection
 */
public function getActiveScholarships(array $filters = []): Collection
{
    // Inline comments for complex logic only
    // Query scholarships with eager loading to prevent N+1
    return Scholarship::with(['countries', 'deadlines'])
        ->active()
        ->filter($filters)
        ->get();
}
```

### README Files
- Every major feature should have a README
- Include setup instructions
- Provide usage examples
- Document configuration options

---

## Code Review Checklist

Before submitting code for review, ensure:

- [ ] All tests pass (`php artisan test`)
- [ ] Code follows PSR-12 (run `./vendor/bin/pint`)
- [ ] No debug code (dd(), dump(), console.log())
- [ ] No commented-out code
- [ ] Type hints on all parameters and returns
- [ ] Proper error handling with try-catch
- [ ] Input validation on all user input
- [ ] Database queries are optimized (no N+1)
- [ ] Proper use of Eloquent relationships
- [ ] Tailwind classes only (no custom CSS)
- [ ] Responsive design implemented
- [ ] Accessibility considerations (ARIA, focus states)
- [ ] Git commit messages follow conventions
- [ ] Documentation updated if needed

---

**Remember:** These rules exist to maintain code quality, consistency, and security. When in doubt, ask for clarification rather than guessing. The goal is to build a maintainable codebase that the entire team can work with efficiently.