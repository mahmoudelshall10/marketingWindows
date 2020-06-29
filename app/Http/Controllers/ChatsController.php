<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use Pusher\Pusher;
use Illuminate\Support\Facades\DB;

class ChatsController extends Controller
{

public function __construct()
{
  $this->middleware('auth');
  // $this->middleware('auth:instructor');
}

/**
 * Show chats
 *
 * @return \Illuminate\Http\Response
 */

public function index()
{
  // $users = User::where('id' ,'!=',Auth::id())->get();

  // count how many message are unread from the selected user
  $users = DB::select("select users.id, users.name, users.avatar, users.email, count(is_read) as unread 
  from users LEFT  JOIN  messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
  where users.id != " . Auth::id() . " 
  group by users.id, users.name, users.avatar, users.email");

  return view('chat',compact('users'));
}

/**
 * Fetch all messages
 *
 * @return Message
 */
public function fetchMessages($user_id)
{
    $my_id = Auth::id();
    //getting all message for selected user
            // Make read all unread message
    Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);
    //gettting those message which is from = Auth::id() and to = user_id OR from = user_id and to = Auth::id()
    $messages = Message::where(function($query) use ($user_id,$my_id){
      $query->where('from',$my_id)->where('to',$user_id);
    })->orWhere(function($query) use ($user_id,$my_id){
      $query->where('from',$user_id)->where('to',$my_id);
    })->get(); 
    return view('messages.message', compact('messages'));
}

/**
 * Persist message to database
 *
 * @param  Request $request
 * @return Response
 */
public function sendMessage(Request $request)
{
    
  $from = Auth::id();
  $to = $request->receiver_id;
  $message = $request->message;

  $data = new Message;
  $data->from = $from;
  $data->to = $to;
  $data->message = $message;
  $data->is_read = 0;

  $data->save();

  $options = array(
    'cluster' => 'eu',
    'useTLS' => true
  );
  $pusher = new Pusher(
    env('PUSHER_APP_KEY'),
    env('PUSHER_APP_SECRET'),
    env('PUSHER_APP_ID'),
    $options
);

  $data = ['from' => $from, 'to' => $to]; // sending from and to user id when pressed enter
  $pusher->trigger('my-channel', 'my-event', $data);

  // broadcast(new MessageSent($user, $message))->toOthers();

  // return ['status' => 'Message Sent!'];



}
}
