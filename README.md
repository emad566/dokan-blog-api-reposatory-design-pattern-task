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
- **PostgreSQL** (default database)
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

4. **Configure PostgreSQL database**
   - Make sure PostgreSQL is running and a database is created:
     ```sh
     createdb -U your_postgres_user your_database_name
     ```
   - Edit your `.env` file as follows:
     ```env
     DB_CONNECTION=pgsql
     DB_HOST=127.0.0.1
     DB_PORT=5432
     DB_DATABASE=your_database_name
     DB_USERNAME=your_postgres_user
     DB_PASSWORD=your_postgres_password
     ```
   - Replace `your_database_name`, `your_postgres_user`, and `your_postgres_password` with your actual PostgreSQL credentials.

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

---

## ⚠️ PostgreSQL Troubleshooting
- If you get a connection error, ensure PostgreSQL is running and the credentials in `.env` are correct.
- If you see `could not connect to server: Connection refused`, check that PostgreSQL is listening on the correct port (default: 5432).
- If you see `database does not exist`, create it with `createdb` or your preferred tool.

---

## API Endpoints

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
