# AOT Railway Staff Management System — Architecture and AI Handoff Guide

> **Purpose:** This document is the project map for developers and AI assistants. Read it before changing the project. It explains where behavior lives, which files are connected, how requests flow, and which parts must be changed together.
>
> **Verified:** 2026-07-24
>
> **Application type:** Laravel 13 / PHP 8.3 / Blade / Tailwind CSS / Alpine.js / Vite
>
> **Primary roles:** `station_user`, `super_admin`
>
> **Important:** The project currently depends on the business database schema in `additional/fulldatabase.sql`. The checked-in Laravel migrations do not yet create the business tables.

---

## 1. One-minute project summary

This application manages railway-station staff records and monthly staffing reports.

### Station user can

- Log in using NIC number and password.
- View the assigned station dashboard.
- Create a monthly report for a station and period.
- Add designation-level staffing details.
- View and edit their station's report records.

### Super administrator can

- View operational dashboard statistics.
- Manage users, station assignments, account status, and passwords.
- Browse, search, edit, and delete monthly reports and report details.
- View monthly, quarterly, station-wise, user-wise, and missing-submission reports.

### Main request path

```text
Browser
  -> routes/*.php
  -> middleware
  -> controller
  -> Form Request validation (where present)
  -> Eloquent model/query
  -> MySQL database
  -> Blade view
  -> Vite CSS/Alpine JS
```

---

## 2. Source-of-truth rules

When making a change, use these rules:

1. **URL or permission change:** start in `routes/web.php` or `routes/auth.php`.
2. **Business behavior change:** find the controller first, then its model and view.
3. **Database field/relationship change:** update the SQL schema, model, controller validation, views, seeders/factories, and tests as applicable.
4. **Authenticated user identity:** the domain uses `nic_number`, `full_name`, `whatsapp_mobile`, `role_id`, `station_id`, and `status`.
5. **Do not assume Breeze defaults are correct.** Some retained Breeze files still use `name` and `email` and are inconsistent with the domain schema.
6. **UI shared styling:** change `resources/css/app.css` or a shared Blade component before editing many individual pages.
7. **Never edit generated assets manually.** Run `npm run build` after source asset changes.
8. **Run `php artisan view:cache` after Blade changes.**
9. **Check nested ownership carefully.** A report detail must belong to the report in the URL.
10. **Preserve the current white/black/gold visual language** unless the request explicitly changes it.

---

## 3. Root files

| File | Responsibility | Change when |
|---|---|---|
| `artisan` | Laravel command-line entry point. | Never for feature work. |
| `composer.json` | PHP dependencies and Composer scripts. | Adding PHP packages or changing setup/test/dev commands. |
| `package.json` | Frontend dependencies and npm scripts. | Adding JS/CSS packages or changing frontend commands. |
| `vite.config.js` | Vite entry points and Laravel refresh integration. | Adding/removing frontend entry files. |
| `tailwind.config.js` | Tailwind scan paths, fonts, plugins. | Changing Tailwind configuration. |
| `postcss.config.js` | Tailwind/PostCSS/Autoprefixer configuration. | Changing CSS processing. |
| `phpunit.xml` | Test environment configuration. | Changing test database or PHPUnit behavior. |
| `.env` | Local environment secrets/settings; do not commit secrets. | Local machine only. |
| `.env.example` | Template for environment variables. | Adding required configuration. |
| `README.md` | General project README; currently mostly Laravel default. | Keep aligned with this architecture document. |
| `ARCHITECTURE.md` | This project map and AI handoff document. | Update whenever structure or important behavior changes. |
| `additional/fulldatabase.sql` | Effective MySQL domain schema, seed data, views, procedures, and triggers. | Any business schema change until migrations replace it. |
| `additional/testing database and models and relationshipsscriptguide.txt` | Supporting database/model/relationship notes. | When domain design notes change. |

---

## 4. Bootstrap and configuration

### `bootstrap/app.php`

Creates the Laravel application and registers:

- `routes/web.php`
- `routes/console.php`
- `/up` health endpoint
- `role` middleware alias mapped to `app/Http/Middleware/CheckRole.php`

