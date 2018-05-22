<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Carbon\Carbon;
use Request;


class AppointmentSchedule extends Model
{

    protected $table = 'appointment_schedules';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'doctor_id',
        'appointmentDate',
        'start',
        'end',
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
}
