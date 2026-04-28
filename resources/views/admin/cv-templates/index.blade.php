@extends('admin.layout')

@section('title', 'Resume templates')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2>Resume templates</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('localized.admin.dashboard', ['lang' => app()->getLocale()]) }}"><i class="fa fa-dashboard"></i></a></li>                            
                        <li class="breadcrumb-item active">Resume templates</li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="d-flex flex-row-reverse">
                        <a href="{{ route('localized.admin.cv-templates.create', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">
                            <i class="fa fa-plus"></i> Create New Template
                        </a>
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
                        <h2>All resume templates</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 c_list">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Preview</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($templates as $template)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($template->preview_path)
                                                <img src="{{ asset($template->preview_path) }}" alt="{{ $template->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <span class="text-muted">No preview</span>
                                            @endif
                                        </td>
                                        <td>{{ $template->name }}</td>
                                        <td><code>{{ $template->slug }}</code></td>
                                        <td>{{ Str::limit($template->description ?? 'No description', 50) }}</td>
                                        <td>
                                            @if($template->is_active)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('localized.admin.cv-templates.edit', ['lang' => app()->getLocale(), 'cvTemplate' => $template->id]) }}" class="btn btn-info btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form action="{{ route('localized.admin.cv-templates.toggle', ['lang' => app()->getLocale(), 'cvTemplate' => $template->id]) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-{{ $template->is_active ? 'warning' : 'success' }} btn-sm" title="{{ $template->is_active ? 'Deactivate' : 'Activate' }}">
                                                    <i class="fa fa-{{ $template->is_active ? 'eye-slash' : 'eye' }}"></i>
                                                </button>
                                            </form>
                                            <form class="delete-template-form" action="{{ route('localized.admin.cv-templates.destroy', ['lang' => app()->getLocale(), 'cvTemplate' => $template->id]) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete-template" title="Delete">
                                                    <i class="fa fa-trash-o"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No templates found. <a href="{{ route('localized.admin.cv-templates.create', ['lang' => app()->getLocale()]) }}">Create one</a></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert for delete confirmation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // SweetAlert for delete confirmation
    $(document).on('click', '.btn-delete-template', function(e) {
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


