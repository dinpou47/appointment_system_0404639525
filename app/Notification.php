<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $table = "notification";

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_id',
        'notification_patient',
        'notification_doctor',
        'notification_admin'
    ];

//function to get patient
    public function scopeCreated($query)
    {
        return $query->where('created_at', '<=', Carbon::now());
    }

    /**
     * @param $id
     * @return mixed
     * id is the user id
     */
    public static function getNotification($id) {
        $notification = Notification::where('patient_id', $id)
            ->select('notification_patient as notification')
            ->take(4)
            ->orderby('created_at', 'desc')
            ->get();
        return $notification;
    }


    /**
     * @param $id
     * @return mixed
     * here the id is doctor id
     */
    public static function getNotificationDoctor($id) {
        $notification = Notification::where('doctor_id', $id)
            ->select('notification_doctor as notification')
            ->take(4)
            ->orderby('created_at', 'desc')
            ->get();
        return $notification;
    }

}
