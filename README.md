# Ecommerce API
The Ecommerce API powers a platform with user auth, product management, cart/orders, vouchers, wishlist, payment gateways, and caching. It features optimized DB design with efficient indexes, JWT auth, SOLID principles, PHPDoc, sorting, filtering, and search. Implemented with Service/Repository patterns, third-party login, and a well-designed ERD.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Documentation](#documentation)
- [Database](#database)
- [Contributing](#contributing)

## Features

### Authentication Routes

- **User Registration**
  - **Route:** `POST /auth/register`
  - **Description:** Register a new user.

- **User Login**
  - **Route:** `POST /auth/login`
  - **Description:** Authenticate user and generate access token.

- **Authenticated Routes**
  - **Route:** `/auth/user`
  - **Description:** Fetch authenticated user details.
  - **Middleware:** `auth:sanctum`

- **Refresh Authentication Token**
  - **Route:** `POST /auth/refresh`
  - **Description:** Refresh authentication token.
  - **Middleware:** `auth:sanctum`

- **User Logout**
  - **Route:** `POST /auth/logout`
  - **Description:** Invalidate current authentication token.
  - **Middleware:** `auth:sanctum`

### Products Routes

- **Fetch All Products**
  - **Route:** `GET /products`
  - **Description:** Retrieve a list of all products.

- **Fetch Product by ID**
  - **Route:** `GET /products/{id}`
  - **Description:** Retrieve details of a specific product.

- **Create Product**
  - **Route:** `POST /products`
  - **Description:** Create a new product.
  - **Middleware:** `auth:sanctum`, `check_admin`

- **Update Product by ID**
  - **Route:** `PATCH /products/{id}`
  - **Description:** Update an existing product.
  - **Middleware:** `auth:sanctum`, `check_admin`

- **Delete Product by ID**
  - **Route:** `DELETE /products/{id}`
  - **Description:** Delete a product.
  - **Middleware:** `auth:sanctum`, `check_admin`

### Categories Routes

- **Fetch All Categories**
  - **Route:** `GET /categories`
  - **Description:** Retrieve a list of all categories.

- **Fetch Category by ID**
  - **Route:** `GET /categories/{id}`
  - **Description:** Retrieve details of a specific category.

- **Create Category**
  - **Route:** `POST /categories`
  - **Description:** Create a new category.
  - **Middleware:** `auth:sanctum`, `check_admin`

- **Update Category by ID**
  - **Route:** `PATCH /categories/{id}`
  - **Description:** Update an existing category.
  - **Middleware:** `auth:sanctum`, `check_admin`

- **Delete Category by ID**
  - **Route:** `DELETE /categories/{id}`
  - **Description:** Delete a category.
  - **Middleware:** `auth:sanctum`, `check_admin`

### Vouchers Routes

- **Fetch All Vouchers**
  - **Route:** `GET /vouchers`
  - **Description:** Retrieve a list of all vouchers.

- **Fetch Voucher by ID**
  - **Route:** `GET /vouchers/{id}`
  - **Description:** Retrieve details of a specific voucher.

- **Create Voucher**
  - **Route:** `POST /vouchers`
  - **Description:** Create a new voucher.
  - **Middleware:** `auth:sanctum`, `check_admin`

- **Update Voucher by ID**
  - **Route:** `PATCH /vouchers/{id}`
  - **Description:** Update an existing voucher.
  - **Middleware:** `auth:sanctum`, `check_admin`

- **Delete Voucher by ID**
  - **Route:** `DELETE /vouchers/{id}`
  - **Description:** Delete a voucher.
  - **Middleware:** `auth:sanctum`, `check_admin`

### WishlistItem Routes

- **Show Wishlist**
  - **Route:** `GET /wishlistitems`
  - **Description:** Retrieve a list of items in the wishlist.

- **Fetch Wishlist Item by ID**
  - **Route:** `GET /wishlistitems/{id}`
  - **Description:** Retrieve details of a specific wishlist item.

- **Create Wishlist Item**
  - **Route:** `POST /wishlistitems`
  - **Description:** Add a new item to the wishlist.

- **Delete Wishlist Item by ID**
  - **Route:** `DELETE /wishlistitems/{id}`
  - **Description:** Remove an item from the wishlist.
  - **Middleware:** `check_ownership:App\\Models\\WishlistItem,id`

### Product Reviews Routes

- **Fetch All Product Reviews**
  - **Route:** `GET /productreviews/product/{product_id}`
  - **Description:** Retrieve all reviews for a specific product.

- **Fetch Product Review by ID**
  - **Route:** `GET /productreviews/review/{id}`
  - **Description:** Retrieve details of a specific product review.

- **Create Product Review**
  - **Route:** `POST /productreviews`
  - **Description:** Add a new review for a product.
  - **Middleware:** `auth:sanctum`

- **Update Product Review by ID**
  - **Route:** `PATCH /productreviews/review/{id}`
  - **Description:** Update an existing product review.
  - **Middleware:** `auth:sanctum`, `check_ownership:App\\Models\\ProductReview,id`

- **Delete Product Review by ID**
  - **Route:** `DELETE /productreviews/review/{id}`
  - **Description:** Delete a product review.
  - **Middleware:** `auth:sanctum`, `check_ownership:App\\Models\\ProductReview,id`

### CartItem Routes

- **Fetch All Cart Items**
  - **Route:** `GET /cart`
  - **Description:** Retrieve a list of all items in the cart.

- **Show Cart Item by ID**
  - **Route:** `GET /cart/{id}`
  - **Description:** Retrieve details of a specific cart item.

- **Create Cart Item**
  - **Route:** `POST /cart`
  - **Description:** Add a new item to the cart.

- **Delete Cart Item by ID**
  - **Route:** `DELETE /cart/{id}`
  - **Description:** Remove a specific item from the cart.
  - **Middleware:** `check_ownership:App\\Models\\CartItem,id`

### Order Routes

- **Fetch All Orders**
  - **Route:** `GET /orders`
  - **Description:** Retrieve a list of all orders.

- **Show Order by ID**
  - **Route:** `GET /orders/{id}`
  - **Description:** Retrieve details of a specific order.

- **Create New Order**
  - **Route:** `POST /orders`
  - **Description:** Place a new order.

### Filter Routes

- **Filter Products by Price**
  - **Route:** `POST /filter/price`
  - **Description:** Filter products by price range.

- **Filter Products by Category**
  - **Route:** `GET /filter/category/{id}`
  - **Description:** Filter products by a specific category.

### Sort Routes

- **Sort Products by Name**
  - **Route:** `GET /sort/name`
  - **Description:** Sort products alphabetically by name.

- **Sort Products by Price**
  - **Route:** `GET /sort/price`
  - **Description:** Sort products by price in ascending order.

- **Sort Products by Price (Descending)**
  - **Route:** `GET /sort/price_desc`
  - **Description:** Sort products by price in descending order.

- **Sort Products by Date**
  - **Route:** `GET /sort/date`
  - **Description:** Sort products by date added, oldest first.

- **Sort Products by Date (Descending)**
  - **Route:** `GET /sort/date_desc`
  - **Description:** Sort products by date added, newest first.

- **Sort Products by Popularity**
  - **Route:** `GET /sort/popularity`
  - **Description:** Sort products by popularity or sales.

### Search Routes

- **Search Products**
  - **Route:** `POST /search`
  - **Description:** Search products by name or keywords.

### Filter and Sort Routes

- **Filter and Sort Products**
  - **Route:** `POST /filterandsort`
  - **Description:** Apply both filtering and sorting to products.

### User Profile Routes

- **Update User Profile**
  - **Route:** `PATCH /profile`
  - **Description:** Update the authenticated user's profile information.
  - **Middleware:** `auth:sanctum`

- **Delete User Profile**
  - **Route:** `POST /profile`
  - **Description:** Delete the authenticated user's profile.
  - **Middleware:** `auth:sanctum`

### Additional Features

- **Authentication**: Implemented with Laravel Sanctum for secure API token management and authentication.
- **Performance Optimization**: Utilization of caching mechanisms to enhance system performance and responsiveness.
- **Design Patterns**: Follows SOLID principles with the implementation of Service & Repository design patterns for robust and maintainable code.
- **Database Design and Optimization**:
  - **ERD Design**: Well-designed Entity-Relationship Diagram (ERD) ensuring efficient data relationships and structure.
  - **Indexes and Data Types**: Optimized database indexes and appropriate data types with correct limits to ensure efficient storage and retrieval.
  - **Query Optimization**: Benefiting from SQL joins and query optimizations for improved database performance.
- **Documentation**: Comprehensive code documentation using PHPDoc for clear understanding and maintainability.

## Installation

To get started with the E-Commerce API, follow these steps:
1. **Clone the Repository:**
git clone https://github.com/omarwaleed7/Ecommerce-API.git
2. **Navigate to the Project Directory:**
cd Ecommerce-API
3. **Install Dependencies:**
composer install
4. **Create a `.env` File:**
Create a copy of the `.env.example` file and name it `.env`. Update the database connection settings and other environment variables as needed.
5. **Generate Application Key:**
php artisan key:generate
6. **Run Database Migrations:**
php artisan migrate 
7. **Start the Development Server:**
php artisan serve
8. **Access the API:**
The API should now be running at `http://127.0.0.1:800`. You can explore the API endpoints and start using the Blog API.
### Swagger Documentation

## Documentation

Explore the API endpoints and usage instructions in the Swagger documentation:
[Swagger Documentation](https://app.swaggerhub.com/apis/OmarWaleed/E-Commerce/1.0.0)

## Database

### Database Schema

The Booking API uses MySQL. Configure your database connection in `.env` and view the schema:
[View Database Schema](https://drive.google.com/file/d/1VksDo-ddC3csS0pWob85_moRk8E-oOWw)

### Entity-Relationship Diagram (ERD)

Visualize the database structure with the ERD:
[View ERD](https://drive.google.com/file/d/1tIgGG2OALXiJI2-1w-x01cHtpyV0nqXI/view)

## Contributing

Contributions to the Booking API are welcome and encouraged. To contribute to this project, please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bug fix: `git checkout -b feature-name`.
3. Make your changes and commit them: `git commit -m 'Add some feature'`.
4. Push to the branch: `git push origin feature-name`.
5. Create a pull request.

Please ensure that your code follows the project's coding standards and practices. Also, make sure to update any relevant documentation and tests.
