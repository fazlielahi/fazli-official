@extends('admin.layout')

@section('title', 'Skills')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2>Skills</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('localized.admin.dashboard', ['lang' => app()->getLocale()]) }}"><i class="fa fa-dashboard"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Founder</a></li>                            
                        <li class="breadcrumb-item active">Skills</li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="d-flex flex-row-reverse">
                        <a href="{{ route('localized.admin.founder.skills.create', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">
                            <i class="fa fa-plus"></i> Add New Skill
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
                        <h2>All Skills</h2>
                    </div>
                    <div class="body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Skills management is coming soon. This section will allow you to manage founder skills dynamically.
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Skill Name</th>
                                        <th>Level</th>
                                        <th>Category</th>
                                        <th>Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <p class="text-muted">No skills found. Skills management will be implemented soon.</p>
                                        </td>
                                    </tr>
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
