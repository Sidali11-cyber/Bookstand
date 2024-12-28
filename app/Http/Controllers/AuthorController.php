<?php
namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Author",
 *     type="object",
 *     title="Author",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="author_name", type="string", example="Jane Austen"),
 *         @OA\Property(property="writing_language", type="string", example="English"),
 *         @OA\Property(property="image", type="string", nullable=true, example="image.jpg")
 *     }
 * )
 */
class AuthorController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/authors",
     *     summary="Get all authors",
     *     tags={"Authors"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all authors",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Author")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Author::all());
    }

    /**
     * @OA\Post(
     *     path="/api/authors",
     *     summary="Create a new author",
     *     tags={"Authors"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Author created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'author_name' => 'required|string|max:100',
            'writing_language' => 'required|string|max:50',
            'image' => 'nullable|image',
        ]);

        $author = Author::create($request->all());
        return response()->json($author, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/authors/{id}",
     *     summary="Get an author by ID",
     *     tags={"Authors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Author ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author details",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found"
     *     )
     * )
     */
    public function show($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }
        return response()->json($author);
    }

    /**
     * @OA\Put(
     *     path="/api/authors/{id}",
     *     summary="Update an author",
     *     tags={"Authors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Author ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Author")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        $author->update($request->all());
        return response()->json($author);
    }

    /**
     * @OA\Delete(
     *     path="/api/authors/{id}",
     *     summary="Delete an author",
     *     tags={"Authors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Author ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             properties={
     *                 @OA\Property(property="message", type="string", example="Author deleted successfully")
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }

        $author->delete();
        return response()->json(['message' => 'Author deleted successfully']);
    }
}
