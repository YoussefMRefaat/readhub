<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    /**
     * Like a review
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function like(int $id): \Illuminate\Http\JsonResponse
    {
        $hasLiked = Like::where('review_id' , $id)->where('user_id' , auth()->id())->first();
        if($hasLiked)
            return $this->undo($id);
        return $this->store($id , true);
    }

    /**
     * Dislike a review
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function dislike(int $id): \Illuminate\Http\JsonResponse
    {
        $hasLiked = Like::where('review_id' , $id)->where('user_id' , auth()->id())->first();
        if($hasLiked)
            return $this->undo($id);
        return $this->store($id , false);
    }

    /**
     * Remove a like or a dislike
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    private function undo(int $id): \Illuminate\Http\JsonResponse
    {
        Like::where('review_id' , $id)->where('user_id' , auth()->id())->delete();
        return response()->json([
            'Message' => 'Like or dislike removed successfully',
        ], 200);
    }

    /**
     * Store the react in the database
     *
     * @param int $id
     * @param bool $isLike
     * @return \Illuminate\Http\JsonResponse
     */
    private function store(int $id,bool $isLike): \Illuminate\Http\JsonResponse
    {
        $message = $isLike ? 'liked' : 'disliked';
        $review = Review::findOrFail($id)->likes()->create([
            'user_id' => auth()->id(),
            'is_like' => $isLike,
        ]);
        return response()->json([
            'Message' => 'Review ' . $message . ' successfully',
        ], 201);
    }

}
