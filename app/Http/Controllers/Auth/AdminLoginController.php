<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAdminRequest;

use Auth;


class AdminLoginController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout', 'adminLogout');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {

        //validate the form

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // if successful, then redirect to their intended location
            return redirect('/admin');
        }

        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));

    }

//function to register admin
    public function createAdmin()
    {

        return view('auth.admin_register')->with('title', "Register Admin");

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function storeAdmin(CreateAdminRequest $request)
    {

        //$input=$request->all();

        $input = ([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        //insert the data in the Clients table

        $data = Admin::create(array_merge($input, ['role' => 'admin']));
        User::create($input);
        Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember);
        //redirect to user page
        return redirect('/admin');
    }


    public function users()
    {
        $doctor = DB::table('doctor')->get();
        $data = [
            'role' => 'doctor',//role is admin becase the admin can view all the doctors
            'title' => 'Doctors'
        ];

        return view('admin.users', compact('doctor'))->with($data);
    }


    //logout

    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return view('welcome');
    }


}
