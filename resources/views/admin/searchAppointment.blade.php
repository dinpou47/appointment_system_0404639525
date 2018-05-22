@extends('layouts.app')

@section('content')
    <div class="container" style="width:100%">
        <!--start div client-list-->

        <div class="search-box" style="">
            <form action="{{route('admin.searchAppointment')}}" method="POST" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" required name="searchInput"
                           placeholder="{{$token}}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                     </span>
                </div>
            </form>
        </div>


        @if(isset($appointmentDetail))
            <div>
                <div class="flash-message">
                    @foreach (['success'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <span
                                        class="glyphicon glyphicon-ok"></span></p>
                        @endif
                    @endforeach
                </div>
                <h3><span class="label label-primary">Appointments</span></h3>
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
                                    <span class="glyphicon glyphicon-remove"></span>
                                @elseif ($app->confirmed==1)
                                    <span class="glyphicon glyphicon-ok"></span>
                                @endif
                            </td>

                            <td>
                                @if($app->payment==0)
                                    <span class="glyphicon glyphicon-remove"></span>
                                @elseif ($app->payment==1)
                                    <span class="glyphicon glyphicon-ok"></span>
                                @endif
                            </td>
                            <td>
                                @if(auth::guard('admin')->check())
                                    <a href="{{route('appointment.edit',$app->id)}}" class=" btn btn-info"
                                       data-id="{{$app->id}}" data-title=""><span
                                                class="glyphicon glyphicon-edit"></span>
                                        Edit</a>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('appointmentDetail',$app->id)}}" class="btn btn-success">
                                    <span class="glyphicon glyphicon-eye-open"></span> Detail
                                </a>
                            </td>

                            <td>
                                @if(auth::guard('admin')->check())

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
                @else
                    <div class="flash-message">
                        @foreach (['danger'] as $msg)
                            @if(Session::has('alert-' . $msg))
                                <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <span
                                            class="glyphicon glyphicon-ok"></span></p>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
    </div>

@stop