<?php
namespace App\Http\Controllers;  // задаем рамки нахождения
//use App\Http\Requests\Request;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use App\Post;
use Mail;

class PagesController extends Controller{

    public function getIndex() {
        $posts = Post::orderBy ('created_at', 'desc')->limit(4)->get();    // з.д.е.с.ь не нужно писать DB:table  т.к модель Post уже использует таблицу постов
       return response()->view('pages.welcome', compact('posts'));         //query builder

     //return view('pages.welcome')->withPosts($posts); // не правильно
        #process variable data or params
        #talk ro the model
        #recieve from the model
        #compile or process data from the model if needed
        #pass that data to the correct view
    }

    public function getAbout() {
        $fname = 'Oleksa';
        $lname = 'Mesnik';
        $email = 'sashabelyi93@gmail.com';
        $fullname = $fname . " " . $lname;
        $data =[];
        $data['email'] = $email;   //[] seems array in php?
        $data['fullname'] = $fullname;

        #different ways to return data

        /*$full = $fname . " " . $lname;
        return view('pages.about')->with("fullname", $full);  // В view выводим $fullname уже  а не $full
        */
        /*$fullname = $fname . " " . $lname;
        return view('pages.about')->with("fullname", $fullname);*/

        ;

        //return view('pages.about')->withFullname($fullname)->withEmail($email);
        return view('pages.about')->withData($data);

    }

    public function getContact() {
        return view('pages.contact');
    }

    public function postContact(Request $request) {
    $this->validate($request,
        ['email' => 'required|email',
        'subject' => 'min:3',
        'message' => 'min:10']);

        $data = array(
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message
        );

        Mail::send('emails.contact', $data, function($message) use ($data){
            $message->from($data ['email']);
            $message->to('sashabelyi93@gmail.com');
            $message->subject($data['subject']);

        });

        Session::flash('success', 'Your email was sent!');

        return redirect('/');
    }


}