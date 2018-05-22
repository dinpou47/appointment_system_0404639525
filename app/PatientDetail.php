<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Carbon\Carbon;
use Request;


class PatientDetail extends Model
{

    protected $table = 'patient_details';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'street',
        'suburb',
        'state',
        'post',
        'contact',
        'email',
        'gender',
        'age',
        'disease',
        'detailsFilled'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // function to get the patient detail
    public function scopeCreated($query)
    {
        return $query->where('created_at', '<=', Carbon::now());
    }

    public function PatientDetail()
    {
        return $this->belongsTo('App\Patient');
    }

    public function appointments()
    {
        return $this->hasMany('App\Appointment');
    }


    /**
     * @param $id
     * @return mixed
     * get the patients for doctor, where id is doctor id
     */
    public function getPatientsForDoctor($id)
    {
        $pid = DB::table('appointments')->distinct()->select('patient_id')->where('doctor_id', $id);
        $patients = DB::table('patient_details')
            ->whereIn('patient_id', $pid)->get();
        return $patients;
    }

    /**
     * @param $id
     * @return string
     */
    public static function getPatientName($id){
        $patient=DB::table('patient_details')
            ->where('patient_id',$id)
            ->select('firstName','lastName')->first();
        return $patient->firstName.' '.$patient->lastName;
    }

    /**
     * @param $input
     */
    public static function getPatientForSearchInput($input){
        $token = $input;
        $patients = PatientDetail::where('firstName', $token)
            ->orwhere('firstName', 'LIKE', "%$token%")
            ->orwhere('email', 'LIKE', "%$token")
            ->get();
        return $patients;
    }
}
