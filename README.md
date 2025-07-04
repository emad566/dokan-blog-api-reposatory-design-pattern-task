# Laravel Blog API

A RESTful API for a blogging platform built with Laravel, featuring post management, commenting system, and authorization using Laravel Policies.

## Features

- 📝 **Blog Posts** - Create, read, update, and delete posts with categories
- 💬 **Comments** - Add comments to posts with user attribution
- 🏷️ **Categories** - Organize posts by categories
- 🛡️ **Authorization** - Laravel Policies for secure access control
- 🗄️ **Repository Pattern** - Clean separation of data access logic

## Quick Start

1. **Clone and install**
   ```bash
   git clone <repository-url>
   cd dokan-blog-api-reposatory-design-pattern-task
   composer install
   ```

2. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Configure database** (PostgreSQL)
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=your_database_name
   DB_USERNAME=your_postgres_user
   DB_PASSWORD=your_postgres_password
   ```

4. **Run migrations and start server**
   ```bash
   php artisan migrate
   php artisan serve
   ```

API will be available at `http://localhost:8000`

## API Endpoints

| Method | Endpoint | Description | Auth Required |
|--------|----------|-------------|---------------|
| GET | `/api/posts` | List all posts | No |
| POST | `/api/posts` | Create a new post | Yes |
| GET | `/api/posts/{id}` | Get a specific post | No |
| PUT | `/api/posts/{id}` | Update a post | Yes (Owner only) |
| DELETE | `/api/posts/{id}` | Delete a post | Yes (Owner only) |
| POST | `/api/posts/{id}/comments` | Add comment to post | Yes |
| PUT | `/api/comments/{id}` | Update a comment | Yes (Owner only) |
| DELETE | `/api/comments/{id}` | Delete a comment | Yes (Owner only) |
| GET | `/api/categories/{id}/posts` | Get posts by category | No |

## Example Usage

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
curl -X GET http://localhost:8000/api/posts
```

### Add a Comment
```bash
curl -X POST http://localhost:8000/api/posts/1/comments \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"content": "Great post! Thanks for sharing."}'
```

## Response Format

### Success Response
```json
{
  "data": {
    "id": 1,
    "title": "Blog Post Title",
    "content": "Blog post content...",
    "user": {"id": 1, "name": "John Doe"},
    "category": {"id": 1, "name": "Technology"},
    "comments_count": 5,
    "created_at": "2024-01-01T00:00:00.000000Z"
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

## Validation Rules

- **Post**: `title` (required, max 255), `content` (required), `category_id` (required, exists)
- **Comment**: `content` (required)

## Testing

```bash
php artisan test
```

## Project Structure

```
app/
├── Http/Controllers/Api/  # API Controllers
├── Http/Requests/         # Form Request Validation
├── Http/Resources/        # API Response Resources
├── Models/                # Eloquent Models
├── Policies/              # Authorization Policies
└── Repositories/          # Repository Pattern
    ├── Interfaces/        # Repository Interfaces
    └── Implementations/   # Repository Implementations
```

## License

MIT License
