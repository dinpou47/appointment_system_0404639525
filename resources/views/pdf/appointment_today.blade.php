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

        .header {
            font-size: 15px;
            background-color: lightgray;
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
        <h3>Todays Date: {{\Carbon\Carbon::now()->format('Y-m-d')}}</h3>
    </div>
    <header class="Header">
        <h2>Appointment Details</h2>
        <p>Total Appointmemnts: {{$appointmentDetail->count()}}</p>
    </header>

    <section>
        <table class="table table-striped" style="border: none">
            <thead>
            <tr class="header">
                <th>
                    Appointment ID
                </th>
                <th>
                    Patient Name
                </th>
                <th>
                    Doctor Name
                </th>
                <th>
                    Appointment date
                </th>
                <th>
                    Appointment Time
                </th>
                <th>
                    Appointment Time
                </th>
            </tr>
            </thead>

            @foreach($appointmentDetail as $item)
                <tbody>
                <tr>
                    <td>
                        {{$item->id}}
                    </td>
                    <td>
                        {{$item->pfname.' '.$item->plname}}
                    </td>
                    <td>
                        {{$item->dfname.' '.$item->dlname}}
                    </td>

                    <td>
                        {{$item->appointmentDate}}
                    </td>
                    <td>
                        {{$item->appointmentTime}}
                    </td>
                    <td>
                        @if($item->confirmed=='0')
                            Not Confirmed
                        @elseif($item->confirmed=='1')
                            Confirmed
                        @endif
                    </td>
                </tr>

                </tbody>


            @endforeach
        </table>

    </section>

    <footer>

    </footer>
</div>

</body>
</html>


