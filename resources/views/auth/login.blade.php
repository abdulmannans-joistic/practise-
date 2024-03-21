@extends('layouts.layout')

@section('title', 'Login')

@section('content')
<div class="CampaignsPage">
    <div class="container mt-4 d-flex justify-content-center align-items-center">
       
        <div class="card newProductFlowContainer" style="width: 1320px; height:567px">
            
            <div class="card-body text-center" id="login">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h1 class="py-2" style="font-size: 40px; font-weight: 700; line-height: 60px; letter-spacing: 0em; text-align: center;"> Log in to <span class="blue">Source.IO </span></h1>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="" fdprocessedid="avz76" style="border-radius: 10px;">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" fdprocessedid="ksorxn" style="border-radius: 10px;">
                    </div>
                    <p class="md_font primarycolor text-end" id="forgot_pass" style="margin-bottom:10px;"><a href="forgotPassword.html" class="blue forgot-reset">Forgot Password /</a> <a href="#" onclick="Toggle()">Register</a></p>

                    <div class="d-flex">
                        <button type="submit" class="btn btn-type-one">Submit</button>
                    </div>
                </form>
            </div>

            <div class="card-body text-center" id="register" style="display: none;">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h1 class="py-2" style="font-size: 40px; font-weight: 700; line-height: 60px; letter-spacing: 0em; text-align: center;">Register to <span class="blue">Source.IO </span></h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="" style="border-radius: 10px;">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="" fdprocessedid="avz76" style="border-radius: 10px;">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" fdprocessedid="ksorxn" style="border-radius: 10px;">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" fdprocessedid="ksorxn" style="border-radius: 10px;">
                    </div>
                
                    <p class="md_font primarycolor text-end" id="forgot_pass" style="margin-bottom: 0px;"> <a href="#" onclick="Toggle()">Login</a></p>

                    <div class="d-flex">
                        <button type="submit" class="btn btn-type-one">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function Toggle(){
        var register = document.getElementById("register");
        var login = document.getElementById("login");
        if (register.style.display === "none") {
            register.style.display = "block";
            login.style.display = "none";
        } else {
            register.style.display = "none";
            login.style.display = "block";
        }
    }
</script>
@endsection
