@extends('front.layouts.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        
        @if(Session::has('success'))
        <div class="alert alert-success">
            <p class="mb-0 pb-0">{{ Session::get('success') }}</p>
        </div>
        @endif
        
        @if(Session::has('error'))
        <div class="alert alert-danger">
            <p class="mb-0 pb-0">{{ Session::get('error') }}</p>
        </div>
        @endif

        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Reset Password</h1>
                    
                    <!-- Step 1: Email Input -->
                    <div id="step1">
                        <form id="emailForm">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="mb-2">Email*</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                                <p class="invalid-feedback"></p>
                            </div>
                            <button type="submit" class="btn btn-primary">Get Reset Code</button>
                        </form>
                    </div>

                    <!-- Step 2: Code Verification -->
                    <div id="step2" style="display: none;">
                        <div class="alert alert-info">
                            <p class="mb-0">Your verification code is: <strong id="resetCode"></strong></p>
                        </div>
                        <form id="codeForm">
                            @csrf
                            <input type="hidden" name="email" id="hidden_email">
                            <div class="mb-3">
                                <label for="code" class="mb-2">Enter Verification Code*</label>
                                <input type="text" name="code" id="code" class="form-control" placeholder="Enter 4-digit code">
                                <p class="invalid-feedback"></p>
                            </div>
                            <button type="submit" class="btn btn-primary">Verify Code</button>
                        </form>
                    </div>

                    <!-- Step 3: New Password -->
                    <div id="step3" style="display: none;">
                        <form id="passwordForm">
                            @csrf
                            <div class="mb-3">
                                <label for="password" class="mb-2">New Password*</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password">
                                <p class="invalid-feedback"></p>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="mb-2">Confirm Password*</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password">
                                <p class="invalid-feedback"></p>
                            </div>
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </form>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('account.login') }}" class="btn btn-primary">Back to Login</a>
                </div>
            </div>
        </div>
        <div class="py-lg-5">&nbsp;</div>
    </div>
</section>
@endsection

@section('customJs')
<script>
    $(document).ready(function() {
        // Step 1: Email Form
        $("#emailForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("account.generateResetCode") }}',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === false) {
                        if (response.errors.email) {
                            $("#email").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(response.errors.email);
                        }
                    } else {
                        $("#resetCode").text(response.code);
                        $("#hidden_email").val($("#email").val());
                        $("#step1").hide();
                        $("#step2").show();
                    }
                }
            });
        });

        // Step 2: Code Verification
        $("#codeForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("account.verifyCode") }}',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === false) {
                        if (response.errors.code) {
                            $("#code").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(response.errors.code);
                        }
                    } else {
                        $("#step2").hide();
                        $("#step3").show();
                    }
                }
            });
        });

        // Step 3: Password Reset
        $("#passwordForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("account.resetPassword") }}',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === false) {
                        if (response.errors.password) {
                            $("#password").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(response.errors.password);
                        }
                        if (response.errors.password_confirmation) {
                            $("#password_confirmation").addClass('is-invalid')
                                .siblings('p')
                                .addClass('invalid-feedback')
                                .html(response.errors.password_confirmation);
                        }
                    } else {
                        window.location.href = '{{ route("account.login") }}';
                    }
                }
            });
        });
    });
</script>
@endsection 