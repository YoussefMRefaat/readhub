<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShowController extends Controller
{

    /**
     * Show a review with the updating history
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id): \Illuminate\Http\JsonResponse
    {
        $review = Review::with('user')->findOrFail($id);
        $history = DB::table('reviews_h')->where('review_id' , $id)->get();
        return response()->json([
            'Message' => 'Review retrieved successfully',
            'Review' => $review,
            'History' => $history,
        ], 200);
    }

    /**
     * Show likes or dislikes of a review
     *
     * @param int $id
     * @param string $path
     * @return \Illuminate\Http\JsonResponse
     */
    public function showLikes(int $id , string $path): \Illuminate\Http\JsonResponse
    {
        $isLike = ($path == 'likes');
        $likes = Like::with('user')
            ->where('review_id' , $id)->where('is_like' , $isLike)->get();
        return response()->json([
            'Message' => $path . ' retrieved successfully',
            ucfirst($path) => $likes,
        ], 200);
    }

}
