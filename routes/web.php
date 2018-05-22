<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/contact', function () {
    return view('contact');
});

Auth::routes();

Route::get('homePage', function () {
    return view('welcome');
})->name('homePage');

Route::prefix('admin')->group(function () {
    //admin login route
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    //admin register route
    Route::get('/register', 'Auth\AdminLoginController@createAdmin')->name('admin.register');
    Route::post('/doctorRegister', 'Auth\AdminLoginController@storeAdmin')->name('adminRegister');
    //admin dashboard
    Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');
    Route::get('/logout', 'Auth\AdminLoginController@adminLogout')->name('admin.logout');
    //search Patient
    Route::post('/searchPatient', 'Admin\AdminController@searchPatient')->name('admin.searchPatient');
    Route::post('/searchAppointment', 'Admin\AdminController@searchAppointment')->name('admin.searchAppointment');


    Route::get('/doctorList', 'Admin\AdminController@showDoctors')->name('doctorList');
    Route::get('/userList', 'Admin\AdminController@usersList')->name('userList');

    //appointment

    Route::get('/allAppointment', 'Appointment\AppointmentController@getAllAppointment')->name('allAppointment');
    Route::resource('appointment', 'Appointment\AppointmentController');

    //delete
    Route::get('/delete/{id}', 'Admin\AdminController@deleteUser')->name('deleteUser');


    Route::get('/createSchedule', 'Admin\AdminController@createSchedule')->name('createSchedule');
    Route::post('/storeDoctorSchedule', 'Admin\AdminController@storeDoctorSchedule')->name('storeDoctorSchedule');
    Route::get('/getDoctorSchedule/{id}', 'Admin\AdminController@getDoctorSchedule')->name('admin.getDoctorSchedule');
    Route::get('/doctorSchedule', 'Admin\AdminController@viewSchedule')->name('admin.viewDoctorSchedule');

    Route::get('/deleteDoctorSchedule/{id}', 'Admin\AdminController@deleteDoctorSchedule')->name('deleteDoctorSchedule');

    //get patients for admin and doctor
    Route::get('/patient', 'Admin\AdminController@showPatients')->name('patient');
    Route::get('/deletePatient/{id}', 'Admin\AdminController@deletePatient')->name('admin.deletePatient');


    //confirm app

    Route::get('/confirmAppointment/{id}', 'Appointment\AppointmentController@confirmAppointment')->name('admin.appointmentConfirm');

    //print
    Route::get('/printAppointmentToday/{date}', 'Admin\AdminController@appointmentToday')->name('print.appointmentToday');

    //Payment
    Route::Post('/billPayment/{id}', 'Payment\PaymentController@storePayment')->name('admin.storePayment');
});

//doctor routes
Route::prefix('doctor')->group(function () {
    Route::get('/', 'Doctor\DoctorController@index')->name('doctor.dashboard');
    Route::get('/login', 'Auth\DoctorLoginController@showLoginForm')->name('doctor.login');
    Route::post('/login', 'Auth\DoctorLoginController@login')->name('doctor.login.submit');
    Route::get('/register', 'Auth\DoctorLoginController@createDoctor')->name('doctor.register');

    Route::post('/doctorRegister', 'Auth\DoctorLoginController@storeDoctor')->name('doctorRegister');
    //route to add dotor details
    Route::get('/addDetails', 'Doctor\DoctorController@create')->name('doctor.addDetails');
    Route::post('addDoctorDetail', 'Doctor\DoctorController@storeDoctorDetail');

    Route::get('/changePassword', 'Auth\DoctorLoginController@passwordChangeForm')->name('doctor.changePass');
    Route::post('/storePassword', 'Auth\DoctorLoginController@storeChangePassword')->name('patient.storeChangePass');

    //update doctor routes
    Route::get('/editDoctorDetail/{id}', 'Doctor\DoctorController@editDoctorDetail')->name('editDoctorDetail');
    Route::post('updateDoctorDetail/{id}', 'Doctor\DoctorController@updateDoctorDetail');

    Route::get('/doctorSchedule', 'Doctor\DoctorController@viewSchedule')->name('doctor.viewDoctorSchedule');


    Route::get('/detailDoctor/{id}', 'Doctor\DoctorController@showDoctorDetails')->name('doctor.detailDoctor');

    Route::get('/patientDetail/{id}', 'Doctor\DoctorController@getPatientsForDoctor')->name('doctor.detailPatient');

    Route::get('/logout', 'Auth\DoctorLoginController@doctorLogout')->name('doctor.logout');
    Route::resource('appointment', 'Appointment\AppointmentController');
});


//routes for patient
Route::prefix('patient')->group(function () {
    Route::get('/login', 'Auth\PatientLoginController@showLoginForm')->name('patient.login');
    Route::post('/login', 'Auth\PatientLoginController@login')->name('patient.login.submit');
    Route::get('/register', 'Auth\PatientLoginController@createPatient')->name('patient.register');

    Route::post('/patientRegister', 'Auth\PatientLoginController@storePatient')->name('patientRegister');
    Route::get('/changePassword', 'Auth\PatientLoginController@passwordChangeForm')->name('patient.changePass');
    Route::post('/storePassword', 'Auth\PatientLoginController@storeChangePassword')->name('patient.storeChangePass');

    //route to add doctor details
    Route::get('/addDetails', 'Patient\PatientController@createPatient')->name('patient.addDetails');
    Route::post('addPatientDetail', 'Patient\PatientController@storePatientDetail');


    //update route
    Route::get('/editPatientDetail/{id}', 'Patient\PatientController@editPatientDetail')->name('editPatientDetail');
    Route::post('updatePatientDetail/{id}', 'Patient\PatientController@updatePatientDetail');

    Route::get('client/{id}', 'Client\ClientController@showPatient');

    Route::get('/detailPatient/{id}', 'Patient\PatientController@showPatientDetails')->name('detailPatient');

    //Notification route

    Route::get('/notification', 'Notification\NotificationController@getNotification')->name('notification');
    Route::get('/notification/all', 'Notification\NotificationController@getNotificationAll')->name('notification.all');


    //end notification route

    Route::get('/logout', 'Auth\PatientLoginController@patientLogout')->name('patient.logout');
    Route::get('/', 'Patient\PatientController@index')->name('patient.dashboard');
    Route::post('/patientRegister', 'Auth\PatientLoginController@storePatient')->name('patientRegister');
    Route::get('/getDoctorScheduleByIdDate/{id}/{date}', 'Appointment\AppointmentController@getDoctorScheduleByIdDate')->name('patient.getDoctorScheduleByIdDate');

    //cancel appointment
    Route::get('/cancelAppointment/{id}', 'Appointment\AppointmentController@cancelAppointment')->name('patient.appointmentCancel');

//appointment detail

    Route::get('/getAppointmentDetail/{id}', 'Appointment\AppointmentController@getAppointmentDetail')->name('appointmentDetail');

    //print apppointment detail
    Route::get('/printAppointmentDetail/{id}', 'Appointment\AppointmentController@printAppointmentDetail')->name('printAppointment');
    Route::get('/printBill/{id}', 'Appointment\AppointmentController@printBill')->name('printBill');


    //Route::get('/storeAppointment/{id}/{date}/{time}','Appointment\AppointmentController@storeAppointment')->name('patient.storeAppointment');
    Route::post('updateAppointment/{id}', 'Appointment\AppointmentController@updateAppointment')->name('updateAppointment');
    Route::resource('appointment', 'Appointment\AppointmentController');
    Route::get('/getDoctorSchedule/{id}', 'Patient\PatientController@getDoctorSchedule')->name('patient.getDoctorSchedule');
});











