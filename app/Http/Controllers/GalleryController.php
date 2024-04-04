<?php

namespace App\Http\Controllers;

use App\Http\Requests\GalleryRequest;
use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class GalleryController extends Controller
{


    public function index()
    {

        $galleries = Gallery::with('author', 'images')
            ->orderBy('created_at', 'desc')->get();

        return response()->json($galleries);
    }
    public function sliderGallery()
    {
        $galleries = Gallery::with('author', 'images')->orderBy('created_at', 'desc')->get();

        return response()->json($galleries);
    }


    public function store(GalleryRequest $request)
    {


        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->user_id = Auth::user()->id;


        $gallery->save();

        $imgs = [];
        foreach ($request->images as $img) {
            $imgs[] = new Image($img);
        }
        $gallery->images()->saveMany($imgs);

        return response()->json($gallery);
    }

    public function update(GalleryRequest $request, $id)
    {
        $gallery = Gallery::find($id);
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        $gallery->user_id = Auth::user()->id;
        $gallery->save();

        $gallery->images()->delete();
        $imgs = [];
        foreach (request('images') as $img) {
            $imgs[] = new Image($img);
        }
        $gallery->images()->saveMany($imgs);

        return response()->json($gallery->id);
    }




    public function show(Request $request, $id)
    {
        $gallery = Gallery::with(['images', 'author', 'comments'])->find($id);

        if (!$gallery) {
            return response()->json(['error' => 'Gallery not found.'], 404);
        }

        $page = $request->query('page', 1);


        $perPage = 5;
        $comments = $gallery->comments()->paginate($perPage, ['*'], 'page', $page);

        $response = [
            'gallery' => $gallery,
            'comments' => $comments,
        ];

        return response()->json($response);
    }





    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        $gallery->delete();

        return response()->json([
            'message' => 'Deleted'
        ]);
    }


    public function getAuthorGallery($id)
    {
        $author_galleries = Gallery::where('user_id', $id)
            ->with('images', 'author')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($author_galleries);
    }
}