### `bootstrap/providers.php`

Laravel provider registration file. The application provider is `AppServiceProvider`.

### `app/Providers/AppServiceProvider.php`

Currently empty. This is the place for global application bindings, observers, view composers, macros, or shared boot configuration.

### `config/auth.php`

Configures the `web` session guard and Eloquent user provider using `App\\Models\\User`.

**Warning:** Laravel's default password reset configuration uses `password_reset_tokens` and email-based behavior, while the domain SQL contains a custom `password_resets` table and NIC-oriented users.

### `config/database.php`

Database connection configuration. The codebase contains MySQL-specific behavior, including SQL in `additional/fulldatabase.sql` and `FIELD()` ordering in the station report controller.

**Practical assumption:** MySQL is currently the safest supported database.

### `config/session.php`

Uses database-backed sessions by default and depends on the `sessions` table migration/schema.

### `routes/console.php`

Currently contains only Laravel's default `inspire` command. There are no scheduled missing-submission jobs, notification jobs, or export commands.

---

## 5. Routing map

### `routes/web.php`

#### Public

| Method | URL | Name | Behavior |
|---|---|---|---|
| GET | `/` | — | Renders `welcome`. |

#### Dashboard

| Method | URL | Name | Behavior |
|---|---|---|---|
| GET | `/dashboard` | `dashboard` | Authenticated role dispatcher. Super admin goes to admin dashboard; all other authenticated users go to station dashboard. |

#### Station routes

Middleware: `auth`, `role:station_user`; prefix: `/station`; names start with `station.`.

| Method | URL/name | Controller |
|---|---|---|
| GET | `/station/dashboard` / `station.dashboard` | `Station\\DashboardController@index` |
| GET | `/station/reports` / `station.reports.index` | `Station\\MonthlyReportController@index` |
| GET | `/station/reports/create` / `station.reports.create` | `Station\\MonthlyReportController@create` |
| POST | `/station/reports` / `station.reports.store` | `Station\\MonthlyReportController@store` |
| GET | `/station/reports/{monthlyReport}` / `station.reports.show` | `Station\\MonthlyReportController@show` |
| POST | `/station/reports/{monthlyReport}/designations` / `station.reports.designations.store` | `Station\\ReportDetailController@store` |
| GET | `/station/reports/{monthlyReport}/designations/{reportDetail}` / `station.designations.show` | `Station\\ReportDetailController@show` |
| GET | `/station/reports/{monthlyReport}/designations/{reportDetail}/edit` / `station.designations.edit` | `Station\\ReportDetailController@edit` |
| PUT | `/station/reports/{monthlyReport}/designations/{reportDetail}` / `station.designations.update` | `Station\\ReportDetailController@update` |

#### Admin routes

Middleware: `auth`, `role:super_admin`; prefix: `/admin`; names start with `admin.`.

| Area | Routes |
|---|---|
| Dashboard | `admin.dashboard` |
| Users | `admin.users.index`, `admin.users.edit`, `admin.users.update`, `admin.users.destroy`, `admin.users.reset-password`, `admin.users.password.update` |
| Records | `admin.records.index`, `admin.records.show`, `admin.records.destroy`, `admin.records.designations.edit`, `admin.records.designations.update`, `admin.records.designations.destroy` |
| Search | `admin.search.index`, `admin.search.results` |
| Reports | `admin.reports.index`, `admin.reports.monthly`, `admin.reports.quarterly`, `admin.reports.station-wise`, `admin.reports.user-wise`, `admin.reports.missing-submissions` |

#### Profile routes

Middleware: `auth` only.

- `GET /profile` -> `profile.edit`
- `PATCH /profile` -> `profile.update`
- `DELETE /profile` -> `profile.destroy`

**Known risk:** Profile code is still Breeze/email-oriented and conflicts with the domain user fields.

### `routes/auth.php`

Breeze-style authentication routes:

- Registration: `GET/POST /register`
- Login: `GET/POST /login`
- Password reset request: `GET/POST /forgot-password`
- Password reset: `GET/POST /reset-password/{token}` and `/reset-password`
- Logout
- Password confirmation/update
- Email verification notice, verification, and resend

