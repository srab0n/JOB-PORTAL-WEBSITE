@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Jobs Applied</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="card border-0 shadow mb-4 p-3">
                    <h3 class="fs-4 mb-4">Jobs Applied</h3>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Applied Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($applications as $application)
                                    <tr>
                                        <td>{{ $application->job->title ?? 'N/A' }}</td>
                                        <td>{{ $application->job->company_name ?? 'N/A' }}</td>
                                        <td>{{ $application->job->location ?? 'N/A' }}</td>
                                        <td>{{ $application->applied_date ? (is_a($application->applied_date, 'Illuminate\Support\Carbon') ? $application->applied_date->format('d M, Y') : (new \Carbon\Carbon($application->applied_date))->format('d M, Y')) : 'N/A' }}</td>
                                        <td>
                                            @if($application->job)
                                                <a href="{{ route('jobs.detail', $application->job->id) }}" class="btn btn-primary btn-sm">View</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No jobs applied yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $applications->links() }}
                    </div>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection 