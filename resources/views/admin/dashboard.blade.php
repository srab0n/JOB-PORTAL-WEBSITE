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
                {{-- Include the admin sidebar --}}
                @include('admin.asidebar')
            </div>
            <div class="col-lg-9">
                {{-- Include any flash messages --}}
                @include('front.message')
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h2>Admin Dashboard</h2>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3>User Management</h3>
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add New User</a>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Users</h5>
                                        <p class="card-text display-4">{{ \App\Models\User::count() }}</p>
                                        <a href="{{ route('admin.manage_users') }}" class="btn btn-primary">Manage Users</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Jobs</h5>
                                        <p class="card-text display-4">{{ \App\Models\Job::count() }}</p>
                                        <a href="{{ route('admin.manage_jobs') }}" class="btn btn-primary">Manage Jobs</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Categories</h5>
                                        <p class="card-text display-4">{{ \App\Models\Category::count() }}</p>
                                        <a href="{{ route('admin.manage_categories') }}" class="btn btn-primary">Manage Categories</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
