@extends('admin.layout')

@section('title', 'Create Skill')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2>Create Skill</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('localized.admin.dashboard', ['lang' => app()->getLocale()]) }}"><i class="fa fa-dashboard"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Founder</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('localized.admin.founder.skills.index', ['lang' => app()->getLocale()]) }}">Skills</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Skill Information</h2>
                    </div>
                    <div class="body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Skills management form will be implemented soon.
                        </div>
                        <form action="{{ route('localized.admin.founder.skills.store', ['lang' => app()->getLocale()]) }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="skill_name">Skill Name <span class="text-danger">*</span></label>
                                <input type="text" name="skill_name" id="skill_name" class="form-control" placeholder="e.g., PHP, JavaScript, Laravel" disabled>
                                <small class="form-text text-muted">Coming soon</small>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" disabled>
                                    <i class="fa fa-save"></i> Save Skill
                                </button>
                                <a href="{{ route('localized.admin.founder.skills.index', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">
                                    <i class="fa fa-times"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
