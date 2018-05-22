@extends('layouts.app')

@section('content')
    <div class="container" style="width:100%">
        <!--start div client-list-->

        <h3><span class="label label-primary">{{$title}}</span></h3>
            <table class="table table-striped">
                <!--Table head-->
                <thead class="mdb-color darken-3">

                </thead>

                <?php  $count = 1; ?>
                <tbody>
                <!--Table body-->
                <tr>
                    <td>Name</td>
                    <td>{{$doctorDetail->firstName.'  '.$doctorDetail->lastName}}</td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>{{$doctorDetail->street.' '.$doctorDetail->suburb.' '. $doctorDetail->state.' '.$doctorDetail->post}}</td>
                </tr>

                <tr>
                    <td>Contact</td>
                    <td>{{$doctorDetail->contact}}</td>
                </tr>

                <tr>
                    <td>Email</td>
                    <td>{{$doctorDetail->email}}</td>
                </tr>

                <!--Table body-->
                </tbody>
            </table>

        <h3><span class="label label-primary">Appointment</span></h3>
        <!--Table-->
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
                <th>Description</th>
                <th></th>
                <th></th>

            </tr>
            </thead>

            <?php  $count = 1; ?>
            <tbody>
            <!--Table head-->
            <!--Table body-->
            @foreach($appointmentDetail as $app)
                <tr>
                    <td scope="row">{{$count}}</td>
                    <td>{{ $app->id }}</td>
                    <td>{{App\PatientDetail::getPatientName($app->patient_id)}}</td>
                    <td>{{App\DoctorDetail::getDoctorName($app->doctor_id)}}</td>

                    <td>{{ $app->appointmentDate }}</td>
                    <td>{{ $app->appointmentTime }}</td>
                    <td>{{ $app->description }}</td>
                    <td></td>

                    <td>
                        <a href="{{route('appointmentDetail',$app->id)}}" class="btn btn-success">
                            <span class="glyphicon glyphicon-eye-open"></span> Detail
                        </a>
                    </td>
                </tr>
                <?php $count++; ?>
            @endforeach
            <!--Table body-->
            </tbody>
        </table>
        <!--Table-->
        {{ $appointmentDetail->links() }}

    </div>


@stop