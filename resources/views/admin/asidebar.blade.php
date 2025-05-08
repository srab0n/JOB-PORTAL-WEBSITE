<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{ route('admin.manage_users') }}">Users</a>
            </li>
            @if (Auth::check() && in_array(Auth::user()->user_type, ['admin', 'employer']))
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('account.myJobs') }}">My Jobs</a>
            </li>
            @endif
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="#">Job applications</a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
               <a href="{{ route('account.logout') }}" style="font-weight: bold; color: #dc3545;">Logout</a>
            </li>                                                                                                                
        </ul>
    </div>
</div>