<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>

    <style>
        table {
            padding-right: 0px;
            padding-left: 0px;
            margin-top: 20px;
            border: 2px solid #57AED1;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 10px;
            margin-top: 10px;
        }


    </style>

</head>
<body>
<div class="appointment-detail_header">
    <div class="appointment-detail-header-left">
        <h2>Appointment Details</h2>
    </div>
</div>
<div class="appointment-detail">
    <div class="appointment">
        <!--Table-->
        <h3> Appointment Details</h3>
        <table class="table table-striped" style="border: none">
            @foreach($appointmentDetail as $item)
                <tr>
                    <td>Status</td>
                    <td>
                        @if($item->confirmed==0)

                            <i class="fa fa-spinner fa-pulse"></i> Not Confirmed


                        @elseif ($item->confirmed==1)
                            <span class="glyphicon glyphicon-ok"></span> Confirmed
                        @endif
                    </td>

                    <td>
                        @if($item->payment==0)

                            <i class="fa fa-spinner fa-pulse"></i> Not paid


                        @elseif ($item->payment==1)
                            <span class="glyphicon glyphicon-ok"></span> Paid &nbsp;&nbsp;Amount($): {{$bill->amount}}
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
        </table>
        <!--Table-->
    </div>

    <div class="patient-app">
        <!--Table-->
        <h3>Patient Details</h3>
        <table class="table table-striped" style="border: none">
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
        </table>
        <!--Table-->
    </div>

    <div class="doctor-app">

        <!--Table-->
        <h3>Doctor Details</h3>
        <table class="table table-striped" style="border: none">
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
        </table>
        <!--Table-->
    </div>

</div>

</body>
</html>
