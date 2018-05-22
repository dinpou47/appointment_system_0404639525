<?php

namespace App\Http\Controllers\Auth;

use App\Patient;
use App\User;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdateCredentialsRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Session;


class PatientLoginController extends Controller
{
    //

    public function __construct()
    {

        $this->middleware('guest:patient')->except('patientLogout','passwordChangeForm','storeChangePassword');

    }

    public function showLoginForm()
    {

        return view('auth.patient_login');

    }

    public function login(Request $request)
    {

        //validate the form

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        // Attempt to log the user in
        if (Auth::guard('patient')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // if successful, then redirect to their intended location
            return redirect('/patient');
        }

        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    //logout

    public function patientLogout()
    {
        Auth::guard('patient')->logout();
        return view('welcome');
    }



    //register doctor


    //function to register patient
    public function createPatient()
    {

        return view('auth.patient_register')->with('title', "Register Patient");

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function storePatient(CreatePatientRequest $request)
    {

        //$input=$request->all();
        $input = ([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);

        //insert the data in the Clients table
        $data = Patient::create(array_merge($input, ['role' => 'patient']));
        Auth::guard('patient')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember);
        //redirect to user page
        return view('home');
    }

    public function passwordChangeForm(){
        $patient=Patient::find(auth::guard('patient')->id());
        return view('auth.resetPassword',compact('patient'));
    }

    public function storeChangePassword(UpdateCredentialsRequest $request){
        $patient=Patient::find(auth::guard('patient')->id());
        $patient['password'] = bcrypt($request['password']);
        $patient->save();
        $request->session()->flash('alert-success', 'Password changed successfully!');
        return redirect('/patient');
    }

}
