<?php

namespace App\Http\Controllers\Appointment;

use App\Payment;
use Illuminate\Http\Request;
use App\Http\Requests\CreateAppointmentRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\DoctorDetail;
use App\PatientDetail;
use App\Appointment;
use App\Patient;
use App\Notification;
use App\AppointmentSchedule;
use Carbon\Carbon;
use Mockery\Matcher\Not;
use Psy\Command\ParseCommand;
use Illuminate\Support\Facades\Mail;
use PDF;


class AppointmentController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:patient');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (auth::guard('admin')->check() || auth::guard('doctor')->check()) {
            $doctors = DoctorDetail::all();
            //$availability
            $select = [];
            foreach ($doctors as $doctor) {
                $select[$doctor->id] = $doctor->firstName . " " . $doctor->lastName;
            }


            return view('appointment/create_appointment', compact('doctors'));
        } else if (auth::guard('patient')->check()) {
            $detail_filled=PatientDetail::where('patient_id',auth::guard('patient')->id())->count();
            if($detail_filled!=0){
                $doctors = DoctorDetail::all();
                //$availability
                $select = [];
                foreach ($doctors as $doctor) {
                    $select[$doctor->id] = $doctor->firstName . " " . $doctor->lastName;
                }
                return view('appointment/create_appointment', compact('doctors'));
            } else{
                return redirect('/patient');
            }
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAppointmentRequest $request)
    {

        if (auth::guard('admin')->check() || auth::guard('patient')->check()) {
            $response = null;
            $appointmentTime = AppointmentSchedule::where('id', $request['scheduleID'])->get();
            foreach ($appointmentTime as $item) {
                $appTime = $item->start . $item->am . '-' . $item->end . $item->pm;
            }

            $doctorName = DoctorDetail::where('doctor_id', $request['doctor_id'])->get();

            $uid = Auth::guard('patient')->id();


            $input['doctor_id'] = $request['doctor_id'];
            $input['schedule_id'] = $request['scheduleID'];
            $input['appointmentDate'] = $request['selectAppointmentDate'];
            $input['appointmentTime'] = $appTime;
            $input['description'] = $request['description'];
            $input['patient_id'] = $uid;

            $data = Appointment::create($input);
            $appointment_id = $data->id;




            $notification['patient_id'] = $uid;
            $notification['doctor_id'] = $request['doctor_id'];
            $notification['appointment_id'] = $appointment_id;
            $notification['notification_patient'] = 'Your appointment is booked for ' . $request['selectAppointmentDate'] . '. at ' . $appTime;
            $notification['notification_doctor'] = 'You have new appointment booked for ' . $request['selectAppointmentDate'] . ' at ' . $appTime;
            $notification['notification_admin'] = 'New appointment booked for ' . $request['selectAppointmentDate'] . 'at ' . $appTime;


            Notification::create($notification);

            AppointmentSchedule::where('id', $request['scheduleID'])
                ->update(['availability' => 0]);
            $request->session()->flash('alert-success', 'Appointement added successfully!');
            return redirect('/patient');

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if (Auth::guard('patient')->check()) {

            //$appointmentDetail=Patient::find($id)->appointments()->paginate(1);;
            $appointmentDetail = Appointment::where('patient_id', $id)
                ->orderby('created_at','desc')
                ->paginate(5);
            $userRole = 'patient';
            $patient=PatientDetail::where('patient_id',$id)->first();
            return view('patient.view_appointment', compact('appointmentDetail','patient'));
        } else if (Auth::guard('doctor')) {
            $appointmentDetail = Appointment::where('doctor_id', $id)
                ->orderby('created_at','desc')
                ->paginate(5);

            return view('doctor.view_appointment', compact('appointmentDetail'));
        } else {
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if (auth::guard('admin')->check() || auth::guard('patient')->check()) {
            $doctors = DoctorDetail::all();
            $schedule = Appointment::find($id)->first();
            return view('appointment.edit_appointment', compact('doctors', 'schedule'))->with('id', $id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function updateAppointment(CreateAppointmentRequest $request, $id)
    {
        //
        if (auth::guard('admin')->check() || auth::guard('patient')->check()) {
            $response = null;
            $appointmentTime = AppointmentSchedule::where('id', $request['scheduleID'])->get();
            foreach ($appointmentTime as $item) {
                $appTime = $item->start . $item->am . '-' . $item->end . $item->pm;
            }

            $doctorName = DoctorDetail::where('doctor_id', $request['doctor_id'])->get();

            $input = Appointment::find($id);
            $input['doctor_id'] = $request['doctor_id'];
            $input['schedule_id'] = $request['scheduleID'];
            $input['patient_id'] = $request['patient_id'];
            $input['appointmentDate'] = $request['selectAppointmentDate'];
            $input['appointmentTime'] = $appTime;
            $input['confirmed'] = 0;
            $input['description'] = $request['description'];
            $input->save();

            $update = AppointmentSchedule::where('id', $request['sid'])
                ->update(['availability' => 1]);

            $notification['patient_id'] = $request['patient_id'];
            $notification['doctor_id'] = $request['doctor_id'];
            $notification['appointment_id'] = $id;
            $notification['notification_patient'] = 'Your appointment is updated for ' . $request['selectAppointmentDate'] . '. at ' . $appTime;
            $notification['notification_doctor'] = 'You have new appointment booked';
            $notification['notification_admin'] = 'New  appointment is booked';


            Notification::create($notification);

            AppointmentSchedule::where('id', $request['scheduleID'])
                ->update(['availability' => 0]);

            $request->session()->flash('alert-success', 'Appointment updated successfully!');
            if (auth::guard('admin')->check()) {
                return redirect('/admin/allAppointment');
            } else {
                return redirect('/patient');
            }
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * @param $doctorID
     * @param $da
     */
    public function getDoctorScheduleByIdDate($doctorID, $date)
    {
        $response = null;
        //$date=Carbon::parse ($da);
        $schedule = AppointmentSchedule::distinct()
            ->where('doctor_id', $doctorID)
            ->where('appointmentDate', $date)
            //->where('availability', 1)
            ->orderBy('appointmentDate', 'desc')
            ->get();


        if ($schedule->count() != null) {
            $response['message'] = "Retrieve Successful";
            $response['code'] = 202;
            $response['object'] = $schedule;
        } else {
            $response['message'] = "Retrieve Unsuccessful";
            $response['code'] = 201;
        }
        echo json_encode($response);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAllAppointment()
    {
        if (Auth::guard('admin')->check()) {

            $appointmentDetail = Appointment::orderby('appointments.updated_at', 'asc')->paginate(5);
            return view('admin.view_appointment', compact('appointmentDetail'));

        } else if (Auth::guard('doctor')->check()) {

        }

    }

    /**
     * @param $id
     * get the detail of the appointment for doctor
     */
    public function getAppointmentDetail($id)
    {
        if (auth::guard('admin') || auth::guard('patient') || auth::guard('doctor')) {

            $appointmentDetail = DB::table('appointments')
                ->where('appointments.id', $id)
                ->get();

            //join appointment and patient_Details table
            $appointmentDetailPatient = Appointment::getAppointmentPatient($id);

            //join appointment and doctor_Details table
            $appointmentDetailDoctor = Appointment::getAppointmentDoctor($id);

            $bill = Payment::where('appointment_id', $id)->first();

            return view('appointment.appointmentDetail', compact('appointmentDetailPatient', 'appointmentDetailDoctor', 'appointmentDetail', 'bill'))->with('app_id', $id);

        }
    }


    /**
     * @param $id
     * @return mixed
     */
    public function printAppointmentDetail($id)
    {
        if (auth::guard('admin') || auth::guard('patient') || auth::guard('doctor')) {
            $appointmentDetail = DB::table('appointments')
                ->where('appointments.id', $id)
                ->get();
            //join appointment and patient_Details table
            $appointmentDetailPatient = Appointment::getAppointmentPatient($id);

            //join appointment and doctor_Details table
            $appointmentDetailDoctor = Appointment::getAppointmentDoctor($id);

            $bill = Payment::where('appointment_id', $id)->first();

            $pdf = PDF::loadView('pdf.appointments_detail', compact('appointmentDetailPatient', 'appointmentDetailDoctor', 'appointmentDetail', 'bill'));
            return $pdf->download('appointments_detail.pdf');

        }
    }


    /**
     * @param $id
     * @return mixed
     */
    public function printBill($id)
    {
        if (auth::guard('admin') || auth::guard('patient') || auth::guard('doctor')) {
            $appointmentDetail = DB::table('appointments')
                ->where('appointments.id', $id)
                ->first();
            //join appointment and patient_Details table
            //create the object of the appointment
            $appointment = new Appointment();
            $appointmentDetailPatient = $appointment->getPatientDetail($id);

            //join appointment and doctor_Details table

            $appointmentDetailDoctor = DB::table('appointments')
                ->join('doctor_details', 'appointments.doctor_id', '=', 'doctor_details.doctor_id')
                ->select('appointments.*', 'doctor_details.*')
                ->where('appointments.id', $id)
                ->first();
            $bill = Payment::where('appointment_id', $id)->first();

            $pdf = PDF::loadView('pdf.bill', compact('appointmentDetailPatient', 'appointmentDetailDoctor', 'appointmentDetail', 'bill'));
            return $pdf->download($id . '-bill.pdf');
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelAppointment($id)
    {
        if (auth::guard('patient')->check() || auth::guard('admin')->check()) {

            $pid = Appointment::getPatientID($id);
            $ap = Appointment::find($id);
            $ap->delete();

            //delete notification
            $not=Notification::where('appointment_id',$id);
            $not->delete();


            AppointmentSchedule::where('id', $ap->schedule_id)
                ->update(['availability' => 1]);
            //return Redirect::route('userList')->with('message','User Deleted successfully');
            if (auth::guard('patient')->check()) {
                $notification['patient_id'] = $pid;
                $notification['appointment_id'] = $id;
                $notification['notification_patient'] = 'Your appointment is cancelled';
                $notification['notification_admin'] = 'Appointment is cancelled';
                Notification::create($notification);

                return redirect('/patient/appointment/' . $pid)->with('status', 'Appointment is cancelled successfully');

            } else if (auth::guard('admin')->check()) {
                $notification['patient_id'] = $pid;
                $notification['appointment_id'] = $id;
                $notification['notification_patient'] = 'Your appointment is cancelled';
                $notification['notification_admin'] = 'Appointment is cancelled';

                Notification::create($notification);
                return redirect(route('allAppointment'))->with('status', 'Appointment is cancelled successfully');

            }

        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function confirmAppointment($id)
    {
        if (auth::guard('admin')) {

            $pid = Appointment::getPatientID($id);
            $ap = Appointment::find($id);
            Appointment::where('id', $id)
                ->update(['confirmed' => 1]);

            $pid = Appointment::getPatientID($id);

            $notification['patient_id'] = $pid;
            $notification['appointment_id'] = $id;
            $notification['notification_patient'] = 'Your appointment is confirmed';
            Notification::create($notification);
            return redirect('/admin/allAppointment')->with('alert-success', 'Appointment is confirmed successfully');

        }
    }


}
