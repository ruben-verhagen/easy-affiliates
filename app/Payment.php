<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Payment extends Model
{


	/**
	 * Get the author.
	 *
	 * @return User
	 */
	public function affiliate()
	{
		return $this->belongsTo('App\Affiliate');
	}

}
