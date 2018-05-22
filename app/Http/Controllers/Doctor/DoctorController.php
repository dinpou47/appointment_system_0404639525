<?php

namespace App\Http\Controllers\Doctor;

use App\DoctorDetail;
use App\Doctor;
use App\Appointment;
use App\PatientDetail;
use App\Notification;
use App\Http\Requests;
use App\Http\Requests\CreateDoctorAddRequest;
use function Faker\Provider\pt_BR\check_digit;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class DoctorController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:doctor');
    }

    //index page of the admin 

    public function index()
    {

        // get all users from database
        if (auth::guard('doctor')->check()) {
            $id = Auth::guard('doctor')->id();
            $email = Auth::guard('doctor')->user()->email;
            $dat = Carbon::parse(Carbon::now())->format('y-m-d');
            $doctorDetail = DoctorDetail::find($id);
            $appointmentCount = Appointment::where('doctor_id', $id)->get()->count();
            $appToday = Appointment::where('appointmentDate', $dat)
                ->where('doctor_id', $id)
                ->get()->count();

            $notification=Notification::where('doctor_id',$id);

            $userRole = 'doctor';

            $data = [

                'role' => 'doctor',
                'title' => 'Doctor Detail',
                'email' => $email,
                'appointments' => $appointmentCount,
                'appToday' => $appToday
            ];
            $doctorDetail = DoctorDetail::where('doctor_id', $id)->get();
            if ($doctorDetail->isEmpty()) {
                return view('home', compact('doctorDetail'))->with($data);
            } else {
                return view('doctor.doctor_dashboard', compact('doctorDetail','notification'))->with($data);
            }
        } else {
            return view('auth.doctor-login');
        }
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function showDoctorDetails($id)
    {
        if (auth::guard('admin')->check() || auth::guard('doctor')->check()) {
            $doctorDetail = DoctorDetail::where('doctor_id',$id)->first();
            $appointmentDetail=Appointment::where('doctor_id',$id)->paginate(10);
            return view('doctor.doctor_details', compact('doctorDetail','appointmentDetail'))->with('title', 'Doctor Details');
        } elseif(auth::guard('patient')->check()){
            $pid=auth::guard('patient')->id();
            $doctorDetail = DoctorDetail::where('doctor_id',$id)->first();
            $appointmentDetail = DB::table('appointments')->select('appointments.*')
                ->where('patient_id', $pid)
                ->where('doctor_id', $id)
                ->orderby('updated_at', 'asc')
                ->paginate(5);
            return view('doctor.doctor_details', compact('doctorDetail','appointmentDetail'))->with('title', 'Doctor Details');

        }else {
            return redirect('/patient/login');
        }
    }


    //function to create doctor

    /**
     * @return $this
     */
    public function create()
    {
        if(auth::guard('doctor')){
            return view('doctor.addDoctorDetails')->with('title', "Add Details");
        }

    }


    /*function to store client data in the database
     *Insert into database
     *
     *@param  Request $request
     */
    //function to store doctor details
    public function storeDoctorDetail(CreateDoctorAddRequest $request)
    {
        if (auth::guard('doctor')->check()) {

            $input = $request->all();

            //insert the data in the Clients table

            $data = DoctorDetail::create($input);

            $uid = Auth::guard('doctor')->id();

            //insert the data in the Doctor table

            DoctorDetail::where('id', $data->id)
                ->update(['detailsFilled' => 1, 'doctor_id' => $uid]);

            return redirect('/doctor');
        }


    }

    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function editDoctorDetail($id)
    {
        if (auth::guard('admin')->check() || auth::guard('doctor')->check()) {
            $doctor = DoctorDetail::find($id);
            return view('doctor.edit_doctor', compact('doctor'))->with('id', $id);
        } else {
            return redirect('/');
        }

    }


    /**
     * @param CreateDoctorAddRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateDoctorDetail(CreateDoctorAddRequest $request, $id)
    {

        if (auth::guard('admin')->check()) {
            $input = DoctorDetail::find($id);
            $input->firstName = $request['firstName'];
            $input->lastName = $request['lastName'];
            $input->firstName = $request['firstName'];
            $input->lastName = $request['lastName'];
            $input->gender = $request['gender'];
            $input->street = $request['suburb'];
            $input->suburb = $request['suburb'];
            $input->state = $request['state'];
            $input->post = $request['post'];
            $input->qualification = $request['qualification'];
            $input->experience = $request['experience'];
            $input->specialisation = $request['specialisation'];
            $input->contact = $request['contact'];
            $input->email = $request['email'];
            $input->save();

            $request->session()->flash('alert-success', 'Doctor record is successfully Updated!');
            return redirect('admin/doctorList');

        } else if (auth::guard('doctor')->check()) {
            $input = DoctorDetail::find($id);
            $input->firstName = $request['firstName'];
            $input->lastName = $request['lastName'];
            $input->firstName = $request['firstName'];
            $input->lastName = $request['lastName'];
            $input->gender = $request['gender'];
            $input->street = $request['suburb'];
            $input->suburb = $request['suburb'];
            $input->state = $request['state'];
            $input->post = $request['post'];
            $input->qualification = $request['qualification'];
            $input->experience = $request['experience'];
            $input->specialisation = $request['specialisation'];
            $input->contact = $request['contact'];
            $input->email = $request['email'];

            $input->save();

            $request->session()->flash('alert-success', 'Your record is successfully Updated!');

            return redirect('/doctor');

        }


    }




    //function to get the details of specific doctor

    /**
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show($id)
    {

        if (Auth::check()) {
            //$clients = DB::table('Clients')->where('id', $id)->get();
            $doctors = DoctorDetail::find($id)->get();
            //dd($clients->firstName);

            return view('doctor.doctor_dashboard')->with('doctors', $doctors);

        } else {
            return redirect('/');
        }
    }

    /**
     * @param $id
     * get the patient details and appointment details of the patients for the doctor
     * id is patient_id
     */

    public function getPatientsForDoctor($id)
    {
        if (auth::guard('doctor')->check()) {
            $did = Auth::guard('doctor')->id();
            $patientDetail = PatientDetail::where('patient_id',$id)->first();
            $appointmentDetail = DB::table('appointments')->select('appointments.*')
                ->where('patient_id', $id)
                ->where('doctor_id', $did)
                ->orderby('updated_at', 'asc')
                ->paginate(10);
            return view('patient.patient_detail', compact('patientDetail', 'appointmentDetail'))->with('title', 'Details');
        }

    }

    public function viewSchedule()
    {
        $id=auth::guard('doctor')->id();

        if (auth::guard('doctor')->check()) {
            $doctor = DoctorDetail::where('doctor_id',$id)->first();
            return view('doctor.view_schedule', compact('doctor'))->with("title", "Create Schedule");
        }

    }

}
 