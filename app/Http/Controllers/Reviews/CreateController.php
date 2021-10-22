<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class CreateController extends Controller
{

    /**
     * Create a new review
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        if(Review::where('user_id' , auth()->id())->where('book_id' , $data['book_id'])->first())
            abort(409 , 'User already reviewed this book');
        $data = array_merge($data , ['user_id' => auth()->id()]);
        Review::create($data);
        return response()->json([
            'Message' => 'Review created successfully',
        ], 201);
    }
}
