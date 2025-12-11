@extends('site.layout')

@section('title', 'CV Builder - ' . ($config['name'] ?? 'Template'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
@endsection

@section('head')

    <!-- Bootstrap CSS (Required for header) -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    
    <!-- Font Awesome (Required for header icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <!-- Main styles -->
    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" />
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Allura&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Template styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />
    
    <!-- Theme styles -->
    
    <!-- CV Builder CSS -->
    <link rel="stylesheet" href="{{ asset('styles/cv-builder.css') }}">
    
    <!-- Template-specific CSS -->
    @if(file_exists(public_path('cv-templates/assets/' . $templateSlug . '/style.css')))
        <link rel="stylesheet" href="{{ asset('cv-templates/assets/' . $templateSlug . '/style.css') }}">
    @elseif(file_exists(resource_path('views/cv/templates/' . $templateSlug . '/style.css')))
        <style>
            {!! file_get_contents(resource_path('views/cv/templates/' . $templateSlug . '/style.css')) !!}
        </style>
    @endif
@endsection

@section('content')
    <div class="cv-builder">
        <!-- Left Panel: Form -->
        <div class="builder-form-panel">
            <h2>CV Information</h2>
            
            <!-- Load Saved CV Section -->
            <div class="load-cv-section" style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
                <label for="load-cv-select" style="display: block; margin-bottom: 8px; font-weight: bold; font-size: 14px;">Load Saved CV:</label>
                <select id="load-cv-select" class="form-control" style="margin-bottom: 10px;">
                    <option value="">-- Select a saved CV --</option>
                </select>
                <button type="button" id="btn-load-cv" class="btn-load-cv" style="width: 100%; padding: 8px; background: #17a2b8; color: white; border: none; border-radius: 4px; cursor: pointer; display: none;">
                    Load CV
                </button>
                <div id="load-message" style="margin-top: 10px; font-size: 12px;"></div>
            </div>
            
            <form id="cv-form">
                <div class="form-group">
                    <label>Profile Photo</label>
                    <input type="file" id="photo-upload" name="photo" accept="image/*" style="margin-bottom: 10px;">
                    <small class="form-text text-muted" style="display: block; margin-top: 5px; font-size: 12px; color: #666;">Upload a square photo for best results (max 2MB)</small>
                    <div id="photo-preview-container" style="margin-top: 10px; display: none;">
                        <img id="photo-preview" src="" alt="Photo Preview" style="max-width: 100px; max-height: 100px; border-radius: 4px; border: 1px solid #ddd;">
                        <button type="button" id="remove-photo" style="display: block; margin-top: 5px; padding: 4px 8px; background: #dc3545; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 12px;">Remove Photo</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ $data['name'] ?? '' }}" placeholder="Your Name">
                </div>
                
                <div class="form-group">
                    <label>Professional Title</label>
                    <input type="text" name="job_title" value="{{ $data['job_title'] ?? '' }}" placeholder="e.g., Software Engineer, Marketing Manager">
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $data['email'] ?? '' }}" placeholder="your.email@example.com">
                </div>
                
                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone" value="{{ $data['phone'] ?? '' }}" placeholder="+1 234 567 8900">
                </div>
                
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" value="{{ $data['city'] ?? '' }}" placeholder="City">
                </div>
                
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country" value="{{ $data['country'] ?? '' }}" placeholder="Country">
                </div>
                
                <div class="form-group">
                    <label>Professional Summary</label>
                    <textarea name="summary" placeholder="Brief description about yourself...">{{ $data['summary'] ?? '' }}</textarea>
                </div>
                
                <!-- Add More Sections Button -->
                <button type="button" id="btn-add-sections" class="btn-add-entry" style="background: #17a2b8; margin-top: 20px;">
                    ➕ Add More Sections
                </button>
                
                <!-- Save CV Section -->
                <div class="form-group" style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #2563eb;">
                    <label for="cv-title">CV Title (Optional)</label>
                    <input type="text" id="cv-title" class="form-control" placeholder="e.g., My Professional CV, Updated CV 2024">
                    <small class="form-text text-muted">Give your CV a name to identify it later</small>
                </div>
                <div class="form-group">
                    <button type="button" id="btn-save-cv" class="btn-save-cv">💾 Save CV</button>
                    <div id="save-message" style="margin-top: 10px;"></div>
                </div>
            </form>
        </div>
        
        <!-- Add More Sections Modal -->
        <div id="add-sections-modal" class="modal-overlay">
            <div class="add-sections-modal">
                <h3>Add More Sections to Your CV</h3>
                <p style="margin-bottom: 20px; color: #666;">Select the sections you want to add to your CV:</p>
                
                <div class="sections-list" id="sections-list">
                    <!-- Sections will be populated by JavaScript -->
                </div>
                
                <div class="modal-actions">
                    <button type="button" class="btn-modal btn-modal-secondary" id="btn-close-modal">Cancel</button>
                    <button type="button" class="btn-modal btn-modal-primary" id="btn-add-selected-sections">Add Selected</button>
                </div>
            </div>
        </div>
        
        <!-- Right Panel: Preview -->
        <div class="builder-preview-panel">
            <div class="cv-preview-container" id="cv-preview">
                @if(isset($templateExists) && $templateExists)
                    @include('cv.templates.' . $templateSlug . '.template', ['data' => $data])
                @else
                    <div style="padding: 40px; text-align: center; color: #999;">
                        <h3>Template Files Not Found</h3>
                        <p>The template folder and files need to be created in:</p>
                        <code style="display: block; margin: 20px 0; padding: 10px; background: #f5f5f5; border-radius: 4px;">
                            resources/views/cv/templates/{{ $templateSlug }}/
                        </code>
                        <p>Required files:</p>
                        <ul style="text-align: left; display: inline-block;">
                            <li>template.blade.php</li>
                            <li>config.json (optional - can use database config)</li>
                            <li>style.css (optional)</li>
                        </ul>
                        <p style="margin-top: 20px;">
                            <small>Note: Template was created in admin panel, but template files need to be added manually.</small>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Bootstrap JS (Required for header dropdowns and mobile menu) -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    
    
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
    <!-- CV Builder JavaScript -->
    <script src="{{ asset('cv/js/cv-builder.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize CV Builder with configuration
            if (typeof window.CVBuilder !== 'undefined') {
                window.CVBuilder.init({
                    templateSlug: '{{ $templateSlug }}',
                    routes: {
                        saved: '{{ route("localized.cv.saved", ["lang" => app()->getLocale()]) }}',
                        load: '{{ route("localized.cv.load", ["lang" => app()->getLocale(), "id" => "CV_ID"]) }}',
                        save: '{{ route("localized.cv.save", ["lang" => app()->getLocale()]) }}'
                    },
                    csrfToken: '{{ csrf_token() }}'
                });
            }
        });
    </script>
@endsection

