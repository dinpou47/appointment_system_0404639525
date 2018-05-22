@extends('layouts.app')

@section('content')
    <div class="container" style="width:100%">
        <!--start div client-list-->


        <h3><span class="label label-primary">Patient Detail</span></h3>
        <table class="table table-striped">
            <!--Table head-->
            <thead class="mdb-color darken-3">

            </thead>

            <?php  $count = 1; ?>
            <tbody>
            <!--Table body-->
            <tr>
                <td>Name</td>
                <td>{{$patientDetail->firstName.'  '.$patientDetail->lastName}}</td>
            </tr>
            <tr>
                <td>Address</td>
                <td>{{$patientDetail->street.' '.$patientDetail->suburb.' '. $patientDetail->state.' '.$patientDetail->post}}</td>
            </tr>

            <tr>
                <td>Contact</td>
                <td>{{$patientDetail->contact}}</td>
            </tr>

            <tr>
                <td>Email</td>
                <td>{{$patientDetail->email}}</td>
            </tr>

            <!--Table body-->
            </tbody>
        </table>


        <h3><span class="label label-primary">Appointments</span></h3>
        <table class="table table-striped">
            <!--Table head-->
            <thead class="mdb-color darken-3">
            <tr class="text-white">
                <th>S.N</th>
                <th>Appointment Number</th>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Confirmation</th>
                <th>Payment</th>
                <th></th>
                <th></th>
                <th></th>

            </tr>
            </thead>

            <?php  $count = 1; ?>
            <tbody>
            <!--Table body-->
            @foreach($appointmentDetail as $app)
                <tr>
                    <td scope="row">{{$count}}</td>
                    <td>{{ $app->id }}</td>
                    <td>{{App\PatientDetail::getPatientName($app->patient_id)}}</td>
                    <td>{{App\DoctorDetail::getDoctorName($app->doctor_id)}}</td>
                    <td>{{ $app->appointmentDate }}</td>
                    <td>{{ $app->appointmentTime }}</td>
                    <td>
                        @if($app->confirmed==0)
                            <i class="fa fa-spinner fa-pulse"></i>
                        @elseif ($app->confirmed==1)
                            <span class="glyphicon glyphicon-ok"></span>
                        @endif
                    </td>

                    <td>
                        @if($app->payment==0)
                            <i class="fa fa-spinner fa-pulse"></i>
                        @elseif ($app->payment==1)
                            <span class="glyphicon glyphicon-ok"></span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('appointmentDetail',$app->id)}}" class="btn btn-success">
                            <span class="glyphicon glyphicon-eye-open"></span> Detail
                        </a>
                    </td>
                    <td>

                    </td>
                    <td>

                    </td>

                </tr>


                <?php $count++; ?>
            @endforeach
            <!--Table body-->
            </tbody>
        </table>
        {{$appointmentDetail->links()}}
    </div>


@stop