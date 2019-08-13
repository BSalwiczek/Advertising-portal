<?php

namespace App;

use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;

class MasseurPost extends Model
{
	use EloquentJoin;
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function massagetypes()
    {
    	return $this->hasMany('App\MassageType');
    }
}
