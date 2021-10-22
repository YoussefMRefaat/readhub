<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    use ImageHandler;

    /**
     * Delete a book
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $book = Book::findOrFail($id);
        $this->deleteOld($book->image);
        $book->delete();
        return response()->json([
            'Message'=> 'Book deleted successfully',
        ],200);
    }
}
