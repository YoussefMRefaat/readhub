<?php

namespace App\Http\Controllers\Authors;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    use ImageHandler;

    /**
     * Delete an author
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): \Illuminate\Http\JsonResponse
    {
        $author = Author::findOrFail($id);
        $this->deleteOld($author->image);
        $author->delete();
        return response()->json([
            'Message' => 'Author deleted successfully',
        ], 200);
    }

}
