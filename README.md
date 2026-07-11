# Leonce Blog

**Smart Tips & Stories for Car Lovers**

A full-featured blog application built with Laravel for publishing articles about car maintenance, cleaning technology, and automotive industry updates.

## Tech Stack

- **Backend:** Laravel 13, PHP 8.3
- **Frontend:** Tailwind CSS, Alpine.js, Vite
- **Auth:** Laravel Breeze
- **Database:** SQLite (default)

## Features

### Public

- Responsive blog homepage with featured post hero and category filter pills
- Full-text search across post titles and content
- Single post view with reading time estimate and threaded comments
- Category browsing with post counts
- Mobile-friendly navigation with hamburger menu

### Admin Panel

- Dashboard with post/category stats
- Full post CRUD (create, edit, delete) with image upload
- Category management (create, edit, delete)
- Comment moderation (view, delete)
- User listing
- Post filtering by category, status, and search

### Authentication

- Login, registration, email verification
- Password reset and confirmation
- User profile management (edit info, change password, delete account)
- Role-based access (admin vs regular user)

## Database Schema

| Table | Description |
|---|---|
| `users` | User accounts with `is_admin` flag |
| `posts` | Blog posts with slug, excerpt, image, status, published date |
| `categories` | Post categories with auto-generated slugs |
| `comments` | Threaded comments with `parent_id` for nested replies |
| `post_category` | Many-to-many pivot for multi-category assignment |

## Installation

```bash
# Clone the repository
git clone <repo-url>
cd blog

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Create database and run migrations
touch database/database.sqlite
php artisan migrate

# Seed sample data
php artisan db:seed

# Build frontend assets
npm run dev

# Start the server
php artisan serve
```

## Default Users

| Email | Password | Role |
|---|---|---|
| admin@example.com | password | Admin |
| john@example.com | password | User |
| jane@example.com | password | User |

## Routes

| URI | Access | Description |
|---|---|---|
| `/` | Public | Blog homepage |
| `/posts/{slug}` | Public | Single post view |
| `/categories` | Public | Category listing |
| `/categories/{slug}` | Public | Posts in category |
| `/dashboard` | Auth | User dashboard |
| `/profile` | Auth | Profile management |
| `/admin` | Admin | Admin dashboard |
| `/admin/posts` | Admin | Post management |
| `/admin/categories` | Admin | Category management |
| `/admin/comments` | Admin | Comment moderation |
| `/admin/users` | Admin | User listing |

## License

MIT License. See [LICENSE](LICENSE) for details.
