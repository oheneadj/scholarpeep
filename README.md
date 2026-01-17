# Scholarpeep

Scholarpeep is a comprehensive scholarship management platform designed to help students discover, track, and apply for scholarships. It features a modern, responsive UI built with Laravel, Livewire, and TailwindCSS, including a "Saved Resources" feature for personalizing the user experience.

## 🚀 Features

-   **Scholarship Pipeline:** sophisticated tracking of scholarship applications.
-   **Resource Library:** Curated guides, templates, and tools for students.
-   **Saved Resources:** Authenticated users can save resources to their personal dashboard (with rate limiting protection).
-   **Blog & Content:** Integrated blog system for educational content.
-   **User Dashboard:** Personalized dashboard for tracking progress and managing preferences.
-   **Authentication:** Secure login/registration including extensive social auth support (via Socialite).
-   **Admin Panel:** Powered by **Filament** for easy management of content and data.

## 🛠️ Tech Stack

-   **Backend:** [Laravel](https://laravel.com)
-   **Frontend:** [Livewire](https://livewire.laravel.com) & [Alpine.js](https://alpinejs.dev)
-   **Styling:** [Tailwind CSS](https://tailwindcss.com) (v4)
-   **Admin:** [Filament](https://filamentphp.com)
-   **Database:** SQLite (default) / MySQL

## 🔧 Installation

1.  **Clone the repository**
    ```bash
    git clone https://github.com/oheneadj/scholarpeep.git
    cd scholarpeep
    ```

2.  **Install PHP dependencies**
    ```bash
    composer install
    ```

3.  **Install Node.js dependencies**
    ```bash
    npm install
    ```

4.  **Environment Setup**
    Copy the `.env.example` file to `.env`:
    ```bash
    cp .env.example .env
    ```
    Configure your database and other environment variables in `.env`.

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Run Migrations**
    ```bash
    php artisan migrate
    ```

7.  **Build Assets & Run Server**
    ```bash
    # Terminal 1: Build assets (watch mode)
    npm run dev

    # Terminal 2: Start Laravel server
    php artisan serve
    ```

## 🔒 Security

-   **Rate Limiting:** Actions like saving resources are rate-limited (e.g., 10 saves/min) to prevent abuse.
-   **Authentication:** Protected routes and middleware ensure secure access to user data.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
