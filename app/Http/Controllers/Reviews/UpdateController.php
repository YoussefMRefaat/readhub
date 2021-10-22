<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\UpdateCommentRequest;
use App\Http\Requests\Review\UpdateRatingRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{

    /**
     * Update the rating of a review
     *
     * @param UpdateRatingRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRating(UpdateRatingRequest $request , int $id): \Illuminate\Http\JsonResponse
    {
        $review = $this->findAndCheck($id);
        $review->update($request->validated());
        return response()->json([
            'Message' => 'Review updated successfully',
        ], 200);
    }

    /**
     * Update the comment of a review
     *
     * @param UpdateCommentRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateComment(UpdateCommentRequest $request , int $id): \Illuminate\Http\JsonResponse
    {
        $review = $this->findAndCheck($id);
        if($review->comment)
            DB::table('reviews_h')->insert([
                'review_id' => $id,
                'comment' => $review->comment,
                'archived_at' => now(),
            ]);
        $review->update($request->validated());
        return response()->json([
            'Message' => 'Review updated successfully',
        ], 200);
    }

    /**
     * Find the review and check if the user is authorized to update it
     *
     * @param int $id
     * @return Review
     */
    private function findAndCheck(int $id): Review
    {
        $review = Review::findOrFail($id);
        if(auth()->user()->cannot('access' , $review))
            abort(403);
        return $review;
    }
}
