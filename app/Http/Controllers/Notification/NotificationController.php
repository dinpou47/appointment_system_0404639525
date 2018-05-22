<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers;
use App\Notification;
use App\PatientDetail;
use App\Appointment;
use App\AppointmentSchedule;
use App\Patient;
use App\Http\Requests;
use App\Http\Requests\CreatePatientAddRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

use Carbon\Carbon;

class NotificationController extends Controller
{
    //

    /**
     * @param
     * get noitification
     */
    public function getNotification()
    {
        $response = null;
        if (Auth::guard('patient')->check()) {
            $id=auth::guard('patient')->id();
            $notification = Notification::getNotification($id);
            if ($notification->count() != null) {
                $response['message'] = "Notification retrieved successfully";
                $response['role'] = 'patient';
                $response['code'] = 202;
                $response['object'] = $notification;
            } else {
                $response['role'] = 'patient';
                $response['message'] = "No New Notifications";
                $response['code'] = 201;
            }
        } else if (Auth::guard('doctor')->check()) {
            $id=auth::guard('doctor')->id();
            $notification = Notification::getNotificationDoctor($id);

            if ($notification->count() != null) {
                $response['message'] = "Notification retrieved successfully";
                $response['role'] = 'doctor';
                $response['code'] = 202;
                $response['object'] = $notification;
            }
        }else if (Auth::guard('admin')->check()) {
            $notification = Notification::select('notification_admin as notification')
                ->orderby('created_at', 'desc')
                ->take(4)
                ->get();
            if ($notification->count() != null) {
                $response['message'] = "Notification retrieved successfully";
                $response['role'] = 'doctor';
                $response['code'] = 202;
                $response['object'] = $notification;
            }
        }else {
                $response['message'] = "No New Notifications";
                $response['role'] = 'doctor';
                $response['code'] = 201;
            }

        echo json_encode($response);
    }


    //

    /**
     * @param
     */
    public function getNotificationAll()
    {
        $response = null;
        if (Auth::guard('patient')->check()) {
            $id=auth::guard('patient')->id();
            $notification = Notification::where('patient_id', $id)
                ->orderby('created_at', 'desc')
                ->paginate(6);

            if ($notification->count() != null) {
                return view('notification.notification_all',compact('notification'));
            } else {

            }
        } else if (Auth::guard('doctor')->check()) {
            $id=auth::guard('doctor')->id();
            $notification = Notification::where('doctor_id', $id)
                ->orderby('created_at', 'desc')
                ->paginate(6);

            if ($notification->count() != null) {
                return view('notification.notification_all',compact('notification'));
            } else{

            }
        }else if (Auth::guard('admin')->check()) {
            $notification = Notification::select('*')
                ->orderby('created_at', 'desc')
                ->paginate(6);
            if ($notification->count() != null) {
                return view('notification.notification_all',compact('notification'));
            }
        }else {

        }

    }

}
