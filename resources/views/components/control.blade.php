<div class="component" style=margin-bottom: 10px;">
@if(auth::guard('admin')->check())

    <a class="btn btn-primary hidden-xs" href="{{route('allAppointment')}}">
        <span class="glyphicon glyphicon-eye-open"></span> Appointments
    </a>

    <a class="btn btn-primary hidden-xs" href="{{route('createSchedule')}}">
        <span class="glyphicon glyphicon-plus-sign"></span> Add Doctor Schedule
    </a>
    <a class="btn btn-primary hidden-xs" href="">
        <span class="glyphicon glyphicon-plus-sign"></span>View Doctor Schedule
    </a>
    <a class="btn btn-primary hidden-xs" href="{{route('userList')}}">
        <span class="glyphicon glyphicon-eye-open"></span>Users
    </a>
    <a class="btn btn-primary hidden-xs" href="{{route('admin.payment')}}">
        <span class="glyphicon glyphicon-credit-card"></span>Payment
    </a>
    @elseif(auth::guard('doctor')->check())

    @elseif(auth::guard('patient')->check())


    @endif

    </div>

