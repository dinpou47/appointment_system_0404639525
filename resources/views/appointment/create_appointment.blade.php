@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="component" style="margin-bottom: 10px;">
            <a href="{{route('appointment.create')}}" class="btn btn-info ">
                <span class="glyphicon glyphicon-plus-sign"></span> Make Apppointment
            </a>
            <a href="{{route('appointment.show',['id' => Auth::guard('patient')->id()])}}"
               class="btn btn-primary hidden-xs"> <span class="glyphicon glyphicon-eye-open"></span></i> View
                Appointments</a>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Add New Appointment</div>
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
                              action="{{route('appointment.store')}}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="selectDoctor">Select Doctor *</label>
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


                            </div>

                            <div class="form-group appointment-time">


                            </div>
                            <!--
                            <div class="form-group">
                                <label for="selectDoctor">Select Doctor</label>
                                <select  name="appointmentDate" class="form-control custom-select  doctor-name"  required id="doctor-name">
                                    <option value="">--select doctor--</option>
                                        <option data-url="" value=""></option>
                                </select>
                            </div> -->
                            <!--
                            <div class="form-group">
                                <label for="selectDate">Select Date</label>
                                <input required name="appointmentDate" id="form-datepicker" data-date-format="yyyy-mm-dd" class="form-control form-datepicker">
                            </div>
                                -->
                            <div class="form-group ">
                                <label for="description">Description of Disease *</label>&nbsp;&nbsp;
                                <textarea type="text" name="description" placeholder="description" class="form-control"
                                          required id="description"></textarea>

                            </div>

                            <div>
                                <button type="submit" class="btn btn-success btnAddAppointment" disabled
                                        id="btnAddAppointment">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Add
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

