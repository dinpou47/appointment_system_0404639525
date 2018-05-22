/*----------------------------------------------------*/
// Superslides
/*----------------------------------------------------*/
$('#slides').superslides({
    play: 2000,
    animation: 'fade', // slide
    pagination: true
});


$(document).ready(function () {
    $(".menu-list>li").hover(function () {
        $(this).css("background-color", "#EEEEEE");
    }, function () {
        $(this).css("background-color", "#3E6088");
    });

    $(".menu-list").find('li>a').css('color', '#FFFFFF');

    $(".menu-list").find('li>a').hover(function () {
        $(this).css("color", "green");
    }, function () {
        $(this).css("color", "#FFFFFF");
    });


//noti


    // ANIMATEDLY DISPLAY THE NOTIFICATION COUNTER.
    $('#noti-counter')
        .css({opacity: 0})
        .text('*')
        .css({top: '-10px'})
        .animate({top: '-2px', opacity: 1}, 500);

    function notificatonHtml(object) {
        var html = '';
        var count = 1;
        for (i = 0; i < object.length; i++) {
            html += '<p style="color:#000001;padding: 0px;margin:2px;font-size: 15px;">' + object[i].notification + '</p>';
        }
        return html;
    }


    $('#noti-button').click(function (e) {
        e.preventDefault();
        $('#notification-message').html('');
        console.log("hello");
        var url = $(this).attr('href');
        console.log(url);
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (message) {
                var response = eval(message);
                console.log(response);
                if (response.code = 202) {
                    $('#notification-message').append(notificatonHtml(response.object));

                } else if (response.code = 201) {
                    $('#notification-message').append('<p style="color:red;">' + response.message + '</p>');
                }
            }

        });


        // TOGGLE (SHOW OR HIDE) NOTIFICATION WINDOW.
        $('#notifications').fadeToggle('fast', 'linear', function () {
            if ($('#notifications').is(':hidden')) {
                $('#noti-button').css('background-color', '#f3f7fa');
            }
            else $('#noti-button').css('background-color', '#f3f7fa');
        });

        $('#noti-counter').fadeOut('slow');

        return false;
    });

    // HIDE NOTIFICATIONS WHEN CLICKED ANYWHERE ON THE PAGE.
    $(document).click(function () {
        $('#notifications').hide();

        // CHECK IF NOTIFICATION COUNTER IS HIDDEN.
        if ($('#noti-counter').is(':hidden')) {
            // CHANGE BACKGROUND COLOR OF THE BUTTON.
            $('#noti-button').css('background-color', '#f3f7fa');
        }
    });

    $('#notifications').click(function () {
        return false;       // DO NOTHING WHEN CONTAINER IS CLICKED.
    });


    $(".form-datepicker").datepicker({
        format: 'yyyy-mm-dd',
    }).on('change', function () {
        $('.datepicker').hide();
    });


    $(".selectScheduleDate").datepicker({
        format: 'yy-mm-dd',
    }).on('change', function () {
        console.log('hello');
    });


    function getDay(date) {
        var weekday = new Array(7);
        weekday[0] = "Sunday";
        weekday[1] = "Monday";
        weekday[2] = "Tuesday";
        weekday[3] = "Wednesday";
        weekday[4] = "Thursday";
        weekday[5] = "Friday";
        weekday[6] = "Saturday";

        var n = weekday[date.getDay()];
        return n;
    }

    //ajax function to referesh the doctor schedule

    function refreshSchedulePage() {
        var url = $('#select-doctor :selected').attr('data-url');
        console.log(url);
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (message) {
                var response = eval(message);
                var code = response['code'];
                var object = response.object;
                console.log(code);
                if (code == 202) {
                    $('#schedule-detail').append(displayScheduleHtml(object));
                }
            }
        });
    }

