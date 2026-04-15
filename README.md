# Event Booking System (Laravel 12 + Breeze)

This is a simple Event Booking System built with Laravel 12 and Breeze (Blade + Tailwind).

Think of it like this:
- Admin creates events
- Users open events and book seats
- Users can also cancel their own bookings
- Seat counts update so overbooking does not happen

---

## What this project includes

- Public event listing and event details
- Date/location filtering on events
- Booking flow from event details page
- My Bookings page for each user
- Cancel booking support
- Email verification gate for booking actions
- Booking confirmation email support (Mailtrap ready)
- Role-based authorization (admin/user) using policies

---

## Tech stack

- PHP 8.2+
- Laravel 12
- Laravel Breeze (Blade)
- Tailwind CSS
- MySQL

---

## Quick setup (step by step)

### 1. Clone and open the project

```bash
git clone https://github.com/Muhammad-Arsal/event-booking-system.git
cd event-booking-system
```

### 2. Install backend packages

```bash
composer install
```

### 3. Install frontend packages

```bash
npm install
```

### 4. Create environment file

```bash
cp .env.example .env
```

### 5. Generate app key

```bash
php artisan key:generate
```

### 6. Set your database in `.env`

Update these values:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_booking_system
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Run migrations and seed demo data

```bash
php artisan migrate:fresh --seed
```

### 8. Build frontend assets

```bash
npm run build
```

### 9. Start the Laravel server

```bash
php artisan serve
```

Now open the app at:

`http://127.0.0.1:8000`

---

## Demo accounts

Use these to test quickly:

- Admin  
  Email: `admin@example.com`  
  Password: `password`

- Reviewer user  
  Email: `reviewer@example.com`  
  Password: `password`

- Extra user  
  Email: `ayesha@example.com`  
  Password: `password123`

---

## Mail setup (Mailtrap)

Mail is already wired to use `.env` values.

If needed, confirm these are set:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## How to use the system quickly

1. Login as admin and create/edit/delete events.
2. Login as reviewer and open event details.
3. Book seats from the event details page.
4. Open **My Bookings** to view and cancel your bookings.
5. Check that available seats go down on booking and come back on cancel.

---

## Useful commands

```bash
# clear caches
php artisan optimize:clear

# run fresh database + seed data again
php artisan migrate:fresh --seed

# build assets for production
npm run build

# (optional during development) watch assets live
npm run dev
```

---

## Notes

- Event browsing is public.
- Creating, updating, and deleting events is admin-only.
- Booking and cancellation require authenticated + verified users.
- Users can only cancel their own bookings.
