@extends('layouts.app')

@section('content')
    <div class="container" style="width:100%">
        <!--start div client-list-->

        @if(auth::guard('admin')->check())
            <a class="btn btn-primary hidden-xs" href="{{ route('doctor.register') }}">
                <span class="glyphicon glyphicon-plus"></span>Add Doctor
            </a>
        @endif


        <h1 class="head-text"><span class="label label-info">{{$title}}</span></h1>
        <!--Table-->
        <table class="table table-striped">
            <!--Table head-->
            <thead class="mdb-color darken-3">
            <tr class="text-white">
                <th>S.N</th>
                <th>Name</th>
                @if(auth::guard('admin')->check()||auth::guard('doctor')->check())
                    <th>Address</th>
                    <th>Email</th>
                    <th>Contact</th>
                @endif
                <th>Qualification</th>
                <th>Specialisation</th>
                <th>Experience</th>
                <th></th>
                @if(auth::guard('admin')->check()||auth::guard('doctor')->check())
                    <th></th>
                    <th></th>
                @elseif(auth::guard('patient')->check())
                    <th>

                    </th>
                @endif
            </tr>
            </thead>

            <?php  $count = 1; ?>
            <tbody>
            <!--Table head-->
            <!--Table body-->
            @foreach($doctorDetail as $doctor)

                <tr>
                    <td scope="row">{{$count}}</td>
                    <td>{{ $doctor->firstName .' '.$doctor->lastName}}</td>
                    @if(auth::guard('admin')->check()||auth::guard('doctor')->check())
                        <td>{{ $doctor->street  ." ,". $doctor->suburb." ,".$doctor->state}}</td>
                        <td>{{ $doctor->email  }}</td>
                        <td>{{ $doctor->contact }}</td>
                    @endif
                    <td>{{ $doctor->qualification}}</td>
                    <td>{{ $doctor->specialisation}}</td>
                    <td>{{ $doctor->experience}}</td>
                    <td>
                        <a href="{{route('doctor.detailDoctor',['id' => $doctor->doctor_id])}}" class="btn btn-success">
                            <span class="glyphicon glyphicon-eye-open"></span> Detail
                        </a>
                    </td>
                    @if(auth::guard('admin')->check()||auth::guard('doctor')->check())
                        <td>
                            <a href="{{route('editDoctorDetail',['id' => $doctor->id])}}" class="btn btn-info">
                                <span class="glyphicon glyphicon-edit"></span> Edit
                            </a>
                        </td>

                        <td>
                            <a href="{{route('deleteUser',$doctor->doctor_id)}}" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span> Delete
                            </a>
                        </td>
                    @elseif(auth::guard('patient')->check())
                        <td>

                        </td>
                    @endif
                </tr>
                <?php $count++; ?>
            @endforeach
            <!--Table body-->
            </tbody>
        </table>
       {{$doctorDetail->links()}}

    <!--Table-->
    </div>

@stop