//append schedule

    $("#btnAddSchedule").on('click', function (e) {
        e.preventDefault();
        $('#schedule-detail').html('');
        $('#response-message').html('');

        console.log("Hello");
        var id = $('.select-doctor :selected').val();
        console.log(id);
        var date = $("#form-datepicker").val();
        console.log(date);
        $start = $("#start").val();
        $end = $("#end").val();
        console.log(id);
        if (id='') {
            $('#response-message').html('<p style="padding: 3px;color: #ff0c0c;"><span class="glyphicon glyphicon-remove-circle"></span>Please select the doctor</p>');
        } else if (date=='') {
            $('#response-message').html('<p style="padding: 3px;color: #ff0c0c;"><span class="glyphicon glyphicon-remove-circle"></span>Please select time</p>');

        } else {
            $.ajax({
                url: $('#formStoreSchedule').attr('action'),
                type: 'POST',
                dataType: 'json',
                data: $('#formStoreSchedule').serialize(),
                success: function (message) {
                    var response = eval(message);
                    var code = (response['code']);
                    var object = response.object;
                    console.log(code);
                    if (code == 202) {
                        $('#response-message').html('<p style="padding: 3px;color: green;"><span class="glyphicon glyphicon-ok-circle"></span>' + response['message'] + '</p>');
                        setTimeout(function () {
                            $('#response-message').fadeOut('slow');
                        }, 3000);
                        refreshSchedulePage();
                        $('#response-message').css('display', 'block');
                    } else if (code == 201) {
                        $('#response-message').html('<p style="padding: 3px;color: #ff0c0c;"><span class="glyphicon glyphicon-remove-circle"></span>' + response['message'] + '</p>');

                        setTimeout(function () {
                            $('#response-message').fadeOut('slow');
                        }, 3000);

                        refreshSchedulePage();
                        $('#response-message').css('display', 'block');

                    }

                }
            });

        }

    });

//get the doctor schedule on change function
    $('.select-doctor').on('change', function () {
        $('#schedule-detail').html('');
        $('#response-message').html('');
        var id = $('#select-doctor :selected').val();
        console.log(id);
        var url = $('#select-doctor :selected').attr('data-url');
        console.log(url);
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (message) {
                var response = eval(message);
                var code = response['code'];
                console.log(code);
                if (code == 202) {
                    var object = response.object;
                    $('#schedule-detail').append(displayScheduleHtml(object));
                } else if (code == 201) {
                    $('#response-message').html('<p style="padding: 3px;color: #ff0c0c;"><span class="glyphicon glyphicon-remove-circle"></span>' + response['message'] + '</p>');
                }
            }
        });
    });

    function format_time(date_obj) {
        // formats a javascript Date object into a 12h AM/PM time string
        var hour = date_obj;
        var amPM = (hour > 11) ? "pm" : "am";
        if (hour > 12) {
            hour -= 12;
        } else if (hour == 0) {
            hour = "12";
        }
        return hour + ":" + amPM;
    }

    //display the docotor schedule
    function displayScheduleHtml(object) {
        var html = " ";
        html += '<h3> <span class="label label-primary">Doctor Schedule</span></h1>';
        html += '<table class="table table-striped">';
        html += '<thead class="mdb-color darken-3">';
        html += '<tr class="text-white">';
        html += '<th>S.N</th>';
        html += '<th>Appointme Date</th>';
        html += '<th>Appointment Start</th>';
        html += '<th>Appointment End</th>';
        html += '<th>Status</th>';
        html += '<th></th>';

        html += '</tr>';
        html += '</thead> <tbody>';
        var count = 1;
        for (i = 0; i < object.length; i++) {
            html += '<tr>';
            html += '<td scope="row">' + count + '</td>';
            html += '<td>' + object[i].appointmentDate + '</td>';
            html += '<td>' + object[i].start + '</td>';
            html += '<td>' + (object[i].end) + '</td>';
            if (object[i].availability == 1) {
                html += '<td><button class="btn btn-success" data-id="">';
                html += '<span class="glyphicon glyphicon-ok"></span>Available';
                html += '</button>';
                html += '</td>';
            } else if (object[i].availability == 0) {
                html += '<td><button class="btn btn-default" data-id="">';
                html += '<span class="glyphicon glyphicon-remove"></span>Booked';
                html += '</button>';
                html += '</td>';
            }
            html += '<td id="delete-schedule-td">';
            if (object[i].availability == 1) {
                html += '<button id="delete-schedule" class="btn btn-danger" data-id="' + object[i].id + '">';
                html += '<span class="glyphicon glyphicon-trash"></span> Delete';
                html += '<span class="hidden" id="schedule-id">' + object[i].id + '</span> <span id="delete-success"></span>';
                html += '</button>';
            }
            html += '</td>';


            html += '</tr>';
            count++;
        }
        html += '</tbody>';
        html += '</table>';
        return html;
    }

    //delete schedule
    $(document).on('click', '#delete-schedule', function (e) {
        e.preventDefault();
        console.log("Delete button clicked");
        var id = $(this).attr('data-id');

        console.log(APP_URL);
        $.ajax({
            url: APP_URL + '/admin/deleteDoctorSchedule/' + id,
            type: 'GET',
            dataType: 'json',
            success: function (message) {
                var response = eval(message);
                if (response.code == 202) {
                    $('#response-message').html('<p style="padding: 3px;color: green;"><span class="glyphicon glyphicon-ok-circle"></span>' + response['message'] + '</p>');
                    $('#schedule-detail').html('');

                    refreshSchedulePage();
                    setTimeout(function () {
                        $('#response-message').fadeOut('slow');
                    }, 3000);

                    $('#response-message').css('display', 'block');


                }

            }
        });

    });