**Known risk:** Registration/login are customized for NIC, but several password/email verification routes still expect email.

---

## 6. Middleware and request validation

### `app/Http/Middleware/CheckRole.php`

Checks `auth()->user()->role->slug` against the route role. Returns HTTP 403 when the role does not match.

It does not check:

- Account status
- Station assignment
- Record ownership
- Audit logging

### `app/Http/Requests/Auth/LoginRequest.php`

Validates `nic_number` and `password`, then authenticates active users using NIC/password. It rate-limits failed attempts and combines normalized NIC with IP address for the throttle key.

### `app/Http/Requests/ProfileUpdateRequest.php`

Breeze-derived validation for `name` and `email`. This is inconsistent with the domain model and should be changed together with the profile controller/views if profile behavior is repaired.

---

## 7. Controllers: exact responsibilities

### Base/general controllers

| File | Responsibility |
|---|---|
| `app/Http/Controllers/Controller.php` | Empty base controller. Shared controller helpers can be added here. |
| `app/Http/Controllers/LandingPageController.php` | Currently unused; returns a `landing` view that is not the active root flow. |
| `app/Http/Controllers/ProfileController.php` | Breeze-style profile display/update/delete. Uses `name`/`email` and is not aligned with domain fields. |

### Authentication controllers (`app/Http/Controllers/Auth`)

| File | Responsibility |
|---|---|
| `AuthenticatedSessionController.php` | Login page, NIC authentication request, session regeneration, logout. |
| `RegisteredUserController.php` | Registration page, active station list, station-user creation, login after registration. Currently hardcodes `role_id = 1`. |
| `PasswordController.php` | Authenticated password change. |
| `PasswordResetLinkController.php` | Sends Laravel password reset links; email/table mismatch exists. |
| `NewPasswordController.php` | Completes Laravel password resets; email/table mismatch exists. |
| `ConfirmablePasswordController.php` | Password confirmation; currently uses email-oriented logic. |
| `VerifyEmailController.php` | Marks email verified; likely unused/incompatible with current user schema. |
| `EmailVerificationPromptController.php` | Shows verification prompt. |
| `EmailVerificationNotificationController.php` | Resends verification notification. |

### Station controllers (`app/Http/Controllers/Station`)

| File | Responsibility |
|---|---|
| `DashboardController.php` | Loads the authenticated user's station, current period status, and recent reports. |
| `MonthlyReportController.php` | Lists/creates/shows station monthly reports, checks station ownership, finds remaining designations. |
| `ReportDetailController.php` | Creates/shows/edits/updates designation-level report details and checks report ownership. |

#### Station report lifecycle

```text
create form
  -> MonthlyReportController@store
  -> validate year/month
  -> resolve authenticated user's station
  -> reject duplicate station/year/month
  -> create draft MonthlyReport
  -> database trigger generates report_identifier/month_full
  -> redirect to report show
  -> ReportDetailController@store adds designation detail
  -> report becomes submitted after first detail
```

### Admin controllers (`app/Http/Controllers/Admin`)

| File | Responsibility |
|---|---|
| `DashboardController.php` | Counts active stations, station users, current-period submissions/pending stations, and recent reports. |
| `UserController.php` | User search/list/edit/delete, station assignment, status changes, password reset/custom password. |
| `RecordController.php` | Admin report filtering, report detail viewing/editing/deleting, whole report deletion. |
| `SearchController.php` | Search by station code, user NIC, or report identifier pattern. |
| `ReportController.php` | Monthly, quarterly, station-wise, user-wise, and missing-submission report pages. |

**Important security issue:** Admin nested report-detail operations should verify that the `ReportDetail` belongs to the supplied `MonthlyReport`; current routes/controllers do not consistently enforce this.

---

## 8. Models and database relationships

All models are under `app/Models`.

```text
UserRole 1 ─── * User
Station  1 ─── 1 User
Station  1 ─── * MonthlyReport
User     1 ─── * MonthlyReport
MonthlyReport 1 ─── * ReportDetail
Designation   1 ─── * ReportDetail
Station  1 ─── * QuarterlyReportSummary
Station  1 ─── * MissingSubmissionTracking
User     1 ─── * AuditLog
User     1 ─── * PasswordChangeHistory
User     1 ─── * SystemNotification
```

