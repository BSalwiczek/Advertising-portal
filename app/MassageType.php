<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MassageType extends Model
{
	public function masseurpost(){
		return $this->belongsTo('App\MasseurPost');
	}
}
