<?php

namespace App\Http\Controllers\Auth;

use App\Doctor;
use App\User;
use App\Model\DoctorDetail;
use App\Http\Requests\CreateDoctorRequest;
use App\Http\Requests\UpdateCredentialsRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;


class DoctorLoginController extends Controller
{
    //

    public function __construct()
    {

        $this->middleware('guest:doctor')->except('logout', 'doctorLogout','passwordChangeForm','storeChangePassword');

    }

    public function showLoginForm()
    {

        return view('auth.doctor-login');

    }

    public function login(Request $request)
    {

        //validate the form

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Attempt to log the user in
        if (Auth::guard('doctor')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // if successful, then redirect to their intended location

            return redirect('/doctor');
        }

        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));

    }

    //logout

    public function doctorLogout()
    {
        Auth::guard('doctor')->logout();
        return view('welcome');
    }



    //register doctor


    //function to register doctor
    public function createDoctor()
    {

        return view('auth.doctor_register')->with('title', "Register Doctor");

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function storeDoctor(CreateDoctorRequest $request)
    {
        //$input=$request->all();
        $input = ([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        //User::create($input);
        $data = Doctor::create(array_merge($input, ['role' => 'doctor']));
        // Auth::guard('doctor')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember);
        //redirect to user page
        return redirect('admin/userList')->with('status', 'Doctor is added successfully');
    }
    //reset password form
    public function passwordChangeForm(){
        $patient=Doctor::find(auth::guard('doctor')->id());
        return view('auth.resetPasswordDoctor',compact('patient'));
    }

    public function storeChangePassword(UpdateCredentialsRequest $request){
        $doctor=Doctor::find(auth::guard('doctor')->id());
        $doctor['password'] = bcrypt($request['password']);
        $doctor->save();
        $request->session()->flash('alert-success', 'Password changed successfully!');
        return redirect('/doctor');
    }


}
