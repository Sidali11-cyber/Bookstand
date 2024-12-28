<?php

namespace App\Http\Controllers;

use App\Models\Reader;
use App\Models\Book;
use App\Models\Author;

class DownloadedBookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users-by-book/{title}",
     *     summary="Get users by book title",
     *     description="Retrieve all users (readers) who have downloaded a book with a specific title.",
     *     operationId="getUsersByBook",
     *     tags={"DownloadedBooks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="title",
     *         in="path",
     *         required=true,
     *         description="The title of the book",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of users who have downloaded the book",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 ref="#/components/schemas/Reader"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function getUsersByBook($title)
    {
        $book = Book::where('title', $title)->firstOrFail();
        $readers = $book->readers;
        if ($readers->isEmpty()) {
            return response()->json(['message' => "No readers found for title '{$title}'."], 404);
        }
        return response()->json($readers);
    }

    /**
     * @OA\Get(
     *     path="/api/books-by-user/{reader_name}",
     *     summary="Get books by reader name",
     *     description="Retrieve all books downloaded by a specific reader (user) by their name.",
     *     operationId="getBooksByUser",
     *     tags={"DownloadedBooks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="reader_name",
     *         in="path",
     *         required=true,
     *         description="The name of the reader",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of books downloaded by the user",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 ref="#/components/schemas/Book"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reader not found"
     *     )
     * )
     */
    public function getBooksByUser($reader_name)
    {
        $reader = Reader::where('reader_name', $reader_name)->firstOrFail();
        $books = $reader->books;
        if ($books->isEmpty()) {
            return response()->json(['message' => "No books found for reader '{$reader_name}'."], 404);
        }
        return response()->json($books);
    }

    /**
     * @OA\Get(
     *     path="/api/users-by-author/{author_name}",
     *     summary="Get users by author name",
     *     description="Retrieve all users who have downloaded books by a specific author, based on the author's name.",
     *     operationId="getUsersByAuthor",
     *     tags={"DownloadedBooks"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="author_name",
     *         in="path",
     *         required=true,
     *         description="The name of the author",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of users who have downloaded books by the specified author",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 ref="#/components/schemas/Reader"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found"
     *     )
     * )
     */
    public function getUsersByAuthor($author_name)
    {
        $author = Author::where('author_name', $author_name)->firstOrFail();
        $books = $author->books;
        if ($books->isEmpty()) {
            return response()->json(['message' => "No readers found for author '{$author_name}'."], 404);
        }
        $readers = $books->flatMap(function ($book) {
            return $book->readers;
        })->unique('id');
        return response()->json($readers);
    }
}