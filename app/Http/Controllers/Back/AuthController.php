<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function login()
    {
        return view('back.auth.login');
    }

    public function loginPost(Request $request)
    {
        if ($request->isMethod('post')) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                auth()->login(Auth::user(), true);
                toastr()->success('You have been logged in successfully! ' . Auth::user()->name);
                if (Auth::user()->role == 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                if (Auth::user()->role == 'moderator') {
                    return redirect()->route('moderator.dashboard');
                }
                if (Auth::user()->role == 'user') {
                    return redirect()->route('homepage');
                }
                if (Auth::user()->role == 'creator') {
                    return redirect()->route('creator.dashboard');
                }
            } else {
                toastr()->error('Email or password is incorrect!');
                return redirect()->route('login');
            }
        }
    }

    public function register()
    {
        return view('back.auth.register');
    }

    public function registerPost(Request $request)
    {
        // Yeni kullanıcı oluşturulurken kullanılacak olan validation kuralları
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // E-posta adresi zaten kullanılıyor mu kontrol et
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return redirect()->route('register')->with('error', 'Email already exists!');
        }

        // Kullanıcıyı oluştur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);
        // Kullanıcıyı oturum açık olarak işaretle ve anasayfaya yönlendir
        auth()->login($user, true);
        toastr()->success('You have been registered successfully! ' . Auth::user()->name);
        return redirect()->route('homepage');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login')->with('success', 'You have been logged out!');
    }
}
