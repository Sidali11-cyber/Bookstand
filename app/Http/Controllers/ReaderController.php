<?php
namespace App\Http\Controllers;

use App\Models\Reader;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Reader",
 *     type="object",
 *     title="Reader",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="email", type="string", example="johndoe@example.com")
 *     }
 * )
 */

class ReaderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/readers",
     *     summary="Get all readers",
     *     tags={"Readers"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all readers",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Reader")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Reader::all());
    }

    /**
     * @OA\Post(
     *     path="/api/readers",
     *     summary="Create a new reader",
     *     tags={"Readers"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="reader_name", type="string", example="John Doe"),
     *             @OA\Property(property="reader_email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="image", type="string", format="binary", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reader created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Reader")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'reader_name' => 'required|string|max:100',
            'reader_email' => 'required|email|unique:readers,reader_email',
            'image' => 'nullable|image',
        ]);

        $reader = Reader::create($request->all());
        return response()->json($reader, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/readers/{id}",
     *     summary="Get a reader by ID",
     *     tags={"Readers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Reader ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reader data",
     *         @OA\JsonContent(ref="#/components/schemas/Reader")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reader not found"
     *     )
     * )
     */
    public function show($id)
    {
        $reader = Reader::find($id);
        if (!$reader) {
            return response()->json(['message' => 'Reader not found'], 404);
        }
        return response()->json($reader);
    }

    /**
     * @OA\Put(
     *     path="/api/readers/{id}",
     *     summary="Update a reader",
     *     tags={"Readers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Reader ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="reader_name", type="string", example="Jane Doe"),
     *             @OA\Property(property="reader_email", type="string", example="janedoe@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reader updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Reader")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reader not found"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $reader = Reader::find($id);
        if (!$reader) {
            return response()->json(['message' => 'Reader not found'], 404);
        }

        $reader->update($request->all());
        return response()->json($reader);
    }

    /**
     * @OA\Delete(
     *     path="/api/readers/{id}",
     *     summary="Delete a reader",
     *     tags={"Readers"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Reader ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Reader deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Reader not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $reader = Reader::find($id);
        if (!$reader) {
            return response()->json(['message' => 'Reader not found'], 404);
        }

        $reader->delete();
        return response()->json(['message' => 'Reader deleted successfully']);
    }
}
