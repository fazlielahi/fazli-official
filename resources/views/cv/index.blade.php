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
        .template-preview-placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #999;
            font-size: 18px;
            z-index: 0;
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
        /* Preview Modal Styles */
        .preview-modal .modal-dialog {
            max-width: 90%;
            margin: 3rem auto;
            max-height: calc(100vh - 6rem);
            display: flex;
            flex-direction: column;
        }
        @media (max-width: 768px) {
            .preview-modal .modal-dialog {
                margin: 1rem auto;
                max-height: calc(100vh - 2rem);
            }
        }
        .preview-modal .modal-content {
            background: #f8f9fa;
            max-height: calc(100vh - 6rem);
            display: flex;
            flex-direction: column;
            border-radius: 8px;
        }
        @media (max-width: 768px) {
            .preview-modal .modal-content {
                max-height: calc(100vh - 2rem);
            }
        }
        .preview-modal .modal-header {
            flex-shrink: 0;
            padding: 1rem 1.5rem;
        }
        .preview-modal .modal-body {
            padding: 1.5rem;
            text-align: center;
            background: white;
            overflow-y: auto;
            flex: 1 1 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 0;
        }
        .preview-modal .modal-body img {
            max-width: 100%;
            max-height: calc(100vh - 14rem);
            width: auto;
            height: auto;
            object-fit: contain;
        }
        @media (max-width: 768px) {
            .preview-modal .modal-body img {
                max-height: calc(100vh - 10rem);
            }
        }
        .preview-modal .modal-footer {
            flex-shrink: 0;
            padding: 1rem 1.5rem;
        }
        .preview-modal .modal-header {
            border-bottom: 1px solid #dee2e6;
            background: white;
        }
        .preview-modal .modal-header .modal-title {
            font-weight: 600;
            color: #333;
        }
        .preview-modal .modal-footer {
            border-top: 1px solid #dee2e6;
            background: white;
        }
        .preview-modal .btn-use-from-modal {
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .preview-modal .btn-use-from-modal:hover {
            background: #1e40af;
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
                            @if(!empty($template['preview_path']))
                                <img src="{{ $template['preview_path'] }}" alt="{{ $template['name'] }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="template-preview-placeholder" style="display: none;">Preview</div>
                            @else
                                <div class="template-preview-placeholder">Preview</div>
                            @endif
                        </div>
                        <div class="template-info">
                            <h3>{{ $template['name'] }}</h3>
                            <p>{{ $template['description'] ?: 'Professional CV template' }}</p>
                            <div class="template-actions">
                                <a href="{{ route('localized.cv.builder', ['lang' => app()->getLocale(), 'slug' => $template['slug']]) }}" class="btn-use-template">
                                    Use Template
                                </a>
                                @if(!empty($template['preview_path']))
                                    <button class="btn-preview" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#previewModal"
                                            data-preview-image="{{ $template['preview_path'] }}"
                                            data-template-name="{{ $template['name'] }}"
                                            data-template-slug="{{ $template['slug'] }}">
                                        Preview
                                    </button>
                                @else
                                    <button class="btn-preview" disabled title="No preview available">Preview</button>
                                @endif
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
                <a href="{{ route('localized.cv.builder', ['lang' => app()->getLocale(), 'slug' => 'classic']) }}" class="btn-create-default">
                    Create CV with Default Template
                </a>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="modal fade preview-modal" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Template Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="previewModalImage" src="" alt="Template Preview" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a id="previewModalUseBtn" href="#" class="btn btn-use-from-modal">
                        <i class="fas fa-check me-2"></i>Use This Template
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Bootstrap JS (Required for header dropdowns and mobile menu) -->
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    {{-- Plugins --}}
    <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    
    {{-- GSAP --}}
    <script src="{{ asset('assets/js/gsap/gsap.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/ScrollTrigger.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/SplitText.js') }}"></script>
    
    {{-- Menu script --}}
    <script src="{{ asset('js/menu.js') }}"></script>
    
    <script src="{{ asset('assets/js/script.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Handle preview button click
            $('#previewModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const previewImage = button.data('preview-image');
                const templateName = button.data('template-name');
                const templateSlug = button.data('template-slug');
                
                // Update modal content
                const modal = $(this);
                modal.find('#previewModalLabel').text(templateName + ' - Preview');
                modal.find('#previewModalImage').attr('src', previewImage);
                modal.find('#previewModalImage').attr('alt', templateName + ' Preview');
                
                // Update "Use This Template" button link
                const useBtn = modal.find('#previewModalUseBtn');
                const useUrl = '{{ route("localized.cv.builder", ["lang" => app()->getLocale(), "slug" => "TEMPLATE_SLUG"]) }}'.replace('TEMPLATE_SLUG', templateSlug);
                useBtn.attr('href', useUrl);
            });
            
            // Handle image load error
            $('#previewModalImage').on('error', function() {
                const $img = $(this);
                // Only show error message if not already shown
                if ($img.siblings('.image-error-message').length === 0) {
                    $img.attr('src', '{{ asset("images/default.png") }}');
                    $img.after('<p class="text-muted mt-3 image-error-message">Preview image could not be loaded</p>');
                }
            });
            
            // Clear error message when modal is hidden
            $('#previewModal').on('hidden.bs.modal', function() {
                $(this).find('.image-error-message').remove();
            });
        });
    </script>
@endsection