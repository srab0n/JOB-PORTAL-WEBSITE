@extends('front.layouts.app')

@section('main')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            @include('employer.sidebar2')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Employer Dashboard</h4>
                    <a href="{{ route('account.createJob') }}" class="btn btn-primary">Post New Job</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Company Information Update Form --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Update Company Information</h5>
                        </div>
                        <div class="card-body">
                            <form id="companyInfoForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="company_name" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $employer->company_name ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="company_location" class="form-label">Company Location</label>
                                    <input type="text" class="form-control" id="company_location" name="company_location" value="{{ $employer->company_location ?? '' }}">
                                </div>
                                <div class="mb-3">
                                    <label for="company_website" class="form-label">Company Website</label>
                                    <input type="url" class="form-control" id="company_website" name="company_website" value="{{ $employer->company_website ?? '' }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Company Info</button>
                            </form>
                        </div>
                    </div>

                    {{-- Display Current Company Information --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Company Information</h5>
                            @if($employer && ($employer->company_name || $employer->company_location || $employer->company_website))
                                <p><strong>Company Name:</strong> {{ $employer->company_name ?? 'Not set' }}</p>
                                <p><strong>Location:</strong> {{ $employer->company_location ?? 'Not set' }}</p>
                                <p><strong>Website:</strong> 
                                    @if($employer->company_website)
                                        <a href="{{ $employer->company_website }}" target="_blank">{{ $employer->company_website }}</a>
                                    @else
                                        Not set
                                    @endif
                                </p>
                            @else
                                <p class="text-muted">Company information not set. Please update your profile to add company details.</p>
                            @endif
                        </div>
                    </div>

                    <h5>Posted Jobs</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Posted Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobs as $job)
                                    <tr>
                                        <td>{{ $job->title }}</td>
                                        <td>{{ $job->category->name }}</td>
                                        <td>{{ $job->location }}</td>
                                        <td>
                                            @if($job->status == 1)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $job->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('employer.jobs.applicants', $job) }}" class="btn btn-info btn-sm">
                                                    Applicants
                                                </a>
                                                <a href="{{ route('employer.jobs.edit', $job) }}" class="btn btn-primary btn-sm">
                                                    Edit
                                                </a>
                                                <form action="{{ route('employer.jobs.delete', $job) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this job?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No jobs posted yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $jobs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    $("#companyInfoForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("employer.updateCompanyInfo") }}',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === true) {
                    alert('Company information updated successfully!');
                    window.location.reload();
                } else {
                    alert('Error updating company information. Please try again.');
                }
            },
            error: function() {
                alert('Error updating company information. Please try again.');
            }
        });
    });
</script>
@endsection