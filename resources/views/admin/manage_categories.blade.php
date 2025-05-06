@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Categories</li>
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
                <div class="card border-0 shadow mb-4">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Manage Categories</h3>
                            </div>
                            <div style="margin-top: -10px;">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    Add New Category
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if($categories->isNotEmpty())
                                        @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $category->name }}</td>
                                            <td>
                                                @if($category->status == 1)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>{{ $category->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteCategory({{ $category->id }})">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">No categories found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addCategoryForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                        <p class="text-danger" id="categoryError"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('customJs')
<script>
    $("#addCategoryForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("admin.store_category") }}',
            type: 'POST',
            data: $(this).serializeArray(),
            dataType: 'json',
            success: function(response) {
                if (response.status === true) {
                    window.location.reload();
                } else {
                    var errors = response.errors;
                    if (errors.name) {
                        $("#categoryError").html(errors.name[0]);
                    }
                }
            }
        });
    });

    function deleteCategory(categoryId) {
        if (confirm("Are you sure you want to delete this category?")) {
            $.ajax({
                url: '{{ route("admin.delete_category", "") }}/' + categoryId,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === true) {
                        window.location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    }
</script>
@endsection 