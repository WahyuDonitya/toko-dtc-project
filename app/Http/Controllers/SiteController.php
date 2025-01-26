<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function dologin(Request $request)
    {
        $request->validate(
            [
                "user_name" => 'required',
                "password" => 'required',
            ],
            [
                'user_name.required' =>  'Username Tidak Boleh Kosong',
                'password.required' => 'Password Tidak Boleh Kosong',
            ]
        );

        $credential = [
            'user_name' => $request->user_name,
            'password' => $request->password,
        ];
        try {
            if (Auth::attempt($credential)) {
                if (Auth::user()->hasRole('admin')) {
                    return redirect()->intended('dashboard');
                } else {
                    return redirect()->intended('dashboard');
                }
            } else {
                // Pengguna gagal masuk
                return redirect()->back()->with('danger', 'Username / Password Salah !');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', 'Terjadi Kesalahan');
        }
    }
}
