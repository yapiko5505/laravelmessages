<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index() {
        $users = User::all();
        return view('profile.index', compact('users'));
    }
}
