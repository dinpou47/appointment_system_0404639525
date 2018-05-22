@extends('layouts.app')

@section('content')
    <div class="container">
        <!--start div client-list-->

        @component('components.control')
        @endcomponent


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
                @foreach($user as $doctor)

                    <tr>
                        <td scope="row">1</td>
                        <td>{{ $doctor->firstName }}</td>
                        <td>{{ $doctor->email  }}</td>
                        <td>{{ $doctor->role  }}</td>
                        <td>
                            <button type="button" class="btn btn-primary">Edit</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success">Detail</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>


                    <?php $count++; ?>
                @endforeach
                <!--Table body-->
                </tbody>
            </table>                <!--Table-->
    </div>

@stop