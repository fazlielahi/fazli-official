@extends('admin.layout')

@section('title', 'Experiences')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2>Experiences</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('localized.admin.dashboard', ['lang' => app()->getLocale()]) }}"><i class="fa fa-dashboard"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Founder</a></li>                            
                        <li class="breadcrumb-item active">Experiences</li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="d-flex flex-row-reverse">
                        <a href="{{ route('localized.admin.founder.experiences.create', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">
                            <i class="fa fa-plus"></i> Add New Experience
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
                        <h2>All Experiences</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Company</th>
                                        <th>Role</th>
                                        <th>Date Range</th>
                                        <th>Location</th>
                                        <th>Type</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($experiences as $index => $experience)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if($experience->company_logo)
                                                    <img src="{{ asset('storage/' . $experience->company_logo) }}" alt="{{ $experience->company_name }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; margin-right: 10px;">
                                                @endif
                                                {{ $experience->company_name }}
                                            </td>
                                            <td>{{ $experience->role_title }}</td>
                                            <td>{{ $experience->date_range }}</td>
                                            <td>{{ $experience->location ?? 'N/A' }}</td>
                                            <td>{{ $experience->employment_type }}</td>
                                            <td>{{ $experience->display_order }}</td>
                                            <td>
                                                @if($experience->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('localized.admin.founder.experiences.edit', ['lang' => app()->getLocale(), 'id' => $experience->id]) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('localized.admin.founder.experiences.destroy', ['lang' => app()->getLocale(), 'id' => $experience->id]) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this experience?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No experiences found. <a href="{{ route('localized.admin.founder.experiences.create', ['lang' => app()->getLocale()]) }}">Add one now</a></td>
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

@endsection
