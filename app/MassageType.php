<?php

namespace App;

use Fico7489\Laravel\EloquentJoin\Traits\EloquentJoin;
use Illuminate\Database\Eloquent\Model;

class MassageType extends Model
{
	use EloquentJoin;
	public function masseurpost(){
		return $this->belongsTo('App\MasseurPost');
	}
	public function masseur_post_with_price_beetwen($min,$max){

	}
}
