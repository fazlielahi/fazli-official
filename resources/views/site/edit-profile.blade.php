@extends('site.profile')

@section('head')
    <!-- Preload critical CSS -->
    <link rel="preload" href="{{ asset('assets/css/style.css') }}" as="style" />
    <link rel="preload" href="{{ asset('assets/css/responsive.css') }}" as="style" />

    <link rel="stylesheet" href="{{ asset('styles/header.css') }}" /> <!-- main heading css -->
    <link rel="stylesheet" href="{{ asset('styles/index.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet" />
    <!-- Font Awesome CDN for version 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Third-party CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom-animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome-all.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jarallax.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}" />

    <!-- Module CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/banner.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/footer.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/sliding-text.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/category.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/about.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/services.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/why-choose.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/live-class.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/video-one.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/blog.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/counter.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/team.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/newsletter.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/testimonial.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/contact.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/process.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/page-header.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/become-a-teacher.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/shop.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/faq.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/module-css/error.css') }}" />

    <!-- Template styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />
@endsection

@section('content')
    <style>
        .menu-thumb {
            display: inline-block !important;
        }
        .blog-boxes{
            flex-direction: row !important;
        }

        h3{
            color: white;
        }

        input, textarea{
            background: #0c0c0c !important;
            color: #eee !important;
        }

        .form{
            width: 100% !important;
            background: #0c0c0c;
            padding: 11px;
            border-radius: 16px;
            padding-top: 20px;
            margin-top: 20px;
            box-shadow: 0px 0px 5px 1px #3333331f;
            color: #e2e8f0;
        }

        /* Enhanced photo upload styles */
        .photo-upload-container {
            margin: 20px 0;
        }

        .drag-drop-zone {
            border: 2px dashed #21cf8c;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            background: #1a1a1a;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .drag-drop-zone:hover {
            border-color: #5ba3f5;
            background: #2a2a2a;
        }

        .drag-drop-zone.dragover {
            border-color: #5ba3f5;
            background: #2d3748;
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(74, 144, 226, 0.3);
        }

        .drag-drop-zone .upload-icon {
            font-size: 48px;
            color: #21cf8c;
            margin-bottom: 15px;
        }

        .drag-drop-zone .upload-text {
            font-size: 16px;
            color: #e2e8f0;
            margin-bottom: 10px;
        }

        .drag-drop-zone .upload-hint {
            font-size: 14px;
            color: #a0aec0;
        }

        .photo-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 10;
        }

        .photo-preview-container {
            margin-top: 20px;
        }

        .preview-wrapper {
            display: inline-block;
            position: relative;
            margin: 10px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4);
            transition: transform 0.3s ease;
            background: #2a2a2a;
            border: 2px solid #3a3a3a;
        }

        .preview-wrapper:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 30px rgba(0,0,0,0.6);
            border-color: #21cf8c;
        }

        .preview-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            display: block;
        }

        .remove-preview {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .remove-preview:hover {
            background: rgba(239, 68, 68, 1);
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.5);
        }

        .file-info {
            margin-top: 10px;
            padding: 12px;
            background: #2d3748;
            border-radius: 8px;
            font-size: 14px;
            color: #21cf8c;
            border: 1px solid #4a5568;
        }

        .file-info i {
            margin-right: 8px;
            color: #21cf8c;
        }

        .error-message {
            color: #fc8181;
            font-size: 14px;
            margin-top: 5px;
            padding: 8px 12px;
            background: rgba(239, 68, 68, 0.1);
            border-radius: 6px;
            border-left: 3px solid #fc8181;
        }

        .success-message {
            color: #68d391;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>

    <div class="col-12" style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 10px; justify-content: flex-end !important;">
        <div class="form mb-4">
            <h3>{{ __('lang.Edit Profile') }}</h3>

            <!-- display validation errors -->
            <hr style="border-top: 1px dashed #424242; margin: 10px 0;">

            @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li style="color:red; display: block !important"> {{ $error }} </li>
                    @endforeach
                </ul>
            @endif

            <!-- Registration form -->
            <form method="POST" action="{{route('localized.profile-update', ['lang' => app()->getLocale()])}}" enctype="multipart/form-data">
                @csrf

                <div class="form-group my-3">
                    <label for="name">{{ __('lang.Name') }}</label>
                    <input type="text" name="name" id="" value="{{ old('name', $user->name) }}" placeholder="{{ __('lang.Enter Your Name') }}" class="form-control">
                </div>

                <div class="photo-upload-container">
                    <label for="photo" class="form-label">{{ __('lang.Profile Photo') }}</label>
                    
                    <div class="drag-drop-zone" id="dragDropZone">
                        <div class="upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="upload-text">{{ __('lang.Drag & drop your photo here') }}</div>
                        <div class="upload-hint">{{ __('lang.or click to browse files') }}</div>
                        <div class="upload-hint">{{ __('lang.Supports: JPG, PNG, GIF (Max: 5MB)') }}</div>
                        
                        <input type="file" name="photo" class="form-control photo-input" id="photo" accept="image/*">
                    </div>

                    <div class="file-info" id="fileInfo" style="display: none;">
                        <i class="fas fa-info-circle"></i>
                        <span id="fileName"></span>
                        <span id="fileSize"></span>
                    </div>

                    <div class="error-message" id="errorMessage" style="display: none;"></div>
                    <div class="success-message" id="successMessage" style="display: none;"></div>
                </div>

                <div class="photo-preview-container" id="photoPreview">
                    @if($user->photo)
                        <div class="preview-wrapper">
                            <img src="{{ asset('images/' . $user->photo) }}" alt="Current Profile Photo" class="preview-image">
                            <button type="button" class="remove-preview" onclick="removeCurrentPhoto()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn text-light btn-sm mt-3" style="background: #335214;">{{ __('lang.Update') }}</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dragDropZone = document.getElementById('dragDropZone');
            const photoInput = document.getElementById('photo');
            const photoPreview = document.getElementById('photoPreview');
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const errorMessage = document.getElementById('errorMessage');
            const successMessage = document.getElementById('successMessage');

            // Drag and drop functionality
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dragDropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dragDropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dragDropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dragDropZone.classList.add('dragover');
            }

            function unhighlight(e) {
                dragDropZone.classList.remove('dragover');
            }

            // Handle dropped files
            dragDropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                handleFiles(files);
            }

            // Handle file input change
            photoInput.addEventListener('change', function(e) {
                handleFiles(e.target.files);
            });

            // Add explicit click handler for the drag zone
            dragDropZone.addEventListener('click', function(e) {
                // Prevent triggering if clicking on the file input itself
                if (e.target !== photoInput) {
                    photoInput.click();
                }
            });

            // Prevent click event from bubbling when clicking the file input
            photoInput.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // Handle file selection
            function handleFiles(files) {
                if (files.length === 0) return;

                const file = files[0];
                
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showError('{{ __('lang.Please select a valid image file.') }}');
                    return;
                }

                // Validate file size (5MB limit)
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    showError('{{ __('lang.File size must be less than 5MB.') }}');
                    return;
                }

                // Create a new FileList-like object and assign it to the input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                photoInput.files = dataTransfer.files;

                // Show file info
                showFileInfo(file);
                
                // Create preview
                createPreview(file);
                
                // Show success message
                showSuccess('{{ __('lang.Image selected successfully!') }}');
            }

            function showFileInfo(file) {
                fileName.textContent = `{{ __('lang.File:') }} ${file.name}`;
                fileSize.textContent = `{{ __('lang.Size:') }} ${formatFileSize(file.size)}`;
                fileInfo.style.display = 'block';
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            function createPreview(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.innerHTML = '';
                    
                    const previewWrapper = document.createElement('div');
                    previewWrapper.className = 'preview-wrapper';
                    
                    previewWrapper.innerHTML = `
                        <img src="${e.target.result}" alt="Preview" class="preview-image">
                        <button type="button" class="remove-preview" onclick="removePreview()">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    
                    photoPreview.appendChild(previewWrapper);
                };
                reader.readAsDataURL(file);
            }

            function showError(message) {
                errorMessage.textContent = message;
                errorMessage.style.display = 'block';
                successMessage.style.display = 'none';
                setTimeout(() => {
                    errorMessage.style.display = 'none';
                }, 5000);
            }

            function showSuccess(message) {
                successMessage.textContent = message;
                successMessage.style.display = 'block';
                errorMessage.style.display = 'none';
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3000);
            }

            // Make functions globally accessible
            window.removePreview = function() {
                photoInput.value = '';
                photoPreview.innerHTML = '';
                fileInfo.style.display = 'none';
                errorMessage.style.display = 'none';
                successMessage.style.display = 'none';
            };

            window.removeCurrentPhoto = function() {
                // Add a hidden input to indicate photo removal
                const removePhotoInput = document.createElement('input');
                removePhotoInput.type = 'hidden';
                removePhotoInput.name = 'remove_photo';
                removePhotoInput.value = '1';
                photoInput.parentNode.appendChild(removePhotoInput);
                
                photoPreview.innerHTML = '';
                showSuccess('{{ __('lang.Current photo will be removed on save.') }}');
            };
        });
    </script>
@endsection

@section('script')
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jarallax.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/odometer.min.js') }}"></script>
    <script src="{{ asset('assets/js/wNumb.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/marquee.min.js') }}"></script>
    <script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/gsap.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/ScrollTrigger.js') }}"></script>
    <script src="{{ asset('assets/js/gsap/SplitText.js') }}"></script>
    <!-- template js -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.like-toggle').forEach(function(link) {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    var icon = link.querySelector('i');
                    if (icon.classList.contains('fa-regular')) {
                        icon.classList.remove('fa-regular');
                        icon.classList.add('fa-solid');
                    } else {
                        icon.classList.remove('fa-solid');
                        icon.classList.add('fa-regular');
                    }
                });
            });
        });
    </script>
@endsection
