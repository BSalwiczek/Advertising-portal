<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('newmsg.{id1}.{id2}',function($user,$id1,$id2){
  if((int) $user->id === (int) $id1 or (int) $user->id === (int) $id2)
  {
    return ['id'=>$user->id];
  }
});
