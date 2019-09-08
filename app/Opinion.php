<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
  protected  $primaryKey = 'id';
  public function masseurpost(){
    return $this->belongsTo('App\MasseurPost');
  }
  public function user(){
    return $this->belongsTo('App\User');
  }
}
