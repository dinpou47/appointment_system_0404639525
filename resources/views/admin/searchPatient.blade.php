@extends('layouts.app')

@section('content')
    <div class="container">
        <!--start div client-list-->


        <div class="search-box" style="">
            <form action="{{route('admin.searchPatient')}}" method="POST" role="search">
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


        @if(isset($patients))
            <div>
                <div class="flash-message">
                    @foreach (['success'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <span
                                        class="glyphicon glyphicon-ok"></span></p>
                        @endif
                    @endforeach
                </div>
                <h3><span class="label label-info">{{$title}}</span></h3>
                <!--Table-->
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
                        <th></th>
                    </tr>
                    </thead>

                    <?php  $count = 1; ?>
                    <tbody>
                    <!--Table head-->
                    <!--Table body-->
                    @foreach($patients as $client)

                        <tr>
                            <td scope="row">1</td>
                            <td>{{ $client->firstName }}</td>
                            <td>{{ $client->lastName  }}</td>
                            <td>{{ $client->street  ." ,". $client->suburb." ,".$client->state}}</td>
                            <td>{{ $client->contact  }}</td>
                            <td>{{ $client->email  }}</td>

                            <td>
                                @if(auth::guard('admin')->check())
                                    <a href="{{route('editPatientDetail',['id' => $client->id])}}" class="btn btn-info">
                                        <span class="glyphicon glyphicon-edit"></span> Edit
                                    </a>
                                @endif
                            </td>
                            <td>
                                @if (auth::guard('doctor')->check())
                                    <a href="{{route('doctor.detailPatient',['id' => $client->patient_id])}}"
                                       class="btn btn-success">
                                        <span class="glyphicon glyphicon-eye-open"></span> Detail
                                    </a>
                                @elseif (auth::guard('admin')->check())
                                    <a href="{{route('detailPatient',['id' => $client->patient_id])}}"
                                       class="btn btn-success">
                                        <span class="glyphicon glyphicon-eye-open"></span> Detail
                                    </a>
                                @endif
                            </td>

                            <td>
                                @if(auth::guard('admin')->check())
                                    <a href="{{route('admin.deletePatient',['id' => $client->patient_id])}}" class="btn btn-danger">
                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                    </a>
                                @endif

                            </td>
                        </tr>
                        <?php $count++; ?>
                    @endforeach
                    <!--Table body-->
                    </tbody>
                </table>
            </div>
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

@stop