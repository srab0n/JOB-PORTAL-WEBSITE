@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Jobs</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('admin.asidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Manage Jobs</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Company</th>
                                        <th>Category</th>
                                        <th>Job Type</th>
                                        <th>Location</th>
                                        <th>Posted By</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($jobs->isNotEmpty())
                                        @foreach($jobs as $job)
                                        <tr>
                                            <td>{{ $job->title }}</td>
                                            <td>{{ $job->company_name }}</td>
                                            <td>{{ $job->category->name }}</td>
                                            <td>{{ $job->jobType->name }}</td>
                                            <td>{{ $job->location }}</td>
                                            <td>{{ $job->user->name }}</td>
                                            <td>
                                                @if($job->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $job->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('jobs.detail', $job->id) }}" class="btn btn-sm btn-info" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteJob({{ $job->id }})" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center">No jobs found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $jobs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
function deleteJob(jobId) {
    if (confirm("Are you sure you want to delete this job?")) {
        $.ajax({
            url: '{{ route("admin.delete_job", "") }}/' + jobId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === true) {
                    window.location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred while deleting the job');
            }
        });
    }
}
</script>
@endsection 
 