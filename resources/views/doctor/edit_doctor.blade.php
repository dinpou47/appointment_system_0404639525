@extends('layouts.app')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Update Details</div>

                    <div class="panel-body">
                        <div class="form-style form-update"
                        ">
                        @if($errors->any())
                            <ul class="alert alert-danger" style="list-style-type: none">

                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>
                        @endif

                        {!! Form::open(['action' => ['Doctor\DoctorController@updateDoctorDetail',$id]])!!}

                        <div class='form-group'>

                            {!! Form::label('First Name') !!}
                            {!! Form::text('firstName',$doctor->firstName,['required' => 'required','id'=>'firstName', 'class'=>'form-control']) !!}

                        </div>


                        <div class='form-group'>

                            {!! Form::label('Last Name') !!}
                            {!! Form::text('lastName',$doctor->lastName,['required' => 'required','id'=>'lastName','class'=>'form-control']) !!}

                        </div>

                        <div class='form-group'>

                            {!! Form::label('Gender') !!}
                            {!!Form::select('gender', ['Male' => 'Male', 'Female' => 'Female','Other' => 'Other'], $doctor->gender, ['required' => 'required','id'=>'gender','class'=>'form-control','placeholder' => 'Select Gender...']) !!}
                        </div>

                        <div class='form-group'>

                            {!! Form::label('Unit Street') !!}
                            {!! Form::text('street',$doctor->street,['required' => 'required','id'=>'street','class'=>'form-control']) !!}

                        </div>


                        <div class='form-group'>

                            {!! Form::label('Suburb') !!}
                            {!! Form::text('suburb',$doctor->suburb,['required' => 'required','id'=>'suburb','class'=>'form-control']) !!}

                        </div>


                        <div class='form-group'>

                            {!! Form::label('State') !!}
                            {!! Form::text('state',$doctor->state,['required' => 'required','id'=>'state','class'=>'form-control']) !!}

                        </div>


                        <div class='form-group'>

                            {!! Form::label('Post Code') !!}
                            {!! Form::text('post',$doctor->post,['required' => 'required','id'=>'post','class'=>'form-control']) !!}

                        </div>


                        <div class='form-group'>

                            {!! Form::label('Contact') !!}
                            {!! Form::text('contact',$doctor->contact,['required' => 'required','id'=>'contact','class'=>'form-control']) !!}
                        </div>


                        <div class='form-group'>

                            {!! Form::label('Email') !!}
                            {!! Form::email('email',$doctor->email,['required' => 'required','id'=>'email','class'=>'form-control']) !!}

                        </div>

                        <div class='form-group'>

                            {!! Form::label('Qualification') !!}
                            {!! Form::text('qualification',$doctor->qualification,['required' => 'required','id'=>'qualification', 'class'=>'form-control']) !!}

                        </div>

                        <div class='form-group'>

                            {!! Form::label('Experience') !!}
                            {!! Form::text('experience',$doctor->experience,['required' => 'required','id'=>'experience', 'class'=>'form-control']) !!}

                        </div>


                        <div class='form-group'>

                            {!! Form::label('Specialisation') !!}
                            {!! Form::text('specialisation',$doctor->specialisation,['required' => 'required','id'=>'specialisation', 'class'=>'form-control']) !!}

                        </div>

                        <div class='form-group'>

                            {!! Form::Submit('Update',['id'=>'btnAddDoctorDetails','class'=>"btn btn-success form-control"]) !!}

                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>

    </div>

@stop

 