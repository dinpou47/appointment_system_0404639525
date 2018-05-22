<?php

namespace App\Providers;

namespace App\Http\Controllers\Patient;

use App\Http\Controllers;
use App\Notification;
use App\PatientDetail;
use App\Appointment;
use App\AppointmentSchedule;
use App\Patient;
use App\Http\Requests;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\CreatePatientAddRequest;
use http\Env\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

use Carbon\Carbon;


class PatientController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:patient')->except('editPatientDetail','updatePatientDetail');
    }

    //index page of the admin 

    /**
     * @return $this|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        // get all users from database
        if (auth::guard('patient')->check()) {
            $id = Auth::guard('patient')->id();


            $data = [

                'role' => 'patient',
                'title' => 'Patient Detail',
                'patient_id' => $id,
            ];

            $patientDetail = PatientDetail::where('patient_id', $id)->get();
            $notification=Notification::where('patient_id',$id);
            $appointmentDetail = Appointment::where('patient_id', $id)->get();

            if ($patientDetail->isEmpty()) {
                return view('home');
            } else {
                return view('patient.patient_dashboard', compact('patientDetail', 'appointmentDetail','notification'))->with($data);

            }
        } else {
            return view('auth.patient_login');
        }
    }


    //function to create doctor
    public function createPatient()
    {
        if(auth::guard('patient')->check()){
            return view('patient.addPatientDetails');
        }
    }




    //function to store doctor details

    /**
     * @param CreatePatientAddRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function storePatientDetail(CreatePatientAddRequest $request)
    {

        $input = $request->all();

        //insert the data in the patient table

        $data = PatientDetail::create($input);

        $uid = Auth::guard('patient')->id();

        //insert the data in the patient table

        PatientDetail::where('id', $data->id)
            ->update(['detailsFilled' => 1, 'patient_id' => $uid]);
        $request->session()->flash('alert-success', 'Your record is successfully added!');

        return redirect('/patient');


    }

    //function to get the details of specific doctor
    public function showPatient($id)
    {

        if (Auth::guard('patient')->check()) {
            $patients = PatientDetail::where('patient_id',$id)->first();
            return view('patient.patient_dashboard')->with('patients', $patients);

        } else {
            return redirect('/');
        }
    }


    /**
     * @param $id
     * @return string
     */
    public function editPatientDetail($id)
    {
        if (auth::guard('patient')->check() || auth::guard('admin')->check()) {
            $patient = PatientDetail::find($id);
            return view('patient.edit_patient', compact('patient'))->with('id', $id);
        } else {
            return redirect('/');
        }

    }


    public function updatePatientDetail(CreatePatientAddRequest $request, $id)
    {
        if (auth::guard('patient')->check()) {

            $input = PatientDetail::find($id);
            $input->firstName = $request['firstName'];
            $input->lastName = $request['lastName'];
            $input->age = $request['age'];
            $input->gender = $request['gender'];
            $input->disease = $request['disease'];
            $input->street = $request['suburb'];
            $input->suburb = $request['suburb'];
            $input->state = $request['state'];
            $input->post = $request['post'];
            $input->contact = $request['contact'];
            $input->email = $request['email'];

            $input->save();
            $request->session()->flash('alert-success', 'Your record is successfully Updated!');
            return redirect('/patient');

        } else if (auth::guard('admin')->check()) {
            $input = PatientDetail::find($id);
            $input->firstName = $request['firstName'];
            $input->lastName = $request['lastName'];
            $input->age = $request['age'];
            $input->gender = $request['gender'];
            $input->disease = $request['disease'];
            $input->street = $request['suburb'];
            $input->suburb = $request['suburb'];
            $input->state = $request['state'];
            $input->post = $request['post'];
            $input->contact = $request['contact'];
            $input->email = $request['email'];
            $input->save();
            $request->session()->flash('alert-success', 'Patient record is successfully Updated!');
            return redirect('admin/patient');

        }


    }


    //show Patient Detail

    //function to get the details of patients,all the appointments made with the doctor
    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function showPatientDetails($id)
    {
        if (Auth::guard('patient')->check()) {
            $patientDetail = PatientDetail::where('patient_id',$id)->first();
            //get past apppointment
            $appointmentDetail = Appointment::where('patient_id', $id)
                ->orwhere('payment', 1)->paginate(5);
            return view('patient.patient_detail', compact('patientDetail', 'appointmentDetail'))->with('title', 'Details');

        } else if (Auth::guard('admin')->check()) {
            $patientDetail = PatientDetail::where('patient_id',$id)->first();
            $appointmentDetail = Appointment::where('patient_id', $id)
                ->orderby('updated_at', 'desc')->paginate(3);
            return view('patient.patient_detail', compact('patientDetail', 'appointmentDetail'))->with('title', 'Details');

        } else {
            return redirect('/');
        }
    }


    /**
     * @param $doctorID
     */


    public function getDoctorSchedule($doctorID)
    {
        $response = null;
        $schedule = AppointmentSchedule::where('doctor_id', $doctorID)
            ->where('availability', 1)
            ->orderBy('appointmentDate', 'desc')
            ->get();

        $doctorDate = DB::table('appointment_schedules')->select('appointmentDate', 'doctor_id')
            ->where('doctor_id', $doctorID)
            ->where('availability', 1)
            ->distinct('appointmentDate')
            ->get();

        if ($schedule->count() != null) {
            $response['message'] = "Retrieve Successful";
            $response['code'] = 202;
            $response['object'] = $schedule;
            $response['doctorDate'] = $doctorDate;
        } else {
            $response['message'] = "Retrieve unsuccessful";
        }
        echo json_encode($response);
    }

    //handle change password

}
 