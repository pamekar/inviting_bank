# Project Context: Inviting Bank (Detailed)

This document provides a comprehensive summary of the "Inviting Bank" project, its architecture, branding, features, and key implementation details. It is intended to be used as a detailed reference for future development sessions.

---

## 1. Brand Identity & Vision

*   **Brand Name**: Inviting Bank
*   **Core Concept**: An **AI-centric** banking experience designed to be intelligent, intuitive, and deeply personalized. The brand voice emphasizes ease of use, security, and empowering users with smart financial tools.
*   **Visual Style**: The UI is modern, clean, and trustworthy, designed to be mobile-first.
    *   **Color Palette**: A primary color of purple (`#7c3aed` / `text-purple-700`) is used for branding and key actions. Accent colors from the UI kit inspiration (green for income, red for expenses) are used in the dashboard.
    *   **Imagery**: The public website uses high-quality, professional images from Unsplash that are directly related to finance, technology, and positive customer outcomes.
        *   **Hero Image**: A full-width background image of a happy couple managing finances (`https://images.unsplash.com/photo-1604328698692-f76ea9498e7b`).
        *   **About Us Image**: A photo of a professional team collaborating (`https://images.unsplash.com/photo-1522071820081-009f0129c71c`).
        *   **AI Insights Image**: A person analyzing financial charts (`https://images.unsplash.com/photo-1551288049-bebda4e38f71`).
    *   **Logo**: A simple, stylized text-based SVG logo is used for a clean, scalable brand mark. It consists of a circle with an "i" and the bank's name.

---

## 2. Technology & Architecture

*   **Backend**: Laravel 11 with a MySQL database.
*   **Frontend**:
    *   **User Application**: Built with **Laravel Breeze (Blade stack)** and styled extensively with **Tailwind CSS**.
    *   **Public Website**: Also uses Blade and Tailwind CSS, with **Alpine.js** for interactive elements (mobile menu, testimonial carousel, FAQ accordion).
*   **Admin Panel**: **Filament PHP** provides the admin backend UI.
*   **Key Packages**:
    *   `laravel/breeze`: For frontend authentication scaffolding.
    *   `filament/filament`: For the admin panel.
    *   `spatie/laravel-permission`: For robust Role-Based Access Control (RBAC).
    *   `pragmarx/google2fa`: For Time-based One-Time Password (TOTP) functionality.
    *   `league/csv`: For generating CSV reports.
    *   `chart.js`: Used via CDN for rendering charts on the statistics page.
    *   `alpine.js`: Used via CDN for frontend interactivity.

---

## 3. Application Structure & Key File Locations

*   **Routes**:
    *   `routes/web.php`: Defines all public-facing and authenticated user web pages.
    *   `routes/api.php`: Defines all API endpoints for programmatic access.
*   **Controllers**:
    *   **Web**: `app/Http/Controllers/` (e.g., `DashboardController.php`, `ProfileController.php`).
    *   **API**: `app/Http/Controllers/Api/` (e.g., `AuthController.php`, `TransferController.php`, `TwoFactorAuthController.php`).
*   **Models**: All Eloquent models are located in `app/Models/`.
*   **Views**:
    *   **Layouts**: `resources/views/layouts/` (`guest.blade.php` for public pages, `app.blade.php` for the user dashboard).
    *   **Public Pages**: `welcome.blade.php`, `about.blade.php`, `contact.blade.php`.
    *   **Auth Pages**: `resources/views/auth/` (customized login, register, etc.).
    *   **Dashboard Pages**: `dashboard.blade.php`, `transfers.blade.php`, `statistics.blade.php`, etc.
*   **Database**:
    *   **Migrations**: `database/migrations/`.
    *   **Seeders**: `database/seeders/` (`DatabaseSeeder.php` calls all other seeders).
    *   **Factories**: `database/factories/`.
