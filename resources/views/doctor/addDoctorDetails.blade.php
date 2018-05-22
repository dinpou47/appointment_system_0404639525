@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Register</div>

                    <div class="panel-body">
                        <div class="form-style">
                            @if($errors->any())

                                <ul class="alert alert-danger">

                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>
                            @endif
                            {!! Form::open(['action' => 'Doctor\DoctorController@storeDoctorDetail'])!!}
                                {{ csrf_field() }}
                                <div class='form-group'>

                                {!! Form::label('First Name') !!}
                                {!! Form::text('firstName',null,['required' => 'required','id'=>'firstName', 'class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('Last Name') !!}
                                {!! Form::text('lastName',null,['required' => 'required','id'=>'lastName','class'=>'form-control']) !!}

                            </div>

                            <div class='form-group'>

                                {!! Form::label('Gender') !!}
                                {!!Form::select('gender', ['Male' => 'Male', 'Female' => 'Female','Other' => 'Other'], null, ['required' => 'required','id'=>'gender','class'=>'form-control','placeholder' => 'Select Gender...']) !!}
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
                                {!! Form::email('email',auth::guard('doctor')->user()->email,['required' => 'required','id'=>'email','class'=>'form-control']) !!}

                            </div>

                            <div class='form-group'>

                                {!! Form::label('Qualification') !!}
                                {!! Form::text('qualification',null,['required' => 'required','id'=>'qualification', 'class'=>'form-control']) !!}

                            </div>

                            <div class='form-group'>

                                {!! Form::label('Experience') !!}
                                {!! Form::text('experience',null,['required' => 'required','id'=>'experience', 'class'=>'form-control']) !!}

                            </div>


                            <div class='form-group'>

                                {!! Form::label('Specialisation') !!}
                                {!! Form::text('specialisation',null,['required' => 'required','id'=>'specialisation', 'class'=>'form-control']) !!}

                            </div>

                            <div class='form-group'>

                                {!! Form::Submit('Submit',['id'=>'btnAddDoctorDetails','class'=>"btn btn-primary form-control"]) !!}

                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

@stop

 