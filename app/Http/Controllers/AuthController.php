<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class AuthController extends Controller
{
   

   
    public function create()
    {
        return view('auth.create');
    }

   
    public function store(Request $request)
    {
         //  Validate the request
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
    ]);

    //  Create the user
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    

    return redirect()->route('auth.login')->with('success', 'Account created successfully.');
    }

    

    public function login()
    {
      return view('auth.login');   
    }


    public function loginValidate(Request $request)
    {
$request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            return redirect()->intended('/');
        } else {
            return redirect()->back()
                ->with('error', 'Invalid credentials');
        }
    }
   
    public function destroy()
    {
        Auth::logout();
 
         request()->session()->invalidate();
         request()->session()->regenerateToken();
 
         return redirect('/');
    }
}
