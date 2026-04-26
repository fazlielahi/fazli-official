@extends('site.layout')

@section('body_class', 'page-register')

@section('title', __('lang.Register'))

@section('meta')
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        .footer{
            display: none !important;
        }
    </style>
@endsection 
 
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
    <link rel="stylesheet" href="{{ asset('styles/login-register.css') }}" />
    @if(in_array(app()->getLocale(), ['ar', 'ur']))
        <link rel="stylesheet" href="{{ asset('styles/login-register-rtl.css') }}" />
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" media="all" />

@endsection


@section('content')

<style>

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        color: #e2e8f0;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }

    /* Enhanced photo upload styles */
    .photo-upload-container {
        margin: 20px 0;
    }

    .drag-drop-zone {
        border: 2px dashed #4a90e2;
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
        color: #4a90e2;
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
        padding: 8px 12px;
        background: rgba(72, 187, 120, 0.1);
        border-radius: 6px;
        border-left: 3px solid #68d391;
    }
    
</style>

<div class="auth-shell">
    <div class="auth-card">
    <aside class="auth-media" aria-hidden="true">
            <img class="auth-media__bg" src="{{ asset('images/login-image.jpg') }}" alt="" />

            <div class="auth-media-inner">
                <div class="brand">
                    <img
                        class="brand-logo"
                        src="{{ asset('images/tfc.png') }}"
                        alt=""
                        width="80"
                        height="24"
                    />
                    <span class="brand-text">{{ __('lang.MADE_BY') }}</span>
                </div>

                <div class="media-quote">
                    <p>{{ __('lang.AUTH_QUOTE') }}</p>
                    <div class="meta">
                        <strong></strong><br />
                        <span>{{ __('lang.AUTH_SUPPORT') }}</span>
                    </div>
                </div>
            </div>
        </aside>

        <main class="auth-main">
            <header class="auth-heading">
                <h1>{{ __('lang.Register') }}</h1>
                <p>{{ __('lang.AUTH_REGISTER_DESC') }}</p>
            </header>

            <form id="registerForm" class="auth-form" method="POST" action="{{ route('localized.register', ['lang' => app()->getlocale()]) }}" enctype="multipart/form-data">
                @csrf

                <div class="auth-field auth-field--float @error('name') is-error @enderror">
                    <div class="auth-input-wrap">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" autocomplete="name" />
                        <label for="name">{{ __('lang.Name') }}</label>
                    </div>
                    @error('name')
                        <div class="auth-field-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field auth-field--float @error('email') is-error @enderror">
                    <div class="auth-input-wrap">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="email" />
                        <label for="email">{{ __('lang.Email') }}</label>
                    </div>
                    @error('email')
                        <div class="auth-field-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field auth-field--float @error('password') is-error @enderror">
                    <div class="auth-input-wrap">
                        <input type="password" name="password" id="password" autocomplete="new-password" />
                        <label for="password">{{ __('lang.Password') }}</label>
                    </div>
                    @error('password')
                        <div class="auth-field-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field auth-field--float @error('password_confirmation') is-error @enderror">
                    <div class="auth-input-wrap">
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" />
                        <label for="password_confirmation">{{ __('lang.Confirm Password') }}</label>
                    </div>
                    @error('password_confirmation')
                        <div class="auth-field-msg">{{ $message }}</div>
                    @enderror
                </div>

                <div class="auth-field @error('photo') is-error @enderror">
                    <div class="auth-photo">
                        <div class="auth-photo__head">
                            <span class="auth-photo__label">{{ __('lang.PhotoOptional') }}</span>
                            <span class="auth-photo__hint">{{ __('lang.PhotoSupports') }}</span>
                        </div>

                        <div class="photo-upload-container">
                            <div class="drag-drop-zone" id="photoDragDropZone">
                                <div class="upload-text">{{ __('lang.DragDropPhoto') }}</div>

                                <input type="file" name="photo" class="form-control photo-input" id="photo" accept="image/*">
                            </div>

                            <div class="error-message" id="photoErrorMessage" style="display: none;"></div>
                            <div class="success-message" id="photoSuccessMessage" style="display: none;"></div>
                        </div>

                        <div class="photo-preview-container" id="photoPreview"></div>

                        @error('photo')
                            <div class="auth-field-msg">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" id="registerButton" class="auth-submit">{{ __('lang.Register') }}</button>

                <div class="auth-foot">
                    {{ __('lang.Already have an account?') }}
                    <a href="{{ route('localized.login', ['lang' => app()->getlocale()]) }}">{{ __('lang.Login here.') }}</a>
                </div>
            </form>
        </main>
    </div>
