<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginRegisterController extends Controller
{
    public $data = [];

    private $user;


    public function __construct()
    {
        $this->user = new User();
    }
    public function admin_logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin_login');
    } 
    public function admin_login(Request $request){
        $this->data['title'] = 'Đăng nhập trang quản trị';
        return view("auth.admin_login", $this->data);
    }
    public function postadmin_login(Request $request)
    {
        $data = [
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(Auth::attempt($data)){
            return redirect(route('admin.home'));
        }
        return redirect(route('admin_login'))->with('msgErr', 'Thất bại');
    }

    ////

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('dangnhap');
    } 
    public function login(Request $request){
        $this->data['title'] = 'Đăng nhập';
        $this->data['url'] = 'dangnhap';
        return view("user.dangnhap", $this->data);
    }
    public function post_login(Request $request)
    {
        $data = [
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(Auth::attempt($data)){
            return redirect(route('home'))->with('msgDnSuc', 'Thành công');
        }
        return redirect(route('dangnhap'))->with('msgDnErr', 'Thất bại');
    }

    
}
