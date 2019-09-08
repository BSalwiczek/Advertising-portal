<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $sender_id;
    public $receiver_id;
    public $msg_created;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message,$sender_id,$receiver_id,$msg_created)
    {
      $this->message = $message;
      $this->sender_id = $sender_id;
      $this->receiver_id = $receiver_id;
      $this->msg_created = $msg_created;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
      if($this->sender_id<$this->receiver_id){
          return new PresenceChannel('newmsg.'.$this->sender_id.'.'.$this->receiver_id);
      }
      else {
          return new PresenceChannel('newmsg.'.$this->receiver_id.'.'.$this->sender_id);
      }
    }
}
