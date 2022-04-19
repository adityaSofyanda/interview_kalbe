<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel 8 Firebase - Phone Number OTP Authentication</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    </head>
    <body>
        <div class="container mt-5">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">Add Phone Number</div>
                        <div class="card-body">
                            <div class="alert alert-danger" id="error" style="display: none;"></div>
                            <div class="alert alert-success" id="successAuth" style="display: none;"></div>
                            <form>
                                <input type="text" id="number" class="form-control" placeholder="+62 ********">
                                <div id="recaptcha-container" class="mt-2"></div>
                                <button type="button" class="btn btn-primary mt-3" onclick="sendOTP();">Send OTP</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">Add verification code</div>
                        <div class="card-body">
                            <div class="alert alert-success" id="successOtpAuth" style="display: none;"></div>
                            <form>
                                <input type="text" id="verification" class="form-control" placeholder="Verification code">
                                <button type="button" class="btn btn-success mt-3" onclick="verify()">Verify code</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
        <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
        <script>
            var firebaseConfig = {
            apiKey: "AIzaSyAcu2x6oumnMn1cs0r6SApKXbgQ-cBk9Vc",
            authDomain: "laravel-otp-authenticati-e6d0d.firebaseapp.com",
            projectId: "laravel-otp-authenticati-e6d0d",
            storageBucket: "laravel-otp-authenticati-e6d0d.appspot.com",
            messagingSenderId: "881195985983",
            appId: "881195985983:web:e876d23dc6cb5385bb9c8a",
            measurementId: "G-NCS3KH66Z4"
            };
            firebase.initializeApp(firebaseConfig);
        </script>
        <script type="text/javascript">
            window.onload = function () {
                render();
            };
            
            function render() {
                window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
                recaptchaVerifier.render();
            }
            
            function sendOTP() {
                var number = $("#number").val();
                firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
                    window.confirmationResult = confirmationResult;
                    coderesult = confirmationResult;
                    console.log(coderesult);
                    $("#successAuth").text("Message sent");
                    $("#successAuth").show();
                }).catch(function (error) {
                    $("#error").text(error.message);
                    $("#error").show();
                });
            }
            
            function verify() {
                var code = $("#verification").val();
                coderesult.confirm(code).then(function (result) {
                    var user = result.user;
                    console.log(user);
                    $("#successOtpAuth").text("Auth is successful");
                    $("#successOtpAuth").show();
                }).catch(function (error) {
                    $("#error").text(error.message);
                    $("#error").show();
                });
            }
        </script>
    </body>
</html>
