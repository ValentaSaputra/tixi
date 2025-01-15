<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    function tampilRegisterasi() {
        return view('registerasi');
    }
    
    function submitRegisterasi(Request $request) {
        $existingUser = User::where('email', $request->email)->first();
    
    if ($existingUser) {
        return redirect()->back()
            ->withInput()
            ->with('email_error', 'Email sudah terdaftar');
    }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        // dd($user);
        return redirect()->route('login');
    }

    function tampilLogin() {
        return view('login');
    }

    function submitLogin(Request $request) {
        $data = $request->only('email', 'password');

        if(Auth::attempt($data)) {
            $request->session()->regenerate();
            return redirect()->route('front.index');
        } else {
            return redirect()->back()->with('gagal', 'Email atau password anda salah');
        }
    }

    function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

}
