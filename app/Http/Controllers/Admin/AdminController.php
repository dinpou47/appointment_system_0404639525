<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Appointment;
use App\Doctor;
use App\DoctorDetail;
use App\Patient;
use App\PatientDetail;
use App\AppointmentSchedule;
use App\Notification;
use App\Http\Requests\CreateDoctorRequest;
use App\Http\Requests\CreateDoctorAddRequest;
use App\Http\Requests\SearchPatientRequest;
use App\Http\Requests\SearchAppointmentRequest;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use PDF;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;


class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin')->except('showDoctors', 'showPatients','searchPatient','searchAppointment');
    }

    //index page of the admin

    public function index()
    {

        //get all users from database

        $id = Auth::id();
        $doctorsCount = Doctor::all()->count();
        $appointmentCount = Appointment::all()->count();
        $patient_count = PatientDetail::all()->count();
        $dat = Carbon::parse(Carbon::now())->format('y-m-d');
        // dd($dat);
        $appToday = Appointment::where('appointmentDate', $dat)->get()->count();

        //get the user of given id

        $users = Admin::get();

        $data = [
            'role' => 'admin', 'title' => 'Dashboard',
            'doctors' => $doctorsCount,
            'patients' => $patient_count,
            'appointments' => $appointmentCount,
            'appToday' => $appToday
        ];

        $doctorsCount = Doctor::all()->count();
        $appointmentCount = Appointment::all()->count();
        $patient_count = PatientDetail::all()->count();

        $appointmentDetail = DB::table('appointments')
            ->join('doctor_details', 'appointments.doctor_id', '=', 'doctor_details.doctor_id')
            ->join('patient_details', 'appointments.patient_id', '=', 'patient_details.patient_id')
            ->select('appointments.*', 'patient_details.patient_id', 'patient_details.firstName', 'doctor_details.firstName')
            ->where('appointments.appointmentDate', '2018-05-02')
            ->get();
        $notification=Notification::all()->count();


        return view('admin.admin_dashboard', compact('users', 'appointmentDetail','notification'))->with($data);
    }


    //function to get the role of the logged user
    public function getRole($id)
    {
        $loggedUser = Admin::where('id', $id)->get()->toArray();
        return $loggedUser[0]['role'];
    }


    /**
     * @return $this
     * doctor user list
     */
    public function usersList()
    {
        $doctor = Doctor::paginate(10);
        $patient=Patient::paginate(10);
        $data = [
            'role' => 'doctor',//role is admin because the admin can view all the doctors
            'title' => 'Doctors'
        ];
        return view('admin.users', compact('doctor','patient'))->with($data);
    }


    /**
     * @param $id
     */
    public function deleteUser($id)
    {

        $user = Doctor::find($id);
        $user->delete();

        return redirect('admin/userList')->with('status', 'User is deleted successfully');
    }





