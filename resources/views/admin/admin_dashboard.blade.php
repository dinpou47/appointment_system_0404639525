<?php use Carbon\Carbon?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <!--start div client-list-->
        <div class="alert alert-success" role="alert">
            Your are logged in as {{Auth::guard('admin')->user()->name}} <a style="float:right"
                                                                            class="glyphicon glyphicon-remove remove-message"></a> </label>
        </div>

        <h3><span class="label label-primary">{{$title}}</span></h3>
            <!--Table-->
            <div class="row dashboard-detail">
                <a href="{{route('doctorList')}}">
                    <div class="col-2 doctor-count">
                        <span style="color:#fcfff6;">Doctors Count</span>
                        <div class="data">
                            <span>{{$doctors}}</span>
                        </div>
                    </div>
                </a>
                <a href="{{route('patient')}}">
                    <div class="col-2 patient-count">
                        <span style="color:#fcfff6;">Patient Count</span>
                        <div class="data">
                            <span>{{$patients}}</span>
                        </div>
                    </div>
                </a>

                <a href="{{route('allAppointment')}}">
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
                            <span>{{$notification}}</span>
                        </div>
                    </div>
                </a>


                <a href="{{route('print.appointmentToday',Carbon::now(new DateTimeZone('Australia/Melbourne'))->format('Y-m-d'))}}">
                    <div class="col-2 appointment-count-today">
                        <span style="color:#fcfff6;">Appointment Today</span>
                        <div class="data">
                            <span>{{$appToday}}</span>
                            <span class="glyphicon glyphicon-print"></span>
                        </div>
                    </div>
                </a>

            </div>
    </div>

@stop