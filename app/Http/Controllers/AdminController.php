<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function Index(){
        return view('admin.admin_login');
    }

    public function Dashboard(){
        return view('admin.index');
    }

    public function Login(Request $req){
        
        $check = $req->all();

        if(Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password']])){
            return redirect()->route('admin.dashboard')->with('message', 'Admin Login Successfully.');
        }

        return back()->with('message', 'Invalid Credentials.');
    }

    public function AdminLogout(){

        Auth::guard('admin')->logout();

        return redirect()->route('login_form')->with('message', 'Admin Logout Successfully.');
    }

    public function AdminRegister(){
        return view('admin.admin_register');
    }

    public function AdminRegisterCreate(Request $req){
        
        Admin::insert([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('login_form')->with('message', 'Admin Create Successfully.');

    }
}