| Model | Table/domain role | Relationships and notes |
|---|---|---|
| `User.php` | Authenticated staff/admin user. | Belongs to `UserRole`, belongs to `Station`, has reports, audit logs, notifications, password history. Role helpers: `hasRole()`, `isSuperAdmin()`, `isStationUser()`. Uses `full_name`, not `name`; uses `nic_number`, not email. |
| `UserRole.php` | Role definitions. | Has many users. Expected slugs: `station_user`, `super_admin`. |
| `Station.php` | Railway station. | Has one user, many monthly reports, quarterly summaries, missing-submission records. |
| `Designation.php` | Staff post/designation catalog. | Has many report details; `active()` scope. |
| `MonthlyReport.php` | Report header for one station/year/month. | Belongs to station/user; has many details; casts `submitted_at` to datetime. |
| `ReportDetail.php` | Designation-level staffing metrics. | Belongs to monthly report and designation. |
| `QuarterlyReportSummary.php` | Optional persisted quarterly summary. | Currently not used; admin report controller calculates dynamically. |
| `MissingSubmissionTracking.php` | Missing-report reminder tracking. | Currently unused by application workflows. |
| `AuditLog.php` | User/action/module/old/new data audit record. | Currently no controller writes audit records. `old_data` and `new_data` cast to arrays. |
| `PasswordChangeHistory.php` | Password-change metadata. | Expected to be populated by SQL trigger; application does not explicitly write it. |
| `SystemNotification.php` | Notification records. | No active notification workflow. |
| `PasswordReset.php` | Custom `password_resets` model. | Not used by Laravel's configured password broker. |
| `ReportExport.php` | Export metadata/file tracking. | No export workflow currently exists. |
| `Session.php` | Eloquent model for sessions. | Default database session handler can work without this model. |

### Domain field names

Use these names for new domain code unless deliberately repairing the schema:

```text
users.full_name
users.nic_number
users.whatsapp_mobile
users.station_id
users.role_id
users.status
monthly_reports.station_id
monthly_reports.user_id
monthly_reports.year
monthly_reports.month
monthly_reports.month_full
monthly_reports.report_identifier
monthly_reports.submission_status
report_details.monthly_report_id
report_details.designation_id
```

---

## 9. Database architecture

### Checked-in migrations

Only these business-independent migrations are present:

- `database/migrations/2026_07_22_091829_create_cache_table.php` -> `cache`, `cache_locks`
- `database/migrations/2026_07_22_093335_create_sessions_table.php` -> `sessions`

### Seeder/factory status

- `database/seeders/DatabaseSeeder.php` is still the default Breeze-style seeder and uses `name`/`email`.
- `database/factories/UserFactory.php` is still the default Breeze-style factory and uses `name`/`email`.
- They do not seed domain roles, stations, designations, a super admin, or valid station users.

### `additional/fulldatabase.sql`

This is currently the effective application schema. It contains:

- Tables: `user_roles`, `stations`, `users`, `designations`, `monthly_reports`, `report_details`, `password_resets`, `password_change_history`, `audit_logs`, `system_notifications`, `missing_submissions_tracking`, `sessions`, `report_exports`, `quarterly_report_summaries`.
- Foreign keys, unique constraints, indexes, and cascade behavior.
- Seed roles, stations, designations, administrator, and sample station user.
- Procedures: `GenerateReportIdentifier`, `CheckMissingSubmissions`, `GetStationSubmissionStats`.
- Views: `v_user_station_details`, `v_monthly_report_summary`, `v_pending_submissions`.
- Triggers: report identifier/month name generation and password history insertion.

### Database risks

1. Fresh `php artisan migrate` does not create the business schema.
2. The SQL is MySQL-specific.
3. Monthly report creation depends on a trigger for required fields.
4. Laravel password reset defaults do not match the custom SQL table.
5. The SQL user schema has no email field, while retained Breeze features expect email.
6. Several SQL tables/features have no active application workflow.

