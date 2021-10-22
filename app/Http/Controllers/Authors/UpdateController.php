<?php

namespace App\Http\Controllers\Authors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\UpdateImageRequest;
use App\Http\Requests\Author\UpdateRequest;
use App\Models\Author;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    use ImageHandler;

    /**
     * Update information of an author
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, int $id): \Illuminate\Http\JsonResponse
    {
        $author = Author::findOrFail($id);
        $author->update($request->validated());
        return response()->json([
            'Message' => 'Author updated successfully',
        ], 200);
    }

    /**
     * Update the image of an author
     *
     * @param UpdateImageRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateImage(UpdateImageRequest $request , int $id): \Illuminate\Http\JsonResponse
    {
        $author = Author::findOrFail($id);
        $path = $this->saveImage($request->validated()['image'] , 'authors');
        $this->deleteOld($author->image);
        $author->update(['image' => $path]);
        return response()->json([
            'Message' => 'Image uploaded successfully',
        ], 200);
    }

}
