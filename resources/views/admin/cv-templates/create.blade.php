@extends('admin.layout')

@section('title', 'Create CV Template')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <h2>Create CV Template</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('localized.admin.dashboard', ['lang' => app()->getLocale()]) }}"><i class="fa fa-dashboard"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('localized.admin.cv-templates.index', ['lang' => app()->getLocale()]) }}">CV Templates</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2>Template Information</h2>
                    </div>
                    <div class="body">
                        <form action="{{ route('localized.admin.cv-templates.store', ['lang' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data">
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

                            <div class="form-group">
                                <label for="name">Template Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required placeholder="e.g., Modern, Classic, Professional">
                                <small class="form-text text-muted">Display name for the template</small>
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug <span class="text-danger">*</span></label>
                                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" required placeholder="e.g., modern, classic, professional">
                                <small class="form-text text-muted">URL-friendly identifier (lowercase, no spaces). Must match template folder name.</small>
                                @if(!empty($existingTemplates))
                                    <small class="form-text text-info">
                                        <strong>Existing template folders:</strong> {{ implode(', ', $existingTemplates) }}
                                    </small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3" placeholder="Brief description of the template">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="preview_image">Preview Image</label>
                                <input type="file" name="preview_image" id="preview_image" class="form-control-file" accept="image/webp,image/png,image/jpeg,image/jpg">
                                <small class="form-text text-muted">Upload a preview image (WebP, PNG, or JPG). Max size: 2MB</small>
                                <div id="image-preview" class="mt-2"></div>
                            </div>

                            <div class="form-group">
                                <label for="config">Config JSON</label>
                                <textarea name="config" id="config" class="form-control" rows="15" placeholder='{"name": "Modern", "sections": {...}}'>{{ old('config') }}</textarea>
                                <small class="form-text text-muted">Template configuration in JSON format. Leave empty if template folder already has config.json</small>
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active') ? 'checked' : 'checked' }}>
                                    <label for="is_active">Active (Template will be visible in gallery)</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Create Template</button>
                                <a href="{{ route('localized.admin.cv-templates.index', ['lang' => app()->getLocale()]) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Auto-generate slug from name
    $('#name').on('input', function() {
        var name = $(this).val();
        var slug = name.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        $('#slug').val(slug);
    });

    // Preview image before upload
    $('#preview_image').on('change', function(e) {
        var file = e.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image-preview').html('<img src="' + e.target.result + '" style="max-width: 200px; max-height: 200px; border-radius: 4px; border: 1px solid #ddd;">');
            };
            reader.readAsDataURL(file);
        }
    });

    // Auto-format JSON
    $('#config').on('blur', function() {
        try {
            var json = JSON.parse($(this).val());
            $(this).val(JSON.stringify(json, null, 2));
        } catch(e) {
            // Invalid JSON, leave as is
        }
    });
});
</script>

@endsection

