# 5Rose Coolspot Feedback

A mobile-friendly feedback collection site for 5Rose Cool Bar in Kurunegala. Customers can choose a rating, optionally select an ordered item and name, add a comment, and submit feedback for storage.

## Implemented

- Customer home page with menu highlights, gallery area, and feedback entry point.
- Five-star feedback form with validation, character count, loading state, and success state.
- Laravel endpoint validates and saves feedback to the database.
- Optional customer name supports anonymous submissions.

## Planned

- Admin login and moderation queue to approve or reject submissions.
- Public display of approved reviews only.
- Real shop gallery images and production deployment.

The current home page intentionally shows an empty reviews state. Do not describe moderation or published reviews as implemented yet.

## Tech stack

- PHP 8.3 or newer and Laravel 13
- Blade templates, Tailwind CSS 4, and Vite
- SQLite by default for local development and tests

The repository description currently mentions MySQL, but `.env.example` and the test configuration default to SQLite. Update the database configuration and test it before claiming MySQL support.

## Run locally

Requirements: PHP 8.3+, Composer, Node.js, and npm.

```bash
git clone https://github.com/abdulahadh3148/5rose-feedback-saas.git
cd 5rose-feedback-saas
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan serve
```

Open the local URL printed by Artisan. For frontend development, run `npm run dev` in a second terminal.

## Tests

```bash
php artisan test
```

Feature tests cover valid feedback storage and validation failures using an in-memory SQLite database.

## Screenshots and demo

No live demo is configured in GitHub yet. Add privacy-safe screenshots under `docs/screenshots/` after deploying and checking the customer home, feedback form, successful submission, and moderation queue.

## Security and privacy

Customer names are optional. Before accepting real customer submissions, add moderation and a retention policy, protect admin routes, and configure production database, HTTPS, backups, and application secrets through the host's environment settings.
