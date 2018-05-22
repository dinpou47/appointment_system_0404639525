<?php

namespace App\Http\Controllers\Payment;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use App\Appointment;
use App\Doctor;
use App\DoctorDetail;
use App\PatientDetail;
use App\AppointmentSchedule;
use App\Patient;
use App\Payment;
use App\Http\Requests\AddPaymentRequest;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use PDF;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class PaymentController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin')->except('showDoctors');
    }

    public function storePayment(Request $request, $id)
    {
        $response = null;

        $input['appointment_id'] = $id;
        $input['payment_mode'] = $request['payment-mode'];
        $input['amount'] = $request['amount'];

        $data = Payment::create($input);
        Appointment::where('id', $id)
            ->update(['payment' => 1]);
        if (isset($data)) {
            $response['code'] = 202;
            $response['object'] = $input;
            $response['message'] = "Payment added successfully";
        } else {
            $response['code'] = 202;
            $response['message'] = "Payment not added check the details";
        }

        echo json_encode($response);

    }

}
