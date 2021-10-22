<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class DeleteController extends Controller
{

    /**
     * Delete a review
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $review = Review::findOrFail($id);
        if(auth()->user()->cannot('access' , $review))
            abort(403);
        $review->delete($id);
        return response()->json([
            'Message' => 'Review deleted successfully',
        ], 200);
    }
}
