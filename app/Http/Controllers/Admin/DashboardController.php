<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\User;

class DashboardController extends AdminController {

    public function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
        $title = "Dashboard";

        $users = User::count();
		return view('admin.dashboard.index',  compact('title', 'users'));
	}
}