---

## 10. Blade UI map

### Layouts

| File | Used for |
|---|---|
| `resources/views/layouts/app.blade.php` | Authenticated pages. Includes navigation, optional header, and page slot. |
| `resources/views/layouts/guest.blade.php` | Login/registration/authentication pages. Includes StaffMS branding and guest card. |
| `resources/views/layouts/navigation.blade.php` | Role-aware desktop/mobile navigation, profile dropdown, logout. |

### Public/authentication views

| File | Purpose |
|---|---|
| `resources/views/welcome.blade.php` | Minimal public landing page with StaffMS name, login/register actions, and dashboard action for authenticated users. |
| `resources/views/auth/login.blade.php` | NIC/password login. |
| `resources/views/auth/register.blade.php` | Full name, NIC, WhatsApp, station, password registration. |
| `resources/views/auth/forgot-password.blade.php` | Default email password-reset request; currently inconsistent with NIC-only domain. |
| `resources/views/auth/reset-password.blade.php` | Default email reset form; same inconsistency. |
| `resources/views/auth/confirm-password.blade.php` | Password confirmation page. |
| `resources/views/auth/verify-email.blade.php` | Email verification page; likely incompatible until email support is implemented. |

### Station views

| File | Purpose |
|---|---|
| `resources/views/station/dashboard.blade.php` | Station identity, current-month status, quick actions, recent submissions. |
| `resources/views/station/reports/index.blade.php` | Paginated station report list. |
| `resources/views/station/reports/create.blade.php` | Year/month report creation form. |
| `resources/views/station/reports/show.blade.php` | Report header, status, remaining designations, add-detail form, existing details. |
| `resources/views/station/reports/_designation-form-fields.blade.php` | Shared staffing/detail fields used by station and admin edit forms. |
| `resources/views/station/designations/show.blade.php` | Read-only designation detail. |
| `resources/views/station/designations/edit.blade.php` | Station-owned designation edit form. |

### Admin views

| File | Purpose |
|---|---|
| `resources/views/admin/dashboard.blade.php` | Admin metrics and recent submissions. |
| `resources/views/admin/users/index.blade.php` | User search/list/actions. |
| `resources/views/admin/users/edit.blade.php` | User identity, station, status, and password forms. |
| `resources/views/admin/records/index.blade.php` | Filterable monthly report list. |
| `resources/views/admin/records/show.blade.php` | Designation details inside a report. |
| `resources/views/admin/records/edit.blade.php` | Admin detail edit; reuses designation partial. |
| `resources/views/admin/search/index.blade.php` | Search form. |
| `resources/views/admin/search/results.blade.php` | Search results and optional user summary. |
| `resources/views/admin/reports/index.blade.php` | Reporting hub. |
| `resources/views/admin/reports/monthly.blade.php` | Monthly report summary. |
| `resources/views/admin/reports/quarterly.blade.php` | Quarterly aggregate report. |
| `resources/views/admin/reports/station-wise.blade.php` | Reports for a selected station. |
| `resources/views/admin/reports/user-wise.blade.php` | Reports for a user/NIC. |
| `resources/views/admin/reports/missing-submissions.blade.php` | Active stations without a report for a selected period. |

### Profile and generic views

- `resources/views/profile/edit.blade.php` -> profile page composed of three partials.
- `resources/views/profile/partials/update-profile-information-form.blade.php` -> Breeze `name`/`email` form; inconsistent with domain.
- `resources/views/profile/partials/update-password-form.blade.php` -> password update form.
- `resources/views/profile/partials/delete-user-form.blade.php` -> account deletion with confirmation modal.
- `resources/views/dashboard.blade.php` -> default Breeze dashboard, normally bypassed by role redirect.
- `resources/views/user/dashboard.blade.php` -> legacy dashboard, not used by current station route.

### Shared Blade components

