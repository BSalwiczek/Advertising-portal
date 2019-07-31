<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasseurPost extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function massagetypes()
    {
    	return $this->hasMany('App\MassageType');
    }
}
