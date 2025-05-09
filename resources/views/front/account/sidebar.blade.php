<div class="card border-0 shadow mb-4 p-3">
    <div class="s-body text-center mt-3">
        <img src="assets/assets/images/avatar7.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
        <h5 class="mt-3 pb-0">{{ Auth::user()->name }}</h5>
        <p class="text-muted mb-1 fs-6">{{ Auth::user()->designation }}</p>
        <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change Profile Picture</button>
        </div>
    </div>
</div>
<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="http://127.0.0.1:8000/account/profile">Account Settings</a>
            </li>
            @if (Auth::check() && in_array(Auth::user()->user_type, ['admin', 'employer']))
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('account.createJob') }}">Post a Job</a>
                </li>
            @endif
            @if (Auth::check() && in_array(Auth::user()->user_type, ['admin', 'employer']))
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('account.myJobs') }}">My Jobs</a>
                </li>
            @endif
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.jobsApplied') }}">Jobs Applied</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="saved-jobs.html">Saved Jobs</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.logout') }}" style="font-weight: bold; color: #dc3545;">Logout</a>
            </li>
        </ul>
    </div>
</div>