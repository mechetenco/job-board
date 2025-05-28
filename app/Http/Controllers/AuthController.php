<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
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
   


    public function forgot()
    {
        return view('auth.forgot');
    }

    public function forgotPassword(Request $request)
    {
 $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))->with('success', 'Password reset Link Sent Successfully.')
        : back()->withErrors(['email' => __($status)]);
    }


    public function showResetForm(Request $request, $token)
{
    return view('auth.reset', [
        'token' => $token,
        'email' => $request->email
    ]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
                'remember_token' => Str::random(60),
            ])->save();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('auth.login')->with('success', 'Password reset successful.')
        : back()->withErrors(['email' => [__($status)]]);
}

    public function destroy()
    {
        Auth::logout();
 
         request()->session()->invalidate();
         request()->session()->regenerateToken();
 
         return redirect('/');
    }
}
