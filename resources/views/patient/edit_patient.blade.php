@extends('layouts.app')

@section('content')

    <div class="container">


        <div class="row">
            <div class="col-md-8 col-md-offset-2">

                <div class="panel panel-primary">
                    <div class="panel-heading">Update Details</div>

                    <div class="panel-body">

                        <div class="form-style">
                            @if($errors->any())
                                <ul class="alert alert-danger" style="list-style-type: none">

                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>
                            @endif

                            {!! Form::open(['action' => ['Patient\PatientController@updatePatientDetail',$id]])!!}

                            <div class='form-group'>

                                {!! Form::label('First Name') !!}
                                {!! Form::text('firstName',$patient->firstName,['required' => 'required','id'=>'firstName', 'class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('Last Name') !!}
                                {!! Form::text('lastName',$patient->lastName,['required' => 'required','id'=>'lastName','class'=>'form-control']) !!}

                            </div>

                            <div class='form-group'>

                                {!! Form::label('Age') !!}
                                {!! Form::text('age',$patient->age,['required' => 'required','id'=>'age','class'=>'form-control']) !!}

                            </div>

                            <div class='form-group'>

                                {!! Form::label('Gender') !!}
                                {!!Form::select('gender', ['Male' => 'Male', 'Female' => 'Female','Other' => 'Other'], $patient->gender, ['required' => 'required','id'=>'gender','class'=>'form-control','placeholder' => 'Select Gender...']) !!}

                            </div>

                            <div class='form-group'>

                                {!! Form::label('Disease') !!}
                                {!! Form::text('disease',$patient->disease,['id'=>'disease','class'=>'form-control']) !!}

                            </div>

                            <div class='form-group'>

                                {!! Form::label('Unit Street') !!}
                                {!! Form::text('street',$patient->street,['required' => 'required','id'=>'street','class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('Suburb') !!}
                                {!! Form::text('suburb',$patient->suburb,['required' => 'required','id'=>'suburb','class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('State') !!}
                                {!! Form::text('state',$patient->state,['required' => 'required','id'=>'state','class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('Post Code') !!}
                                {!! Form::text('post',$patient->post,['required' => 'required','id'=>'post','class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('Contact') !!}
                                {!! Form::text('contact',$patient->contact,['required' => 'required','id'=>'contact','class'=>'form-control']) !!}
                            </div>


                            <div class='form-group'>

                                {!! Form::label('Email') !!}
                                {!! Form::text('email',$patient->email,['required' => 'required','id'=>'email','class'=>'form-control']) !!}

                            </div>

                            <div class='form-group'>
                                {!! Form::Submit('Update',['id'=>'btnAddPatientDetails','class'=>"btn btn-success form-control btnAddPatientDetails"]) !!}
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@stop