</div>
@endsection

@section('script')
{{-- Core JS --}}
        <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

        {{-- Plugins --}}
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

        {{-- GSAP --}}
        <script src="{{ asset('assets/js/gsap/gsap.js') }}"></script>
        <script src="{{ asset('assets/js/gsap/ScrollTrigger.js') }}"></script>
        <script src="{{ asset('assets/js/gsap/SplitText.js') }}"></script>

        {{-- Custom Template JS --}}
        <script src="{{ asset('assets/js/script.js') }}"></script>

        {{-- Enhanced Photo Upload Script --}}
        <script>
            // Define error and success messages for photo upload
            const photoErrorInvalid = @json(__('lang.PhotoErrorInvalid'));
            const photoErrorSize = @json(__('lang.PhotoErrorSize'));
            const photoSuccess = @json(__('lang.PhotoSuccess'));
            
            document.addEventListener('DOMContentLoaded', function () {
                function inputLooksFilled(input) {
                    if (input.value && String(input.value).trim().length > 0) {
                        return true;
                    }
                    try {
                        if (input.matches(':-webkit-autofill')) {
                            return true;
                        }
                    } catch (e) { /* unsupported selector */ }
                    try {
                        if (input.matches(':-moz-autofill')) {
                            return true;
                        }
                    } catch (e) { /* unsupported selector */ }
                    return false;
                }

                function refreshAuthFloat(input) {
                    const field = input.closest('.auth-field--float');
                    if (!field) return;
                    const has = inputLooksFilled(input);
                    const focused = document.activeElement === input;
                    field.classList.toggle('is-float', has || focused);
                }

                function refreshAllAuthFloats() {
                    document.querySelectorAll('.auth-field--float input').forEach(refreshAuthFloat);
                }

                document.querySelectorAll('.auth-field--float input').forEach((input) => {
                    refreshAuthFloat(input);
                    ['focus', 'blur', 'input', 'change'].forEach((evt) => {
                        input.addEventListener(evt, () => refreshAuthFloat(input));
                    });
                    input.addEventListener('animationstart', (e) => {
                        if (e.animationName === 'auth-autofill-detect') {
                            refreshAuthFloat(input);
                        }
                    });
                });

                function scheduleAutofillFloatSync() {
                    refreshAllAuthFloats();
                    [50, 150, 400, 800, 1600].forEach((ms) => setTimeout(refreshAllAuthFloats, ms));
                }

                if (document.readyState === 'complete') {
                    scheduleAutofillFloatSync();
                } else {
                    window.addEventListener('load', scheduleAutofillFloatSync);
                }
                window.addEventListener('pageshow', (ev) => {
                    if (ev.persisted) {
                        refreshAllAuthFloats();
                    }
                });

                const dragDropZone = document.getElementById('photoDragDropZone');
                const photoInput = document.getElementById('photo');
                const photoPreview = document.getElementById('photoPreview');
                const errorMessage = document.getElementById('photoErrorMessage');
                const successMessage = document.getElementById('photoSuccessMessage');

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
                        showError(photoErrorInvalid);
                        return;
                    }

                    // Validate file size (5MB limit)
                    const maxSize = 5 * 1024 * 1024; // 5MB
                    if (file.size > maxSize) {
                        showError(photoErrorSize);
                        return;
                    }

                    // Create a new FileList-like object and assign it to the input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    photoInput.files = dataTransfer.files;

                    // Create preview
                    createPreview(file);
                    
                    // Show success message
                    showSuccess(photoSuccess);
                }

                function createPreview(file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoPreview.innerHTML = '';
                        
                        const previewWrapper = document.createElement('div');
                        previewWrapper.className = 'preview-wrapper';
                        
                        previewWrapper.innerHTML = `
                            <img src="${e.target.result}" alt="" class="preview-image">
                            <button type="button" class="remove-preview" onclick="removePreview()" aria-label="Remove photo">&times;</button>
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

                // Make removePreview function globally accessible
                window.removePreview = function() {
                    photoInput.value = '';
                    photoPreview.innerHTML = '';
                    errorMessage.style.display = 'none';
                    successMessage.style.display = 'none';
                };
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const form = document.getElementById('registerForm');
                if (!form) return;

                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const I18N = {
                    nameRequired: @json(__('lang.AUTH_NAME_REQUIRED')),
                    emailRequired: @json(__('lang.AUTH_EMAIL_REQUIRED')),
                    emailInvalid: @json(__('lang.AUTH_EMAIL_INVALID')),
                    passwordRequired: @json(__('lang.AUTH_PASSWORD_REQUIRED_REGISTER')),
                    passwordMin: @json(__('lang.AUTH_PASSWORD_MIN')),
                    passwordConfirmMismatch: @json(__('lang.AUTH_PASSWORD_CONFIRM_MISMATCH')),
                };

                function clearRegisterClientErrors() {
                    form.querySelectorAll('.auth-field-msg[data-register-client-msg]').forEach((n) => n.remove());
                    form.querySelectorAll('.auth-field.is-error').forEach((w) => w.classList.remove('is-error'));
                }

                function setRegisterFieldError(fieldKey, message) {
                    if (!message) return;
                    const map = {
                        name: 'name',
                        email: 'email',
                        password: 'password',
                        password_confirmation: 'password_confirmation',
                        photo: 'photo',
                    };
                    const inputId = map[fieldKey] || fieldKey;
                    const input = document.getElementById(inputId);
                    const wrap = input ? input.closest('.auth-field') : null;
                    if (!wrap) return;

                    wrap.classList.add('is-error');

                    let msg = wrap.querySelector('.auth-field-msg[data-register-client-msg]');
                    if (!msg) {
                        msg = document.createElement('div');
                        msg.className = 'auth-field-msg';
                        msg.setAttribute('data-register-client-msg', '1');

                        if (fieldKey === 'photo') {
                            const photoRoot = wrap.querySelector('.auth-photo');
                            const preview = photoRoot?.querySelector('#photoPreview');
                            if (preview && preview.parentNode) {
                                preview.parentNode.insertBefore(msg, preview);
                            } else if (photoRoot) {
                                photoRoot.appendChild(msg);
                            } else {
                                wrap.appendChild(msg);
                            }
                        } else {
                            const inner = wrap.querySelector('.auth-input-wrap');
                            if (inner && inner.parentNode) {
                                inner.insertAdjacentElement('afterend', msg);
                            } else {
                                wrap.appendChild(msg);
                            }
                        }
                    }
                    msg.textContent = message;
                }

                function applyRegisterServerErrors(errors) {
                    Object.keys(errors || {}).forEach((key) => {
                        const arr = errors[key];
                        const text = Array.isArray(arr) ? arr[0] : String(arr);
                        setRegisterFieldError(key, text);
                    });
                }

                function clearRegisterFieldUI(wrap) {
                    if (!wrap) return;
                    wrap.classList.remove('is-error');
                    wrap.querySelectorAll('.auth-field-msg').forEach((n) => n.remove());
                }

                function fieldWrapByInputId(id) {
                    const el = document.getElementById(id);
                    return el ? el.closest('.auth-field') : null;
                }

                function validateSingleField(inputId) {
                    const wrap = fieldWrapByInputId(inputId);
                    if (!wrap) return;

                    const name = (form.querySelector('#name')?.value || '').trim();
                    const email = (form.querySelector('#email')?.value || '').trim();
                    const password = form.querySelector('#password')?.value || '';
                    const passwordConfirmation = form.querySelector('#password_confirmation')?.value || '';

                    let ok = true;
                    if (inputId === 'name') {
                        ok = name.length > 0;
                    } else if (inputId === 'email') {
                        ok = email.length > 0 && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                    } else if (inputId === 'password') {
                        ok = password.length >= 8;
                    } else if (inputId === 'password_confirmation') {
                        ok = password.length >= 8 && password === passwordConfirmation;
                    }

                    if (ok) {
                        clearRegisterFieldUI(wrap);
                    }
                }

                ['input', 'change'].forEach((evt) => {
                    ['name', 'email', 'password', 'password_confirmation'].forEach((id) => {
                        form.querySelector('#' + id)?.addEventListener(evt, () => {
                            validateSingleField(id);
                            if (id === 'password') {
                                validateSingleField('password_confirmation');
                            }
                        });
                    });
                });

                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    clearRegisterClientErrors();

                    const name = (form.querySelector('#name')?.value || '').trim();
                    const email = (form.querySelector('#email')?.value || '').trim();
                    const password = form.querySelector('#password')?.value || '';
                    const passwordConfirmation = form.querySelector('#password_confirmation')?.value || '';

                    let invalid = false;

                    if (!name) {
                        setRegisterFieldError('name', I18N.nameRequired);
                        invalid = true;
                    }
                    if (!email) {
                        setRegisterFieldError('email', I18N.emailRequired);
                        invalid = true;
                    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                        setRegisterFieldError('email', I18N.emailInvalid);
                        invalid = true;
                    }
                    if (!password) {
                        setRegisterFieldError('password', I18N.passwordRequired);
                        invalid = true;
                    } else if (password.length < 8) {
                        setRegisterFieldError('password', I18N.passwordMin);
                        invalid = true;
                    }
                    if (password !== passwordConfirmation) {
                        setRegisterFieldError('password_confirmation', I18N.passwordConfirmMismatch);
                        invalid = true;
                    }

                    if (invalid) return;

                    const btn = document.getElementById('registerButton');
                    if (btn) btn.disabled = true;

                    try {
                        const fd = new FormData(form);
                        const res = await fetch(form.action, {
                            method: 'POST',
                            body: fd,
                            credentials: 'same-origin',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                            },
                        });

                        if (res.status === 422) {
                            const data = await res.json().catch(() => ({}));
                            applyRegisterServerErrors(data.errors || {});
                            if (btn) btn.disabled = false;
                            return;
                        }

                        if (res.redirected || res.ok) {
                            window.location.href = res.url;
                            return;
                        }

                        if (btn) btn.disabled = false;
                    } catch (err) {
                        if (btn) btn.disabled = false;
                    }
                });
            });
        </script>

        {{-- Heart Icon Toggle Script --}}
        <script>
            $(document).ready(function() {
                // Heart icon toggle functionality
                $('.blogs-one__heart a').on('click', function(e) {
                    e.preventDefault();
                    var $heartIcon = $(this).find('.icon-heart');
                    
                    // Toggle the active class
                    $heartIcon.toggleClass('active');
                    
                    // Optional: Add animation effect
                    if ($heartIcon.hasClass('active')) {
                        $heartIcon.addClass('heart-beat');
                        setTimeout(function() {
                            $heartIcon.removeClass('heart-beat');
                        }, 300);
                    }
                });
            });
        </script>


@endsection