<?php
namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use Mews\Purifier\Facades\Purifier;
use Session;


// todo: запилить комментарии

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth'); //allows only auth users to accsess
    }

    public function index()
    {

        //$posts = Post::all();
          $posts = Post::orderBy('id', 'desc')-> paginate(10);
        // неправильно
        //return view('posts.index')->withPosts($posts);

        // правильно, надо возвращать именно объект респонс, а не просто вьюху, хотя могу ошибаться,
        // если Лара сама обрабатывает :(
        return response()->view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags= Tag::all();
        return response()->view('posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate the data

     //   dd($request) ;   //laravel command dump
        $this->validate($request, array(
            'title' => 'required|max:255',
            'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',   //unique table,column
            'category_id' => 'required|integer',
            'body'  => 'required'
        ));
        //store in DB
        $post = new Post();
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = Purifier::clean( $request->body);
//        purifier

        $post->save();

        // нужно делать после сохранения
        $post->tags()->sync($request->tags, false);  //т.у.т false что бы не перезаписовать связи ?

        Session::flash('success', 'The blog post was successfully save');  //can use put instead of flash

        //redirect to another page.

        // вот как тут! только вместо редиректа респонс надо делать
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        // не правильно
       //  return view('posts.show')->withPost($post);

        //  правильно
        //return response()->view('posts.show', array('post' => $post));

        //  или еще лучше
        return response()->view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $categories = Category::all()->lists('name', 'id');

        $tags = Tag::lists('name', 'id');
        /*$tags = Tag::all();
        $tags2 = array();
        foreach ($tags as $tag) {
            $tags2[$tag->id] = $tag->name;

        } */

        //return view('posts.edit')->withPost($post);
        return response()->view('posts.edit', compact('post', 'categories', 'tags')); // вторая вьюха!?
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //validate the data
        $post = Post::find($id);
        if ($request->input('slug') == $post->slug ) {
            $this->validate($request, array(
                'title' => 'required|max:255',
                'category_id' => 'required|integer',
                'body'  => 'required'

            ));

        }

        else {

        $this->validate($request, array(
            'title' => 'required|max:255',
            'slug'  => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            'category_id' => 'required|integer',
            'body'  => 'required'
             ));
        }
        //save the data to the db

        $post = Post::find($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body = Purifier::clean($request->input('body'));

        $post->save();

        if (isset($request->tags)) {
            $post->tags()->sync($request->tags); // тут если было 3 тега, а 1 удалили потому второй параметр
            // второй параметр false не нужен. здесь строка типо перезаписывается полностью на деле sync-ом,
            // а не удаляется  1 тег
        } else{

            $post->tags()->sync(array());   // если нет тего  то записать пустую строку =удаляет связи в post_tag таблице
        }

        //set flash with success message
        Session::flash('success', 'Great! This post was successfully saved.');

        //redirect with flash data to posts.show
        return response()->view('posts.show', compact('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $post = Post::find($id);
        $post->tags()->detach(); //разорвать отношение  (удалить строку)в таблице post_tag если оно есть

        $post->delete();

        Session::flash('success', 'Blog post was successfully deleted.');
        return redirect()-> route('posts.index');


    }
}
