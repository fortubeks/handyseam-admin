<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        //this returns all the registered users sorted by the latest, get only the users that have a foreign key record in settings table
        $users = User::latest()->withCount('orders')->whereHas('appSetting')->get();
        $title = 'All Users';
        return view('material.users.index', compact('users', 'title'));
    }
}
