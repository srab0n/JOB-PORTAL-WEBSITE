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
                <div class="card border-0 p-3 shadow mb-4 position-relative">
                    @if(auth()->check() && auth()->user()->user_type === 'aspirant')
                        @php $isSaved = auth()->user()->savedJobs->contains($job->id); @endphp
                        <form action="{{ $isSaved ? route('jobs.unsave', $job->id) : route('jobs.save', $job->id) }}" method="POST" style="position:absolute; top:18px; right:18px; z-index:2;">
                            @csrf
                            @if($isSaved)
                                @method('DELETE')
                            @endif
                            <button type="submit" style="background:none;border:none;padding:0;cursor:pointer;" title="{{ $isSaved ? 'Remove from Saved Jobs' : 'Save Job' }}">
                                <span style="display:inline-block;width:38px;height:38px;">
                                    @if($isSaved)
                                    <!-- Filled Heart SVG -->
                                    <svg viewBox="0 0 24 24" fill="#206a2c" xmlns="http://www.w3.org/2000/svg" width="38" height="38">
                                        <title>Remove from Saved Jobs</title>
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    @else
                                    <!-- Outlined Heart SVG -->
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#206a2c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg" width="38" height="38">
                                        <title>Save Job</title>
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    @endif
                                </span>
                            </button>
                        </form>
                    @endif
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
                                        <span class="fw-bolder">৳</span>
                                        <span class="ps-1">
                                            @if(is_numeric($job->salary))
                                                {{ number_format((float)$job->salary) }}
                                            @elseif(!empty($job->salary))
                                                {{ $job->salary }}
                                            @else
                                                N/A
                                            @endif
                                        </span>
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
                            <p><strong>Name:</strong> {{ $job->company_name }}</p>
                            <p><strong>Website:</strong> 
                                @if($job->company_website)
                                    <a href="{{ $job->company_website }}" target="_blank">{{ $job->company_website }}</a>
                                @else
                                    Not set
                                @endif
                            </p>
                            <p><strong>Location:</strong> {{ $job->company_location ?? 'Not set' }}</p>
                        </div>

                        @if(auth()->check() && auth()->user()->user_type === 'aspirant')
                            <div class="d-grid mt-4">
                                <a href="{{ route('jobs.apply.form', $job->id) }}" class="btn btn-primary btn-lg mb-2">Apply Now</a>
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