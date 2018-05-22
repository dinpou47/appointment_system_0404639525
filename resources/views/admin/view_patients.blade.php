@extends('layouts.app')

@section('content')
    <div class="container" style="width:100%">
        <!--start div client-list-->
        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif


        <div class=" form-style search-box" style="">
            @if($errors->any())
                <ul class="alert alert-danger" style="list-style-type: none">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>
            @endif
            <form action="{{route('admin.searchPatient')}}" method="POST" role="search">
                {{ csrf_field() }}
                <div class="input-group">
                    <input required type="text" class="form-control" name="searchInput"
                           placeholder="Search Patients">
                    <span class="input-group-btn">
						<button type="submit" class="btn btn-default">
							<span class="glyphicon glyphicon-search"></span>
						</button>
				</span>
                </div>
            </form>

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
                        <td scope="row">{{$count}}</td>
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
                            @if(auth::guard('admin')->check())
                                <a href="{{route('detailPatient',['id' => $client->patient_id])}}" class="btn btn-success">
                                    <span class="glyphicon glyphicon-eye-open"></span> Detail
                                </a>
                            @elseif (auth::guard('doctor')->check())
                                <a href="{{route('doctor.detailPatient',['id' => $client->patient_id])}}"
                                   class="btn btn-success">
                                    <span class="glyphicon glyphicon-eye-open"></span> Detail
                                </a>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('admin.deletePatient',$client->patient_id)}}" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span> Delete
                            </a>

                        </td>
                    </tr>


                    <?php $count++; ?>
                @endforeach
                <!--Table body-->
                </tbody>
            </table>
        {{$patients->links()}}
    </div>

@stop