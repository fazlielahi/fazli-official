@extends('admin.layout')

@section('title', 'Create Experience')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2>Create Experience</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('localized.admin.dashboard', ['lang' => app()->getLocale()]) }}"><i class="fa fa-dashboard"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Founder</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('localized.admin.founder.experiences.index', ['lang' => app()->getLocale()]) }}">Experiences</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Experience Information</h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('localized.admin.founder.experiences.store', ['lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_name">Company Name <span class="text-danger">*</span></label>
                                        <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="company_logo">Company Logo</label>
                                        <input type="file" name="company_logo" id="company_logo" class="form-control-file" accept="image/*">
                                        <small class="form-text text-muted">Recommended: 100x100px, square image</small>
                                        <div id="logo-preview" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role_title">Role Title <span class="text-danger">*</span></label>
                                        <input type="text" name="role_title" id="role_title" class="form-control" value="{{ old('role_title') }}" required placeholder="e.g., PHP Developer, Full Stack Developer">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="employment_type">Employment Type <span class="text-danger">*</span></label>
                                        <select name="employment_type" id="employment_type" class="form-control" required>
                                            <option value="Full-Time" {{ old('employment_type') == 'Full-Time' ? 'selected' : '' }}>Full-Time</option>
                                            <option value="Part-Time" {{ old('employment_type') == 'Part-Time' ? 'selected' : '' }}>Part-Time</option>
                                            <option value="Contract" {{ old('employment_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                            <option value="Internship" {{ old('employment_type') == 'Internship' ? 'selected' : '' }}>Internship</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="end_date">End Date</label>
                                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
                                        <small class="form-text text-muted">Leave empty if current position</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="location">Location</label>
                                        <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" placeholder="e.g., Remote, New York, etc.">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <input type="checkbox" name="is_current" id="is_current" value="1" {{ old('is_current') ? 'checked' : '' }}>
                                    <label for="is_current">Current Position</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3" placeholder="Brief description of the role">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Responsibilities</label>
                                <div id="responsibilities-container">
                                    <div class="responsibility-item mb-2">
                                        <div class="input-group">
                                            <input type="text" name="responsibilities[]" class="form-control" placeholder="Enter responsibility">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-danger remove-responsibility" style="display: none;">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-responsibility">
                                    <i class="fa fa-plus"></i> Add Responsibility
                                </button>
                            </div>

                            <div class="form-group">
                                <label for="media_images">Media Images</label>
                                <input type="file" name="media_images[]" id="media_images" class="form-control-file" accept="image/*" multiple>
                                <small class="form-text text-muted">Upload project images or screenshots (Multiple files allowed)</small>
                                <div id="media-preview" class="mt-2 row"></div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="display_order">Display Order</label>
                                        <input type="number" name="display_order" id="display_order" class="form-control" value="{{ old('display_order', 0) }}" min="0">
                                        <small class="form-text text-muted">Lower numbers appear first</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="checkbox mt-4">
                                            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label for="is_active">Active (Show on founder profile)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Save Experience
                                </button>
                                <a href="{{ route('localized.admin.founder.experiences.index', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Logo preview
    document.getElementById('company_logo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logo-preview').innerHTML = '<img src="' + e.target.result + '" style="max-width: 100px; max-height: 100px; border-radius: 50%;">';
            };
            reader.readAsDataURL(file);
        }
    });

    // Media preview
    document.getElementById('media_images').addEventListener('change', function(e) {
        const files = e.target.files;
        const preview = document.getElementById('media-preview');
        preview.innerHTML = '';
        
        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3 mb-2';
                col.innerHTML = '<img src="' + e.target.result + '" style="width: 100%; height: 150px; object-fit: cover; border-radius: 5px;">';
                preview.appendChild(col);
            };
            reader.readAsDataURL(files[i]);
        }
    });

    // Add/Remove responsibilities
    document.getElementById('add-responsibility').addEventListener('click', function() {
        const container = document.getElementById('responsibilities-container');
        const newItem = document.createElement('div');
        newItem.className = 'responsibility-item mb-2';
        newItem.innerHTML = `
            <div class="input-group">
                <input type="text" name="responsibilities[]" class="form-control" placeholder="Enter responsibility">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger remove-responsibility">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        updateRemoveButtons();
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-responsibility')) {
            e.target.closest('.responsibility-item').remove();
            updateRemoveButtons();
        }
    });

    function updateRemoveButtons() {
        const items = document.querySelectorAll('.responsibility-item');
        items.forEach((item, index) => {
            const btn = item.querySelector('.remove-responsibility');
            if (items.length > 1) {
                btn.style.display = 'block';
            } else {
                btn.style.display = 'none';
            }
        });
    }

    // Auto-check is_current if end_date is empty
    document.getElementById('end_date').addEventListener('change', function() {
        if (!this.value) {
            document.getElementById('is_current').checked = true;
        }
    });

    document.getElementById('is_current').addEventListener('change', function() {
        if (this.checked) {
            document.getElementById('end_date').value = '';
        }
    });
});
</script>

@endsection
