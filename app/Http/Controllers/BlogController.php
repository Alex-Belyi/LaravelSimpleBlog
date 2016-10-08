<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
class BlogController extends Controller
{
    public function getIndex(){
     $posts = Post::paginate(5);

        return response()->view('blog.index', compact('posts'));

    }

    public function getSingle($slug){

        //fetch from db based on slug
        $post = Post::where('slug', '=', $slug)->first();  // get changed to first for speedup because the slug is unique

        // return the view and pass in the post  object
        return response()->view('blog.single', compact('post'));
//return $slug;
    }
}
