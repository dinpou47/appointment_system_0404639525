<?php
/**
 * Created by PhpStorm.
 * User: dineshpoudel
 * Date: 6/5/18
 * Time: 7:22 PM
 */
<?
php
/**
 * Created by PhpStorm.
 * User: dineshpoudel
 * Date: 6/5/18
 * Time: 7:18 PM
 */
?>
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
<div class="container">
    <header class="Header">
        <h2>Appointment Details</h2>
    </header>

    <section>
        <table class="table table-striped" style="border: none">
            @foreach($printDetail as $item)
                <tr>
                    <td>Status</td>
                    <td>
                        @if($item->confirmed==0)

                            <i class="fa fa-spinner fa-pulse"></i> Not Confirmed


                        @elseif ($item->confirmed==1)
                            <span class="glyphicon glyphicon-ok"></span> Confirmed
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

    </section>

    <footer>

    </footer>
</div>

</body>
</html>


