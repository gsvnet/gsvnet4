<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\UsersController;

class AdminController extends Controller 
{
    public function index()
    {
        return view('admin.index');
    }

    public function redirectToMyProfile(Request $request)
    {
        return redirect()->action([UsersController::class, 'show'], ['gebruiker' => $request->user()->id]);
    }
}