<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Request;

class Appointment extends Model
{
    //
    protected $table = "appointments";

    protected $fillable = [
        'doctor_id',
        'schedule_id',
        'appointmentDate',
        'appointmentTime',
        'description',
        'notification_patient',
        'notification_admin',
        'notification_doctor',
        'patient_id'
    ];

//function to get patient
    public function scopeCreated($query)
    {
        return $query->where('created_at', '<=', Carbon::now());
    }

    public function PatientDetail()
    {
        return $this->belongsTo('App\PatientDetail ', 'patient_id');
    }

    /**
     * @param $id
     * @return mixed
     * get patient detail for given appointment
     */
    public function getPatientDetail($id){
        $appointmentDetailPatient = DB::table('appointments')
            ->join('patient_details', 'appointments.patient_id', '=', 'patient_details.patient_id')
            ->select('appointments.*', 'patient_details.*')
            ->where('appointments.id', $id)
            ->first();
        return $appointmentDetailPatient;
    }


    /**
     * @param $id
     */

    public static function getAppointmentToday($date){
        $appointmentDetail = DB::table('appointments')
            ->join('doctor_details', 'appointments.doctor_id', '=', 'doctor_details.doctor_id')
            ->join('patient_details', 'appointments.patient_id', '=', 'patient_details.patient_id')
            ->select('appointments.*', 'patient_details.lastName as plname', 'patient_details.firstName as pfname', 'doctor_details.firstName as dfname', 'doctor_details.lastname as dlname')
            ->where('appointments.appointmentDate', $date)
            ->orderby('appointments.created_at', 'desc')
            ->get();
        return $appointmentDetail;
    }

    /**
     * @param $aid
     */
    public static function getAppointmentPatient($aid){
        //join appointment and patient_Details table
        $appointmentDetailPatient = DB::table('appointments')
            ->join('patient_details', 'appointments.patient_id', '=', 'patient_details.patient_id')
            ->select('appointments.*', 'patient_details.*')
            ->where('appointments.id', $aid)
            ->get();
        return $appointmentDetailPatient;
    }

    /**
     * @param $aid
     */
    public static function getAppointmentDoctor($aid){
        //join appointment and doctor_Details table
        $appointmentDetailDoctor = DB::table('appointments')
            ->join('doctor_details', 'appointments.doctor_id', '=', 'doctor_details.doctor_id')
            ->select('appointments.*', 'doctor_details.*')
            ->where('appointments.id', $aid)
            ->get();
        return $appointmentDetailDoctor;
    }
    //get patient id from appointment id

    public static function getPatientID($aid){
        $pid=Appointment::select('patient_id')->where('id',$aid)->first();
        return  $pid->patient_id;
    }
}
