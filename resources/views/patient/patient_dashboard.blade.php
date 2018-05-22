@extends('layouts.app')

@section('content')
    <div class="container">
        <!--start div client-list-->
        <div class="alert alert-success" role="alert">
            Your are logged in as {{Auth::guard('patient')->user()->name}} <a style="float:right"
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
            <a href="{{route('appointment.show',$patient_id)}}">
                <div class="col-2 appointment-count">
                    <span style="color:#fcfff6;">Appointment Count</span>
                    <div class="data">
                        <span>{{$appointmentDetail->count()}}</span>
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

            <a href="{{route('appointment.create',$patient_id)}}">
                <div class="col-2 appointment-count">
                    <span style="color:#fcfff6;">Make a booking</span>
                    <div class="data">
                        <span class="glyphicon glyphicon-plus-sign"></span>
                    </div>
                </div>
            </a>
        </div>


        <h3><span class="label label-primary">Your Details</span></h1>
            <!--Table-->
            <table class="table table-striped">
                <!--Table head-->
                <thead class="mdb-color darken-3">
                <tr class="text-white">
                    <th>S.N</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th></th>
                    <th></th>

                </tr>
                </thead>

                <?php  $count = 1; ?>
                <tbody>
                <!--Table head-->
                <!--Table body-->
                @foreach($patientDetail as $client)

                    <tr>
                        <td scope="row">1</td>
                        <td>{{ $client->firstName }}</td>
                        <td>{{ $client->lastName  }}</td>
                        <td>{{ $client->street  ." ,". $client->suburb." ,".$client->state}}</td>
                        <td>{{ $client->contact  }}</td>
                        <td>{{ $client->email  }}</td>

                        <td>
                            <a href="{{route('editPatientDetail',['id' => $client->id])}}" class="btn btn-info">
                                <span class="glyphicon glyphicon-edit"></span> Edit
                            </a>
                        </td>

                        <td>
                            <a href="{{route('detailPatient',['id' => $client->patient_id])}}" class="btn btn-success">
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


            <!-- Modal form to edit a form -->
            <div id="editModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">ll</h4>
                        </div>
                        <div class="modal-body">

                            {!! Form::open(['action' => 'Patient\PatientController@storePatientDetail'])!!}

                            <div class='form-group'>

                                {!! Form::label('First Name') !!}
                                {!! Form::text('firstName',null,['required' => 'required','id'=>'firstName', 'class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('Last Name') !!}
                                {!! Form::text('lastName',null,['required' => 'required','id'=>'lastName','class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('Unit Street') !!}
                                {!! Form::text('street',null,['required' => 'required','id'=>'street','class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('Suburb') !!}
                                {!! Form::text('suburb',null,['required' => 'required','id'=>'suburb','class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('State') !!}
                                {!! Form::text('state',null,['required' => 'required','id'=>'state','class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('Post Code') !!}
                                {!! Form::text('post',null,['required' => 'required','id'=>'post','class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('Contact') !!}
                                {!! Form::text('contact',null,['required' => 'required','id'=>'contact','class'=>'form-control']) !!}
                            </div>


                            <div class='form-group'>

                                {!! Form::label('Email') !!}
                                {!! Form::text('email',null,['required' => 'required','id'=>'email','class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>
                                {!! Form::Submit('Submit',['id'=>'btnAddPatientDetails','class'=>"btn btn-success form-control btnAddPatientDetails"]) !!}

                            </div>
                            {!! Form::close() !!}

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                                    <span class='glyphicon glyphicon-check'></span> Edit
                                </button>
                                <button type="button" class="btn btn-warning" data-dismiss="modal">
                                    <span class='glyphicon glyphicon-remove'></span> Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>

@stop