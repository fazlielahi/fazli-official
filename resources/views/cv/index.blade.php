@extends('site.layout')

@section('title', 'CV Templates - ' . __('lang.DEFAULT_TITLE'))

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
    <style>
        .cv-gallery {
            padding: 60px 0;
            background: #f8f9fa;
        }
        .cv-gallery h1 {
            text-align: center;
            margin-bottom: 40px;
            color: #333;
        }
        .templates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .template-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .template-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }
        .template-preview {
            width: 100%;
            height: 400px;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .template-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .template-preview::before {
            content: 'Preview';
            position: absolute;
            color: #999;
            font-size: 18px;
        }
        .template-info {
            padding: 20px;
        }
        .template-info h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .template-info p {
            color: #666;
            margin: 0 0 15px 0;
            font-size: 14px;
        }
        .template-actions {
            display: flex;
            gap: 10px;
        }
        .btn-use-template {
            flex: 1;
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: background 0.3s;
        }
        .btn-use-template:hover {
            background: #1e40af;
        }
        .btn-preview {
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-preview:hover {
            background: #5a6268;
        }
        .create-cv-default {
            text-align: center;
            margin: 40px 0;
        }
        .btn-create-default {
            display: inline-block;
            padding: 15px 40px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
            transition: background 0.3s;
        }
        .btn-create-default:hover {
            background: #218838;
        }
    </style>
@endsection

@section('content')
    <div class="cv-gallery">
        <div class="container">
            <h1>Choose Your CV Template</h1>
            
            <div class="templates-grid">
                @forelse($templateFolders as $template)
                    <div class="template-card">
                        <div class="template-preview">
                            @if(file_exists(public_path('cv-templates/previews/' . $template['slug'] . '-preview.webp')))
                                <img src="{{ asset('cv-templates/previews/' . $template['slug'] . '-preview.webp') }}" alt="{{ $template['name'] }}">
                            @endif
                        </div>
                        <div class="template-info">
                            <h3>{{ $template['name'] }}</h3>
                            <p>{{ $template['description'] ?: 'Professional CV template' }}</p>
                            <div class="template-actions">
                                <a href="{{ route('localized.cv.builder', ['lang' => app()->getLocale(), 'slug' => $template['slug']]) }}" class="btn-use-template">
                                    Use Template
                                </a>
                                <button class="btn-preview">Preview</button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                        <p>No templates available yet.</p>
                    </div>
                @endforelse
            </div>
            
            <div class="create-cv-default">
                <a href="{{ route('localized.cv.builder', ['lang' => app()->getLocale(), 'slug' => 'modern']) }}" class="btn-create-default">
                    Create CV with Default Template
                </a>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Bootstrap JS (Required for header dropdowns and mobile menu) -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
@endsection