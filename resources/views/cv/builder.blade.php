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
    
    <!-- Template styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />
    
    <!-- Theme styles -->
    <link rel="stylesheet" href="{{ asset('styles/theme.css') }}" />
    
    <!-- Template-specific CSS -->
    @if(file_exists(public_path('cv-templates/assets/' . $templateSlug . '/style.css')))
        <link rel="stylesheet" href="{{ asset('cv-templates/assets/' . $templateSlug . '/style.css') }}">
    @elseif(file_exists(resource_path('views/cv/templates/' . $templateSlug . '/style.css')))
        <style>
            {!! file_get_contents(resource_path('views/cv/templates/' . $templateSlug . '/style.css')) !!}
        </style>
    @endif
    <style>
        .cv-builder {
            display: flex;
            min-height: calc(100vh - 200px);
            background: #f5f5f5;
        }
        .builder-form-panel {
            width: 400px;
            background: white;
            padding: 20px;
            overflow-y: auto;
            border-right: 1px solid #ddd;
        }
        .builder-preview-panel {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            background: #e9ecef;
            display: flex;
            justify-content: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-group textarea {
            min-height: 80px;
            resize: vertical;
        }
        .cv-preview-container {
            background: white;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 210mm;
            width: 100%;
        }
        .section-title {
            margin-top: 30px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2563eb;
            color: #2563eb;
        }
        @media (max-width: 768px) {
            .cv-builder {
                flex-direction: column;
            }
            .builder-form-panel {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #ddd;
            }
        }
    </style>
@endsection

@section('content')
    <div class="cv-builder">
        <!-- Left Panel: Form -->
        <div class="builder-form-panel">
            <h2>CV Information</h2>
            
            <form id="cv-form">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ $data['name'] ?? '' }}" placeholder="Your Name">
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
                    <label>Professional Summary</label>
                    <textarea name="summary" placeholder="Brief description about yourself...">{{ $data['summary'] ?? '' }}</textarea>
                </div>
                
                <h3 class="section-title">Experience</h3>
                <div class="form-group">
                    <label>Job Title</label>
                    <input type="text" name="experience[0][title]" value="{{ $data['experience'][0]['title'] ?? '' }}" placeholder="Senior Developer">
                </div>
                <div class="form-group">
                    <label>Company</label>
                    <input type="text" name="experience[0][company]" value="{{ $data['experience'][0]['company'] ?? '' }}" placeholder="Company Name">
                </div>
                <div class="form-group">
                    <label>Period</label>
                    <input type="text" name="experience[0][period]" value="{{ $data['experience'][0]['period'] ?? '' }}" placeholder="2020 - Present">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="experience[0][description]" placeholder="Job responsibilities and achievements...">{{ $data['experience'][0]['description'] ?? '' }}</textarea>
                </div>
                
                <h3 class="section-title">Education</h3>
                <div class="form-group">
                    <label>Degree</label>
                    <input type="text" name="education[0][degree]" value="{{ $data['education'][0]['degree'] ?? '' }}" placeholder="Bachelor of Science">
                </div>
                <div class="form-group">
                    <label>Institution</label>
                    <input type="text" name="education[0][institution]" value="{{ $data['education'][0]['institution'] ?? '' }}" placeholder="University Name">
                </div>
                <div class="form-group">
                    <label>Period</label>
                    <input type="text" name="education[0][period]" value="{{ $data['education'][0]['period'] ?? '' }}" placeholder="2016 - 2020">
                </div>
            </form>
        </div>
        
        <!-- Right Panel: Preview -->
        <div class="builder-preview-panel">
            <div class="cv-preview-container">
                @include('cv.templates.' . $templateSlug . '.template', ['data' => $data])
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Bootstrap JS (Required for header dropdowns and mobile menu) -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        // Phase 1: Static preview only
        // Phase 2: Will add live update functionality here
        console.log('CV Builder loaded for template: {{ $templateSlug }}');
    </script>
@endsection

