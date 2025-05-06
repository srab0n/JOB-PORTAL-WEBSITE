@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">user
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.manage_users') }}">Users</a></li>
                        <li class="breadcrumb-item active">Create User</li>
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
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h2>Create New User</h2>
                        <form id="createUserForm" action="{{ route('admin.users.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="user_type" class="form-label">User Type</label>
                                <select class="form-control" id="user_type" name="user_type" required>
                                    <option value="">Select User Type</option>
                                    <option value="aspirant">Aspirant</option>
                                    <option value="employer">Employer</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('createUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this; // <-- Store reference to the form

    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Clear any existing error or success messages
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        if (data.status) {
            // Show a success message
            const successDiv = document.createElement('div');
            successDiv.className = 'alert alert-success';
            successDiv.innerHTML = data.message || 'User created successfully.';
            form.prepend(successDiv); // <-- Use form instead of this

            // Clear the form
            form.reset(); // <-- Use form instead of this

            // Redirect after 1.5 seconds
            setTimeout(() => {
                window.location.href = data.redirect || "{{ route('admin.dashboard') }}";
            }, 1500);
        } else {
            // Handle validation errors
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger';
            let errorMessages = [];
            if (data.errors) {
                for (const [field, messages] of Object.entries(data.errors)) {
                    errorMessages.push(`${field}: ${messages.join(', ')}`);
                }
            }
            errorDiv.innerHTML = errorMessages.join('<br>');
            form.prepend(errorDiv); // <-- Use form instead of this
        }
    })
    .catch(error => {
        console.error('Error:', error);
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger';
        errorDiv.innerHTML = 'An unexpected error occurred. Please try again.';
        form.prepend(errorDiv); // <-- Use form instead of this
    });
});
</script>
@endsection
