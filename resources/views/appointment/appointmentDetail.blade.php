@extends('layouts.app')

@section('content')

    <div class="container">
        <!--start div client-list-->
        <div class="flash-message">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

        </div>

        <div class="appointment-detail_header">
            <div class="appointment-detail-header-left">
                <h3 class="label label-primary">Appointment Details</h3>
            </div>
            <div class='appointment-detail-header-right'>
                <a href="{{route('printAppointment',$app_id)}}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-print"></span> Print
                </a>
            </div>
        </div>


        <div class="appointment-detail">
            <div class="appointment">
                <!--Table-->
                <table class="table table-striped" style="border: none">
                    <thead>
                    <th>Appointment Details</th>
                    </thead>
                    <tbody>
                    @foreach($appointmentDetail as $item)
                        <tr>
                            <td>Status</td>
                            <td>
                                @if($item->payment==1)
                                    <span class="glyphicon glyphicon-ok"></span> Completed
                                @elseif($item->payment==0)
                                    @if($item->confirmed==0)
                                        @if(auth::guard('admin')->check())
                                            <a href="{{route('admin.appointmentConfirm',$item->id)}}"
                                               class="btn btn-success">
                                                <span class="glyphicon glyphicon-ok"></span> Confirm

                                            </a>

                                        @endif
                                        <i class="fa fa-spinner fa-pulse"></i> Please wait for confirmation

                                    @elseif ($item->confirmed==1)
                                        <span class="glyphicon glyphicon-ok"></span> Confirmed
                                    @endif
                                @endif


                            </td>
                        </tr>
                        <tr>
                            <td>Payment</td>
                            <td>
                                @if(auth::guard('admin')->check())
                                    @if($item->confirmed==1)
                                        @if($item->payment==0)
                                            <a href="" id="payment-button" data-id="{{$app_id}}" class="btn btn-success"
                                               data-toggle="modal" data-target="#add-payment">
                                                <span class="glyphicon glyphicon-credit-card"></span> Update Payment
                                            </a>
                                            <i class="fa fa-spinner fa-pulse"></i> Not Paid
                                        @elseif ($item->payment==1)
                                            <span class="glyphicon glyphicon-ok"></span> Paid &nbsp;&nbsp;Amount($): {{$bill->amount}}
                                           <span><a href="{{route('printBill',$app_id)}}" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-print"></span> Print Bill
                                            </a>
                                           </span>
                                        @endif
                                    @endif
                                @elseif(auth::guard('patient')->check()||auth::guard('doctor')->check())
                                    @if($item->confirmed==1)
                                        @if($item->payment==0)
                                            <i class="fa fa-spinner fa-pulse"></i> Not Paid
                                        @elseif ($item->payment==1)
                                            <span class="glyphicon glyphicon-ok"></span> Paid
                                        @endif
                                    @endif
                                @endif

                            </td>
                        </tr>

                        <tr>
                            <td>Appointment Date</td>
                            <td>{{$item->appointmentDate}}</td>
                        </tr>


                        <tr>
                            <td>Appointment Time</td>
                            <td>{{$item->appointmentTime}}</td>
                        </tr>


                        <tr>
                            <td>Description</td>
                            <td>{{$item->description}}</td>
                        </tr>


                    @endforeach
                    </tbody>
                </table>
                <!--Table-->
            </div>

            <div class="patient-app">
                <!--Table-->
                <table class="table table-striped" style="border: none">
                    <thead>
                    <tr>
                        <th>Patient Details</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($appointmentDetailPatient as $item)
                        <tr>
                            <td>First Name</td>

                            <td>{{$item->firstName}}</td>
                        </tr>

                        <tr>
                            <td>Last Name</td>

                            <td>{{$item->lastName}}</td>
                        </tr>

                        <tr>
                            <td>Address</td>

                            <td>{{$item->street.' ,'.$item->suburb.','.$item->state.','.$item->post}}</td>
                        </tr>

                        <tr>
                            <td>Age</td>

                            <td>{{$item->age}}</td>
                        </tr>

                        <tr>
                            <td>Disease</td>

                            <td>{{$item->disease}}</td>
                        </tr>

                        <tr>
                            <td>Contact</td>
                            <td>{{$item->contact}}</td>
                        </tr>

                        <tr>
                            <td>Last Name</td>

                            <td>{{$item->email}}</td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
                <!--Table-->
            </div>

            <div class="doctor-app">

                <!--Table-->
                <table class="table table-striped" style="border: none">
                    <thead>
                    <th>Doctor Details</th>
                    </thead>
                    <tbody>
                    @foreach($appointmentDetailDoctor as $item)
                        <tr>
                            <td>First Name</td>

                            <td>{{$item->firstName}}</td>
                        </tr>

                        <tr>
                            <td>Last Name</td>

                            <td>{{$item->lastName}}</td>
                        </tr>

                        <tr>
                            <td>Address</td>

                            <td>{{$item->street.' ,'.$item->suburb.','.$item->state.','.$item->post}}</td>
                        </tr>

                        <tr>
                            <td>Contact</td>
                            <td>{{$item->contact}}</td>
                        </tr>

                        <tr>
                            <td>Last Name</td>

                            <td>{{$item->email}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!--Table-->
            </div>

        </div>


        <!-- Modal form to edit a form -->
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
                                <select name="payment-mode" class="form-control payment-mode" required
                                        id="payment-mode">
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

        <!--  -->


    </div>

@stop