///book appointment

    function getDate(object) {
        var html = '';
        html += '<label for="selectDate">Select Date</label>';
        html += '<select name="selectAppointmentDate" class="form-control custom-select selectAppointmentDate"  required id="selectAppointmentDate">';
        html += '<option>--select date--</option>';
        for (i = 0; i < object.length; i++) {
            html += '<option data-id="' + object[i].doctor_id + '" value="' + object[i].appointmentDate + '" >' + object[i].appointmentDate;
            html += '</option>';
        }
        html += '</select>';
        return html;
    }

    $('.doctor-name').on('change', function (e) {
        e.preventDefault();
        console.log("Doctor changed");
        $('.appointment-time').html('');
        var url = $('.doctor-name :selected').attr('data-url');
        console.log(url);
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (message) {
                var response = eval(message);
                var code = response['code'];
                var object = response.doctorDate;
                console.log(response.doctorDate);
                console.log(object);
                if (code == 202) {
                    $('.appointment-date').html('');
                    $('.appointment-date').append(getDate(object));
                    $('.selectAppointmentDate').attr('required', 'required');

                } else {

                }
            }
        });

    });

//handle change date

    function getTime(object) {
        var html = '';
        html += '<label for="selectTime">Select Time</label>';
        html += '<select name="scheduleID" class="form-control custom-select selectAppointmentTime"  required id="selectAppointmentTime">';
        html += '<option>--select Time--</option>';
        for (i = 0; i < object.length; i++) {
            html += '<option data-id="' + object[i].doctor_id + '" value="' + object[i].id + '" >' + object[i].start + '-' + object[i].end;
            html += '</option>';
        }
        html += '</select>';
        return html;
    }

    //handle change date function
    $(document).find('.appointment-date').on('change', '#selectAppointmentDate', function (e) {
        e.preventDefault();
        console.log('hello');
        var id = $('#selectAppointmentDate :selected').attr('data-id');
        var date = $('#selectAppointmentDate :selected').text();
        var ur = APP_URL + '/patient/getDoctorScheduleByIdDate/' + id + '/' + date;
        console.log(ur);
        $.ajax({
            url: ur,
            type: 'GET',
            dataType: 'json',
            success: function (message) {
                var response = eval(message);
                var object = response.object;
                if (response.code == 202) {
                    console.log(response.message);
                    $('.appointment-time').html('');
                    $('.appointment-time').append(getTime(object));
                    $('.selectAppointmentTime').attr('required', 'required');

                } else {
                    $('#response-message').html('<p style="padding: 3px;color: red;"><span class="glyphicon glyphicon-ok-circle"></span>' + response['message'] + '</p>');
                }
            }


        });
    });

    $(document).find('.appointment-time').on('change', '#selectAppointmentTime', function (e) {
        console.log('Time changed');
        $('#btnAddAppointment').removeAttr('disabled');

    });


    //add appointment

    //hide the message
    setTimeout(function () {
        $('.flash-message').fadeOut('slow');
    }, 2000);


    //remove flash message after login
    $('.remove-message').click(function () {
        setTimeout(function () {
            $('.alert').fadeOut('fast');
        });
    });


    //contact form
    $('#characterLeft').text('200 characters left');
    $('#message').keydown(function () {
        var max = 200;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft').text('You have reached the limit');
            $('#characterLeft').addClass('red');
            $('#btnSubmit').addClass('disabled');
        }
        else {
            var ch = max - len;
            $('#characterLeft').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft').removeClass('red');
        }
    });
