@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-top: -10px">
            <div style="margin-bottom: 10px;" id="contact-form" class="col-8">
                <h3 class="page-header">Contact Form</h3>
                <div class="form-area">
                    <form role="form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Name</label>
                            <input required type="text" class="form-control" id="name" name="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Contact No</label>
                            <input type="text" class="form-control" id="mobile" name="mobile"
                                   placeholder="Mobile Number" required>
                        </div>
                        <div class="form-group">
                            <textarea required class="form-control" type="textarea" id="message" placeholder="Message"
                                      maxlength="200" rows="7"></textarea>
                            <span class="help-block"><p id="characterLeft" class="help-block ">You have reached the limit</p></span>
                        </div>
                        <button type="submit" id="submit" name="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>

            </div>
            <div id="contact-info" class="col-6">
                <h3 class="page-header">Contact Us</h3>
                <p><span>Contact: </span><span>03 9809 9090</span></p>
                <p><span>Email: </span><span>enquiry@7-day.com</span></p>
            </div>
        </div>
    </div>



@endsection