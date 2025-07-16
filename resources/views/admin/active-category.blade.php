@extends('admin.layout')

@section('title', __('lang.Table Basic'))

@section('content')

<div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h2>Categories</h2>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="fa fa-dashboard"></i></a></li>                            
                            <li class="breadcrumb-item active">Categories</li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="d-flex flex-row-reverse">
                            <!-- Create Category Modal -->
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#createCategoryModal">
                                <i class="fa fa-plus"></i> Create New
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="createCategoryModal" tabindex="-1" role="dialog" aria-labelledby="createCategoryModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="createCategoryModalLabel">Create Category</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <form action="{{ route('localized.admin.categories.store', ['lang' => app()->getLocale()]) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                      @if($errors->any())
                                        @foreach($errors->all() as $error)
                                          <p class="text-danger">{{ $error }}</p>
                                        @endforeach
                                      @endif
                                      <div class="form-group">
                                        <label for="categoryName">Category Name</label>
                                        <input type="text" name="name" class="form-control" id="categoryName" placeholder="Enter category name" value="{{ old('name') }}" required>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <div class="p-2 d-flex">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row clearfix">
                <div class="col-lg-12">
                  
                    <div class="card">
                        <div class="header">
                            <h2>All Categories</h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 c_list">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>                                    
                                            <th>Slug</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                        @foreach($categories as $category)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info btn-edit-category" data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-toggle="modal" data-target="#editCategoryModal" title="Edit"><i class="fa fa-edit"></i></button>
                                                <form class="delete-category-form" action="{{ route('localized.admin.categories.destroy', ['lang' => app()->getLocale(), 'category' => $category->id]) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-delete-category" title="Delete"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="editCategoryForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="form-group">
            <label for="editCategoryName">Category Name</label>
            <input type="text" name="name" class="form-control" id="editCategoryName" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Ensure jQuery is loaded before SweetAlert2 and custom scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Populate edit modal with category data
    $(document).on('click', '.btn-edit-category', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var action = "{{ route('localized.admin.categories.update', ['lang' => app()->getLocale(), 'category' => 'CATEGORY_ID']) }}".replace('CATEGORY_ID', id);
        $('#editCategoryForm').attr('action', action);
        $('#editCategoryName').val(name);
    });

    // SweetAlert for delete confirmation
    $(document).on('click', '.btn-delete-category', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

@endsection
