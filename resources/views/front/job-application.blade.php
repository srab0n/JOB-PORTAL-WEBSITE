@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jobs') }}">Jobs</a></li>
                        <li class="breadcrumb-item active">Apply for {{ $job->title }}</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                @include('front.message')
                @if(isset($alreadyApplied) && $alreadyApplied)
                    <div class="alert alert-danger">You have already applied for this job.</div>
                @endif
                <div id="general-error" class="alert alert-danger" style="display:none;"></div>
                <form action="{{ route('jobs.apply', $job->id) }}" method="post" id="applicationForm" name="applicationForm" @if(isset($alreadyApplied) && $alreadyApplied) style="pointer-events:none;opacity:0.6;" @endif>
                    @csrf
                    <div class="card border-0 shadow p-4">
                        <h3 class="fs-4 mb-4">Application Form</h3>

                        <div class="mb-4">
                            <label for="institute" class="mb-2">Institute<span class="req">*</span></label>
                            <input type="text" name="institute" id="institute" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="degree" class="mb-2">Degree<span class="req">*</span></label>
                            <input type="text" name="degree" id="degree" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="cgpa" class="mb-2">CGPA<span class="req">*</span></label>
                            <input type="text" name="cgpa" id="cgpa" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="passing_year" class="mb-2">Passing Year<span class="req">*</span></label>
                            <input type="text" name="passing_year" id="passing_year" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="experience" class="mb-2">Years of Experience<span class="req">*</span></label>
                            <select name="experience" id="experience" class="form-control">
                                <option value="">Select Experience</option>
                                <option value="1">1 Year</option>
                                <option value="2">2 Years</option>
                                <option value="3">3 Years</option>
                                <option value="4">4 Years</option>
                                <option value="5">5 Years</option>
                                <option value="6">6 Years</option>
                                <option value="7">7 Years</option>
                                <option value="8">8 Years</option>
                                <option value="9">9 Years</option>
                                <option value="10">10 Years</option>
                                <option value="10_plus">10+ Years</option>
                            </select>
                        </div>

                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary" id="submitApplication">Submit Application</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow p-4">
                    <h3 class="fs-4 mb-4">Job Details</h3>
                    <div class="mb-4">
                        <h4 class="mb-1">{{ $job->title }}</h4>
                        <p class="mb-0">{{ $job->company_name }}</p>
                        <p class="mb-0">{{ $job->location }}</p>
                    </div>
                    <div class="mb-4">
                        <h5>Job Type</h5>
                        <p>{{ $job->jobType->name }}</p>
                    </div>
                    <div class="mb-4">
                        <h5>Experience Required</h5>
                        <p>{{ $job->experience }} Years</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script type="text/javascript">
    // Ensure CSRF token is sent with all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $("#applicationForm").submit(function(e) {
        e.preventDefault();
        $("button[type='submit']").prop('disabled', true);

        $.ajax({
            url: '{{ route("jobs.apply", $job->id) }}',
            type: 'POST',
            dataType: 'json',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                $("#general-error").hide().text("");
                $("button[type='submit']").prop('disabled', false);
                if (response.status === true) {
                    // Redirect to jobs applied page to show success message
                    window.location.href = response.redirect;
                } else {
                    var errors = response.errors;
                    // Show general error if present
                    if (errors.general) {
                        $("#general-error").text(errors.general[0]).show();
                    }
                    // Reset all fields
                    $(".is-invalid").removeClass('is-invalid');
                    $(".invalid-feedback").remove();
                    // Handle each error
                    $.each(errors, function(field, messages) {
                        if(field !== 'general') {
                            var input = $("#" + field);
                            input.addClass('is-invalid');
                            $.each(messages, function(index, message) {
                                input.after('<div class="invalid-feedback">' + message + '</div>');
                            });
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                $("button[type='submit']").prop('disabled', false);
                alert("An error occurred while submitting your application. Please try again.");
            }
        });
    });
</script>
@endsection 