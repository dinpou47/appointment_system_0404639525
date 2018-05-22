@extends('layouts.app')

@section('content')
    <div class="container" style="width:100%">
        <!--start div client-list-->
        <div class="flash-message">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <div class="component" style=margin-bottom: 10px;
        ">
    </div>

    <h3><span class="label label-primary">Next Appointment</span></h1>
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
                <th>Confirmation</th>
                <th>Payment</th>
                <th></th>
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
                        @endif                    </td>

                    <td>
                        <a href="{{route('appointment.edit',$app->id)}}" class=" btn btn-info" data-id="{{$app->id}}"
                           data-title=""><span class="glyphicon glyphicon-edit"></span> Edit</a>

                    </td>
                    <td>
                        <a href="{{route('appointmentDetail',$app->id)}}" class="btn btn-success">
                            <span class="glyphicon glyphicon-eye-open"></span> Detail
                        </a>
                    </td>
                    <td>
                        @if ($app->confirmed==0)
                            <a href="{{route('patient.appointmentCancel',$app->id)}}" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove-circle"></span> Cancel
                            </a>
                        @endif
                    </td>

                </tr>


                <?php $count++; ?>
            @endforeach
            <!--Table body-->
            </tbody>
        </table>
        <!--Table-->
        <div class="pagination">
           {{ $appointmentDetail->links()}}
        </div>
        <!-- Modal form to edit a form -->

        </div>

@stop