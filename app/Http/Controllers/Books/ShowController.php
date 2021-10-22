<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class ShowController extends Controller
{

    /**
     * Get best five books based on the ratings. For the homepage.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function home(): \Illuminate\Http\JsonResponse
    {
        $books = Book::with('authors')->withAvg('reviews' , 'rating')
            ->orderBy('reviews_avg_rating' , 'desc')->limit(5)->get();
        return response()->json([
            'Data' => $books,
        ], 200);
    }

    /**
     * Get all books
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $books = Book::with('authors')->withAvg('reviews' , 'rating')->get();
        return response()->json([
            'Message' => 'Books retrieved successfully',
            'Data' => $books
        ], 200);
    }

    /**
     * Show a book with its reviews ordered by ratings
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $book = Book::with('authors')
            ->withAvg('reviews' , 'rating')->findOrFail($id);
        $reviews = Review::with('user')->where('book_id' , $id)->withCount([
            'likes' => function($query){$query->where('is_like' , 1); }
        ])->withCount([
            'likes as dislikes_count' => function($query){$query->where('is_like' , 0); }
        ])->orderBy('likes_count', 'desc')->get();
        return response()->json([
            'Message' => 'Book retrieved successfully',
            'Book' => $book,
            'Reviews' => $reviews,
        ], 200);
    }

    /**
     * Search for a book or an author
     *
     * @param string $search
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(string $search): \Illuminate\Http\JsonResponse
    {
        $authors = Author::where('name' , 'LIKE' , '%' . $search . '%')->get();
        $books = Book::with('authors')->withAvg('reviews' , 'rating')
            ->orderBy('reviews_avg_rating')
            ->where('title' , 'LIKE' , '%' . $search . '%')->get();
        return response()->json([
            'Message' => 'Search done successfully',
            'Authors' => $authors,
            'Books' => $books,
        ], 200);
    }

}
