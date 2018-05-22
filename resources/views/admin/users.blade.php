@extends('layouts.app')

@section('content')
    <div class="container">
        <!--start div client-list-->


        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif


        <h3><span class="label label-info">{{$title}}</span></h3>
            <!--Table-->
            <table class="table table-striped">
                <!--Table head-->
                <thead class="mdb-color darken-3">
                <tr class="text-white">
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>

                <?php  $count = 1; ?>
                <tbody>
                <!--Table head-->
                <!--Table body-->
                @foreach($doctor as $d)

                    <tr>
                        <td scope="row">{{$count}}</td>

                        <td>{{ $d->name}}</td>
                        <td>{{ $d->email}}</td>
                        <td>
                            <a href="#" class="btn btn-primary ">
                                <span class="glyphicon glyphicon-edit"></span> Edit
                            </a>
                        </td>
                        <td>

                            <a href="{{route('deleteUser',$d->id)}}" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span> Delete
                            </a>

                        </td>
                    </tr>


                    <?php $count++; ?>
                @endforeach
                <!--Table body-->
                </tbody>
            </table>                <!--Table-->
        {{$doctor->links()}}
    </div>

@stop