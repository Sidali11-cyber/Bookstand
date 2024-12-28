<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Book",
 *     type="object",
 *     title="Book",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="title", type="string", example="Pride and Prejudice"),
 *         @OA\Property(property="genre", type="string", example="Romance"),
 *         @OA\Property(property="publication_date", type="string", format="date", example="1813-01-28"),
 *         @OA\Property(property="author_id", type="integer", example=1),
 *         @OA\Property(property="image", type="string", nullable=true, example="book_cover.jpg")
 *     }
 * )
 */
class BookController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/books",
     *     summary="Get all books",
     *     tags={"Books"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all books",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Book")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Book::all());
    }

    /**
     * @OA\Post(
     *     path="/api/books",
     *     summary="Create a new book",
     *     tags={"Books"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:200',
            'genre' => 'required|string|max:100',
            'publication_date' => 'required|date',
            'author_id' => 'required|exists:authors,id',
            'image' => 'nullable|image',
        ]);

        $book = Book::create($request->all());
        return response()->json($book, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/books/{id}",
     *     summary="Get a book by ID",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Book ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book details",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($book);
    }

    /**
     * @OA\Put(
     *     path="/api/books/{id}",
     *     summary="Update a book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Book ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Book")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->update($request->all());
        return response()->json($book);
    }

    /**
     * @OA\Delete(
     *     path="/api/books/{id}",
     *     summary="Delete a book",
     *     tags={"Books"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Book ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="message", type="string", example="Book deleted successfully")
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();
        return response()->json(['message' => 'Book deleted successfully']);
    }

    /**
     * @OA\Get(
     *     path="/api/books/genre/{genre}",
     *     summary="Get books by genre",
     *     description="Retrieve all books belonging to a specific genre.",
     *     operationId="getBooksByGenre",
     *     tags={"Books"},
     *      security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="genre",
     *         in="path",
     *         required=true,
     *         description="The genre of the books to retrieve",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Book")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No books found for this genre"
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */    

    public function getBooksByGenre($genre)
    {
            $books = Book::where('genre', $genre)->get();
            if ($books->isEmpty()) {
                return response()->json(['message' => "No books found for genre '{$genre}'."], 404);
            }
            return response()->json($books);
    }

    /**
     * @OA\Get(
     *     path="/api/books/{title}/author",
     *     summary="Get author by book title",
     *     description="Retrieve the author of a book by its title.",
     *     operationId="getAuthorsByBook",
     *     tags={"Books", "Authors"},
     *      security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="title",
     *         in="path",
     *         required=true,
     *         description="The title of the book",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */

    public function getAuthorsByBook($title)
    {
        $book = Book::where('title', $title)->firstOrFail();
        $author = $book->author;
        if ($author->isEmpty()) {
            return response()->json(['message' => "No authors found for title '{$title}'."], 404);
        }
        return response()->json($author);
    }

    /**
     * @OA\Get(
     *     path="/api/books/author/{author_name}",
     *     summary="Get books by author name",
     *     description="Retrieve all books written by a specific author.",
     *     operationId="getBooksByAuthor",
     *     tags={"Books", "Authors"},
     *      security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="author_name",
     *         in="path",
     *         required=true,
     *         description="The name of the author",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Book")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found"
     *     ),
     *      @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */

    public function getBooksByAuthor($author_name)
    {
        $author = Author::where('author_name', $author_name)->firstOrFail();
        $books = $author->books;
        if ($books->isEmpty()) {
            return response()->json(['message' => "No books found for author '{$author_name}'."], 404);
        }
        return response()->json($books);
    }
}
