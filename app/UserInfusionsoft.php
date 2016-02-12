<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class UserInfusionsoft extends Model
{

	protected $table = "users_infusionsoft";


	/**
	 * Get the author.
	 *
	 * @return User
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

}
