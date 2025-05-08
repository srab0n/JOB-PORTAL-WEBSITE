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
                        <li class="breadcrumb-item active">Job Details</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 p-3 shadow mb-4">
                    <div class="card-body">
                        <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->title }}</h3>
                        
                        <div class="bg-light p-3 border mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-0">
                                        <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                        <span class="ps-1">{{ $job->location }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0">
                                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                        <span class="ps-1">{{ $job->jobType->name }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0">
                                        <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                        <span class="ps-1">{{ number_format($job->salary) }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-0">
                                        <span class="fw-bolder"><i class="fa fa-building"></i></span>
                                        <span class="ps-1">{{ $job->company_name }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h4>Job Description</h4>
                            <p>{{ $job->description }}</p>
                        </div>

                        <div class="mb-4">
                            <h4>Requirements</h4>
                            <p>{{ $job->qualifications }}</p>
                        </div>

                        <div class="mb-4">
                            <h4>Responsibilities</h4>
                            <p>{{ $job->responsibility }}</p>
                        </div>

                        <div class="mb-4">
                            <h4>Benefits</h4>
                            <p>{{ $job->benefits }}</p>
                        </div>

                        <div class="mb-4">
                            <h4>Company Information</h4>
                            <p>{{ $job->company_description }}</p>
                        </div>

                        @if(auth()->check() && !auth()->user()->is_admin)
                            <div class="d-grid mt-4">
                                <a href="#" class="btn btn-primary btn-lg">Apply Now</a>
                            </div>
                        @elseif(!auth()->check())
                            <div class="d-grid mt-4">
                                <a href="{{ route('account.login') }}" class="btn btn-primary btn-lg">Login to Apply</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 p-3 shadow mb-4">
                    <div class="card-body">
                        <h4 class="mb-4">Job Summary</h4>
                        <div class="mb-3">
                            <p class="mb-0">
                                <span class="fw-bolder">Posted By:</span>
                                <span class="ps-1">{{ $job->user->name }}</span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-0">
                                <span class="fw-bolder">Category:</span>
                                <span class="ps-1">{{ $job->category->name }}</span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-0">
                                <span class="fw-bolder">Posted Date:</span>
                                <span class="ps-1">{{ $job->created_at->format('d M, Y') }}</span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-0">
                                <span class="fw-bolder">Last Date to Apply:</span>
                                <span class="ps-1">{{ $job->expiry_date ? $job->expiry_date->format('d M, Y') : 'No deadline' }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 