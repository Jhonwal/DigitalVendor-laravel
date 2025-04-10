# Laravel Digital Marketplace

A web-based digital product marketplace for buying and selling digital items such as software, ebooks, templates, and other downloadable content. The marketplace is inspired by platforms like Gumroad and Creative Market, focusing on clean product displays and streamlined purchase flows.

## Features

- Product listings with details and previews
- Secure digital product upload/download system
- Shopping cart and checkout functionality
- User dashboard for managing purchased and sold items
- Admin panel for marketplace management

## Running the Application

To run the Laravel application in the Replit environment, use the management script:

```bash
# Start the server
./manage-server.sh start

# Stop the server
./manage-server.sh stop

# Restart the server
./manage-server.sh restart

# Check server status
./manage-server.sh status

# View server logs
./manage-server.sh logs
```

The start script will:
1. Install dependencies (if needed)
2. Create storage link
3. Set up the SQLite database
4. Run migrations
5. Start the Laravel development server on port 3000

The server will run in the background, and you can access it at the Replit URL.

## Database

The application is configured to use SQLite for simplicity in the Replit environment. The database file is located at `database/database.sqlite`.

## Authentication

The authentication system is implemented using Laravel Breeze. Test accounts include:
- Admin: admin@example.com
- Seller: seller@example.com
- Buyer: buyer@example.com

## Core Components

- **Models**: Product, Category, Order, OrderItem, CartItem
- **Controllers**: ProductController, CategoryController, CartController, OrderController, HomeController, DashboardController
- **Middleware**: AdminMiddleware, Authenticate, ValidateSignature, VerifyCsrfToken

## Directory Structure

- `/app` - Core application code
- `/resources/views` - Blade views
- `/public` - Public assets
- `/routes` - Application routes
- `/database` - Migrations and seeders