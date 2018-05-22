@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Edit Appointment</div>
                    @if($errors->any())

                        <ul class="alert alert-danger" style="list-style-type: none">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>
                    @endif
                    <div class="panel-body">
                        <!--start of form -->
                        <form class="form" id="formStoreAppointment" method="POST"
                              action="{{action('Appointment\AppointmentController@updateAppointment',$id)}}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="selectDoctor">Select Doctor</label>
                                <select required name="doctor_id" class="form-control custom-select doctor-name"
                                        id="doctor-name">
                                    <option value="">--select doctor--</option>
                                    @foreach($doctors as $doctor)
                                        <option data-url="{{route('patient.getDoctorSchedule',$doctor->doctor_id)}}"
                                                value="{{$doctor->doctor_id}}">{{$doctor->firstName." ".
								           $doctor->lastName.'( Specialisation: '.$doctor->specialisation.')'}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group appointment-date">
                                <label for="selectDate">Select Date</label>
                                <select required name="selectAppointmentDate"
                                        class="form-control custom-select selectAppointmentDate"
                                        id="selectAppointmentDate">
                                    <option data-id="{{$schedule->doctor_id}}"
                                            value="{{$schedule->appointmentDate}}">{{$schedule->appointmentDate}}</option>
                                </select>
                            </div>

                            <div class="form-group appointment-time">
                                <label for="selectTime">Select Time</label>
                                <select required name="scheduleID"
                                        class="form-control custom-select selectAppointmentTime" required
                                        id="selectAppointmentTime">';
                                    <option data-id="{{$schedule->doctor_id}}"
                                            value="{{$schedule->appointmentTime}}">{{$schedule->appointmentTime}}</option>
                                </select>
                            </div>
                            <div class="form-group ">
                                <label for="description">Description</label>&nbsp;&nbsp;
                                <textarea type="text" name="description" placeholder="{{$schedule->description}}" class="form-control" required id="description"></textarea>
                            </div>
                            <input id="patient-id" name="patient_id" type="hidden" value="{{$schedule->patient_id}}">
                            <input id="sid" name="sid" type="hidden" value="{{$schedule->schedule_id}}">

                            <div>
                                <button type="submit" class="btn btn-success btnAddAppointment" id="btnAddAppointment">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Update
                                </button>
                            </div>
                        </form>
                        <!--end of form -->

                    </div>
                    <div class="response-message">

                    </div>
                </div>
            </div>

        </div>

    </div>

    <script>
    </script>


@stop

