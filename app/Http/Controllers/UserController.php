<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function userSettings()
    {
        $user = User::whereId(Auth::id())->get();
        return view('userSettings', ['user' => $user->first()]);
    }
    
    public function changeImap(Request $request)
    {
        $request->except('_token');
        $user = User::whereId(Auth::id())->update($request->except('_token'));
        return redirect()->back()->with('message', 'IMAP data saved correctly');
    }
}
