@extends('site.profile')

@section('title', __('lang.Create Blog'))

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

        .form{
            width: 100% !important;
            background: #0c0c0c;
            padding: 11px;
            border-radius: 16px;
            padding-top: 20px;
            box-shadow: 0px 0px 5px 1px #3333331f;
        }

        .cke_notifications_area{
            display: none;
        }

        #cke_1_bottom{
            background: #0c0c0c;
        }

        .col-md-10 {
            flex: 0 0 auto;
            width: 79.333333%;
        }

        .card{
            background: #0c0c0c !important;
        }

        .nice-select{
            height: auto !important;
            background: #0c0c0c !important;
            border: 1px solid;
            line-height: 23px !important;
            border-radius: 4px;
        }

        h3{
            color: #eee;
        }

        input, textarea{
            background: #0c0c0c !important;
            color: #eee !important;
        }

        /* Image preview styles */
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
            border-color: #4a90e2;
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

        .remove-btn {
            position: absolute;
            top: 0;
            right: 5px;
            background: rgba(239, 68, 68, 0.9);
            color: white;
            font-weight: bold;
            font-size: 18px;
            border-radius: 50%;
            padding: 0 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            background: rgba(239, 68, 68, 1);
            transform: scale(1.1);
        }

        .image-wrapper {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }
    </style>

    <div class="col-12 col-md-10" style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 10px; justify-content: flex-end !important;">
        <div class="form mb-4">
            <h3>New Post</h3>

            @if(session('success'))
                <p style="color: #21cf8c">{{ session('success') }}</p>
            @endif

            @if (session('status'))
                <span style="color:rgb(29, 89, 179);" role="alert">
                    {{ session('status') }}
                </span>
            @endif

            <!-- Registration form -->

            <form action="{{ route('localized.admin.blog.store', ['lang' => app()->getLocale()]) }}" method="post" enctype="multipart/form-data">

                @csrf

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
    
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control" placeholder="Enter Blog title" />
                                @error('title')
                                    <p style="color: rgb(160, 40, 50);">{{ $message }}</p>
                                    <style>
                                        #title {
                                            border-color: rgb(160, 40, 50) !important;
                                        }
                                    </style>
                                @enderror
                            </div>
                            
                            <div class="form-group m-t-20 m-b-20 my-2">
                                <label for="thumb">Thumbnail</label>
                                <input type="file" name="thumb" id="thumb" class="image-input-thumb form-control-file d-block" 
                                style="font-size: small !important;" value="{{ old('thumb') }}" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">Dimensions: 600x340</small>
                                @error('thumb')
                                    <p style="color: rgb(160, 40, 50);">{{ $message }}</p>
                                    <style>
                                        #thumb {
                                            border-color: rgb(160, 40, 50) !important;
                                        }
                                    </style>
                                @enderror
                                <div class="photo-preview-container" id="thumb-preview-container"></div>
                            </div>

                            <div class="form-group m-t-20 m-b-20 my-2">
                                <label for="image">Main Image</label>
                                <input type="file" name="image" id="image" class="image-input-main form-control-file d-block" 
                                style="font-size: small !important;" value="{{ old('image') }}" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">Dimensions: 1920x500</small>
                                @error('image')
                                    <p style="color: rgb(160, 40, 50);">{{ $message }}</p>
                                    <style>
                                        #image {
                                            border-color: rgb(160, 40, 50) !important;
                                        }
                                    </style>
                                @enderror
                                <div class="photo-preview-container" id="image-preview-container"></div>
                            </div>

                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea id="content" name="content">
                                    {{ old('content') }}
                                </textarea>
                                @error('content')
                                    <p style="color: rgb(160, 40, 50);">{{ $message }}</p>
                                    <style>
                                        #content {
                                            border-color: rgb(160, 40, 50) !important;
                                        }
                                    </style>
                                @enderror
                            </div>

                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control show-tick" style="height: 36px;">
                                        <option selected value="draft">{{__('lang.Draft')}}</option>
                                        <option value="request">Request for review</option>
                                    </select>
                                    @error('status')
                                        <p style="color: rgb(160, 40, 50);">{{ $message }}</p>
                                        <style>
                                            #status {
                                                border-color: rgb(160, 40, 50) !important;
                                            }
                                        </style>
                                    @enderror
                                </div>
                            <button type="submit" class="btn text-light btn-sm my-3" style="color: #222 !important; background: #21cf8c;">Post</button>
                        </div>
                    </div>
                </div>            
            </div>
        </form>
        </div>
    </div>


    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        CKEDITOR.replace('content', {
                extraAllowedContent: 'img[width,height]{width,height}', // Allow width & height as attributes and styles
                removeFormatAttributes: '',
                image_prefillDimensions: true, 
                allowedContent: true, 
                filebrowserUploadUrl: "{{ route('localized.admin.ckeditor.upload', ['lang' => app()->getLocale()]) }}?_token={{ csrf_token() }}",
                filebrowserUploadMethod: 'form',
                filebrowserUploadMethod: 'xhr'
                
            });
    </script>

    <script>
        setupImagePreview('.image-input-thumb', 'thumb-preview-container');
        setupImagePreview('.image-input-main', 'image-preview-container');

        function setupImagePreview(inputSelector, previewContainerId) {
            const input = document.querySelector(inputSelector);
            const preview = document.getElementById(previewContainerId);

            input.addEventListener('change', e => {
                const file = e.target.files[0]; // Only one file
                if (!file) return;

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    input.value = '';
                    return;
                }

                // Validate file size (5MB limit)
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    alert('File size must be less than 5MB.');
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = ev => {
                    // Clear previous preview
                    preview.innerHTML = '';

                    const wrapper = document.createElement('div');
                    wrapper.className = 'preview-wrapper';

                    wrapper.innerHTML = `
                        <img src="${ev.target.result}" class="preview-image" style="max-width: 200px; max-height: 200px; border-radius: 10px;">
                        <button type="button" class="remove-preview" onclick="removePreview('${inputSelector}', '${previewContainerId}')">
                            <i class="fas fa-times"></i>
                        </button>
                    `;

                    preview.appendChild(wrapper);
                };

                reader.readAsDataURL(file);
            });
        }

        // Make removePreview function globally accessible
        window.removePreview = function(inputSelector, previewContainerId) {
            const input = document.querySelector(inputSelector);
            const preview = document.getElementById(previewContainerId);
            input.value = ''; // Clear file input
            preview.innerHTML = ''; // Clear preview
        };
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

