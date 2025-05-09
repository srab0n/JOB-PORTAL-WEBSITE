@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Admin Dashboard</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('admin.asidebar')
            </div>
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Job Applications</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Email</th>
                                        <th>Job Title</th>
                                        <th>Company</th>
                                        <th>Location</th>
                                        <th>Applied Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($applications as $application)
                                        <tr>
                                            <td>{{ $application->user->name ?? 'N/A' }}</td>
                                            <td>{{ $application->user->email ?? 'N/A' }}</td>
                                            <td>{{ $application->job->title ?? 'N/A' }}</td>
                                            <td>{{ $application->job->company_name ?? 'N/A' }}</td>
                                            <td>{{ $application->job->location ?? 'N/A' }}</td>
                                            <td>
                                                @if($application->applied_date)
                                                    {{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>
                                                @if($application->job)
                                                    <a href="{{ route('jobs.detail', $application->job->id) }}" class="btn btn-primary btn-sm" target="_blank">View Job</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No job applications found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $applications->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 