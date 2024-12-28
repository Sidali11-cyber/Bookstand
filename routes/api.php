<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DownloadedBookController;

// Authentication routes
Route::post('login', [AuthController::class, 'login']); // User login route
Route::post('register', [AuthController::class, 'register']); // User registration route

// Secure routes
Route::middleware('auth:api')->group(function () {

    Route::get('profile', [AuthController::class, 'profile']); // Get the authenticated user's profile
    
    // Routes for readers
    Route::get('readers', [ReaderController::class, 'index']); // Get all readers
    Route::post('readers', [ReaderController::class, 'store']); // Create a new reader
    Route::get('readers/{id}', [ReaderController::class, 'show']); // Get details of a specific reader by ID
    Route::put('readers/{id}', [ReaderController::class, 'update']); // Update a reader's details by ID
    Route::delete('readers/{id}', [ReaderController::class, 'destroy']); // Delete a reader by ID

    // Routes for authors
    Route::get('authors', [AuthorController::class, 'index']); // Get all authors
    Route::post('authors', [AuthorController::class, 'store']); // Create a new author
    Route::get('authors/{id}', [AuthorController::class, 'show']); // Get details of a specific author by ID
    Route::put('authors/{id}', [AuthorController::class, 'update']); // Update an author's details by ID
    Route::delete('authors/{id}', [AuthorController::class, 'destroy']); // Delete an author by ID

    // Routes for books
    Route::get('books', [BookController::class, 'index']); // Get all books
    Route::post('books', [BookController::class, 'store']); // Create a new book
    Route::get('books/{id}', [BookController::class, 'show']); // Get details of a specific book by ID
    Route::put('books/{id}', [BookController::class, 'update']); // Update a book's details by ID
    Route::delete('books/{id}', [BookController::class, 'destroy']); // Delete a book by ID
    Route::get('/books/genre/{genre}', [BookController::class, 'getBooksByGenre']); // Get books by genre
    Route::get('/books/author/{author_name}', [BookController::class, 'getBooksByAuthor']); // Get books by a specific author
    Route::get('/books/{title}/author', [BookController::class, 'getAuthorsByBook']); // Get authors associated with a book title

    // Downloaded Book Routes
    Route::get('/users-by-book/{title}', [DownloadedBookController::class, 'getUsersByBook']); // Get users who downloaded a specific book
    Route::get('/books-by-user/{reader_name}', [DownloadedBookController::class, 'getBooksByUser']); // Get books downloaded by a specific user
    Route::get('/users-by-author/{author_name}', [DownloadedBookController::class, 'getUsersByAuthor']); // Get users who downloaded books by a specific author

});
