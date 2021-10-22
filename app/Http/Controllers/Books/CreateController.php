<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreRequest;
use App\Models\Book;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    use ImageHandler;

    /**
     * Store a new book and attach authors of it
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $path = $this->saveImage($data['image'] , 'books');
        $authors = array_pop($data);
        $data = array_merge($data , ['image' => $path]);
        $book = Book::create($data);
        foreach ($authors as $author)
            $book->authors()->attach($author);
        return response()->json([
            'Message' => 'Book created successfully',
        ], 201);
    }

}
