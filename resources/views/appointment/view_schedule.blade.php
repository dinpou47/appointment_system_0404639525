@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="component" style=margin-bottom: 10px;
        ">
        @if(auth::guard('admin')->check())

            <a class="btn btn-primary hidden-xs" href="{{route('createSchedule')}}">
                <span class="glyphicon glyphicon-plus-sign"></span> Add Doctor Schedule
            </a>
            <a class="btn btn-default" href="{{route('admin.viewDoctorSchedule')}}">
                <span class="glyphicon glyphicon-eye-open"></span>View Doctor Schedule
            </a>
        @endif
    </div>
    <div class="row" style="margin-top: 70px;">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary">
                <div class="panel-heading">View Schedule</div>
                <div class="panel-body" style="width:80%;margin:0 auto;">
                    <!--start of form -->
                    <div id="validation-message"></div>
                    <form class="form form-inline" id="formStoreSchedule" method="POST"
                          action="{{route('storeDoctorSchedule')}}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="selectDoctor">Select Doctor *</label>
                            <select name="doctor_id" class="form-control custom-select select-doctor" required
                                    id="select-doctor">
                                <option value="">--select doctor--</option>
                                @foreach($doctors as $doctor)
                                    <option data-url="{{route('admin.getDoctorSchedule',$doctor->doctor_id)}}"
                                            value="{{$doctor->doctor_id}}">{{$doctor->firstName." ".
								           $doctor->lastName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="selectDate">Select Date *</label>
                            <input required name="selectScheduleDate" id="selectScheduleDate"
                                   data-date-format="yy-mm-dd" class="form-control form-datepicker selectScheduleDate">
                        </div>
                    </form>
                    <!--end of form -->
                </div>
                <!--Display the schedule -->

                <div id="response-message">

                </div><!--end display schedule -->

            </div>
        </div>

    </div>

    <div id="schedule-detail">

    </div>




    </div>




    <script>
    </script>


@stop

