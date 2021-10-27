<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use App\Models\User;

class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) {
            //Login Success
            return redirect()->route('home');
        }
        return view('auth/login');
    }

    public function login(Request $request)
    {   
        // Validations
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];
        $messages = [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
        
        $fieldType = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $data = [
            $fieldType => $request->input('username'),
            'password' => $request->input('password'),
        ];
  
        Auth::attempt($data); 
        if (Auth::check()) {
            //Login Success
            return redirect()->route('home');
        } else {
            //Login Fail
            Session::flash('error', 'Username atau password salah');
            return redirect("/");
        }
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect("/");
    }
}