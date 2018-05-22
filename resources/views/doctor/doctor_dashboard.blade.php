@extends('layouts.app')

@section('content')
    <div class="container">
        <!--start div client-list-->
        <div class="alert alert-success" role="alert">
            Your are logged in as {{Auth::guard('doctor')->user()->name}} <a style="float:right"
                                                                             class="glyphicon glyphicon-remove remove-message"></a> </label>
        </div>
        <div class="flash-message">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <span
                                class="glyphicon glyphicon-ok"></span></p>
                @endif
            @endforeach
        </div>

        <div class="row dashboard-detail">
            <a href="{{route('appointment.show',['id' => Auth::guard('doctor')->id()])}}">
                <div class="col-2 appointment-count">
                    <span style="color:#fcfff6;">Appointment Count</span>
                    <div class="data">
                        <span>{{$appointments}}</span>
                    </div>
                </div>
            </a>
            <a href="{{route('notification.all')}}">
                <div class="col-2 noti-count">
                    <span style="color:#fcfff6;">Messages</span>
                    <div class="data">
                        <span>{{$notification->count()}}</span>
                    </div>
                </div>
            </a>

            <a href="">
                <div class="col-2 appointment-count-today">
                    <span style="color:#fcfff6;">Appointment Today </span>
                    <div class="data">
                        <span>{{$appToday}}</span>
                    </div>
                </div>
            </a>
        </div>


        <h3><span class="label label-primary">{{$title}}</span></h3>
            <!--Table-->
            <table class="table table-striped">
                <!--Table head-->
                <thead class="mdb-color darken-3">
                <tr class="text-white">
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>

                <?php  $count = 1; ?>
                <tbody>
                <!--Table head-->
                <!--Table body-->
                @foreach($doctorDetail as $doctor)

                    <tr>
                        <td scope="row">1</td>
                        <td>{{ $doctor->firstName }}  {{ $doctor->lastName  }}</td>
                        <td>{{ $doctor->street  ." ,". $doctor->suburb." ,".$doctor->state}}</td>
                        <td>{{ $doctor->email  }}</td>

                        <td>
                            <a href="{{route('editDoctorDetail',['id' => $doctor->id])}}" class="btn btn-info">
                                <span class="glyphicon glyphicon-edit"></span> Edit
                            </a>
                        </td>

                        <td>
                            <a href="{{route('doctor.detailDoctor',['id' => $doctor->doctor_id])}}" class="btn btn-success">
                                <span class="glyphicon glyphicon-eye-open"></span> Detail
                            </a>
                        </td>
                    </tr>


                    <?php $count++; ?>
                @endforeach
                <!--Table body-->
                </tbody>
            </table>                <!--Table-->
    </div>

@stop