| Component | Responsibility |
|---|---|
| `application-logo.blade.php` | Default Laravel SVG; largely unused after StaffMS branding. |
| `auth-session-status.blade.php` | Session status message. |
| `danger-button.blade.php` | Shared action button styling. |
| `dropdown.blade.php` | Alpine dropdown container/trigger/content. |
| `dropdown-link.blade.php` | Dropdown menu link. |
| `input-error.blade.php` | Validation messages. |
| `input-label.blade.php` | Shared form label. |
| `modal.blade.php` | Alpine modal with transitions/focus behavior. |
| `nav-link.blade.php` | Desktop navigation link and active state. |
| `primary-button.blade.php` | Primary action button. |
| `responsive-nav-link.blade.php` | Mobile navigation link. |
| `secondary-button.blade.php` | Secondary-style action component, currently normalized to project palette. |
| `text-input.blade.php` | Shared form input. |

### PHP view components

- `app/View/Components/AppLayout.php` -> renders `layouts.app`.
- `app/View/Components/GuestLayout.php` -> renders `layouts.guest`.

---

## 11. Frontend architecture

### `resources/css/app.css`

Contains Tailwind directives and the shared visual system:

- White background
- Black text
- Gold `#ebae34` buttons
- StaffMS brand lockup/mark
- Page shell, cards, inputs, tables, focus states
- Legacy Tailwind color overrides to keep old views visually consistent

**When changing the overall UI:** edit this file first, then shared components, then individual Blade pages only where layout/content differs.

### `resources/js/app.js`

Imports and starts Alpine.js. Alpine currently powers:

- Responsive navigation
- Dropdowns
- Modal dialogs
- Timed/status UI behavior

There is no API client or custom application JavaScript layer.

### Build files

- `npm run dev` -> Vite development server.
- `npm run build` -> production assets in `public/build`.
- `public/build/*` -> generated; do not hand-edit.

---

## 12. Tests and current test limitations

### Test files

- `tests/Pest.php` -> Pest setup and `RefreshDatabase` configuration.
- `tests/TestCase.php` -> base Laravel test case.
- `tests/Feature/Auth/*` -> mostly retained Breeze authentication tests.
- `tests/Feature/ProfileTest.php` -> mostly retained Breeze profile tests.
- `tests/Feature/ExampleTest.php` -> root HTTP smoke test.
- `tests/Unit/ExampleTest.php` -> trivial unit smoke test.

### Known test mismatch

Many existing tests submit `email`/`name`, but the application uses `nic_number`/`full_name`. Do not use passing/failing Breeze tests as proof that domain authentication/profile behavior is correct until they are rewritten.

### Missing coverage

There are no reliable domain tests for:

- Role middleware
- Station ownership/isolation
- Report creation and duplicate prevention
- Designation duplicate prevention
- Report lifecycle
- Admin authorization
- Aggregations
- Missing submissions
- Audit logging
- Notifications
- Exports
- SQL triggers
- Clean database setup

---

## 13. Change impact map

### If changing the login identity

Review together:

