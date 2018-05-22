@extends('layouts.app')

@section('content')
    <div class="container">
        <!--start div client-list-->
        <div class="alert alert-success" role="alert">
            Your are logged in as {{Auth::guard('admin')->user()->name}} <a style="float:right"
                                                                            class="glyphicon glyphicon-remove remove-message"></a> </label>
        </div>

        <h3><span class="label label-primary">{{$title}}</span></h1>
            <!--Table-->
            <table class="table table-striped">
                <!--Table head-->
                <thead class="mdb-color darken-3">
                <tr class="text-white">
                    <th>S.N</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>

                <?php  $count = 1; ?>
                <tbody>
                <!--Table head-->
                <!--Table body-->
                @foreach($users as $admin)
                    <tr>
                        <td scope="row">1</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email  }}</td>
                        <td>{{ $admin->role  }}</td>
                        <td>
                            <a href="#" class="btn btn-primary ">
                                <span class="glyphicon glyphicon-pencil"></span> Edit
                            </a>
                        </td>
                        <td>
                            <a href="#" class="btn btn-success">
                                <span class="glyphicon glyphicon-file"></span> Detail
                            </a>
                        </td>
                        <td>
                            <a href="#" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span> Delete
                            </a>

                        </td>
                    </tr>


                    <?php $count++; ?>
                @endforeach
                <!--Table body-->
                </tbody>
            </table>                <!--Table-->
    </div>

@stop