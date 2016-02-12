<?php namespace App\Http\Controllers;

use App\Affiliate;
use Illuminate\Database\Eloquent;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class FileController extends Controller {

    /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Show the affiliate dashboard to the user.
	 *
	 * @return Response
	 */
	public function downloadW9(Request $request, $affiliate_id)
	{

        $affiliate_row = Affiliate::where('id', '=', $affiliate_id)->first();
        if ($affiliate_row == null) {
            abort(404, "No affiliate");
        }
        if (!$affiliate_row->w9_file) {
            abort(404, "No W9 file.");
        }

        $file = Storage::disk('local')->get($affiliate_row->w9_file);
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition: attachment; filename=' => $affiliate_row->w9_file_original_name
        ];

        return (new Response($file, 200, $headers));

    }

}