*   **Scheduled Jobs**:
    *   **Command**: `app/Console/Commands/ProcessScheduledTransfers.php`.
    *   **Scheduler**: `app/Console/Kernel.php` (configured to run the command daily).

---

## 4. Core Features & Implementation Details

### Database Schema
A total of 27 tables were created to support the application's features:
*   `users`, `password_reset_tokens`, `sessions`: Standard Laravel tables.
*   `accounts`, `account_tiers`: For managing user bank accounts and their feature tiers.
*   `transactions`: A central ledger for all financial movements.
*   `transfers`, `withdrawals`, `deposits`, `utility_payments`: Detail tables for specific transaction types.
*   `beneficiaries`: Stores user-saved recipient accounts for quick transfers.
*   `transaction_fees`: Stores configuration for various fees.
*   `two_factor_auths`, `totp_secrets`, `otp_verifications`: Manages 2FA settings, secrets (for TOTP), and SMS codes.
*   `pending_authorizations`: A crucial table that holds transactions awaiting 2FA approval.
*   `authorization_approvals`: Logs successful 2FA approvals.
*   `audit_logs`, `disputes`, `notifications`, `cards`, `loans`, `devices`: Tables for extended and future features.
*   `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`: Tables from the `spatie/laravel-permission` package.

### Two-Factor Authentication (2FA) Flow
*   **TOTP is the default method**.
*   **Setup**: The `TwoFactorAuthController@setup` method generates a secret key using `pragmarx/google2fa`, stores it in the `totp_secrets` table, and passes a QR code URL to the `2fa.setup` view.
*   **Verification**: The `verifySetup` method validates the code from the user's authenticator app. If correct, it sets `verified_at` on the secret and enables 2FA in the `two_factor_auths` table.
*   **Transaction Authorization**:
    1.  Sensitive actions (e.g., `TransferController@store`) create a transaction with a status of `awaiting_authorization` and a record in the `pending_authorizations` table.
    2.  The user must then call the `approveAuthorization` endpoint with the pending authorization ID and a valid 2FA code.
    3.  The `approveAuthorization` method first checks the TOTP code. If that fails, it iterates through the user's **hashed backup codes** (stored as a JSON array in `totp_secrets`) to check for a match.
    4.  On success, it processes the transaction (e.g., decrements/increments balances, applies fees) and updates the transaction status to `completed`.

### Roles & Permissions (RBAC)
*   **Implementation**: Uses `spatie/laravel-permission`.
*   **Roles Defined**: `super-admin`, `finance-admin`, `compliance-admin`, `support-admin`.
*   **Permissions Defined**: `view users`, `manage users`, `view transactions`, `manage transactions`, `view reports`.
*   **Seeding**: `RolesAndPermissionsSeeder` creates the roles and permissions, and `AdminSeeder` assigns the `super-admin` and `finance-admin` roles to the initial admin users. The `User` model uses the `HasRoles` trait.

### Frontend UI/UX
*   **Public Website**: A fully custom, branded website was built to establish the "Inviting Bank" identity. It is mobile-responsive and includes dynamic elements.
*   **Authenticated Dashboard**: The default Breeze UI was heavily modified to create a mobile-first banking experience.
    *   **Navigation**: The primary navigation is a **fixed bottom bar** on mobile, providing an app-like feel.
    *   **Styling**: All pages were restyled to match the brand's color palette and modern aesthetic.
    *   **Dashboard**: The dashboard is the centerpiece, featuring a prominent balance card and quick access to core features.
    *   **Data Visualization**: The `statistics.blade.php` view uses **Chart.js** to render doughnut and bar charts for financial insights.

### Demo Data
*   The `DatabaseSeeder` is configured to run a chain of seeders in a specific order to maintain data integrity.
*   The `UserSeeder` was modified to create 5 specific, predictable customer accounts (`customer1@invitingbank.com` to `customer5@invitingbank.com`) for easy testing. The full list of credentials is in `credentials.md`.

This detailed context should provide a comprehensive foundation for any future work on the Inviting Bank project.