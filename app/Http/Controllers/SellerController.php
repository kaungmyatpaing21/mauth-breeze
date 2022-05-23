<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    public function Index(){
        return view('seller.seller_login');
    }

    public function SellerDashboard(){
        return view('seller.index');
    }

    public function SellerLogin(Request $req){
        
        $check = $req->all();

        if(Auth::guard('seller')->attempt(['email' => $check['email'], 'password' => $check['password']])){
            return redirect()->route('seller.dashboard')->with('message', 'Seller Login Successfully.');
        }

        return back()->with('message', 'Invalid Credentials.');
    }

    public function SellerLogout(){
        Auth::guard('seller')->logout();

        return redirect()->route('seller_login_form')->with('message', 'Seller Logout Successfully.');
    }

    public function SellerRegister(){
        return view('seller.seller_register');
    }

    public function SellerRegisterCreate(Request $req){
        
        Seller::insert([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('seller_login_form')->with('message', 'Seller Create Successfully.');

    }
}