// function to list all doctors

    /**
     * @return $this
     */
    public function showDoctors()
    {

        //get all users

        $doctorDetail = DB::table('doctor_details')->paginate(10);
        $data = [
            'role' => 'doctor',//role is admin because the admin can view all the doctors
            'title' => 'Doctor List'
        ];
        return view('admin.view_doctors', compact('doctorDetail'))->with($data);

    }

    // function to list all clients
    public function showPatients()
    {
        //get all users
        if (Auth::guard('admin')->check()) {
            $patients = PatientDetail::paginate(5);
            return view('admin.view_patients', compact('patients'))->with('title', "Patient List");
        } else if (Auth::guard('doctor')->check()) {
            $id = Auth::guard('doctor')->id();
            $detail = new PatientDetail();
            $patients = $detail->getPatientsForDoctor($id);
            return view('doctor.view_patients', compact('patients'))->with('title', "Patient List");
        }
    }


    /**
     * @param $id
     */
    public function deletePatient($id)
    {
        $patient=Patient::find($id);
        $patient->delete();
        return redirect('admin/patient')->with('status', 'Patient is deleted successfully');
    }
    //public function create schedule

    /**
     * @return $this
     */
    public function createSchedule()
    {
        $doctors = DoctorDetail::all();
        return view('appointment.create_schedule', compact('doctors'))->with("title", "Create Schedule");

    }

    /**
     * @param Request $request
     */
    public function storeDoctorSchedule(Request $request)
    {
        $response = null;

        $starttime = $request['start'];  // your start time
        $endtime = $request['end']; // End time
        $duration = '60';  // split by 60 mins

        $start_time = strtotime($starttime); //change to strtotime
        $end_time = strtotime($endtime); //change to strtotime

        $add_mins = $duration * 60;

        $did = $request['doctor_id'];
        $dat = Carbon::parse($request['appointmentDate'])->format('y-m-d');

        while ($start_time <= $end_time) // loop between time
        {
            $start = date("H:i:s", $start_time); //format the start time
            $end = date("H:i:s", $start_time + $add_mins);

            $input[] = [
                'doctor_id' => $did,
                'appointmentDate' => $dat,
                'start' => $start,
                'end' => $end,
                'created_at' => Carbon::now(),
            ];

            $start_time += $add_mins;
        }

        //DB::table('appointment_schedules')->insert($input);
        $data = AppointmentSchedule::where('doctor_id', $request['doctor_id'])
            ->where('start', $start)
            ->Where('appointmentDate', $request['appointmentDate'])
            ->orderby('created_at','desc')
            ->get();

        if ($data->count() != null) {
            $response['code'] = 201;
            $response['message'] = 'Schedule already exist for given date and time';
        } else {
            DB::table('appointment_schedules')->insert($input);
            $response['code'] = 202;
            $response['message'] = 'Schedule added Successfully';
            //$response['object']=$input;

        }

        echo json_encode($response);
    }

    /**
     * @param $doctorID
     */
    public function getDoctorSchedule($doctorID)
    {
        $response = null;
        $schedule = AppointmentSchedule::where('doctor_id', $doctorID)
            // ->groupBy('appointmentDate')
            ->orderBy('appointmentDate', 'desc')
            ->get();

        if ($schedule->count() != null) {
            $response['message'] = "Retrieve Successful";
            $response['code'] = 202;
            $response['object'] = $schedule;
        } else {
            $response['message'] = "No schedule found";
            $response['code'] = 201;
        }
        echo json_encode($response);
    }

    public function viewSchedule()
    {
        $doctors = DoctorDetail::all();
        return view('appointment.view_schedule', compact('doctors'))->with("title", "Create Schedule");

    }

    /**
     * @param $id
     * Delete Doctor Schedule
     */
    public function deleteDoctorSchedule($id)
    {
        $response = null;
        $schedule = AppointmentSchedule::find($id);
        $schedule->delete();
        $refSchedule = AppointmentSchedule::find($id);

        $response['code'] = 202;
        $response['message'] = "Schedule deleted successfully";
        $response['object'] = $refSchedule;
        echo json_encode($response);

    }


    /**
     * @param $date
     */
    public function appointmentToday($date)
    {
        if (auth::guard('admin')) {
            $appointmentDetail =Appointment::getAppointmentToday($date);
        }
        $pdf = PDF::loadView('pdf.appointment_today', compact('appointmentDetail'));
        $appointments = "Appointments-" . Carbon::now() . ".pdf";
        return $pdf->download($appointments);
    }


    /**
     * @param SearchPatientRequest $request
     * @return $this
     */
    public function searchPatient(SearchPatientRequest $request)
    {
        $token = $request['searchInput'];
        $patients=PatientDetail::getPatientForSearchInput($token);
        if ($patients->count() > 0) {
            $request->session()->flash('alert-success', 'Patient found!');
            return view('admin.searchPatient', compact('patients'))->with('title', 'Patient Record Found')->with('token',$token);
        } else {
            $request->session()->flash('alert-danger', 'Patient Not found!');
            return view('admin.searchPatient')->with('token',$token);
        }
    }


    /**
     * @param SearchAppointmentRequest $request
     * @return $this
     */
    public function searchAppointment(SearchAppointmentRequest $request)
    {
        $token = $request['searchInput'];
        $appointmentDetail = Appointment::where('id', $token)
                 ->orwhere('appointmentDate', $token)
                  ->get();
        if ($appointmentDetail->count() > 0) {
            $request->session()->flash('alert-success', 'Appointment found!');
            return view('admin.searchAppointment', compact('appointmentDetail'))->with('token',$token);
        } else {
            $request->session()->flash('alert-danger', 'Appointment Not found!');
            return view('admin.searchAppointment')->with('token',$token);
        }
    }


    //function to adds services



}
 