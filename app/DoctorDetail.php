<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Carbon\Carbon;
use Request;


class DoctorDetail extends Model
{

    protected $table = 'doctor_details';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'gender',
        'street',
        'suburb',
        'state',
        'post',
        'contact',
        'email',
        'specialisation',
        'qualification',
        'experience',
        'detailsFilled'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // function to get the doctor


    public function scopeCreated($query)
    {
        return $query->where('created_at', '<=', Carbon::now());
    }

    public function DoctorDetail()
    {
        return $this->belongsTo('App\Doctor');
    }

    /**
     * @param $id
     * @return string
     * id is doctor id
     */
    public static function getDoctorName($id){
        $patient=DB::table('doctor_details')
            ->where('doctor_id',$id)
            ->select('firstName','lastName')->first();
        return $patient->firstName.' '.$patient->lastName;
    }




}
