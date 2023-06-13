<?php

namespace App\Http\Controllers\Api;


use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Support\Facades\Variabel;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(5);
        return new PostResource(true, 'list data Posts', $posts);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'     => 'required',
            'content'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // mengecek variabel tersebut berfungsi apa
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // untuk mengupload
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());


        //untuk menambahkan post
        $post = Post::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'content'   => $request->content,
        ]);


        //return response
        return new PostResource(true, 'Data Post Berhasil Ditambahkan!', $post);
    }
}
