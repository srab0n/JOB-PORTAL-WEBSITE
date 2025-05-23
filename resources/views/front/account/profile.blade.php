@extends('front.layouts.app')

@section('main')

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-lg-9">
               @include('front.message')

                {{-- Profile Update Section --}}
                <div class="card border-0 shadow mb-4">
                    <form action="{{ route('account.updateProfile') }}" method="POST" id="userForm" name="userForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">My Profile</h3>
                            <div class="mb-4">
                                <label for="name" class="mb-2">Name*</label>
                                <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control" value="{{ $user->name }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control" value="{{ $user->email }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="designation" class="mb-2">Designation</label>
                                <input type="text" name="designation" id="designation" placeholder="Designation" class="form-control" value="{{ $user->designation }}">
                            </div>
                            <div class="mb-4">
                                <label for="mobile" class="mb-2">Mobile</label>
                                <input type="text" name="mobile" id="mobile" placeholder="Mobile" class="form-control" value="{{ $user->mobile }}">
                            </div>
                            <div class="mb-4">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Change Profile Picture
                                </button>
                            </div>
                        </div>
                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

                {{-- Password Update Section --}}
                <div class="card border-0 shadow mb-4">
                    <form action="{{ route('account.updatePassword') }}" method="POST" id="passwordForm">
                        @csrf
                        @method('PUT')
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">Change Password</h3>
                            <div class="mb-4">
                                <label for="old_password" class="mb-2">Old Password*</label>
                                <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                <p class="invalid-feedback"></p>
                            </div>
                            <div class="mb-4">
                                <label for="new_password" class="mb-2">New Password*</label>
                                <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                                <p class="invalid-feedback"></p>
                            </div>
                            <div class="mb-4">
                                <label for="new_password_confirmation" class="mb-2">Confirm Password*</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" placeholder="Confirm Password" class="form-control">
                                <p class="invalid-feedback"></p>
                            </div>
                        </div>
                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

                {{-- Delete Account Section --}}
                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h3 class="fs-4 mb-1 text-danger">Delete Account</h3>
                        <p class="text-danger mb-4">Warning: This action cannot be undone. All your data will be permanently deleted.</p>
                        <button type="button" class="btn btn-danger" id="deleteAccountBtn">Delete My Account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')
<script type="text/javascript">
    // Profile Update Form
    $("#userForm").submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        $.ajax({
            url: '{{ route("account.updateProfile") }}',
            type: 'PUT',
            dataType: 'json',
            data: $("#userForm").serialize(), // Serialize the form data
            success: function(response) {
                if (response.status == true) {
                    alert('Profile updated successfully.');
                    window.location.href = '{{ route('account.profile') }}';
                } else {
                    var errors = response.errors;

                    // Handle name errors
                    if (errors.name) {
                        $("#name").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors.name);
                    } else {
                        $("#name").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');
                    }

                    // Handle email errors
                    if (errors.email) {
                        $("#email").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors.email);
                    } else {
                        $("#email").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                }
            }
        });
    });

    // Password Update Form
    $("#passwordForm").submit(function(e) {
        e.preventDefault(); // Prevent the default form submission

        $.ajax({
            url: '{{ route("account.updatePassword") }}',
            type: 'PUT',
            dataType: 'json',
            data: $("#passwordForm").serialize(), // Serialize the form data
            success: function(response) {
                if (response.status == true) {
                    alert('Password updated successfully.');
                    window.location.href = '{{ route('account.profile') }}';
                } else {
                    var errors = response.errors;

                    // Handle old password errors
                    if (errors.old_password) {
                        $("#old_password").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors.old_password);
                    } else {
                        $("#old_password").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');
                    }

                    // Handle new password errors
                    if (errors.new_password) {
                        $("#new_password").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors.new_password);
                    } else {
                        $("#new_password").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');
                    }

                    // Handle confirm password errors
                    if (errors.new_password_confirmation) {
                        $("#new_password_confirmation").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors.new_password_confirmation);
                    } else {
                        $("#new_password_confirmation").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback')
                            .html('');
                    }
                }
            }
        });
    });

    // Delete Account
    $("#deleteAccountBtn").click(function() {
        if (confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
            $.ajax({
                url: '{{ route("account.deleteAccount") }}',
                type: 'DELETE',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.status == true) {
                        alert('Your account has been deleted successfully.');
                        window.location.href = '{{ route('home') }}';
                    } else {
                        alert('Something went wrong. Please try again.');
                    }
                }
            });
        }
    });
</script>

<!-- Profile Picture Upload Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="profilePictureForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="image" class="form-label">Select Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <p class="invalid-feedback"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Profile Picture Upload Form
    $("#profilePictureForm").submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("account.updateProfilePicture") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == true) {
                    alert('Profile picture updated successfully.');
                    window.location.reload();
                } else {
                    var errors = response.errors;
                    if (errors.image) {
                        $("#image").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors.image);
                    }
                }
            }
        });
    });
</script>
@endsection