1. `routes/auth.php`
2. `app/Http/Requests/Auth/LoginRequest.php`
3. `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
4. `app/Models/User.php`
5. `resources/views/auth/login.blade.php`
6. `config/auth.php`
7. Authentication tests

If changing to email, also update the database schema, registration controller/view, password reset, password confirmation, verification, factories, seeders, profile, and tests.

### If changing registration fields

Review together:

1. `app/Http/Controllers/Auth/RegisteredUserController.php`
2. `resources/views/auth/register.blade.php`
3. `app/Models/User.php`
4. `additional/fulldatabase.sql`
5. `database/factories/UserFactory.php`
6. `database/seeders/DatabaseSeeder.php`
7. Registration tests

### If changing a monthly report field

Review together:

1. `additional/fulldatabase.sql`
2. `MonthlyReport.php` or `ReportDetail.php`
3. Relevant controller validation
4. `resources/views/station/reports/_designation-form-fields.blade.php`
5. Station report show/edit views
6. Admin record edit/show views
7. Monthly/quarterly report views and aggregation queries
8. Tests

### If changing station-user permissions

Review together:

1. `routes/web.php`
2. `CheckRole.php`
3. `User.php` role helpers
4. Station controllers
5. Admin controllers if permissions overlap
6. Navigation view
7. Policies/scoped bindings if record ownership is involved

### If changing navigation or global UI

Review together:

1. `resources/css/app.css`
2. `resources/views/layouts/navigation.blade.php`
3. `resources/views/components/nav-link.blade.php`
4. `resources/views/components/responsive-nav-link.blade.php`
5. `resources/views/layouts/app.blade.php`
6. `resources/views/layouts/guest.blade.php`
7. `resources/views/welcome.blade.php` if public UI is affected

### If adding a new page

Recommended sequence:

1. Add route in the correct route file.
2. Add middleware/role protection.
3. Add controller action.
4. Add Form Request if validation is non-trivial.
5. Add/update model query and relationships.
6. Add Blade view under `resources/views`.
7. Add navigation link if users need to discover it.
8. Add feature tests.
9. Run build/cache validation.
10. Update this document.

---

## 14. Safe AI workflow for future changes

Give an AI assistant this instruction before work:

> Read `ARCHITECTURE.md` first. Do not modify files until you identify the route, controller, model, view, shared component, database schema, and tests connected to the requested behavior. Preserve existing public APIs and UI conventions. Make the smallest complete change. After editing, run the relevant tests, `php artisan view:cache` for Blade changes, and `npm run build` for frontend changes. Report all changed files and any known schema mismatch.

### Required AI investigation checklist

- What URL/action is changing?
- Which route name maps to it?
- Which middleware protects it?
- Which controller method handles it?
- Which Form Request validates it?
- Which model/table/relationship stores it?
- Which Blade view displays it?
- Which shared component or CSS affects its appearance?
- Which other role/page uses the same partial or model?
- Does `additional/fulldatabase.sql` need updating?
- Are tests/factories/seeders still compatible?
- Is the change safe for station ownership and nested relationships?

### Required AI final report

The AI should report:

- Files changed
- Why each file changed
- Validation commands run
- Test/build results
- Any unresolved schema or security risk
- Any follow-up work that is intentionally not included

---

## 15. Development commands

Run from the project root: `F:\AOT-Railway-Staff-Management-System\myproject`.

```text
composer install
npm install
php artisan serve
npm run dev
npm run build
php artisan route:list
php artisan migrate:status
php artisan view:cache
php artisan config:clear
php artisan test
```

### Minimum validation by change type

| Change | Validation |
|---|---|
| Blade view/layout/component | `php artisan view:cache` |
| CSS/JS/Tailwind | `npm run build` |
| Route/controller/model | `php artisan route:list`, relevant tests, `php artisan test` where database is available |
| Database schema | `php artisan migrate:status`, fresh database verification, SQL import verification |
| Authentication | Login/registration/password tests plus manual role checks |

---

## 16. Known issues to keep visible

These are existing architecture issues, not automatically fixed by this document:

1. Domain tables are not represented by Laravel migrations.
2. MySQL-specific SQL is mixed with Laravel's SQLite default.
3. Report identifier/month name generation relies on a database trigger.
4. NIC/full-name domain identity conflicts with retained email/name Breeze code.
5. Password reset and email verification are not aligned with the custom user schema.
6. Factories, seeders, and many tests are still default Breeze implementations.
7. Admin nested report-detail routes need stronger parent-child ownership checks.
8. Audit, notification, export, missing-tracking, and quarterly-summary models exist without complete workflows.
9. Some controllers contain business logic that would be safer in services/Form Requests/policies.
10. The README does not yet describe the real domain setup; this document is the more accurate operational reference.

---

## 17. Recommended future stabilization order

1. Decide whether MySQL is mandatory.
2. Convert `additional/fulldatabase.sql` into ordered Laravel migrations and domain seeders.
3. Choose one identity strategy: fully NIC-based or fully email-based.
4. Repair factories, seeders, and authentication/profile tests.
5. Add policies or scoped bindings for all nested report/detail routes.
6. Add Form Requests for report details and admin user operations.
7. Add transactions around report/detail creation and duplicate-sensitive updates.
8. Implement audit logging for administrator mutations.
9. Implement or remove dormant notification, export, missing-tracking, and quarterly-summary features.
10. Keep this document updated after every structural change.
