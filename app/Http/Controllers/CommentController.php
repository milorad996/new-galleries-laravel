<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $galleryId)
    {
        $newComment = new Comment();
        $newComment->body = $request->body;
        $newComment->user_id = Auth::user()->id;
        $newComment->gallery_id = $galleryId;
        $newComment->save();

        $gallery = Gallery::with(['images', 'author', 'comments'])->find($galleryId);
        return response()->json($gallery);
    }


    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return response()->json([
            'message' => 'Deleted'
        ]);
    }

    public function getComments($id)
    {
        $comments = Comment::with(['user', 'gallery'])
            ->where('gallery_id', $id)
            ->get();

        return response()->json($comments);
    }
}
