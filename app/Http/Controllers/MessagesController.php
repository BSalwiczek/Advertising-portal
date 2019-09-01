<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Auth;
use DB;
use App\Events\NewMessage;

class MessagesController extends Controller
{
    public function store(Request $request){
      $data = $this->validate($request,[
        'message'=>'max:255|required',
        'receiver_id'=>'required|numeric',
      ]);

      $message = new Message();
      $message->sender_id = Auth::id();
      $message->receiver_id = $data['receiver_id'];
      $message->message = $data['message'];
      $message->seen_at = null;
      $message->save();
      broadcast(new NewMessage($message->message,$message->sender_id,$message->receiver_id,date("Y-m-d H:i:s")))->toOthers();

      return $data;
    }

    public function index(Request $request){
      $data = $this->validate($request,[
        'friend_id'=>'required|numeric',
      ]);

      $your_messages = Message::where('sender_id',Auth::id())->where('receiver_id',$data['friend_id'])->get();
      $friend_messages = Message::where('receiver_id',Auth::id())->where('sender_id',$data['friend_id'])->get();

      $all_messages = $your_messages->merge($friend_messages);

      return $all_messages;
    }

    public function getFriends(){
      $user_id = Auth::id();
      // dd($user_id);
      // $msg1 = DB::table('messages')->join('users', 'users.id', '=', 'messages.sender_id')->groupBy('sender_id')->having('receiver_id',$user_id)->get();
      // $msg2 = DB::table('messages')->join('users', 'users.id', '=', 'messages.receiver_id')->groupBy('receiver_id')->having('sender_id',$user_id)->get();

      $msg1 = DB::table('messages')->join('users', 'users.id', '=', 'messages.sender_id')->where('receiver_id',$user_id)->orderBy('msg_created','desc')->groupBy('sender_id')->get();
      $msg2 = DB::table('messages')->join('users', 'users.id', '=', 'messages.receiver_id')->where('sender_id',$user_id)->orderBy('msg_created','desc')->groupBy('receiver_id')->get();


      $allmsg = $msg1->merge($msg2);

      // dd($allmsg);

      $response = array();
      foreach ($allmsg as $key => $msg) {
        if(empty($response))
        {
          array_push($response,[
            'name' => $msg->name,
            'surname' => $msg->surname,
            'receiver_id' => $msg->receiver_id,
            'sender_id' => $msg->sender_id,
            'message' => $msg->message,
            'msg_created' => $msg->msg_created,
            'profile_img' =>$msg->profile_img
          ]);
        }else{
          $addthismessage = true;
          foreach ($response as $key1 => $value) {
            if($msg->receiver_id == $value['sender_id'] and $msg->sender_id == $value['receiver_id'])
            {
              $addthismessage = false;
              // echo $msg->msg_created;
              // echo " ";
              // echo $msg->message;
              // echo " ";
              // echo $value['msg_created'];
              // echo " ";
              // echo $value['message'];
              // echo "\n";
              if($msg->msg_created >= $value['msg_created'])
              {

                $response[$key1] = [
                  'name' => $msg->name,
                  'surname' => $msg->surname,
                  'receiver_id' => $msg->receiver_id,
                  'sender_id' => $msg->sender_id,
                  'message' => $msg->message,
                  'msg_created' => $msg->msg_created,
                  'profile_img' =>$msg->profile_img
                ];
                break;
              }

            }
          }
          if ($addthismessage)
          {
            array_push($response,[
              'name' => $msg->name,
              'surname' => $msg->surname,
              'receiver_id' => $msg->receiver_id,
              'sender_id' => $msg->sender_id,
              'message' => $msg->message,
              'msg_created' => $msg->msg_created,
              'profile_img' =>$msg->profile_img
            ]);
          }
        }
      }

    // print_r($response);
    // dd($response);
      return  $response;

    }
}
