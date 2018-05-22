@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if(Auth::guard('patient')->check())
                            <a class="btn btn-danger" href="{{ route('patient.addDetails') }}">
                                Click here to complete the registration process
                            </a>
                        @elseif(Auth::guard('doctor'))
                            <a class="btn btn-danger" href="{{ route('doctor.addDetails') }}">
                                Click here to complete the registration process
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
