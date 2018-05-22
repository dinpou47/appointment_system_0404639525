@extends('layouts.app')

@section('content')
    <div class="container">
        <!--start div client-list-->


        <h3><span class="label label-primary">Notification</span></h3>
        <table class="table table-striped">
            <!--Table head-->
            <thead class="mdb-color darken-3">
            <tr class="text-white">
                <th>S.N</th>
                <th>Date</th>
                <th>Message</th>
                <th></th>
            </tr>

            </thead>

            <?php  $count = 1; ?>
            <tbody>
            <!--Table body-->
            @foreach($notification as $noti)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$noti->created_at}}</td>
                    <td>
                        @if(auth::guard('patient')->check())
                            {{$noti->notification_patient}}

                        @elseif(auth::guard('doctor')->check())
                            {{$noti->notification_doctor}}


                        @elseif(auth::guard('admin')->check())
                            {{$noti->notification_admin}}
                        @endif

                    </td>
                    <td>
                        <a href="{{route('appointmentDetail',$noti->appointment_id)}}" class="btn btn-success">
                            <span class="glyphicon glyphicon-eye-open"></span> Appointment Detail
                        </a>
                    </td>
                </tr>

                <!--Table body-->
            </tbody>
            <?php $count++; ?>
            @endforeach

        </table>
        {{$notification->links()}}

    </div>

@stop