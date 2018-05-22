<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //

    protected $table = "payments";

    protected $fillable = [
        'id',
        'patient_id',
        'appointment_id',
        'payment_mode',
        'amount',
    ];

    //function

    /**
     * @param $query
     * @return mixed
     */
    public function scopeCreated($query)
    {
        return $query->where('created_at', '<=', Carbon::now());
    }
}
