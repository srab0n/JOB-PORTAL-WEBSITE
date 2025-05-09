@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow mb-4 p-3">
                    <h3 class="fs-4 mb-4">Applicants for: {{ $job->title }}</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Applied Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applicants as $applicant)
                                    <tr>
                                        <td>{{ $applicant->user->name ?? 'N/A' }}</td>
                                        <td>{{ $applicant->user->email ?? 'N/A' }}</td>
                                        <td>{{ $applicant->applied_date ? \Carbon\Carbon::parse($applicant->applied_date)->format('d M, Y') : 'N/A' }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm" data-applicant-id="{{ $applicant->applicant_id }}">Accept</button>
                                            <button class="btn btn-danger btn-sm" data-applicant-id="{{ $applicant->applicant_id }}">Reject</button>
                                            <button class="btn btn-warning btn-sm" data-applicant-id="{{ $applicant->applicant_id }}">Call for Interview</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No applicants found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $applicants->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
// Ensure CSRF token is sent with all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    function updateRowStatus(button, statusText) {
        const row = button.closest('tr');
        $(row).find('td:last').html('<span class="badge bg-info">' + statusText + '</span>');
    }

    function showAlert(message, type = 'danger') {
        // Remove any existing alert
        $('.custom-alert').remove();
        // Add new alert above the table
        $('.table-responsive').before(
            `<div class="alert alert-${type} custom-alert" role="alert">${message}</div>`
        );
        // Auto-hide after 3 seconds
        setTimeout(() => { $('.custom-alert').fadeOut(); }, 3000);
    }

    $('.btn-success').click(function() {
        let id = $(this).data('applicant-id');
        let btn = this;
        updateApplicantStatus(id, 'accept', btn, 'Accepted');
    });
    $('.btn-danger').click(function() {
        let id = $(this).data('applicant-id');
        let btn = this;
        updateApplicantStatus(id, 'reject', btn, 'Rejected');
    });
    $('.btn-warning').click(function() {
        let id = $(this).data('applicant-id');
        let btn = this;
        updateApplicantStatus(id, 'interview', btn, 'Interview');
    });

    function updateApplicantStatus(applicantId, action, btn, statusText) {
        let url = `/employer/applicants/${applicantId}/${action}`;
        $.ajax({
            url: url,
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    updateRowStatus(btn, statusText);
                    showAlert(response.message, 'success');
                } else {
                    showAlert(response.message || "Action failed", 'danger');
                }
            },
            error: function(xhr) {
                let msg = "Action failed";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                showAlert(msg, 'danger');
            }
        });
    }
});
</script>
@endsection 