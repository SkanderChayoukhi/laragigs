<?php

namespace App\Http\Controllers;

// use App\Mail\ConfirmEmail;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
// use App\Mail\VerifyEmail;
// use App\Mail\ConfirmEmail;
use App\Mail\EmailVerificatioMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Mail as FacadesMail;

// use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    //Show Register/Create Form
    public function create()
    {
        return view('users.register');
    }
    //Create New User 
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            // 'password' => ['required', 'confirmed', 'min:6']  shiha ama autrement :
            'password' => 'required|confirmed|min:6'
        ]);
        //Hash Password 
        $formFields['password'] = bcrypt($formFields['password']);

        $formFields['verification_token'] = bin2hex(random_bytes(20));

        //Create User And Log In automatically

        //Create User 
        $user = User::create($formFields);

        Mail::to($user->email)->send(new EmailVerificatioMail($user));






        // // Generate verification token
        // $token = uniqid();

        // // Store token in user record
        // $user->email_verification_token = $token;
        // $user->save();
        // //Send Confirmation Email
        // Mail::to($user->email)->send(new ConfirmEmail($user, $token));

        // return redirect('/')->with('message', 'User created. Please check your email for confirmation link.');

        // Send verification email
        // Mail::to($user->email)->send(new ConfirmEmail($user));

        // Send the verification email
        // Mail::to($user->email)->send(new VerifyEmail($user));

        // auth()->login($user);

        // // Redirect to login page with a success message
        // return redirect('/login')->with('message', 'User created. Please check your email to activate your account.');




        // // Login
        // auth()->login($user);
        // return redirect('/')->with('message', 'User created and logged in');

        return redirect('/')->with('message', 'User created. Please check your email for confirmation link.');
    }

    // //Confirm Email
    // public function confirmEmail($token)
    // {
    //     $user = User::where('verification_token', $token)->firstOrFail();

    //     //Update User Record
    //     $user->email_verified_at = now();
    //     $user->verification_token = null;
    //     $user->save();

    //     //Login User
    //     auth()->login($user);

    //     return redirect('/')->with('message', 'Email confirmed. You are now logged in!');
    // }

    public function verify_email($verification_code)
    {
        $user = User::where('verification_token', $verification_code)->firstOrFail();
        if (!$user) {
            return redirect('/register')->with('message', 'Invalid URL');
        } else {
            if ($user->email_verified_at) {
                return redirect('/register')->with('message', 'Email already verified');
            } else {
                $user->update([
                    'email_verified_at' => Carbon::now()
                ]);
                // return redirect('/register')->with('message', 'Email successfully verified');
                auth()->login($user);
                return redirect('/')->with('message', 'Email confirmed. You are now logged in!');
            }
        }
    }


    //Logout User 
    public function logout(Request $request)
    {
        auth()->logout(); // remove the user's authentification
        // invalidate the user's session
        $request->session()->invalidate();

        //regenerate the user's token 
        $request->session()->regenerateToken();
        //redirect to home page with a flash message 
        return redirect('/')->with('message', 'You have been logged out');
    }

    //Show Login Form  
    public function login()
    {
        return view('users.login');
    }
    //Authenticate User 
    public function authenticate(Request $request)
    {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            // 'password' => ['required', 'confirmed', 'min:6']  shiha ama autrement :
            'password' => 'required'
        ]);
        // if (auth()->attempt($formFields) && auth()->user()->email_verified_at) {
        //     //generate a session's id 
        //     $request->session()->regenerate();
        //     return redirect('/')->with('message', 'You are now logged in!');
        // }
        // // else {
        // //     Auth::logout();
        // //     return redirect('/login')->with('message', 'Please check your email to activate your account.');
        // // }
        // return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
        if (!auth()->attempt($formFields)) {
            return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
        } else {
            if (!auth()->user()->email_verified_at) {
                Auth::logout();
                return redirect('/login')->with('message', 'Please check your email to activate your account.');
            } else {
                // generate a session's id 
                $request->session()->regenerate();
                return redirect('/')->with('message', 'You are now logged in!');
            }
        }
    }
}
