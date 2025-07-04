<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Laravel Blog API

A RESTful API for a blogging platform built with Laravel, featuring user authentication, post management, commenting system, and comprehensive authorization using Laravel Policies.

## Features

- 🔐 **Authentication** - Laravel Sanctum token-based authentication
- 📝 **Blog Posts** - Create, read, update, and delete posts with categories
- 💬 **Comments** - Add comments to posts with user attribution
- 🏷️ **Categories** - Organize posts by categories
- 🛡️ **Authorization** - Laravel Policies for secure access control
- ✅ **Validation** - Form Request classes for input validation
- 🧪 **Testing** - Comprehensive feature tests
- 🗄️ **Repository Pattern** - Clean separation of data access logic
- 🔄 **Soft Deletes** - Safe deletion with data recovery capability

## Requirements

- PHP 8.2 or higher
- Laravel 12.0
- MySQL/PostgreSQL/SQLite
- Composer

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd dokan-blog-api-reposatory-design-pattern-task
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_blog_api
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

## API Endpoints

### Authentication

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/api/auth/register` | Register a new user | No |
| POST | `/api/auth/login` | Login user | No |
| POST | `/api/auth/logout` | Logout user | Yes |
| GET | `/api/auth/profile` | Get user profile | Yes |
| PUT | `/api/auth/profile` | Update user profile | Yes |
| PUT | `/api/auth/password` | Change password | Yes |

### Posts

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/posts` | List all posts | No |
| POST | `/api/posts` | Create a new post | Yes |
| GET | `/api/posts/{id}` | Get a specific post | No |
| PUT | `/api/posts/{id}` | Update a post | Yes (Owner only) |
| DELETE | `/api/posts/{id}` | Delete a post | Yes (Owner only) |

### Comments

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| POST | `/api/posts/{id}/comments` | Add comment to post | Yes |
| PUT | `/api/comments/{id}` | Update a comment | Yes (Owner only) |
| DELETE | `/api/comments/{id}` | Delete a comment | Yes (Owner only) |

### Categories

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/categories/{id}/posts` | Get posts by category | No |

## Authentication

The API uses Laravel Sanctum for token-based authentication.

### Register a new user
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

### Login
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "john@example.com",
    "password": "password123"
  }'
```

### Using the token
Include the token in subsequent requests:
```bash
curl -X GET http://localhost:8000/api/posts \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

## API Examples

### Create a Post
```bash
curl -X POST http://localhost:8000/api/posts \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "My First Blog Post",
    "content": "This is the content of my first blog post.",
    "category_id": 1
  }'
```

### Get All Posts
```bash
curl -X GET http://localhost:8000/api/posts \
  -H "Accept: application/json"
```

### Add a Comment
```bash
curl -X POST http://localhost:8000/api/posts/1/comments \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "content": "Great post! Thanks for sharing."
  }'
```

### Update a Post (Owner only)
```bash
curl -X PUT http://localhost:8000/api/posts/1 \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Updated Blog Post Title",
    "content": "Updated content for the blog post.",
    "category_id": 1
  }'
```

## Response Format

All API responses follow a consistent format:

### Success Response
```json
{
  "data": {
    "id": 1,
    "title": "Blog Post Title",
    "content": "Blog post content...",
    "user": {
      "id": 1,
      "name": "John Doe"
    },
    "category": {
      "id": 1,
      "name": "Technology"
    },
    "comments_count": 5,
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
  }
}
```

### Error Response
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["The title field is required."]
  }
}
```

## Authorization

The API implements Laravel Policies for secure access control:

- **Posts**: Only the post owner can update or delete their posts
- **Comments**: Only the comment owner can update or delete their comments
- **Public Access**: Anyone can view posts and comments
- **Authentication Required**: Creating posts and comments requires authentication

## Validation Rules

### Post Creation/Update
- `title`: Required, string, max 255 characters
- `content`: Required, string
- `category_id`: Required, must exist in categories table

### Comment Creation/Update
- `content`: Required, string

### User Registration
- `name`: Required, string, max 255 characters
- `email`: Required, valid email, unique
- `password`: Required, minimum 8 characters, confirmed

## Testing

Run the test suite:

```bash
php artisan test
```

### Test Coverage
- ✅ Creating posts as authenticated user
- ✅ Failing to create posts when unauthenticated
- ✅ Posting comments to posts
- ✅ Viewing posts with comments
- ✅ Authorization tests (owner-only access)
- ✅ Validation tests

## Project Structure

```
app/
├── Http/
│   ├── Controllers/Api/     # API Controllers
│   ├── Requests/           # Form Request Validation
│   └── Resources/          # API Response Resources
├── Models/                 # Eloquent Models
├── Policies/              # Authorization Policies
└── Repositories/          # Repository Pattern Implementation
    ├── Interfaces/        # Repository Interfaces
    └── Implementations/   # Repository Implementations
```

## Database Schema

### Users Table
- `id` (Primary Key)
- `name` (String)
- `email` (String, Unique)
- `password` (Hashed)
- `email_verified_at` (Timestamp, Nullable)
- `remember_token` (String, Nullable)
- `created_at` (Timestamp)
- `updated_at` (Timestamp)

### Categories Table
- `id` (Primary Key)
- `name` (String)
- `created_at` (Timestamp)
- `updated_at` (Timestamp)

### Posts Table
- `id` (Primary Key)
- `title` (String)
- `content` (Text)
- `user_id` (Foreign Key)
- `category_id` (Foreign Key)
- `deleted_at` (Timestamp, Nullable) - Soft Delete
- `created_at` (Timestamp)
- `updated_at` (Timestamp)

### Comments Table
- `id` (Primary Key)
- `content` (Text)
- `user_id` (Foreign Key)
- `post_id` (Foreign Key)
- `deleted_at` (Timestamp, Nullable) - Soft Delete
- `created_at` (Timestamp)
- `updated_at` (Timestamp)

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Ensure all tests pass
6. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
