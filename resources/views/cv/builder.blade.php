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
            height: 615px;  
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
        .experience-entry,
        .education-entry {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
            position: relative;
        }
        .entry-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .entry-header h4 {
            margin: 0;
            color: #2563eb;
            font-size: 16px;
        }
        .entry-number {
            color: #666;
            font-weight: normal;
        }
        .btn-add-entry {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-bottom: 20px;
            transition: background 0.3s;
        }
        .btn-add-entry:hover {
            background: #218838;
        }
        .btn-remove-entry {
            padding: 5px 15px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.3s;
        }
        .btn-remove-entry:hover {
            background: #c82333;
        }
        #experience-container,
        #education-container {
            margin-bottom: 10px;
        }
        .btn-save-cv {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn-save-cv:hover {
            background: #1e40af;
        }
        .btn-save-cv:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }
        #save-message {
            padding: 10px;
            border-radius: 4px;
            display: none;
        }
        #save-message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        #save-message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .cv-preview-container {
            transition: opacity 0.1s ease-in-out;
        }
        .cv-preview-container.updating {
            opacity: 0.7;
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
                <div id="experience-container">
                    <!-- Experience Entry Template (hidden, used for cloning) -->
                    <div class="experience-entry" data-index="0" style="display: none;">
                        <div class="entry-header">
                            <h4>Experience <span class="entry-number">#1</span></h4>
                            <button type="button" class="btn-remove-entry" style="display: none;">Remove</button>
                        </div>
                        <div class="form-group">
                            <label>Job Title</label>
                            <input type="text" name="experience[INDEX][title]" placeholder="Senior Developer">
                        </div>
                        <div class="form-group">
                            <label>Company</label>
                            <input type="text" name="experience[INDEX][company]" placeholder="Company Name">
                        </div>
                        <div class="form-group">
                            <label>Period</label>
                            <input type="text" name="experience[INDEX][period]" placeholder="2020 - Present">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="experience[INDEX][description]" placeholder="Job responsibilities and achievements..."></textarea>
                        </div>
                    </div>
                    
                    <!-- First Experience Entry -->
                    <div class="experience-entry" data-index="0">
                        <div class="entry-header">
                            <h4>Experience <span class="entry-number">#1</span></h4>
                            <button type="button" class="btn-remove-entry" style="display: none;">Remove</button>
                        </div>
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
                    </div>
                </div>
                <button type="button" id="btn-add-experience" class="btn-add-entry">+ Add Experience</button>
                
                <h3 class="section-title">Education</h3>
                <div id="education-container">
                    <!-- Education Entry Template (hidden, used for cloning) -->
                    <div class="education-entry" data-index="0" style="display: none;">
                        <div class="entry-header">
                            <h4>Education <span class="entry-number">#1</span></h4>
                            <button type="button" class="btn-remove-entry" style="display: none;">Remove</button>
                        </div>
                        <div class="form-group">
                            <label>Degree</label>
                            <input type="text" name="education[INDEX][degree]" placeholder="Bachelor of Science">
                        </div>
                        <div class="form-group">
                            <label>Institution</label>
                            <input type="text" name="education[INDEX][institution]" placeholder="University Name">
                        </div>
                        <div class="form-group">
                            <label>Period</label>
                            <input type="text" name="education[INDEX][period]" placeholder="2016 - 2020">
                        </div>
                    </div>
                    
                    <!-- First Education Entry -->
                    <div class="education-entry" data-index="0">
                        <div class="entry-header">
                            <h4>Education <span class="entry-number">#1</span></h4>
                            <button type="button" class="btn-remove-entry" style="display: none;">Remove</button>
                        </div>
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
                    </div>
                </div>
                <button type="button" id="btn-add-education" class="btn-add-entry">+ Add Education</button>
                
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
    <script>
        // Phase 2: Live Preview Updates (Improved)
        console.log('CV Builder loaded for template: {{ $templateSlug }}');
        
        $(document).ready(function() {
            const $form = $('#cv-form');
            const $preview = $('#cv-preview');
            let formData = {};
            let updateTimer = null;
            let isUpdating = false;
            const DEBOUNCE_DELAY = 300; // milliseconds - delay before updating preview
            
            // Performance: Cache jQuery selectors
            const $nameInput = $form.find('input[name="name"]');
            const $emailInput = $form.find('input[name="email"]');
            const $phoneInput = $form.find('input[name="phone"]');
            const $summaryInput = $form.find('textarea[name="summary"]');
            
            // Function to collect all form data (optimized)
            function collectFormData() {
                try {
                    const data = {
                        name: $nameInput.val() || '',
                        email: $emailInput.val() || '',
                        phone: $phoneInput.val() || '',
                        summary: $summaryInput.val() || '',
                        experience: [],
                        education: []
                    };
                    
                    // Collect experience entries (optimized)
                    $form.find('input[name^="experience["], textarea[name^="experience["]').each(function() {
                        const name = $(this).attr('name');
                        const match = name.match(/experience\[(\d+)\]\[(\w+)\]/);
                        if (match) {
                            const index = parseInt(match[1]);
                            const field = match[2];
                            const value = $(this).val() || '';
                            
                            if (!data.experience[index]) {
                                data.experience[index] = {};
                            }
                            data.experience[index][field] = value;
                        }
                    });
                    
                    // Collect education entries (optimized)
                    $form.find('input[name^="education["]').each(function() {
                        const name = $(this).attr('name');
                        const match = name.match(/education\[(\d+)\]\[(\w+)\]/);
                        if (match) {
                            const index = parseInt(match[1]);
                            const field = match[2];
                            const value = $(this).val() || '';
                            
                            if (!data.education[index]) {
                                data.education[index] = {};
                            }
                            data.education[index][field] = value;
                        }
                    });
                    
                    return data;
                } catch (error) {
                    console.error('Error collecting form data:', error);
                    return formData; // Return previous data on error
                }
            }
            
            // Helper function to escape HTML (prevent XSS) - optimized
            function escapeHtml(text) {
                if (!text) return '';
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
            
            // Step 2: Update preview with captured data (improved with animations)
            function updatePreview(data) {
                if (isUpdating) return; // Prevent concurrent updates
                
                try {
                    // Check if template exists
                    const hasTemplate = $preview.find('.cv-template').length > 0;
                    const hasError = $preview.find('h3:contains("Template Files Not Found")').length > 0;
                    
                    if (hasError && !hasTemplate) {
                        return; // Don't update if template files don't exist
                    }
                    
                    isUpdating = true;
                    
                    // Build HTML structure matching template
                    let html = '<div class="cv-template modern">';
                    
                    // Header section
                    html += '<div class="cv-header">';
                    html += '<h1>' + escapeHtml(data.name || 'Your Name') + '</h1>';
                    html += '<p>' + escapeHtml(data.email || 'your.email@example.com') + '</p>';
                    html += '<p>' + escapeHtml(data.phone || 'Your Phone') + '</p>';
                    html += '</div>';
                    
                    // Body section
                    html += '<div class="cv-body">';
                    
                    // Summary section
                    if (data.summary && data.summary.trim()) {
                        html += '<section class="summary">';
                        html += '<h2>Summary</h2>';
                        html += '<p>' + escapeHtml(data.summary) + '</p>';
                        html += '</section>';
                    }
                    
                    // Experience section
                    if (data.experience && data.experience.length > 0) {
                        const validExperiences = data.experience.filter(exp => exp.title || exp.company);
                        if (validExperiences.length > 0) {
                            html += '<section class="experience">';
                            html += '<h2>Experience</h2>';
                            
                            validExperiences.forEach(function(exp) {
                                html += '<div class="experience-item">';
                                html += '<h3>' + escapeHtml(exp.title || 'Job Title') + '</h3>';
                                html += '<p class="company">' + escapeHtml(exp.company || 'Company Name') + '</p>';
                                html += '<p class="period">' + escapeHtml(exp.period || 'Period') + '</p>';
                                if (exp.description) {
                                    html += '<p>' + escapeHtml(exp.description) + '</p>';
                                }
                                html += '</div>';
                            });
                            
                            html += '</section>';
                        }
                    }
                    
                    // Education section
                    if (data.education && data.education.length > 0) {
                        const validEducations = data.education.filter(edu => edu.degree || edu.institution);
                        if (validEducations.length > 0) {
                            html += '<section class="education">';
                            html += '<h2>Education</h2>';
                            
                            validEducations.forEach(function(edu) {
                                html += '<div class="education-item">';
                                html += '<h3>' + escapeHtml(edu.degree || 'Degree') + '</h3>';
                                html += '<p class="institution">' + escapeHtml(edu.institution || 'Institution') + '</p>';
                                html += '<p class="period">' + escapeHtml(edu.period || 'Period') + '</p>';
                                html += '</div>';
                            });
                            
                            html += '</section>';
                        }
                    }
                    
                    html += '</div>'; // End cv-body
                    html += '</div>'; // End cv-template
                    
                    // Smooth update with fade effect
                    $preview.fadeOut(100, function() {
                        $(this).html(html).fadeIn(100);
                        isUpdating = false;
                    });
                    
                } catch (error) {
                    console.error('Error updating preview:', error);
                    isUpdating = false;
                }
            }
            
            // Debounced function to handle form data changes
            function handleFormChange() {
                // Clear previous timer
                if (updateTimer) {
                    clearTimeout(updateTimer);
                }
                
                // Set new timer (debouncing)
                updateTimer = setTimeout(function() {
                    try {
                        formData = collectFormData();
                        updatePreview(formData);
                    } catch (error) {
                        console.error('Error in handleFormChange:', error);
                    }
                }, DEBOUNCE_DELAY);
            }
            
            // Listen to all input and textarea changes using event delegation
            $form.on('input change', 'input, textarea', function() {
                handleFormChange();
            });
            
            // Initial data collection and preview update
            formData = collectFormData();
            updatePreview(formData); // Show initial preview
            
            // Step 3: Dynamic Form Fields - Add/Remove Experience and Education
            
            // Function to get next available index for entries
            function getNextIndex(containerSelector) {
                let maxIndex = -1;
                $(containerSelector + ' .experience-entry, ' + containerSelector + ' .education-entry').each(function() {
                    const index = parseInt($(this).attr('data-index')) || 0;
                    if (index > maxIndex) maxIndex = index;
                });
                return maxIndex + 1;
            }
            
            // Function to update entry numbers
            function updateEntryNumbers(containerSelector, entryType) {
                $(containerSelector + ' .' + entryType + '-entry:visible').each(function(index) {
                    $(this).find('.entry-number').text('#' + (index + 1));
                    $(this).attr('data-index', index);
                    
                    // Update all input/textarea names with new index
                    $(this).find('input, textarea').each(function() {
                        const name = $(this).attr('name');
                        if (name) {
                            const newName = name.replace(/\[(\d+)\]/, '[' + index + ']');
                            $(this).attr('name', newName);
                        }
                    });
                });
            }
            
            // Function to show/hide remove buttons
            function toggleRemoveButtons(containerSelector, entryType) {
                const entries = $(containerSelector + ' .' + entryType + '-entry:visible');
                if (entries.length > 1) {
                    entries.find('.btn-remove-entry').show();
                } else {
                    entries.find('.btn-remove-entry').hide();
                }
            }
            
            // Add Experience Entry
            $('#btn-add-experience').on('click', function() {
                // Find the first visible entry to clone (or use template if available)
                const $existingEntry = $('#experience-container .experience-entry:visible').first();
                const template = $existingEntry.length ? $existingEntry.clone() : $('#experience-container .experience-entry[style*="display: none"]').clone();
                const nextIndex = getNextIndex('#experience-container');
                
                // Update template
                template.removeAttr('style').show();
                template.attr('data-index', nextIndex);
                template.find('.entry-number').text('#' + (nextIndex + 1));
                
                // Update all input names - replace index in name attribute
                template.find('input, textarea').each(function() {
                    const $input = $(this);
                    let name = $input.attr('name');
                    if (name) {
                        // Replace INDEX placeholder or existing index with new index
                        name = name.replace(/INDEX|\[\d+\]/, '[' + nextIndex + ']');
                        $input.attr('name', name).val('');
                    }
                });
                
                // Append to container
                $('#experience-container').append(template);
                
                // Update entry numbers
                updateEntryNumbers('#experience-container', 'experience');
                toggleRemoveButtons('#experience-container', 'experience');
                
                // Trigger preview update
                handleFormChange();
            });
            
            // Add Education Entry
            $('#btn-add-education').on('click', function() {
                // Find the first visible entry to clone (or use template if available)
                const $existingEntry = $('#education-container .education-entry:visible').first();
                const template = $existingEntry.length ? $existingEntry.clone() : $('#education-container .education-entry[style*="display: none"]').clone();
                const nextIndex = getNextIndex('#education-container');
                
                // Update template
                template.removeAttr('style').show();
                template.attr('data-index', nextIndex);
                template.find('.entry-number').text('#' + (nextIndex + 1));
                
                // Update all input names - replace index in name attribute
                template.find('input').each(function() {
                    const $input = $(this);
                    let name = $input.attr('name');
                    if (name) {
                        // Replace INDEX placeholder or existing index with new index
                        name = name.replace(/INDEX|\[\d+\]/, '[' + nextIndex + ']');
                        $input.attr('name', name).val('');
                    }
                });
                
                // Append to container
                $('#education-container').append(template);
                
                // Update entry numbers
                updateEntryNumbers('#education-container', 'education');
                toggleRemoveButtons('#education-container', 'education');
                
                // Trigger preview update
                handleFormChange();
            });
            
            // Remove Entry (using event delegation for dynamically added buttons)
            $(document).on('click', '.btn-remove-entry', function() {
                const $entry = $(this).closest('.experience-entry, .education-entry');
                const containerSelector = $entry.closest('#experience-container, #education-container').attr('id');
                const entryType = $entry.hasClass('experience-entry') ? 'experience' : 'education';
                
                // Remove the entry
                $entry.fadeOut(200, function() {
                    $(this).remove();
                    
                    // Update entry numbers
                    updateEntryNumbers('#' + containerSelector, entryType);
                    toggleRemoveButtons('#' + containerSelector, entryType);
                    
                    // Trigger preview update
                    handleFormChange();
                });
            });
            
            // Initialize: Show/hide remove buttons based on initial count
            toggleRemoveButtons('#experience-container', 'experience');
            toggleRemoveButtons('#education-container', 'education');
            
            // Step 4: Save CV functionality
            $('#btn-save-cv').on('click', function() {
                const $btn = $(this);
                const $message = $('#save-message');
                const templateSlug = '{{ $templateSlug }}';
                const cvTitle = $('#cv-title').val() || 'My CV';
                
                // Disable button and show loading
                $btn.prop('disabled', true).text('Saving...');
                $message.hide().removeClass('success error');
                
                // Collect current form data
                const cvData = collectFormData();
                
                // Send AJAX request
                $.ajax({
                    url: '{{ route("localized.cv.save", ["lang" => app()->getLocale()]) }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        template_slug: templateSlug,
                        title: cvTitle,
                        cv_data: cvData
                    },
                    success: function(response) {
                        if (response.success) {
                            $message
                                .addClass('success')
                                .text(response.message)
                                .fadeIn();
                            
                            // Reset button after 2 seconds
                            setTimeout(function() {
                                $btn.prop('disabled', false).text('💾 Save CV');
                            }, 2000);
                        } else {
                            $message
                                .addClass('error')
                                .text(response.message)
                                .fadeIn();
                            $btn.prop('disabled', false).text('💾 Save CV');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Error saving CV. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.status === 401) {
                            errorMessage = 'Please login to save your CV';
                        }
                        
                        $message
                            .addClass('error')
                            .text(errorMessage)
                            .fadeIn();
                        $btn.prop('disabled', false).text('💾 Save CV');
                    }
                });
            });
        });
    </script>
@endsection

