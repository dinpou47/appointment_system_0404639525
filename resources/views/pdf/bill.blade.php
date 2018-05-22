<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <link rel="stylesheet" type="text/css" href="../../../public/appointment/master.css">
    <link rel="stylesheet" type="text/css" href="../../../public/css.bootstrap.min.css">

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


        .bill {
            with: auto;
        }

        tbody {
            font-size: 10px;
        }


    </style>

</head>
<body>
<div class="container">
    <div class="logo">
        <h1>7-Day Psychology</h1>
    </div>
    <div class="Header">
        <h2>Appointment Bill</h2>
    </div>

    <div class="info">
        <div class="patient-info">
            <h3>Patient Details</h3>
            <p>
                Patient Name:{{$appointmentDetailPatient->firstName.' '.$appointmentDetailPatient->lastName}}
            </p>
            <p>Address:{{$appointmentDetailPatient->street.' '.$appointmentDetailPatient->suburb.' '.$appointmentDetailPatient->post.' '.$appointmentDetailPatient->state}}</p>

        </div>
    </div>

    <div class="bill">
        <table class="table table-striped" style="border: none">
            <thead>
            <tr>
                <th>Appointment ID</th>
                <th>Doctor</th>
                <th>Mode of Payment</th>
                <th>Amount</th>
                <th>Payment Date</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$appointmentDetail->id}}</td>
                <td>{{$appointmentDetailDoctor->firstName}}</td>
                <td>{{$bill->payment_mode}}</td>
                <td>{{$bill->amount}}</td>
                <td>{{$bill->updated_at}}</td>
            </tr>

            </tbody>
        </table>
    </div>
</div>

</body>
</html>


