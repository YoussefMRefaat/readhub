<?php

namespace App\Http\Controllers\Authors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StoreRequest;
use App\Models\Author;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    use ImageHandler;

    /**
     * Store a new author
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $path = $this->saveImage($request->validated()['image'] , 'authors');
        $data = array_merge($request->validated() , ['image' => $path]);
        Author::create($data);
        return response()->json([
            'Message' => 'Author created successfully',
        ], 201);
    }

}