//timepicker setting


    $('.start-timepicker').timepicker({
        timeFormat: 'h:mm a',
        interval: 60,
        minTime: '9',
        maxTime: '9:00pm',
        defaultTime: '9',
        startTime: '9:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    $('.end-timepicker').timepicker({
        timeFormat: 'h:mm a',
        interval: 60,
        minTime: '9',
        maxTime: '9:00pm',
        defaultTime: '9',
        startTime: '9:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });


    //get the d
    //
    //
    // octor schule on date change

    $('.selectScheduleDate').on('change', function (e) {
        e.preventDefault();
        console.log('hello');
        $('#response-message').html('');
        var id = $('.select-doctor :selected').val();
        console.log(id);
        if (id == '') {
            $('#response-message').html('<p style="padding: 3px;color: #ff0c0c;"><span class="glyphicon glyphicon-remove-circle"></span>Please select the doctor</p>');

        } else {
            var date = $('#selectScheduleDate').val();
            console.log(date);
            var ur = APP_URL + '/patient/getDoctorScheduleByIdDate/' + id + '/' + date;
            console.log(ur);
            $.ajax({
                url: ur,
                type: 'GET',
                dataType: 'json',
                success: function (message) {
                    var response = eval(message);
                    var object = response.object;
                    if (response.code == 202) {
                        console.log(response.object);
                        $('#schedule-detail').html(" ");
                        $('#schedule-detail').append(displayScheduleHtml(object));
                    } else if (response.code == 201) {
                        $('#response-message').html('<p style="padding: 3px;color:red"><span class="glyphicon glyphicon-remove-circle"></span>No Schedule found in the selected date</p>');
                        $('#schedule-detail').html('');
                    }
                }


            });

        }

    });


    //validate payment modal
    $('.btn-add-payment').on('click', function (e) {
        e.preventDefault();
        var app_id = $('#payment-button').attr('data-id');
        //$('input[id="appointment-id"]').val('app_id');
        var amount = $('#amount').val();
        // $('#appointment-id :input').val('app_id');
        var pmode = $('#payment-mode :selected').attr('value');
        console.log(pmode);
        if (amount == "") {
            $('#error-message').text('Please enter the amount');
        }
        else if (pmode == "select") {
            $('#error-message').text('Please select the payment mode');
        } else {
            var ur = $('.form-update-payment').attr('action');
            var urls = APP_URL + '/admin/billPayment/' + app_id;
            var da = $('.form-update-payment').serialize();
            console.log(app_id);
            console.log(ur);
            $.ajax({
                url: urls,
                type: 'POST',
                data: da,
                dataType: 'json',
                success: function (message) {
                    console.log('Hello');
                    var response = eval(message);
                    console.log(response.message);
                    $('.payment-message').text(response.message);
                    setTimeout(function () {
                        $("#add-payment").modal('hide').slow();
                    }, 1000);

                    location.reload();

                }
            });
        }

    })


});