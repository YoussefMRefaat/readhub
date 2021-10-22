<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\UpdateAuthorsRequest;
use App\Http\Requests\Book\UpdateImageRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Models\Book;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    use ImageHandler;

    /**
     * Update information of a book
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request , int $id): \Illuminate\Http\JsonResponse
    {
        $book = Book::findOrFail($id)->update($request->validated());
        return response()->json([
            'Message' => 'Book updated successfully',
        ], 201);
    }

    /**
     * Update the image of a book
     *
     * @param UpdateImageRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateImage(UpdateImageRequest $request , int $id): \Illuminate\Http\JsonResponse
    {
        $book = Book::findOrFail($id);
        $path = $this->saveImage($request->validated()['image'] , 'books');
        $this->deleteOld($book->image);
        $book->update(['image' => $path]);
        return response()->json([
            'Message' => 'Image uploaded successfully',
        ], 200);
    }

    /**
     * Update the authors of a book
     *
     * @param UpdateAuthorsRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateAuthors(UpdateAuthorsRequest $request , int $id): \Illuminate\Http\JsonResponse
    {
        $book = Book::findOrFail($id);
        DB::table('author_book')->where('book_id' , $id)->delete();
        foreach ($request->validated()['authors'] as $author){
            $book->authors()->attach($author);
        }
        return response()->json([
            'Message' => 'Book updated successfully',
        ], 200);
    }
}
