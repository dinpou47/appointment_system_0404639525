@extends('layouts.app')

@section('content')
    <div class="container" style="width:100%">
        <!--start div client-list-->

        <div class="flash-message">
            @foreach (['success'] as $msg)
                @if(Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <span
                                class="glyphicon glyphicon-ok"></span></p>
                @endif
            @endforeach
        </div>
        <!--start div client-list-->
        <div class="flash-message">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>

    <div class="search-box" style="">
        <form action="{{route('admin.searchAppointment')}}" method="POST" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" required name="searchInput"
                       placeholder="Enter Appointment ID">
                <span class="input-group-btn">
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                     </span>
            </div>
        </form>
    </div>

    <h3><span class="label label-primary">Appointments</span></h3>
    <!--Table-->
    <span></span>
    <div>
        <table class="table table-striped">
            <!--Table head-->
            <thead class="mdb-color darken-3">
            <tr class="text-white">
                <th>S.N</th>
                <th>Appointment Number</th>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Confirmation</th>
                <th>Payment</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            </thead>

            <?php  $count = 1; ?>
            <tbody>
            <!--Table head-->
            <!--Table body-->
            @foreach($appointmentDetail as $app)
                <tr>
                    <td scope="row">{{$count}}</td>
                    <td>{{ $app->id }}</td>
                    <td>{{App\PatientDetail::getPatientName($app->patient_id)}}</td>
                    <td>{{App\DoctorDetail::getDoctorName($app->doctor_id)}}</td>
                    <td>{{ $app->appointmentDate }}</td>
                    <td>{{ $app->appointmentTime }}</td>
                    <td>
                        @if($app->confirmed==0)
                                <a href="{{route('admin.appointmentConfirm',$app->id)}}"
                                   class="btn btn-success">
                                    <span class="glyphicon glyphicon"></span> Confirm

                                </a>
                        @elseif ($app->confirmed==1)
                            <span class="glyphicon glyphicon-ok"></span>
                        @endif
                    </td>

                    <td>
                        @if($app->payment==0)
                            <span class="glyphicon glyphicon-remove"></span>
                        @elseif ($app->payment==1)
                            <span class="glyphicon glyphicon-ok"></span>
                        @endif
                    </td>

                    <td>
                        <a href="{{route('appointment.edit',$app->id)}}" class=" btn btn-info" data-id="{{$app->id}}"
                           data-title=""><span class="glyphicon glyphicon-edit"></span> Edit</a>
                    </td>
                    <td>
                        <a href="{{route('appointmentDetail',$app->id)}}" class="btn btn-success">
                            <span class="glyphicon glyphicon-eye-open"></span> Detail
                        </a>
                    </td>
                    <td>
                        @if($app->payment==0)
                            <a href="{{route('patient.appointmentCancel',$app->id)}}" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove-circle"></span> Cancel
                            </a>
                        @endif
                    </td>

                </tr>
                <?php $count++; ?>
            @endforeach
            <!--Table body-->
            </tbody>
            <tfoot>
            </tfoot>

        </table>
        <!--Table-->
    </div>
    <div class="pagination">
        {{$appointmentDetail->links()}}
    </div>
    <!-- Modal form to add payment  -->

    <!-- Modal -->
    <div class="modal fade" id="add-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Payment</h5>
                    <p style="color:Red" id="error-message"></p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-update-payment" method="POST" action="">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="payement-mode">Select Payment Mode</label>
                            <select name="payment-mode" class="form-control payment-mode" required id="payment-mode">
                                <option value="select">--select payment mode--</option>
                                <option value="Card">Card</option>
                                <option value="Cash">Cash</option>
                                >
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-form-label">Amount:</label>
                            <input name="amount" type="text" required class="form-control" id="amount">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Message:</label>
                            <textarea name="message-text" class="form-control" id="message-text"></textarea>
                        </div>

                    </form>
                    <p style="color:green;" class="payment-message">`</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <a href="" type="submit" class="btn btn-success btn-add-payment">Save</a>
                </div>
            </div>
        </div>
    </div>

    </div>

@stop