<?php

namespace App\Http\Controllers\Authors;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class ShowController extends Controller
{

    /**
     * Get all authors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $authors = Author::get();
        return response()->json([
            'Message' => 'Authors retrieved successfully',
            'Data' => $authors,
        ], 200);
    }

    /**
     * Show an author with his books
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $author = Author::with('books')->findOrFail($id);
        return response()->json([
            'Message' => 'Author retrieved successfully',
            'Data' => $author,
        ], 200);
    }
}
