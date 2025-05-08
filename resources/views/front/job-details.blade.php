@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <div class="card border-0 shadow">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h1 class="h3">{{ $job->title }}</h1>
                            <a href="{{ route('jobs.search') }}" class="btn btn-primary">Back to Jobs</a>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="mb-3">Job Description</h4>
                            <p>{{ $job->description }}</p>
                        </div>

                        <div class="mb-4">
                            <h4 class="mb-3">Job Details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <span class="fw-bold"><i class="fa fa-map-marker"></i> Location:</span>
                                        <span class="ps-1">{{ $job->location }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="fw-bold"><i class="fa fa-clock-o"></i> Job Type:</span>
                                        <span class="ps-1">{{ $job->jobType->name }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="fw-bold"><i class="fa fa-usd"></i> Salary:</span>
                                        <span class="ps-1">{{ number_format($job->salary) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <span class="fw-bold"><i class="fa fa-building"></i> Company:</span>
                                        <span class="ps-1">{{ $job->company_name }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="fw-bold"><i class="fa fa-calendar"></i> Posted Date:</span>
                                        <span class="ps-1">{{ $job->created_at->format('d M, Y') }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="fw-bold"><i class="fa fa-tag"></i> Category:</span>
                                        <span class="ps-1">{{ $job->category->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4 class="mb-3">Requirements</h4>
                            <p>{{ $job->requirements }}</p>
                        </div>

                        <div class="mb-4">
                            <h4 class="mb-3">Benefits</h4>
                            <p>{{ $job->benefits }}</p>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-primary btn-lg">Apply Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 