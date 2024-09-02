<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\Exam;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    //
    public function loadRegister()
    {

        if (Auth::user() && Auth::user()->is_admin == 1) {
            return redirect('/admin/dashboard');
        } elseif (Auth::user() && Auth::user()->is_admin == 0) {
            return redirect('/dashboard');
        }

        return view('register');
    }

    public function studentRegister(Request $request)
    {
        $request->validate([
            'name' => 'string|required|min:2',
            'email' => 'string|email|required|max:100|unique:users',
            'password' => 'string|required|confirmed|min:6'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Your Registeration has been successful');
    }

    public function loadLogin()
    {
        if (Auth::user() && Auth::user()->is_admin == 1) {
            return redirect('/admin/dashboard');
        } elseif (Auth::user() && Auth::user()->is_admin == 0) {
            return redirect('/dashboard');
        }
        return view('login');
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $userCredential = $request->only('email', 'password');
        if (Auth::attempt($userCredential)) {
            if (Auth::user()->is_admin == 1) {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/dashboard');
            }
        } else {
            return back()->with('error', 'Email or Password is incorrect');
        }
    }

    public function loadDashboard()
    {
        $exams = Exam::with('subjects')->orderBy('date')->get();
        return view('student.dashboard', ['exams' => $exams]);
    }

    public function adminDashboard()
    {
        $subjects = Subject::all();
        return view('admin.dashboard', compact('subjects'));
    }


    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/login');
    }

    public function forgetPasswordLoad()
    {
        return view('forget-password');
    }

    public function forgetPassword(Request $request)
    {
        try {

            $user = User::where('email', $request->email)->get();

            if (count($user) > 0) {

                $token = Str::random(60);
                $domain = URL::to('/');

                $url = $domain . '/reset-password?token=' . $token;

                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = 'Password Reset Request | Action Required';
                $data['body'] = 'Please click on below link to reset your password.';
                $data['ignore'] = 'Ignore if it is not you';

                Mail::send('forgetPasswordMail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                $dateTime = Carbon::now()->format('Y-m-d H:i:s');

                PasswordReset::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $dateTime
                    ]
                );

                return back()->with('success', 'Please check your mail to reset your password!');
            } else {
                return back()->with('error', 'Email is not exists!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function resetPasswordLoad(Request $request)
    {
        $passwordResetData = PasswordReset::where('token', $request->token)->first();

        if (isset($request->token) && !empty($passwordResetData)) {

            $userData = User::where('email', $passwordResetData['email'])->first();
            $user = $userData['id'];

            return view('resetPassword', compact('user'));
        } else {
            return view('404');
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::find($request->id);

        $user->password = Hash::make($request->password);
        $user->save();
        PasswordReset::where('email', $user->email)->delete();

        return "<h2>Your password has been reset successfully.</h2>";
    }
}
