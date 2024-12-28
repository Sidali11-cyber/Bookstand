# Laravel API for Online Library Management

## Overview

This project is an API for managing an online library system. It supports operations for managing readers, authors, books, and downloads. The API is built using the Laravel framework and incorporates the following features:

-   **Documentation**: Swagger for API documentation.
-   **Authentication**: JWT (JSON Web Token) for secure authentication.

## Features

### Functionalities:

1. **Readers**:

    - Retrieve all readers.
    - Add a new reader.
    - View details of a specific reader.
    - Update reader details.
    - Delete a reader.

2. **Authors**:

    - Retrieve all authors.
    - Add a new author.
    - View details of a specific author.
    - Update author details.
    - Delete an author.

3. **Books**:

    - Retrieve all books.
    - Add a new book.
    - View details of a specific book.
    - Update book details.
    - Delete a book.
    - Retrieve books by genre or author.
    - Retrieve authors associated with a book.

4. **Downloads**:
    - Retrieve books downloaded by a user.
    - Retrieve users who downloaded a specific book.
    - Retrieve users who downloaded books by a specific author.

## Installation

Follow the steps below to set up the project locally:

1. **Clone the Repository**:

    ```bash
    git clone git@github.com:Sidali11-cyber/Bookstand.git
    cd Bookstand
    ```

2. **Install Dependencies**:
   Ensure you have [Composer](https://getcomposer.org/) installed, then run:

    ```bash
    composer install
    ```

3. **Set Environment Variables**:
   Copy the `.env.example` file to `.env`:

    ```bash
    cp .env.example .env
    ```

    Configure the `.env` file with your database and JWT settings.

4. **Generate Application Key**:

    ```bash
    php artisan key:generate
    ```

5. **Run Migrations**:
   Set up the database schema:

    ```bash
    php artisan migrate
    ```

6. **Install Swagger for API Documentation**:
   Publish the Swagger configuration:

    ```bash
    php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
    ```

    Generate the Swagger documentation:

    ```bash
    php artisan l5-swagger:generate
    ```

7. **Serve the Application**:
   Start the Laravel development server:
    ```bash
    php artisan serve
    ```
    The API will be accessible at `http://localhost:8000`.

## API Documentation

Access the Swagger API documentation at:

```
http://localhost:8000/api/documentation
```

## Authentication

The API uses JWT for authentication. Follow these steps to authenticate:

1. **Register**:
   Send a POST request to `/api/register` with the required user details.

2. **Login**:
   Send a POST request to `/api/login` with your email and password to receive a JWT token.

3. **Authenticated Requests**:
   Include the token in the `Authorization` header for subsequent requests:
    ```
    Authorization: Bearer <your-token>
    ```
