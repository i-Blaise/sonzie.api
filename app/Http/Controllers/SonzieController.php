<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \stdClass;
use App\Comment;
use App\Avatar;
use App\Contactus;

class SonzieController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
     {
     
    //    $products = Product::all();
        $comment = DB::table('comment')->get();
        // $object = (object) $comment;
        // return response()->json($object);

        $object = new stdClass();
        foreach ($comment as $key => $value)
        {
            $object->$key = $value;
        }
        return response()->json($object);
     }

     public function countComment($id)
     {
         $commentNum = DB::table('comment')->where('portfolio_id', $id)->count();
         return response()->json($commentNum);
     }

     public function fetchComment($id)
     {
         $port_comment = DB::table('comment')->where('portfolio_id', $id)->get();
         return response()->json($port_comment);
     }

     public function fetchPortfolio()
     {
         $portfolio = DB::table('portfolio')->get();
         return response()->json($portfolio);
     }
     public function fetchSinglePortfolio($id)
     {
         $single_portfolio = DB::table('portfolio')->where('id', $id)->first();
         return response()->json($single_portfolio);
     }

     public function createComment(Request $request)
     {
       
        $submit = $request->api_submit;

       if(!empty($submit) && $submit == "Post Comment")
       {

        $comment = new Comment;
        // $avatar = new Avatar;

        $avatar_id = rand(1,10);
        $avatar = Avatar::select('image')->where('id', $avatar_id)->first();

        $portfolio_id = $request->portfolio_id;

       $comment->name= $request->name;
       $comment->email = $request->email;
       $comment->company= $request->company;
       $comment->comment = $request->comment;
       $comment->avatar = $avatar->image;
       $comment->portfolio_id = $portfolio_id;
       
       if($comment->save()){
        // return response()->json(['status' => 'Success', 'message' => 'Saved']);
        return redirect('http://localhost/sonzie/single.php?id='.$portfolio_id.'&status=comment_saved');

       }else{
        return response()->json(['status' => 'failed', 'message' => 'Could not Save']);
       }
    }else{
        return response()->json(['status' => 'failed', 'message' => 'Could not Submit']);
       }
    //    return response()->json($comment);

     }


     public function contactUs(Request $request)
     {
        $contact_msg = new Contactus;

        $submit= $request->api_submit;

        if(!empty($submit) && $submit == "Send Message")
       {
        $contact_msg->name= $request->name;
        $contact_msg->email= $request->email;
        $contact_msg->subject= $request->subject;
        $contact_msg->message= $request->message;
        if($contact_msg->save()){
            // return response()->json(['status' => 'Success', 'message' => 'Message Sent']);
            return redirect('http://localhost/sonzie/contact_logic.php?status=comment_saved');
           }else{
            return response()->json(['status' => 'failed', 'message' => 'Could not send message']);
           }
        }else{
            return response()->json(['status' => 'failed', 'message' => 'Not submitted']);
           }
     }


     public function getLatestContact()
     {
        $contacts = Contactus::latest('created_at')->first();
        if($contacts){
            return response()->json(['status' => 'Success', 'message' => 'Message Sent', 'data' => $contacts]);
           }else{
            return response()->json(['status' => 'failed', 'message' => 'Could not retrieve data']);
           }
     }
}
