<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Affiliate extends Model
{


	/**
	 * Get the author.
	 *
	 * @return User
	 */
	public function infusionsoft_user()
	{
		return $this->belongsTo('App\UserInfusionsoft', 'user_is_id');
	}

}
