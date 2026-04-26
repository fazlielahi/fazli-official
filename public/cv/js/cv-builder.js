/**
 * CV Builder JavaScript
 * Handles form data collection, live preview updates, and CV save/load functionality
 */

(function($) {
    'use strict';

    // CV Builder Configuration (will be passed from Blade template)
    let cvBuilderConfig = {
        templateSlug: '',
        routes: {
            saved: '',
            load: '',
            save: '',
            duplicateCV: '',
            importUpload: '',
            importExtract: '',
            importParse: ''
        },
        csrfToken: ''
    };

    // Initialize CV Builder
    function initCVBuilder(config) {
        cvBuilderConfig = config;

        const $form = $('#cv-form');
        const $preview = $('#cv-preview');
        const $pagesWrapper = $preview.find('.cv-pages-wrapper');

        /** First page only — avoids matching continuation-page clones of `.cv-template`. */
        function getPrimaryPreviewTemplate() {
            const $page = $pagesWrapper.find('.cv-page-container').first();
            if ($page.length) {
                const $tpl = $page.children('.cv-template').first();
                if ($tpl.length) {
                    return $tpl;
                }
            }
            return $pagesWrapper.children('.cv-template').first();
        }

        let formData = {};
        let updateTimer = null;
        let isUpdating = false;
        const DEBOUNCE_DELAY = 300;
        
        // Page management constants
        const PAGE_HEIGHT_MM = 297;
        const PAGE_PADDING_MM = 15;
        const CONTENT_HEIGHT_MM = PAGE_HEIGHT_MM - (PAGE_PADDING_MM * 2); // 267mm
        const CONTENT_HEIGHT_PX = CONTENT_HEIGHT_MM * 3.779527559; // Convert mm to px (1mm = 3.779527559px at 96dpi)

        // Cache jQuery selectors
        const $nameInput = $form.find('input[name="name"]');
        const $jobTitleInput = $form.find('input[name="job_title"]');
        const $emailInput = $form.find('input[name="email"]');
        const $phoneInput = $form.find('input[name="phone"]');
        const $cityInput = $form.find('input[name="city"]');
        const $photoCircle = $('.cv-photo-upload__circle');
        const $summaryInput = $form.find('textarea[name="summary"]');
        const $photoInput = $('#photo-upload');
        const $photoPreview = $('#photo-preview');
        const $photoPreviewContainer = $('#photo-preview-container');
        const $removePhoto = $('#remove-photo');
        let photoData = null;

        // Personal details view/edit toggle
        const $personalView = $('#cv-personal-view');
        const $personalEdit = $('#cv-personal-edit');
        const $personalEditOpen = $('#cv-personal-view-edit');
        const $personalEditDone = $('#cv-personal-done');

        function showPersonalEdit() {
            $personalView.prop('hidden', true).attr('aria-hidden', 'true');
            $personalEdit.removeClass('is-hidden').attr('aria-hidden', 'false');
            setTimeout(function() { $nameInput.trigger('focus'); }, 0);
        }

        function showPersonalView() {
            $personalEdit.addClass('is-hidden').attr('aria-hidden', 'true');
            $personalView.prop('hidden', false).attr('aria-hidden', 'false');
        }

        $personalEditOpen.on('click', function(e) {
            e.preventDefault();
            showPersonalEdit();
        });

        $personalEditDone.on('click', function(e) {
            e.preventDefault();
            showPersonalView();
        });

        function resumeShowFromData(val) {
            if (val === false || val === 0 || val === '0') return false;
            return true;
        }

        function updatePersonalViewCard(data) {
            if (!$personalView.length) return;

            $('#cv-personal-view-name').text((data.name || '').trim() || 'Your Name');
            $('#cv-personal-view-title').text((data.job_title || '').trim() || 'Professional title');

            const email = (data.email || '').trim();
            const phone = (data.phone || '').trim();
            const loc = (data.address || '').trim();
            const showEmail = resumeShowFromData(data.resume_show_email);
            const showPhone = resumeShowFromData(data.resume_show_phone);
            const showLoc = resumeShowFromData(data.resume_show_location);

            $('#cv-personal-view-email').text(email);
            const $emailWrap = $('#cv-personal-view-email-wrap');
            $emailWrap.prop('hidden', !email);
            $emailWrap.toggleClass('cv-personal-view-card__meta-item--resume-hidden', !!email && !showEmail);
            $emailWrap.find('.cv-personal-view-card__hidden-tooltip').attr('aria-hidden', !email || showEmail ? 'true' : 'false');

            $('#cv-personal-view-phone').text(phone);
            const $phoneWrap = $('#cv-personal-view-phone-wrap');
            $phoneWrap.prop('hidden', !phone);
            $phoneWrap.toggleClass('cv-personal-view-card__meta-item--resume-hidden', !!phone && !showPhone);
            $phoneWrap.find('.cv-personal-view-card__hidden-tooltip').attr('aria-hidden', !phone || showPhone ? 'true' : 'false');

            $('#cv-personal-view-location').text(loc);
            const $locWrap = $('#cv-personal-view-location-wrap');
            $locWrap.prop('hidden', !loc);
            $locWrap.toggleClass('cv-personal-view-card__meta-item--resume-hidden', !!loc && !showLoc);
            $locWrap.find('.cv-personal-view-card__hidden-tooltip').attr('aria-hidden', !loc || showLoc ? 'true' : 'false');

            const $img = $('#cv-personal-view-photo-img');
            const $icon = $('#cv-personal-view-photo-icon');
            if (data.photo && String(data.photo).trim()) {
                $img.attr('src', data.photo).prop('hidden', false);
                $icon.prop('hidden', true);
            } else {
                $img.attr('src', '').prop('hidden', true);
                $icon.prop('hidden', false);
            }
        }

        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Track which sections are already added
        const addedSections = new Set();
        
        // Track entry counts for each section (how many entries per section)
        const sectionEntryCounts = {};

        // Available sections configuration
        const availableSections = {
            'experience': {
                name: 'Experience',
                description: 'Add your professional roles and employer history.',
                iconSvg: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8 7V6a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M4 7h16a2 2 0 0 1 2 2v3a4 4 0 0 1-4 4h-2v-2H8v2H6a4 4 0 0 1-4-4V9a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M8 14h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>',
                fields: [
                    { name: 'title', label: 'Job Title', type: 'text', placeholder: 'e.g., Senior Developer' },
                    { name: 'company', label: 'Company', type: 'text', placeholder: 'e.g., Tech Company Inc.' },
                    { name: 'start_date', label: 'Start Date', type: 'text', placeholder: 'MM/YYYY' },
                    { name: 'end_date', label: 'End Date', type: 'text', placeholder: 'MM/YYYY' },
                    { name: 'location', label: 'Location', type: 'text', placeholder: 'City, Country' },
                    { name: 'description', label: 'Description (Optional)', type: 'textarea', placeholder: 'Brief description of your role and achievements' }
                ]
            },
            'education': {
                name: 'Education',
                description: 'Add your degrees and schools.',
                iconSvg: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 3 2 8l10 5 10-5-10-5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M6 10.5V16c0 1.7 3 3 6 3s6-1.3 6-3v-5.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M22 8v6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>',
                fields: [
                    { name: 'degree', label: 'Degree', type: 'text', placeholder: 'e.g., Bachelor of Science in Computer Science' },
                    { name: 'institution', label: 'Institution', type: 'text', placeholder: 'e.g., University Name' },
                    { name: 'start_date', label: 'Start Date', type: 'text', placeholder: 'MM/YYYY' },
                    { name: 'end_date', label: 'End Date', type: 'text', placeholder: 'MM/YYYY' },
                    { name: 'location', label: 'Location', type: 'text', placeholder: 'City, Country' }
                ]
            },
            'certifications': {
                name: 'Certifications',
                description: 'Add your certifications or licenses.',
                iconSvg: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2 9.5 5l-3.7.6 2.7 2.6-.7 3.7L12 10.8l3.2 1.7-.7-3.7 2.7-2.6L14.5 5 12 2Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M9 13l-1 9 4-2 4 2-1-9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                fields: [
                    { name: 'name', label: 'Certification Name', type: 'text', placeholder: 'e.g., AWS Certified Solutions Architect' },
                    { name: 'issuer', label: 'Issuing Organization', type: 'text', placeholder: 'e.g., Amazon Web Services' },
                    { name: 'date', label: 'Date', type: 'text', placeholder: 'e.g., January 2023' },
                    { name: 'credential_id', label: 'Credential ID (Optional)', type: 'text', placeholder: 'e.g., ABC123' }
                ]
            },
            'awards': {
                name: 'Awards',
                description: 'Add your awards and recognitions.',
                iconSvg: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 2 9.6 7.1 4 7.9l4.1 4-1 5.8L12 15.9l4.9 2.6-1-5.8 4.1-4-5.6-.8L12 2Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>',
                fields: [
                    { name: 'title', label: 'Award Title', type: 'text', placeholder: 'e.g., Employee of the Year' },
                    { name: 'organization', label: 'Organization', type: 'text', placeholder: 'e.g., Company Name' },
                    { name: 'date', label: 'Date', type: 'text', placeholder: 'e.g., 2023' },
                    { name: 'description', label: 'Description (Optional)', type: 'textarea', placeholder: 'Brief description of the award' }
                ]
            },
            'languages': {
                name: 'Languages',
                description: 'Add languages and proficiency.',
                iconSvg: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 12a10 10 0 1 0 20 0A10 10 0 0 0 2 12Z" stroke="currentColor" stroke-width="1.8"/><path d="M2 12h20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M12 2c2.8 3 2.8 17 0 20-2.8-3-2.8-17 0-20Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>',
                fields: [
                    { name: 'language', label: 'Language', type: 'text', placeholder: 'e.g., English' },
                    { name: 'proficiency', label: 'Proficiency Level', type: 'select', options: [
                        { value: '', text: 'Select Level (Optional)' },
                        { value: 'Native', text: 'Native' },
                        { value: 'Fluent', text: 'Fluent' },
                        { value: 'Advanced', text: 'Advanced' },
                        { value: 'Intermediate', text: 'Intermediate' },
                        { value: 'Basic', text: 'Basic' }
                    ]}
                ]
            },
            'projects': {
                name: 'Projects',
                description: 'Add projects with links and impact.',
                iconSvg: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 13a5 5 0 0 1 0-7l1-1a5 5 0 0 1 7 7l-1 1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><path d="M14 11a5 5 0 0 1 0 7l-1 1a5 5 0 0 1-7-7l1-1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>',
                fields: [
                    { name: 'name', label: 'Project Name', type: 'text', placeholder: 'e.g., E-commerce Platform' },
                    { name: 'description', label: 'Description', type: 'textarea', placeholder: 'Brief description of the project' },
                    { name: 'technologies', label: 'Technologies Used', type: 'text', placeholder: 'e.g., PHP, Laravel, MySQL' },
                    { name: 'link', label: 'Project Link (Optional)', type: 'text', placeholder: 'https://example.com' }
                ]
            },
            'skills': {
                name: 'Skills',
                description: 'Add hard and soft skills.',
                iconSvg: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.7 6.3a4 4 0 0 1 5.7 5.7l-3.4 3.4-5.7-5.7 3.4-3.4Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M2 22l7.6-2-5.6-5.6L2 22Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M12 9l3 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>',
                fields: [
                    { name: 'skill', label: 'Skill Name', type: 'text', placeholder: 'e.g., JavaScript' },
                    { name: 'level', label: 'Proficiency Level', type: 'select', options: [
                        { value: '', text: 'Select Level (Optional)' },
                        { value: 'Beginner', text: 'Beginner' },
                        { value: 'Intermediate', text: 'Intermediate' },
                        { value: 'Advanced', text: 'Advanced' },
                        { value: 'Expert', text: 'Expert' }
                    ]}
                ]
            },
            'references': {
                name: 'References',
                description: 'Add references and contact details.',
                iconSvg: '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.6 10.8c1.2 2.3 3.1 4.2 5.4 5.4l1.8-1.8c.3-.3.7-.4 1.1-.3 1.2.4 2.5.6 3.9.6.6 0 1 .4 1 1V20c0 .6-.4 1-1 1C10.9 21 3 13.1 3 3c0-.6.4-1 1-1h3.3c.6 0 1 .4 1 1 0 1.4.2 2.7.6 3.9.1.4 0 .8-.3 1.1l-2 1.8Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/></svg>',
                fields: [
                    { name: 'name', label: 'Name', type: 'text', placeholder: 'Full Name' },
                    { name: 'position', label: 'Position', type: 'text', placeholder: 'e.g., Senior Manager' },
                    { name: 'company', label: 'Company', type: 'text', placeholder: 'Company Name' },
                    { name: 'email', label: 'Email', type: 'email', placeholder: 'email@example.com' },
                    { name: 'phone', label: 'Phone (Optional)', type: 'text', placeholder: '+1234567890' }
                ]
            }
        };

        // Sections that use "list view" + per-entry hide flag in the builder
        const listViewSections = new Set([
            'experience',
            'education',
            'skills',
            'certifications',
            'awards',
            'projects',
            'languages',
            'references',
        ]);

        // Which fields to show in list view per section
        const listViewSummaryFields = {
            certifications: { primary: 'name', secondary: 'issuer' },
            awards: { primary: 'title', secondary: 'organization' },
            projects: { primary: 'name', secondary: 'technologies' },
            languages: { primary: 'language', secondary: 'proficiency' },
            references: { primary: 'name', secondary: 'company' },
        };

        function readResumeShowHidden($el) {
            if (!$el || !$el.length) return true;
            return String($el.val()) !== '0';
        }

        /**
         * Show/hide contact lines in the right-panel preview from resume_show_* flags (does not remove data).
         */
        function applyResumeContactVisibility($template, data) {
            if (!$template || !$template.length) return;
            const showEmail = resumeShowFromData(data.resume_show_email);
            const showPhone = resumeShowFromData(data.resume_show_phone);
            const showLoc = resumeShowFromData(data.resume_show_location);
            const email = (data.email || '').trim();
            const phone = (data.phone || '').trim();
            const addr = (data.address || '').trim();

            $template.find('.contact-info').each(function() {
                const $ci = $(this);
                const $plainItems = $ci.children('.contact-item').filter(function() {
                    return $(this).find('.contact-icon').length === 0;
                });

                $ci.children('.contact-item').each(function() {
                    const $item = $(this);
                    const $iconI = $item.find('.contact-icon i');
                    let hide = false;
                    if ($iconI.length) {
                        const cls = $iconI.attr('class') || '';
                        if (cls.indexOf('fa-envelope') !== -1) {
                            hide = !showEmail || !email;
                        } else if (cls.indexOf('fa-phone') !== -1) {
                            hide = !showPhone || !phone;
                        } else if (cls.indexOf('fa-map-marker-alt') !== -1) {
                            hide = !showLoc || !addr;
                        }
                    } else {
                        const pi = $plainItems.index($item);
                        if (pi === 0) {
                            hide = !showEmail || !email;
                        } else if (pi === 1) {
                            hide = !showPhone || !phone;
                        }
                    }
                    $item.toggleClass('cv-preview-contact-hidden', hide);
                });

                const eVis = $plainItems.length >= 1 && !$plainItems.eq(0).hasClass('cv-preview-contact-hidden');
                const pVis = $plainItems.length >= 2 && !$plainItems.eq(1).hasClass('cv-preview-contact-hidden');
                $ci.children('.contact-separator').toggleClass('cv-preview-contact-hidden', !eVis || !pVis);

                const $contactSection = $ci.closest('section.contact');
                if ($contactSection.length) {
                    const anyContactVisible = $ci.find('.contact-item').filter(function() {
                        return !$(this).hasClass('cv-preview-contact-hidden');
                    }).length > 0;
                    $contactSection.toggleClass('cv-preview-contact-hidden', !anyContactVisible);
                }
            });
        }

        function syncResumeVisibilityButton($btn) {
            if (!$btn || !$btn.length) return;
            const controls = $btn.attr('aria-controls');
            if (!controls) return;
            const $h = $('#' + controls);
            if (!$h.length) return;
            const visible = readResumeShowHidden($h);
            $btn.attr('aria-pressed', visible ? 'true' : 'false');
            const $icon = $btn.find('i').first();
            $icon.removeClass('fa-eye fa-eye-slash').addClass(visible ? 'fa-eye' : 'fa-eye-slash');
            $btn.attr('title', visible ? 'Shown in resume preview' : 'Hidden from resume preview');
            const id = $btn.attr('id') || '';
            if (id === 'cv-toggle-resume-email') {
                $btn.attr('aria-label', visible ? 'Email shown in resume preview. Click to hide.' : 'Email hidden from resume preview. Click to show.');
            } else if (id === 'cv-toggle-resume-location') {
                $btn.attr('aria-label', visible ? 'Location shown in resume preview. Click to hide.' : 'Location hidden from resume preview. Click to show.');
            } else if (id === 'cv-toggle-resume-phone') {
                $btn.attr('aria-label', visible ? 'Phone shown in resume preview. Click to hide.' : 'Phone hidden from resume preview. Click to show.');
            }
        }

        function normalizePresentValue(raw) {
            const v = String(raw || '').trim().toLowerCase();
            return v === 'present' || v === 'current' || v === 'now' || v === 'currently work here';
        }

        function syncExperienceEndDateUi($root) {
            const $scope = $root && $root.length ? $root : $(document);
            $scope.find('.cv-end-date-mode-value').each(function() {
                const $modeValue = $(this);
                const $group = $modeValue.closest('.form-group');
                const $endInput = $group.find('input.cv-end-date-input').first();
                const $dropdown = $group.find('.cv-end-date-mode-dropdown').first();
                const $dateRow = $group.find('.cv-end-date-date-row').first();
                const $labelSpan = $group.find('.cv-end-date-mode-trigger-label').first();
                if (!$endInput.length) return;

                const rawMode = String($modeValue.val() || '').trim();
                const isPresent = rawMode === 'present' || normalizePresentValue($endInput.val());

                $modeValue.val(isPresent ? 'present' : 'date');

                if (isPresent) {
                    $endInput.val('');
                }

                // UI swap (ensure date row is flex so caret stays beside input)
                if ($dropdown.length) {
                    $dropdown.css('display', isPresent ? '' : 'none');
                }
                if ($dateRow.length) {
                    $dateRow.css('display', isPresent ? 'none' : 'flex');
                }

                // Input enable/disable
                $endInput.prop('disabled', isPresent);
                $endInput.attr('aria-disabled', isPresent ? 'true' : 'false');

                // Label text
                if ($labelSpan.length) {
                    const label = isPresent ? 'Currently work here' : 'End date';
                    $labelSpan.text(label);
                    $labelSpan.attr('title', label);
                }
            });
        }

        // Collect form data
        function collectFormData() {
            try {
                const rawLoc = ($cityInput.val() || '').trim();
                let cityVal = rawLoc;
                let countryVal = '';
                const commaIdx = rawLoc.indexOf(',');
                if (commaIdx !== -1) {
                    cityVal = rawLoc.slice(0, commaIdx).trim();
                    countryVal = rawLoc.slice(commaIdx + 1).trim();
                }
                const addressParts = [];
                if (cityVal) addressParts.push(cityVal);
                if (countryVal) addressParts.push(countryVal);
                const fullAddress = addressParts.join(', ');

                const data = {
                    name: $nameInput.val() || '',
                    job_title: $jobTitleInput.val() || '',
                    email: $emailInput.val() || '',
                    phone: $phoneInput.val() || '',
                    address: fullAddress,
                    city: cityVal,
                    country: countryVal,
                    summary: $summaryInput.val() || '',
                    photo: photoData || '',
                    resume_show_email: readResumeShowHidden($('#cv-resume-show-email')),
                    resume_show_phone: readResumeShowHidden($('#cv-resume-show-phone')),
                    resume_show_location: readResumeShowHidden($('#cv-resume-show-location'))
                };

                addedSections.forEach(function(sectionKey) {
                    if (!data[sectionKey]) {
                        data[sectionKey] = [];
                    }

                    $form.find('input[name^="' + sectionKey + '["], textarea[name^="' + sectionKey + '["], select[name^="' + sectionKey + '["]').each(function() {
                        const name = $(this).attr('name');
                        const match = name.match(new RegExp(sectionKey + '\\[(\\d+)\\]\\[(\\w+)\\]'));
                        if (match) {
                            const index = parseInt(match[1]);
                            const field = match[2];
                            const value = $(this).val() || '';

                            if (!data[sectionKey][index]) {
                                data[sectionKey][index] = {};
                            }
                            data[sectionKey][index][field] = value;
                        }
                    });
                });

                // Compatibility mapping for preview/templates
                // Experience preview currently renders `item.period`, so derive it from new fields when present.
                if (Array.isArray(data.experience)) {
                    data.experience.forEach(function(item) {
                        if (!item) return;
                        const start = String(item.start_date || '').trim();
                        const end = String(item.end_date || '').trim();
                        const mode = String(item.end_date_mode || '').trim();
                        const isPresent = mode === 'present' || normalizePresentValue(end);

                        // Keep the stored end_date clean when present is selected.
                        if (isPresent) item.end_date = '';

                        if (!String(item.period || '').trim() && (start || end || isPresent)) {
                            if (start && !isPresent && end) item.period = start + ' - ' + end;
                            else if (start && (isPresent || !end)) item.period = start + ' - Present';
                            else if (!start && isPresent) item.period = 'Present';
                            else item.period = end;
                        }
                    });
                }

                // Education templates render `period`, so derive it from new fields when present.
                if (Array.isArray(data.education)) {
                    data.education.forEach(function(item) {
                        if (!item) return;
                        const start = String(item.start_date || '').trim();
                        const end = String(item.end_date || '').trim();
                        if (!String(item.period || '').trim() && (start || end)) {
                            if (start && end) item.period = start + ' - ' + end;
                            else if (start && !end) item.period = start + ' - Present';
                            else item.period = end;
                        }
                    });
                }

                return data;
            } catch (error) {
                return formData;
            }
        }

        // Rich text editors (Quill) synced into existing textareas
        function initRichTextEditors($root) {
            const $scope = $root && $root.length ? $root : $(document);
            const hasQuill = typeof window.Quill !== 'undefined';
            if (!hasQuill) return;

            $scope.find('textarea[data-richtext="quill"]').each(function() {
                const $textarea = $(this);
                if ($textarea.data('quill-initialized')) return;

                const editorId = $textarea.attr('data-richtext-editor');
                if (!editorId) return;
                const editorEl = document.getElementById(editorId);
                if (!editorEl) return;

                const toolbarEl = $textarea.closest('.cv-richtext').find('.cv-richtext__toolbar')[0] || null;
                const quill = new window.Quill(editorEl, {
                    theme: 'snow',
                    modules: {
                        toolbar: toolbarEl || true
                    }
                });

                // Ensure alignment buttons work with our custom toolbar
                if (toolbarEl) {
                    toolbarEl.querySelectorAll('button.ql-align').forEach(function(btn) {
                        btn.addEventListener('click', function(ev) {
                            ev.preventDefault();
                            ev.stopPropagation();
                            const raw = btn.getAttribute('value');
                            const val = (raw === null) ? null : String(raw);
                            // Quill expects false to clear alignment (left/default)
                            quill.format('align', (val && val.length) ? val : false);
                        });
                    });
                }

                // Hydrate from existing value (HTML)
                const initialHtml = String($textarea.val() || '').trim();
                if (initialHtml) {
                    quill.clipboard.dangerouslyPasteHTML(initialHtml);
                }

                quill.on('text-change', function() {
                    const html = quill.root.innerHTML || '';
                    $textarea.val(html);
                    // trigger preview update
                    $textarea.trigger('input');
                });

                $textarea.data('quill-initialized', true);
                $textarea.data('quill', quill);
            });
        }

        // Escape HTML to prevent XSS
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function sanitizeHtml(html) {
            if (!html) return '';
            try {
                if (window.DOMPurify && typeof window.DOMPurify.sanitize === 'function') {
                    return window.DOMPurify.sanitize(String(html), {
                        USE_PROFILES: { html: true },
                        ALLOWED_TAGS: ['p', 'br', 'strong', 'em', 'u', 'ol', 'ul', 'li', 'a', 'span'],
                        // allow class for Quill alignment (ql-align-*)
                        ALLOWED_ATTR: ['href', 'target', 'rel', 'class'],
                    });
                }
            } catch (e) {
                // fall through
            }
            return escapeHtml(String(html));
        }

        // Generate section item HTML - Template-agnostic (uses standard class names)
        function generateSectionItem(sectionKey, item) {
            let html = '';
            
            if (sectionKey === 'experience') {
                html = '<div class="experience-item">' +
                    '<div class="item-header">' +
                    '<div class="item-title-row">' +
                    '<h3 class="item-title">' + escapeHtml(item.title || 'Job Title') + '</h3>' +
                    ((item.period || item.location)
                        ? '<div class="item-meta">' +
                            (item.period ? '<span class="item-period">' + escapeHtml(item.period) + '</span>' : '') +
                            (item.location ? '<span class="item-location">' + escapeHtml(item.location) + '</span>' : '') +
                          '</div>'
                        : '') +
                    '</div>' +
                    (item.company ? '<p class="item-company">' + escapeHtml(item.company) + '</p>' : '') +
                    '</div>' +
                    (item.description ? '<div class="item-description">' + sanitizeHtml(item.description) + '</div>' : '') +
                    '</div>';
            } else if (sectionKey === 'education') {
                html = '<div class="education-item">' +
                    '<div class="item-header">' +
                    '<div class="item-title-row">' +
                    '<h3 class="item-title">' + escapeHtml(item.degree || 'Degree') + '</h3>' +
                    ((item.period || item.location)
                        ? '<div class="item-meta">' +
                            (item.period ? '<span class="item-period">' + escapeHtml(item.period) + '</span>' : '') +
                            (item.location ? '<span class="item-location">' + escapeHtml(item.location) + '</span>' : '') +
                          '</div>'
                        : '') +
                    '</div>' +
                    (item.institution ? '<p class="item-institution">' + escapeHtml(item.institution) + '</p>' : '') +
                    '</div>' +
                    '</div>';
            } else if (sectionKey === 'certifications') {
                html = '<div class="certification-item">' +
                    '<div class="item-header">' +
                    '<div class="item-title-row">' +
                    '<h3 class="item-title">' + escapeHtml(item.name || 'Certification') + '</h3>' +
                    (item.date ? '<span class="item-period">' + escapeHtml(item.date) + '</span>' : '') +
                    '</div>' +
                    (item.issuer ? '<p class="item-issuer">' + escapeHtml(item.issuer) + '</p>' : '') +
                    (item.credential_id ? '<p class="item-credential">Credential ID: ' + escapeHtml(item.credential_id) + '</p>' : '') +
                    '</div>' +
                    '</div>';
            } else if (sectionKey === 'awards') {
                html = '<div class="award-item">' +
                    '<div class="item-header">' +
                    '<div class="item-title-row">' +
                    '<h3 class="item-title">' + escapeHtml(item.title || 'Award') + '</h3>' +
                    (item.date ? '<span class="item-period">' + escapeHtml(item.date) + '</span>' : '') +
                    '</div>' +
                    (item.organization ? '<p class="item-organization">' + escapeHtml(item.organization) + '</p>' : '') +
                    '</div>' +
                    (item.description ? '<div class="item-description">' + sanitizeHtml(item.description) + '</div>' : '') +
                    '</div>';
            } else if (sectionKey === 'projects') {
                html = '<div class="project-item">' +
                    '<div class="item-header">' +
                    '<div class="item-title-row">' +
                    '<h3 class="item-title">' + escapeHtml(item.name || 'Project') + '</h3>' +
                    (item.link ? '<a href="' + escapeHtml(item.link) + '" target="_blank" class="project-link">View Project</a>' : '') +
                    '</div>' +
                    (item.technologies ? '<p class="item-technologies">' + escapeHtml(item.technologies) + '</p>' : '') +
                    '</div>' +
                    (item.description ? '<div class="item-description">' + sanitizeHtml(item.description) + '</div>' : '') +
                    '</div>';
            } else if (sectionKey === 'skills') {
                // Map skill levels to percentages
                const levelMap = {
                    'Beginner': 25,
                    'Intermediate': 50,
                    'Advanced': 75,
                    'Expert': 100
                };
                const skillLevel = item.level || '';
                const skillPercentage = levelMap[skillLevel] || 0;
                
                html = '<div class="skill-item">' +
                    '<div class="skill-name-row">' +
                    '<span class="skill-name">' + escapeHtml(item.skill || 'Skill') + '</span>' +
                    (skillLevel ? '<span class="skill-level-badge">' + escapeHtml(skillLevel) + '</span>' : '') +
                    '</div>' +
                    '<div class="skill-progress-container">' +
                    '<div class="skill-progress-bar" style="width: ' + skillPercentage + '% !important; min-width: ' + (skillPercentage > 0 ? '2px' : '0') + ';"></div>' +
                    '</div>' +
                    '</div>';
            } else if (sectionKey === 'languages') {
                html = '<div class="language-item">' +
                    '<div class="language-name-row">' +
                    '<span class="language-name">' + escapeHtml(item.language || 'Language') + '</span>' +
                    (item.proficiency ? '<span class="language-proficiency-badge">' + escapeHtml(item.proficiency) + '</span>' : '') +
                    '</div>' +
                    '</div>';
            } else if (sectionKey === 'references') {
                html = '<div class="reference-item">' +
                    '<h3 class="ref-name">' + escapeHtml(item.name || 'Name') + '</h3>' +
                    (item.position ? '<p class="ref-position">' + escapeHtml(item.position) + '</p>' : '') +
                    (item.company ? '<p class="ref-company">' + escapeHtml(item.company) + '</p>' : '') +
                    (item.email ? '<p class="ref-email">' + escapeHtml(item.email) + '</p>' : '') +
                    (item.phone ? '<p class="ref-phone">' + escapeHtml(item.phone) + '</p>' : '') +
                    '</div>';
            }
            
            return $(html);
        }

        // Update preview - Template-agnostic approach
        function updatePreview(data) {
            if (isUpdating) return;

            try {
                const $template = getPrimaryPreviewTemplate();
                const hasError = $preview.find('h3:contains("Template Files Not Found")').length > 0;

                if (hasError && $template.length === 0) {
                    return;
                }

                // If template doesn't exist, we can't update (shouldn't happen)
                if ($template.length === 0) {
                    return;
                }

                isUpdating = true;

                // Update header information
                $template.find('.cv-header .name').text(data.name || 'Your Name');
                
                // Update logo circle initials
                const $logoCircle = $template.find('.logo-circle');
                if ($logoCircle.length > 0) {
                    const name = data.name || 'Your Name';
                    const nameParts = name.trim().split(' ').filter(part => part.length > 0);
                    let firstInitial = nameParts.length > 0 ? nameParts[0].charAt(0).toUpperCase() : 'Y';
                    let lastInitial;
                    if (nameParts.length > 1) {
                        // Multiple words: use first letter of last word
                        lastInitial = nameParts[nameParts.length - 1].charAt(0).toUpperCase();
                    } else {
                        // Single word: use second character if available, otherwise repeat first
                        const singleWord = nameParts[0] || '';
                        lastInitial = singleWord.length > 1 ? singleWord.charAt(1).toUpperCase() : firstInitial;
                    }
                    $logoCircle.text(firstInitial + lastInitial);
                }
                
                // Update professional title/subtitle
                const $subtitle = $template.find('.cv-header .subtitle');
                if ($subtitle.length > 0) {
                    $subtitle.text(data.job_title || 'Professional');
                }

                // Keep the personal details view card in sync
                updatePersonalViewCard(data);
                
                // Update profile photo
                const $photoBox = $template.find('.photo-box .profile-placeholder');
                if ($photoBox.length > 0) {
                    if (data.photo && data.photo.trim()) {
                        // Check if photo img already exists
                        let $photoImg = $photoBox.find('.profile-photo');
                        if ($photoImg.length === 0) {
                            // Remove initials if they exist
                            $photoBox.find('.initials').remove();
                            // Add photo img
                            $photoImg = $('<img>').addClass('profile-photo').attr('alt', 'Profile Photo');
                            $photoBox.append($photoImg);
                        }
                        $photoImg.attr('src', data.photo);
                    } else {
                        // Remove photo if exists, show initials
                        $photoBox.find('.profile-photo').remove();
                        const name = data.name || 'Your Name';
                        const nameParts = name.trim().split(' ').filter(part => part.length > 0);
                        let firstInitial = nameParts.length > 0 ? nameParts[0].charAt(0).toUpperCase() : 'Y';
                        let lastInitial;
                        if (nameParts.length > 1) {
                            // Multiple words: use first letter of last word
                            lastInitial = nameParts[nameParts.length - 1].charAt(0).toUpperCase();
                        } else {
                            // Single word: use second character if available, otherwise repeat first
                            const singleWord = nameParts[0] || '';
                            lastInitial = singleWord.length > 1 ? singleWord.charAt(1).toUpperCase() : firstInitial;
                        }
                        const initials = firstInitial + lastInitial;
                        if ($photoBox.find('.initials').length === 0) {
                            $photoBox.append($('<span>').addClass('initials').text(initials));
                        } else {
                            $photoBox.find('.initials').text(initials);
                        }
                    }
                }
                
                // Update contact info
                const $contactInfo = $template.find('.contact-info');
                const isModernTemplate = $template.hasClass('modern') || $template.find('.left-green, .right-content').length > 0;
                const hasContactIcons = $template.find('.contact-icon').length > 0;
                
                // If this is the modern template but contact lines were previously created using the classic structure
                // (plain spans, missing .contact-icon), rebuild them so icons and sizing are correct.
                if ($contactInfo.length > 0 && isModernTemplate) {
                    const hasBrokenClassicItems = $contactInfo.children('.contact-item').filter(function() {
                        return $(this).is('span') || $(this).find('.contact-icon').length === 0;
                    }).length > 0;

                    if (!hasContactIcons || hasBrokenClassicItems) {
                        const email = (data.email || '').trim();
                        const phone = (data.phone || '').trim();
                        const addr = (data.address || '').trim();

                        $contactInfo.empty();
                        if (email) {
                            $contactInfo.append(
                                '<div class="contact-item">' +
                                '<span class="contact-icon"><i class="fas fa-envelope"></i></span>' +
                                '<span class="contact-text-wrapper"><span class="contact-text"></span></span>' +
                                '</div>'
                            );
                            $contactInfo.find('.contact-item:last .contact-text').text(email);
                        }
                        if (phone) {
                            $contactInfo.append(
                                '<div class="contact-item">' +
                                '<span class="contact-icon"><i class="fas fa-phone"></i></span>' +
                                '<span class="contact-text-wrapper"><span class="contact-text"></span></span>' +
                                '</div>'
                            );
                            $contactInfo.find('.contact-item:last .contact-text').text(phone);
                        }
                        if (addr) {
                            $contactInfo.append(
                                '<div class="contact-item">' +
                                '<span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span>' +
                                '<span class="contact-text-wrapper"><span class="contact-text"></span></span>' +
                                '</div>'
                            );
                            $contactInfo.find('.contact-item:last .contact-text').text(addr);
                        }
                    }
                }

                if ($contactInfo.length > 0 && hasContactIcons) {
                    // Modern template: update text content while preserving icons and structure
                    // Only update if structure is intact (has icon and text wrapper)
                    $contactInfo.find('.contact-item').each(function() {
                        const $item = $(this);
                        const $icon = $item.find('.contact-icon');
                        const $textWrapper = $item.find('.contact-text-wrapper');
                        const $texts = $textWrapper.find('.contact-text');
                        
                        // Skip if structure is broken (missing icon or text wrapper)
                        if ($icon.length === 0 || $textWrapper.length === 0) return;
                        
                        // Identify item type by FontAwesome icon class
                        const $iconElement = $icon.find('i');
                        let isEmailItem = false;
                        let isPhoneItem = false;
                        let isWebsiteItem = false;
                        
                        if ($iconElement.length > 0) {
                            const iconClass = $iconElement.attr('class') || '';
                            isEmailItem = iconClass.includes('fa-envelope');
                            isPhoneItem = iconClass.includes('fa-phone');
                            isWebsiteItem = iconClass.includes('fa-globe') || iconClass.includes('fa-earth');
                        } else {
                            // Fallback: check by icon text (for backward compatibility with emojis)
                            const iconText = $icon.text().trim();
                            isEmailItem = iconText === '✉' || iconText === '✉️';
                            isPhoneItem = iconText === '📞' || iconText === '📞️';
                            isWebsiteItem = iconText === '🌐' || iconText === '🌐️';
                        }
                        
                        // Only update text content, never touch icons or structure
                        if (isEmailItem && data.email && data.email.trim()) {
                            // Update email text only
                            if ($texts.length > 0) {
                                $texts.eq(0).text(data.email);
                            }
                        } else if (isWebsiteItem) {
                            // Website item: update first text if exists
                            // Note: website data comes from server, not form, so we only update email if present
                            if (data.email && data.email.trim() && $texts.length > 1) {
                                // Update second text (email) if it exists
                                $texts.eq(1).text(data.email);
                            }
                        } else if (isPhoneItem && data.phone && data.phone.trim()) {
                            // Update phone text only
                            if ($texts.length > 0) {
                                $texts.eq(0).text(data.phone);
                            }
                        }
                        // Update address
                        let $addressItem = $contactInfo.find('.contact-item').filter(function() {
                            return $(this).find('.contact-icon i').hasClass('fa-map-marker-alt');
                        });
                        if (data.address && data.address.trim()) {
                            if ($addressItem.length === 0) {
                                // Create address item if it doesn't exist
                                $addressItem = $('<div class="contact-item"></div>');
                                $addressItem.append('<span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span>');
                                $addressItem.append('<div class="contact-text-wrapper"><span class="contact-text"></span></div>');
                                $contactInfo.append($addressItem);
                            }
                            // Update address text
                            $addressItem.find('.contact-text').text(data.address);
                        } else if ($addressItem.length > 0) {
                            $addressItem.remove();
                        }
                    });

                    // Safety: the classic template uses a "|" separator between plain contact spans.
                    // If it ever got injected into the modern template, remove it so we don't show a stray bar.
                    $contactInfo.children('.contact-separator').remove();
                } else if ($contactInfo.length > 0) {
                    // Classic template or other: use old update logic
                    // Update email
                    let $emailItem = $contactInfo.find('.contact-item').first();
                    if (data.email && data.email.trim()) {
                        if ($emailItem.length === 0) {
                            // Create email item if it doesn't exist
                            $emailItem = $('<span class="contact-item"></span>');
                            $contactInfo.prepend($emailItem);
                        }
                        // Update text, preserving icon if it exists
                        const $icon = $emailItem.find('.icon');
                        if ($icon.length > 0) {
                            $emailItem.find('span').not('.icon').text(data.email);
                        } else {
                            $emailItem.text(data.email);
                        }
                    } else if ($emailItem.length > 0) {
                        $emailItem.remove();
                    }
                    
                    // Update phone
                    let $phoneItem = $contactInfo.find('.contact-item').last();
                    if (data.phone && data.phone.trim()) {
                        if ($phoneItem.length === 0 || $phoneItem.text() === data.email) {
                            // Create phone item if it doesn't exist
                            if ($contactInfo.find('.contact-item').length > 0 && !$contactInfo.find('.contact-separator').length) {
                                $contactInfo.append('<span class="contact-separator">|</span>');
                            }
                            $phoneItem = $('<span class="contact-item"></span>');
                            $contactInfo.append($phoneItem);
                        }
                        // Update text, preserving icon if it exists
                        const $icon = $phoneItem.find('.icon');
                        if ($icon.length > 0) {
                            $phoneItem.find('span').not('.icon').text(data.phone);
                        } else {
                            $phoneItem.text(data.phone);
                        }
                    } else if ($phoneItem.length > 0 && $phoneItem.text() !== data.email) {
                        $phoneItem.prev('.contact-separator').remove();
                        $phoneItem.remove();
                    }
                    
                    // Update address
                    let $addressItem = $contactInfo.find('.contact-item').filter(function() {
                        return $(this).find('.contact-icon i').hasClass('fa-map-marker-alt');
                    });
                    if (data.address && data.address.trim()) {
                        if ($addressItem.length === 0) {
                            // Create address item if it doesn't exist
                            $addressItem = $('<div class="contact-item"></div>');
                            $addressItem.append('<span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span>');
                            $addressItem.append('<div class="contact-text-wrapper"><span class="contact-text"></span></div>');
                            $contactInfo.append($addressItem);
                        }
                        // Update address text
                        $addressItem.find('.contact-text').text(data.address);
                    } else if ($addressItem.length > 0) {
                        $addressItem.remove();
                    }
                }

                applyResumeContactVisibility($template, data);

                // Update summary
                const $summarySection = $template.find('.summary');
                if (data.summary && data.summary.trim()) {
                    if ($summarySection.length === 0) {
                        // Create summary section if it doesn't exist.
                        // Modern template doesn't have .cv-body; it uses .right-content.
                        const $rightContent = $template.find('.right-content');
                        const $cvBody = $template.find('.cv-body');

                        const isModern = $template.hasClass('modern') || $template.find('.left-green, .right-content').length > 0;
                        const summaryTitle = isModern ? 'ABOUT ME' : 'Professional Summary';

                        const $summaryEl = $(
                            '<section class="summary">' +
                            '<h2 class="section-title">' + summaryTitle + '</h2>' +
                            '<div class="section-content"><p></p></div>' +
                            '</section>'
                        );

                        if ($rightContent.length > 0) {
                            // Ensure summary stays at top of right content, before experience if present
                            const $exp = $rightContent.find('section.experience').first();
                            if ($exp.length) $exp.before($summaryEl);
                            else $rightContent.prepend($summaryEl);
                        } else if ($cvBody.length > 0) {
                            $cvBody.prepend($summaryEl);
                        } else {
                            // Last resort: prepend to template root
                            $template.prepend($summaryEl);
                        }
                    }
                    $template.find('.summary .section-content p').text(data.summary);
                } else {
                    $summarySection.remove();
                }

                // Update experience and education sections
                ['experience', 'education'].forEach(function(sectionKey) {
                    if (!data[sectionKey] || data[sectionKey].length === 0) {
                        // Remove section if no data
                        $template.find('section.' + sectionKey).remove();
                        return;
                    }
                    
                    const validItems = data[sectionKey].filter(function(item) {
                        if (sectionKey === 'experience') {
                            const isHidden = item && (String(item.is_hidden || '').trim() === '1');
                            if (isHidden) return false;
                        }
                        if (sectionKey === 'education') {
                            const isHidden = item && (String(item.is_hidden || '').trim() === '1');
                            if (isHidden) return false;
                        }
                        return Object.values(item).some(function(val) {
                            return val && val.toString().trim() !== '';
                        });
                    });

                    if (validItems.length === 0) {
                        $template.find('section.' + sectionKey).remove();
                        return;
                    }

                    const $section = $template.find('section.' + sectionKey);
                    // Check for new modern template structure (left-green/right-content) or old structure (cv-body)
                    let $targetContainer = $template.find('.right-content');
                    if ($targetContainer.length === 0) {
                        $targetContainer = $template.find('.cv-body');
                    }
                    
                    // Education goes to left-green in new structure, experience to right-content
                    if ($template.find('.left-green').length > 0) {
                        if (sectionKey === 'education') {
                            $targetContainer = $template.find('.left-green');
                        } else {
                            $targetContainer = $template.find('.right-content');
                        }
                    }
                    
                    const sectionConfig = availableSections[sectionKey];
                    
                    let $sectionContent;
                    
                    if ($section.length === 0) {
                        // Create new section if it doesn't exist
                        const sectionTitle = sectionKey === 'experience' ? 'JOB EXPERIENCE' : 'EDUCATION';
                        const $newSection = $('<section class="' + sectionKey + '"></section>');
                        $newSection.append('<h2 class="section-title">' + sectionTitle + '</h2>');
                        $sectionContent = $('<div class="section-content"></div>');
                        $newSection.append($sectionContent);
                        
                        // Append to appropriate container
                        if ($targetContainer.length > 0) {
                            // For left-green, append after photo-box or at start
                            if ($targetContainer.hasClass('left-green')) {
                                const $photoBox = $targetContainer.find('.photo-box');
                                if ($photoBox.length > 0) {
                                    $photoBox.after($newSection);
                                } else {
                                    $targetContainer.prepend($newSection);
                                }
                            } else {
                                // For right-content, append after summary if exists
                                const $summary = $targetContainer.find('.summary');
                                if ($summary.length > 0) {
                                    $summary.after($newSection);
                                } else {
                                    $targetContainer.prepend($newSection);
                                }
                            }
                        }
                    } else {
                        $sectionContent = $section.find('.section-content');
                        if ($sectionContent.length === 0) {
                            $sectionContent = $('<div class="section-content"></div>');
                            $section.append($sectionContent);
                        }
                        // Clear existing items
                        $sectionContent.empty();
                    }

                    // Generate items
                    validItems.forEach(function(item) {
                        const $item = generateSectionItem(sectionKey, item);
                        $sectionContent.append($item);
                    });
                });

                // Update or create dynamically added sections
                addedSections.forEach(function(sectionKey) {
                    // Skip experience and education as they're handled above (they can also be added via modal)
                    if (sectionKey === 'experience' || sectionKey === 'education') return;
                    
                    const sectionConfig = availableSections[sectionKey];
                    if (!sectionConfig) return;

                    const validItems = (data[sectionKey] || []).filter(function(item) {
                        const isHidden = item && (String(item.is_hidden || '').trim() === '1');
                        if (isHidden) return false;
                        return Object.values(item).some(function(val) {
                            return val && val.toString().trim() !== '';
                        });
                    });

                    const $section = $template.find('section.' + sectionKey);
                    const $cvBody = $template.find('.cv-body');
                    const $rightContent = $template.find('.right-content');

                    if (validItems.length > 0) {
                        // Section exists or needs to be created
                        let $sectionContent;
                        
                        if ($section.length === 0) {
                            // Create new section - use standard structure that works with any template
                            const $newSection = $('<section class="' + sectionKey + '"></section>');
                            $newSection.append('<h2 class="section-title">' + sectionConfig.name + '</h2>');
                            const $newSectionContent = $('<div class="section-content"></div>');
                            
                            // Add list wrapper for skills, languages, references
                            if (sectionKey === 'skills' || sectionKey === 'languages' || sectionKey === 'references') {
                                const listClass = sectionKey === 'skills' ? 'skills-list' : 
                                                sectionKey === 'languages' ? 'languages-list' : 'references-list';
                                $newSectionContent.append('<div class="' + listClass + '"></div>');
                                $sectionContent = $newSectionContent.find('.' + listClass);
                            } else {
                                $sectionContent = $newSectionContent;
                            }
                            
                            $newSection.append($newSectionContent);
                            
                            // Determine target container (right-content for modern template, cv-body for others)
                            const $targetContainer = $rightContent.length > 0 ? $rightContent : $cvBody;
                            
                            if (sectionKey === 'skills') {
                                // Place skills section after experience section
                                const $experience = $targetContainer.find('section.experience');
                                if ($experience.length > 0) {
                                    $experience.after($newSection);
                                } else {
                                    // If experience doesn't exist, append after summary
                                    const $summary = $targetContainer.find('section.summary');
                                    if ($summary.length > 0) {
                                        $summary.after($newSection);
                                    } else {
                                        $targetContainer.append($newSection);
                                    }
                                }
                            } else if (sectionKey === 'awards' || sectionKey === 'projects') {
                                // Place awards/projects directly under experience section
                                const $experience = $targetContainer.find('section.experience');
                                if ($experience.length > 0) {
                                    $experience.after($newSection);
                                } else {
                                    const $summary = $targetContainer.find('section.summary');
                                    if ($summary.length > 0) {
                                        $summary.after($newSection);
                                    } else {
                                        $targetContainer.append($newSection);
                                    }
                                }
                            } else if (sectionKey === 'certifications') {
                                // Place certifications section after skills section
                                const $skills = $targetContainer.find('section.skills');
                                if ($skills.length > 0) {
                                    $skills.after($newSection);
                                } else {
                                    // If skills doesn't exist, try after experience
                                    const $experience = $targetContainer.find('section.experience');
                                    if ($experience.length > 0) {
                                        $experience.after($newSection);
                                    } else {
                                        // If experience doesn't exist, append after summary
                                        const $summary = $targetContainer.find('section.summary');
                                        if ($summary.length > 0) {
                                            $summary.after($newSection);
                                        } else {
                                            $targetContainer.append($newSection);
                                        }
                                    }
                                }
                            } else if (sectionKey === 'languages') {
                                // Place languages section in left-green at the end
                                const $leftGreen = $template.find('.left-green');
                                if ($leftGreen.length > 0) {
                                    $leftGreen.append($newSection);
                                } else {
                                    $targetContainer.append($newSection);
                                }
                            } else {
                            // Append to body (after summary if exists, otherwise at start)
                            const $summary = $targetContainer.find('section.summary');
                            if ($summary.length > 0) {
                                $summary.after($newSection);
                            } else {
                                $targetContainer.append($newSection);
                                }
                            }
                        } else {
                            // Handle section placement
                            if (sectionKey === 'references' || sectionKey === 'languages') {
                                const $leftGreen = $template.find('.left-green');
                                const $rightContent = $template.find('.right-content');
                                // Check if section is inside right-content
                                if ($leftGreen.length > 0 && $rightContent.length > 0 && $section.closest('.right-content').length > 0) {
                                    // Move the entire section to left-green
                                    $leftGreen.append($section);
                                }
                            }
                            if (sectionKey === 'awards' || sectionKey === 'projects') {
                                // Keep awards/projects directly under experience
                                const $targetContainer = $rightContent.length > 0 ? $rightContent : $cvBody;
                                const $experience = $targetContainer.find('section.experience').first();
                                if ($experience.length) {
                                    $experience.after($section);
                                }
                            }
                            
                            $sectionContent = $section.find('.section-content');
                            if ($sectionContent.length === 0) {
                                $sectionContent = $('<div class="section-content"></div>');
                                $section.append($sectionContent);
                            }
                            
                            // Check for list wrapper
                            if (sectionKey === 'skills' || sectionKey === 'languages' || sectionKey === 'references') {
                                const listClass = sectionKey === 'skills' ? 'skills-list' : 
                                                sectionKey === 'languages' ? 'languages-list' : 'references-list';
                                let $listWrapper = $sectionContent.find('.' + listClass);
                                if ($listWrapper.length === 0) {
                                    $listWrapper = $('<div class="' + listClass + '"></div>');
                                    $sectionContent.append($listWrapper);
                                }
                                $sectionContent = $listWrapper;
                            }
                            
                            // Clear existing items for dynamically added sections
                            $sectionContent.empty();
                        }

                        // Generate items using standard structure
                        validItems.forEach(function(item) {
                            const $item = generateSectionItem(sectionKey, item);
                            $sectionContent.append($item);
                        });
                    } else {
                        // Remove section if no items (only for dynamically added sections)
                        $section.remove();
                    }
                });

                isUpdating = false;
                
                // Wrap content in pages after preview update
                // Use a small delay to ensure DOM updates are complete
                setTimeout(function() {
                    wrapContentInPages();
                    // Re-check after a short delay
                    setTimeout(checkAndCreatePages, 100);
                }, 150);
                
                // Trigger page height recalculation after preview update
                if (typeof window.CVPageHeight !== 'undefined' && window.CVPageHeight.calculate) {
                    setTimeout(function() {
                        window.CVPageHeight.calculate();
                    }, 200);
                }

            } catch (error) {
                isUpdating = false;
                console.error('Error updating CV preview:', error);
                
                // Wrap content in pages even on error
                setTimeout(function() {
                    wrapContentInPages();
                    setTimeout(checkAndCreatePages, 100);
                }, 150);
                
                // Trigger page height recalculation even on error
                if (typeof window.CVPageHeight !== 'undefined' && window.CVPageHeight.calculate) {
                    setTimeout(function() {
                        window.CVPageHeight.calculate();
                    }, 200);
                }
            }
        }

        // Handle form changes with debouncing
        function handleFormChange() {
            if (updateTimer) {
                clearTimeout(updateTimer);
            }

            updateTimer = setTimeout(function() {
                try {
                    formData = collectFormData();
                    updatePreview(formData);
                } catch (error) {
                    // Silent error handling
                }
            }, DEBOUNCE_DELAY);
        }

        // Experience / Education list view: keep list synced on input
        $form.on('input change', 'input[name^="experience["]', function() {
            const $section = $('#section-experience');
            if ($section.length) renderExperienceList($section);
        });
        $form.on('input change', 'input[name^="education["]', function() {
            const $section = $('#section-education');
            if ($section.length) renderEducationList($section);
        });
        $form.on('input change', 'input[name^="skills["], select[name^="skills["]', function() {
            const $section = $('#section-skills');
            if ($section.length) renderSkillsList($section);
        });
        $form.on('input change', 'input[name^="certifications["], select[name^="certifications["]', function() {
            const $section = $('#section-certifications');
            if ($section.length) renderGenericList('certifications', $section);
        });
        $form.on('input change', 'input[name^="awards["], select[name^="awards["], textarea[name^="awards["]', function() {
            const $section = $('#section-awards');
            if ($section.length) renderGenericList('awards', $section);
        });
        $form.on('input change', 'input[name^="projects["], select[name^="projects["], textarea[name^="projects["]', function() {
            const $section = $('#section-projects');
            if ($section.length) renderGenericList('projects', $section);
        });
        $form.on('input change', 'input[name^="languages["], select[name^="languages["]', function() {
            const $section = $('#section-languages');
            if ($section.length) renderGenericList('languages', $section);
        });
        $form.on('input change', 'input[name^="references["], select[name^="references["]', function() {
            const $section = $('#section-references');
            if ($section.length) renderGenericList('references', $section);
        });

        // Experience / Education editor Done button
        $form.on('click', '.cv-section-editor-view__done', function(e) {
            e.preventDefault();
            const $section = $(this).closest('.added-section');
            const sectionId = String($section.attr('id') || '');
            if (sectionId === 'section-education') closeEducationEntryEditor($section);
            else if (sectionId === 'section-skills') closeSkillsEntryEditor($section);
            else if (sectionId === 'section-certifications' || sectionId === 'section-awards' || sectionId === 'section-projects' || sectionId === 'section-languages' || sectionId === 'section-references') {
                closeGenericEntryEditor(sectionId.replace(/^section-/, ''), $section);
            }
            else closeExperienceEntryEditor($section);
        });

        // Listen to form input changes
        $form.on('input change', 'input, textarea, select', function() {
            handleFormChange();
            if (!window.__cvBuilderHydrating) {
                window.__cvBuilderDirty = true;
            }
        });

        $form.on('click', '.added-section__toggle', function(e) {
            e.preventDefault();
            const $btn = $(this);
            const $section = $btn.closest('.added-section');
            const expanded = $btn.attr('aria-expanded') === 'true';
            $btn.attr('aria-expanded', expanded ? 'false' : 'true');
            $section.toggleClass('is-collapsed', expanded);
        });

        // Handle photo upload
        $photoInput.on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select an image file.');
                    $(this).val('');
                    return;
                }
                
                // Validate file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Image size must be less than 2MB.');
                    $(this).val('');
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoData = e.target.result;
                    $photoPreview.attr('src', photoData);
                    $photoPreviewContainer.prop('hidden', false);
                    $removePhoto.prop('hidden', false);
                    $photoCircle.addClass('has-photo');
                    handleFormChange();
                    if (!window.__cvBuilderHydrating) {
                        window.__cvBuilderDirty = true;
                    }
                };
                reader.onerror = function() {
                    alert('Error reading file. Please try again.');
                    $photoInput.val('');
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle photo removal
        $('#remove-photo').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            photoData = null;
            $photoInput.val('');
            $photoPreview.attr('src', '');
            $photoPreviewContainer.prop('hidden', true);
            $removePhoto.prop('hidden', true);
            $photoCircle.removeClass('has-photo');
            handleFormChange();
        });

        $photoCircle.on('click', function(e) {
            if ($(e.target).closest('#remove-photo').length) return;
            $photoInput.trigger('click');
        });
        $photoCircle.on('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $photoInput.trigger('click');
            }
        });

        $('#cv-personal-card-toggle').on('click', function() {
            const $card = $(this).closest('.cv-personal-card');
            const expanded = $(this).attr('aria-expanded') === 'true';
            $(this).attr('aria-expanded', expanded ? 'false' : 'true');
            $card.toggleClass('is-collapsed', expanded);
        });

        $('#cv-personal-get-tips').on('click', function() {
            const msg = $(this).data('hint') || '';
            if (msg && typeof showToast === 'function') {
                showToast('info', msg, 4000);
            }
        });

        const $personalExtraPanel = $('#cv-personal-extra-panel');
        const $personalExtraExpand = $('#cv-personal-extra-expand');
        const $personalExtraCollapse = $('#cv-personal-extra-collapse');

        function personalExtraPanelHasContent() {
            return !!(
                ($emailInput.val() && String($emailInput.val()).trim()) ||
                ($phoneInput.val() && String($phoneInput.val()).trim()) ||
                ($cityInput.val() && String($cityInput.val()).trim()) ||
                ($summaryInput.val() && String($summaryInput.val()).trim())
            );
        }

        function syncPersonalExtraPanelOpen() {
            if (!$personalExtraPanel.length || !$personalExtraExpand.length) return;
            if (personalExtraPanelHasContent()) {
                $personalExtraPanel.prop('hidden', false);
                $personalExtraExpand.attr('aria-expanded', 'true').prop('hidden', true);
            } else {
                $personalExtraPanel.prop('hidden', true);
                $personalExtraExpand.prop('hidden', false).attr('aria-expanded', 'false');
            }
        }

        $personalExtraExpand.on('click', function(e) {
            e.preventDefault();
            $personalExtraPanel.prop('hidden', false);
            $(this).attr('aria-expanded', 'true').prop('hidden', true);
        });

        $personalExtraCollapse.on('click', function(e) {
            e.preventDefault();
            $personalExtraPanel.prop('hidden', true);
            $personalExtraExpand.prop('hidden', false).attr('aria-expanded', 'false');
            $personalExtraExpand.trigger('focus');
        });

        $personalView.on('click', '.cv-personal-view-card__unhide', function(e) {
            e.preventDefault();
            e.stopPropagation();
            showPersonalEdit();
            if ($personalExtraPanel.length && $personalExtraExpand.length) {
                $personalExtraPanel.prop('hidden', false);
                $personalExtraExpand.attr('aria-expanded', 'true').prop('hidden', true);
            }
        });

        function setResumeVisibilityFromData(cvData) {
            cvData = cvData || {};
            $('#cv-resume-show-email').val(resumeShowFromData(cvData.resume_show_email) ? '1' : '0');
            $('#cv-resume-show-phone').val(resumeShowFromData(cvData.resume_show_phone) ? '1' : '0');
            $('#cv-resume-show-location').val(resumeShowFromData(cvData.resume_show_location) ? '1' : '0');
            syncResumeVisibilityButton($('#cv-toggle-resume-email'));
            syncResumeVisibilityButton($('#cv-toggle-resume-location'));
            syncResumeVisibilityButton($('#cv-toggle-resume-phone'));
        }

        $form.on('click', '.cv-field__resume-visibility-toggle', function(e) {
            e.preventDefault();
            const $btn = $(this);
            const cid = $btn.attr('aria-controls');
            if (!cid) return;
            const $h = $('#' + cid);
            if (!$h.length) return;
            $h.val(String($h.val()) === '0' ? '1' : '0');
            syncResumeVisibilityButton($btn);
            handleFormChange();
        });

        syncResumeVisibilityButton($('#cv-toggle-resume-email'));
        syncResumeVisibilityButton($('#cv-toggle-resume-location'));
        syncResumeVisibilityButton($('#cv-toggle-resume-phone'));

        // Load initial photo if exists in template
        const $initialPhoto = $preview.find('.profile-photo');
        if ($initialPhoto.length > 0 && $initialPhoto.attr('src')) {
            photoData = $initialPhoto.attr('src');
            $photoPreview.attr('src', photoData);
            $photoPreviewContainer.prop('hidden', false);
            $removePhoto.prop('hidden', false);
            $photoCircle.addClass('has-photo');
        }

        // Page Management Functions
        function wrapContentInPages() {
            // Check if pages wrapper exists
            if ($pagesWrapper.length === 0) {
                console.warn('CV Pages wrapper not found');
                return;
            }
            
            const $template = $pagesWrapper.find('.cv-template');
            if ($template.length === 0) {
                // Template not loaded yet, skip
                return;
            }
            
            // Check if already wrapped (avoid double wrapping)
            if ($template.closest('.cv-page-container').length > 0) {
                // Already wrapped, just check for overflow
                checkAndCreatePages();
                return;
            }
            
            // Remove existing page containers (if any)
            $pagesWrapper.find('.cv-page-container').remove();
            
            // Clone the template to preserve event handlers
            const $templateClone = $template.clone(true);
            
            // Create first page container
            const $firstPage = $('<div class="cv-page-container"></div>');
            $firstPage.append($templateClone);
            
            // Replace original template with wrapped version
            $template.replaceWith($firstPage);
            
            // Check for overflow and create additional pages
            setTimeout(function() {
                checkAndCreatePages();
            }, 50);
        }
        
        function checkAndCreatePages() {
            const $pages = $pagesWrapper.find('.cv-page-container');
            if ($pages.length === 0) return;
            
            const $firstPage = $pages.first();
            const $content = $firstPage.find('.cv-template');
            
            if ($content.length === 0) return;
            
            // Remove all continuation pages first
            $firstPage.nextAll('.cv-page-container').remove();
            
            // Force a reflow to get accurate measurements
            $firstPage[0].offsetHeight;
            
            // Use section-based page breaking (create as many continuation pages as needed)
            let $currentPage = $firstPage;
            let guard = 0;
            while ($currentPage && $currentPage.length && guard < 12) {
                guard++;
                const $currentContent = $currentPage.find('.cv-template');
                if ($currentContent.length === 0) break;

                const $nextPage = distributeSectionsAcrossPages($currentPage, $currentContent);
                if (!$nextPage || !$nextPage.length) break;
                $currentPage = $nextPage;
            }
        }
        
        function distributeSectionsAcrossPages($firstPage, $content) {
            // Check if page 2 already exists - if so, we need to preserve it
            const $existingPage2 = $firstPage.nextAll('.cv-page-container').first();
            const hasExistingPage2 = $existingPage2.length > 0;
            
            // Temporarily remove constraints to measure accurately
            $firstPage.css({
                'overflow': 'visible',
                'max-height': 'none',
                'height': 'auto'
            });
            
            // Temporarily show ALL sections to measure original content height
            // This ensures we always measure the full content, not the reduced height after hiding sections
            const $allSections = $content.find('section');
            const originalDisplayStates = [];
            $allSections.each(function() {
                originalDisplayStates.push({
                    display: $(this).css('display'),
                    visibility: $(this).css('visibility')
                });
                // Force all sections to be visible for measurement
                $(this).css({
                    'display': '',
                    'visibility': 'visible'
                });
            });
            // Clear per-entry visibility from a previous pagination pass (sections alone are not enough)
            $content.find('.experience-item, .education-item').css({
                'display': '',
                'visibility': ''
            });
            
            // Force reflow to get accurate measurements with all sections visible
            $firstPage[0].offsetHeight;
            $content[0].offsetHeight;
            
            if ($allSections.length === 0) {
                // No sections found, restore constraints
                const contentHeight = $content[0].scrollHeight || $content.outerHeight();
                $firstPage.css({
                    'overflow': 'hidden',
                    'min-height': '297mm',
                    'max-height': '297mm',
                    'height': contentHeight > CONTENT_HEIGHT_PX ? '297mm' : 'auto'
                });
                return;
            }
            
            // Get header height (stays on first page)
            const $header = $content.find('.cv-header, .top-green, .top-content');
            let headerHeight = 0;
            if ($header.length > 0) {
                headerHeight = $header[0].offsetHeight || $header.outerHeight();
            }
            
            // Calculate available space (accounting for padding)
            const pagePadding = 15 * 3.779527559 * 2; // 15mm top + 15mm bottom in pixels
            const availablePageHeight = CONTENT_HEIGHT_PX - pagePadding;
            const maxPageHeight = headerHeight + availablePageHeight;
            
            // Measure total content height WITH ALL SECTIONS VISIBLE (original state)
            const totalContentHeight = $content[0].scrollHeight || $content.outerHeight();
            
            // If content fits on one page, no need for page 2
            if (totalContentHeight <= maxPageHeight) {
                // Restore original display states
                $allSections.each(function(index) {
                    $(this).css({
                        'display': originalDisplayStates[index].display || '',
                        'visibility': originalDisplayStates[index].visibility || 'visible'
                    });
                });
                
                // Restore constraints
                $firstPage.css({
                    'overflow': 'hidden',
                    'min-height': '297mm',
                    'max-height': '297mm',
                    'height': '297mm'
                });
                
                // All sections fit - ensure all are visible and remove continuation pages
                $allSections.css({
                    'display': '',
                    'visibility': 'visible'
                });
                $firstPage.nextAll('.cv-page-container').remove();
                return null;
            }
            
            // Content overflows - find which section causes overflow
            // Use offsetTop which is relative to offsetParent (more reliable)
            let firstOverflowSectionIndex = -1;
            let overflowExperienceItemIndex = -1;
            let overflowSectionIsExperience = false;
            
            $allSections.each(function(index) {
                if (firstOverflowSectionIndex >= 0) return false; // break - already found
                
                const $section = $(this);
                const sectionEl = $section[0];
                
                // Force reflow
                sectionEl.offsetHeight;
                
                // Get section's offsetTop relative to content container
                const sectionTop = sectionEl.offsetTop;
                const sectionHeight = sectionEl.offsetHeight || sectionEl.scrollHeight;
                const sectionBottom = sectionTop + sectionHeight;
                // Check if this section exceeds the page boundary
                // Sections start after header, so we check if bottom exceeds maxPageHeight
                if (sectionTop >= headerHeight && sectionBottom > maxPageHeight) {
                    firstOverflowSectionIndex = index;
                    return false; // break
                }
            });
            
            // Fallback: if we still couldn't detect, use a simpler approach
            // Hide sections one by one from the end until content fits
            if (firstOverflowSectionIndex === -1 && totalContentHeight > maxPageHeight) {
                // Try hiding sections from the end and see when content fits
                for (let i = $allSections.length - 1; i >= 0; i--) {
                    const $testSections = $allSections.slice(0, i + 1);
                    let testHeight = headerHeight;
                    
                    $testSections.each(function() {
                        const $s = $(this);
                        const sTop = $s[0].offsetTop;
                        const sHeight = $s[0].offsetHeight || $s[0].scrollHeight;
                        if (sTop >= headerHeight) {
                            testHeight = Math.max(testHeight, sTop + sHeight);
                        }
                    });
                    
                    if (testHeight <= maxPageHeight) {
                        firstOverflowSectionIndex = i + 1;
                        break;
                    }
                }
                
                // If still not found, use the last section that starts after header
                if (firstOverflowSectionIndex === -1) {
                    $allSections.each(function(index) {
                        const $section = $(this);
                        const sectionTop = $section[0].offsetTop;
                        if (sectionTop >= headerHeight) {
                            firstOverflowSectionIndex = index;
                            return false; // break
                        }
                    });
                }
            }
            
            // Restore page constraints
            $firstPage.css({
                'overflow': 'hidden',
                'min-height': '297mm',
                'max-height': '297mm',
                'height': '297mm'
            });

            // If the overflow section is Experience, split by items instead of moving whole section
            if (firstOverflowSectionIndex >= 0) {
                const $overflowSection = $allSections.eq(firstOverflowSectionIndex);
                if ($overflowSection.length && $overflowSection.hasClass('experience')) {
                    const $items = $overflowSection.find('.experience-item');
                    if ($items.length > 0) {
                        overflowSectionIsExperience = true;
                        const pageRect = $firstPage[0].getBoundingClientRect();
                        const pageBottom = pageRect.bottom;

                        // Find first experience item that exceeds the *actual* page bottom.
                        // NOTE: offsetTop inside nested containers is not reliable for this layout.
                        $items.each(function(i) {
                            const el = this;
                            el.offsetHeight; // force layout
                            const r = el.getBoundingClientRect();
                            if (r.bottom > pageBottom + 0.5) {
                                overflowExperienceItemIndex = i;
                                return false;
                            }
                        });
                    }
                }
            }
            
            // Now hide sections on first page that overflow (we already have all sections visible from measurement)
            if (firstOverflowSectionIndex >= 0) {
                $allSections.each(function(index) {
                    const $sec = $(this);
                    if (index < firstOverflowSectionIndex) {
                        $sec.css({ 'display': '', 'visibility': 'visible' });
                        return;
                    }

                    if (index > firstOverflowSectionIndex) {
                        // Move all following sections to next page
                        $sec.css({ 'display': 'none', 'visibility': 'hidden' });
                        return;
                    }

                    // index === firstOverflowSectionIndex
                    if (overflowSectionIsExperience && overflowExperienceItemIndex >= 0) {
                        // Keep section header; move only overflowing items
                        $sec.css({ 'display': '', 'visibility': 'visible' });
                        const $items = $sec.find('.experience-item');
                        $items.each(function(i) {
                            $(this).css({
                                'display': i >= overflowExperienceItemIndex ? 'none' : '',
                                'visibility': i >= overflowExperienceItemIndex ? 'hidden' : 'visible'
                            });
                        });
                    } else {
                        // Default behavior: move whole section
                        $sec.css({ 'display': 'none', 'visibility': 'hidden' });
                    }
                });
            } else {
                // All sections fit - ensure all are visible
                $allSections.css({
                    'display': '',
                    'visibility': 'visible'
                });
            }
            
            // Create continuation page if needed
            if (firstOverflowSectionIndex >= 0) {
                // Check if page 2 already exists and has the same overflow section
                if (hasExistingPage2) {
                    const $existingSections = $existingPage2.find('section:visible');
                    if ($existingSections.length > 0) {
                        const existingFirstVisibleIndex = $content.find('section').index($existingSections.first());
                        
                        // If the overflow section index matches, keep the existing page 2
                        if (existingFirstVisibleIndex === firstOverflowSectionIndex) {
                            // Just ensure sections on page 1 are correctly hidden/shown
                            // (already done above)
                            return $existingPage2;
                        }
                    }
                }
                
                // Remove existing continuation pages (will recreate with correct sections)
                $firstPage.nextAll('.cv-page-container').remove();
                
                // Create continuation page showing only overflow sections
                const $nextPage = $('<div class="cv-page-container cv-page-continuation"></div>');
                $nextPage.css({
                    'overflow': 'hidden',
                    'min-height': '297mm',
                    'max-height': '297mm',
                    'height': '297mm',
                    'background': 'white',
                    'display': 'block'
                });
                
                // Clone template for continuation page
                // First, save current display states
                const originalStates = [];
                $allSections.each(function() {
                    originalStates.push({
                        display: $(this).css('display'),
                        visibility: $(this).css('visibility')
                    });
                });
                
                // Temporarily show all sections for cloning
                $allSections.css({
                    'display': '',
                    'visibility': 'visible'
                });
                
                // Force reflow
                $content[0].offsetHeight;
                
                // Clone the content
                const $contentClone = $content.clone(true);
                // Cloned nodes copy inline display/visibility from the live DOM; clear before applying page-2 rules
                $contentClone.find('.experience-item, .education-item').css({
                    display: '',
                    visibility: ''
                });
                
                // Restore first-page visibility (must match the computed split, not "hide everything after overflow index")
                $allSections.each(function(index) {
                    const $sec = $(this);
                    if (index < firstOverflowSectionIndex) {
                        $sec.css({
                            'display': originalStates[index].display || '',
                            'visibility': originalStates[index].visibility || 'visible'
                        });
                        return;
                    }

                    if (index > firstOverflowSectionIndex) {
                        $sec.css({ 'display': 'none', 'visibility': 'hidden' });
                        return;
                    }

                    // index === firstOverflowSectionIndex
                    if (overflowSectionIsExperience && overflowExperienceItemIndex >= 0) {
                        $sec.css({ 'display': '', 'visibility': 'visible' });
                        const $items = $sec.find('.experience-item');
                        $items.each(function(i) {
                            $(this).css({
                                'display': i >= overflowExperienceItemIndex ? 'none' : '',
                                'visibility': i >= overflowExperienceItemIndex ? 'hidden' : 'visible'
                            });
                        });
                    } else {
                        $sec.css({ 'display': 'none', 'visibility': 'hidden' });
                    }
                });
                
                // Remove header from continuation page
                $contentClone.find('.cv-header, .top-green, .top-content').remove();
                
                // Hide sections that should stay on first page, show only overflow sections
                const $cloneSections = $contentClone.find('section');
                $cloneSections.each(function(index) {
                    const $sec = $(this);
                    if (index < firstOverflowSectionIndex) {
                        $sec.css({ 'display': 'none', 'visibility': 'hidden' });
                        return;
                    }

                    if (index > firstOverflowSectionIndex) {
                        $sec.css({ 'display': 'block', 'visibility': 'visible' });
                        return;
                    }

                    // index === firstOverflowSectionIndex
                    if (overflowSectionIsExperience && $sec.hasClass('experience')) {
                        $sec.css({ 'display': 'block', 'visibility': 'visible' });
                        const $items = $sec.find('.experience-item');
                        if (overflowExperienceItemIndex >= 0) {
                            $items.each(function(i) {
                                $(this).css({
                                    'display': i < overflowExperienceItemIndex ? 'none' : 'block',
                                    'visibility': i < overflowExperienceItemIndex ? 'hidden' : 'visible'
                                });
                            });
                        } else {
                            // No per-item split (e.g. whole section continues here): show every job entry
                            $items.css({ 'display': '', 'visibility': 'visible' });
                        }
                    } else {
                        $sec.css({ 'display': 'block', 'visibility': 'visible' });
                    }
                });

                // IMPORTANT for multi-page preview:
                // Remove hidden sections/items from the clone so subsequent pagination passes
                // don't temporarily re-show them (which causes duplicated sidebar/right-content blocks).
                $contentClone.find('section').each(function() {
                    const $sec = $(this);
                    if ($sec.css('display') === 'none' || $sec.css('visibility') === 'hidden') {
                        $sec.remove();
                    }
                });
                $contentClone.find('.experience-item, .education-item').each(function() {
                    const $item = $(this);
                    if ($item.css('display') === 'none' || $item.css('visibility') === 'hidden') {
                        $item.remove();
                    }
                });

                // If nothing is left for the continuation page, don't create an empty trailing page
                if ($contentClone.find('section').length === 0) {
                    return null;
                }

                // Continuation page: don't repeat "JOB EXPERIENCE" if it already appeared on page 1
                if (overflowSectionIsExperience && overflowExperienceItemIndex >= 0) {
                    $contentClone.find('section.experience > .section-title').css({
                        display: 'none',
                        visibility: 'hidden'
                    });
                }
                
                // Append clone to next page
                $nextPage.append($contentClone);
                
                // Append next page after first page
                $firstPage.after($nextPage);
                
                // Force reflow to ensure page 2 is visible
                setTimeout(function() {
                    $nextPage[0].offsetHeight;
                    
                    // Make absolutely sure page 2 is visible
                    $nextPage.css({
                        'display': 'block',
                        'visibility': 'visible',
                        'opacity': '1'
                    });
                    
                    // Scroll to make sure page 2 is in view if needed
                    const $previewContainer = $firstPage.closest('.cv-preview-container');
                    if ($previewContainer.length) {
                        $previewContainer[0].scrollTop = $previewContainer[0].scrollHeight;
                    }
                }, 50);
                return $nextPage;
            } else {
                // All sections fit - remove continuation pages
                $firstPage.nextAll('.cv-page-container').remove();
                return null;
            }
        }
        
        // Initial preview update - delay slightly to ensure CSS is loaded
        setTimeout(function() {
            initRichTextEditors($(document));
            formData = collectFormData();
            // Only update if there's actual data or if template is not already rendered
            const templateClass = cvBuilderConfig.templateSlug || 'classic';
            const hasExistingTemplate = $preview.find('.cv-template.' + templateClass).length > 0;
            const hasData = formData.name || formData.email || formData.phone || formData.summary || formData.photo;
            if (!hasExistingTemplate || hasData) {
                updatePreview(formData);
            }
            updatePersonalViewCard(formData);
            // Wrap content in pages after initial render
            // Use longer delay to ensure template is fully rendered
            setTimeout(function() {
                wrapContentInPages();
                // Re-check after a short delay to handle any async rendering
                setTimeout(checkAndCreatePages, 100);
            }, 300);
        }, 100);

        // Load Saved CVs functionality
        const $loadSelect = $('#load-cv-select');
        const $loadMessage = $('#load-message');
        const $loadMessageText = $('#load-message-text');
        const $toastClose = $('#cv-toast-close');
        let toastTimer = null;

        function hideToast() {
            if (!$loadMessage.length) return;
            if (toastTimer) {
                clearTimeout(toastTimer);
                toastTimer = null;
            }
            $loadMessage.addClass('is-hiding');
            setTimeout(function() {
                $loadMessage.removeClass('is-visible is-hiding success error').hide();
            }, 190);
        }

        function showToast(type, text, ms) {
            if (!$loadMessage.length) return;
            if (toastTimer) {
                clearTimeout(toastTimer);
                toastTimer = null;
            }

            $loadMessage.removeClass('success error is-hiding').addClass(type || 'success');
            if ($loadMessageText.length) {
                $loadMessageText.text(text || '');
            } else {
                $loadMessage.text(text || '');
            }
            $loadMessage.show().addClass('is-visible');

            toastTimer = setTimeout(function() {
                hideToast();
            }, typeof ms === 'number' ? ms : 2800);
        }

        $toastClose.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            hideToast();
        });

        // "Coming soon" tooltips on click (mobile-friendly)
        const $soonEls = $('.cv-soon');
        let soonTimer = null;

        function closeSoonTooltips() {
            $soonEls.removeClass('is-tooltip-open');
            if (soonTimer) {
                clearTimeout(soonTimer);
                soonTimer = null;
            }
        }

        $soonEls.on('click', function(e) {
            // These are static (non-functional) controls; show tooltip instead.
            e.preventDefault();
            e.stopPropagation();
            closeSoonTooltips();
            const $el = $(this);
            $el.addClass('is-tooltip-open');
            soonTimer = setTimeout(closeSoonTooltips, 1600);
        });

        $(document).on('click', closeSoonTooltips);
        const $resumeDropdown = $('#cv-resume-dropdown');
        const $resumeTrigger = $('#cv-resume-trigger');
        const $resumeTriggerText = $('#cv-resume-trigger-text');
        const $resumePanel = $('#cv-resume-panel');
        const $resumeList = $('#cv-resume-list');

        // Template picker modal (toolbar)
        const $tplTrigger = $('#cv-template-switcher-trigger');
        const $tplModal = $('#cv-template-modal');
        const $tplModalGrid = $('#cv-template-modal-grid');
        const $tplModalTabEmpty = $('#cv-templates-modal-tab-empty');
        const $modalTabScroll = $('#cv-template-modal-tabs-scroll');
        const $modalTabPrev = $('#cv-template-modal-tabs-prev');
        const $modalTabNext = $('#cv-template-modal-tabs-next');
        const modalTabScrollStep = 180;

        function updateTemplateModalTabScrollNav() {
            if (!$modalTabScroll.length) return;
            if (window.matchMedia('(min-width: 768px)').matches) {
                $modalTabPrev.addClass('cv-template-tabs__nav--concealed').prop('disabled', true).attr('aria-hidden', 'true');
                $modalTabNext.prop('disabled', true);
                return;
            }
            const el = $modalTabScroll[0];
            const max = el.scrollWidth - el.clientWidth;
            if (max <= 1) {
                $modalTabPrev.addClass('cv-template-tabs__nav--concealed').prop('disabled', true).attr('aria-hidden', 'true');
                $modalTabNext.prop('disabled', true);
                return;
            }
            const sl = el.scrollLeft;
            const atStart = sl <= 1;
            if (atStart) {
                $modalTabPrev.addClass('cv-template-tabs__nav--concealed').prop('disabled', true).attr('aria-hidden', 'true');
            } else {
                $modalTabPrev.removeClass('cv-template-tabs__nav--concealed').prop('disabled', false).attr('aria-hidden', 'false');
            }
            $modalTabNext.prop('disabled', sl >= max - 1);
        }

        function closeTemplateModal() {
            if (!$tplModal.length) return;
            $tplModal.removeClass('is-open').attr('aria-hidden', 'true');
            $tplTrigger.attr('aria-expanded', 'false');
        }

        function openTemplateModal() {
            if (!$tplModal.length) return;
            const $tabBtns = $tplModal.find('.cv-template-tabs__btn');
            $tabBtns.removeClass('is-active').attr('aria-selected', 'false');
            $tabBtns.filter('[data-tab="all"]').addClass('is-active').attr('aria-selected', 'true');
            applyTemplateModalFilter('all');
            $tplModal.addClass('is-open').attr('aria-hidden', 'false');
            $tplTrigger.attr('aria-expanded', 'true');
            setTimeout(function() {
                updateTemplateModalTabScrollNav();
            }, 0);
        }

        function toggleTemplateModal() {
            if (!$tplModal.length) return;
            if ($tplModal.hasClass('is-open')) closeTemplateModal();
            else openTemplateModal();
        }

        function applyTemplateModalFilter(tab) {
            if (!$tplModalGrid.length) return;
            const f = tab || 'all';
            const $cards = $tplModalGrid.find('.template-card');
            let visible = 0;
            if (f === 'all') {
                $cards.show();
                visible = $cards.length;
            } else {
                $cards.each(function() {
                    const $c = $(this);
                    const show = $c.data('tab') === f;
                    $c.toggle(show);
                    if (show) visible++;
                });
            }
            const hasInitialEmpty = $tplModalGrid.find('.cv-templates-grid-empty--initial').length > 0;
            const hasFilterableCards = $cards.length > 0;
            const shouldShowEmpty = !hasInitialEmpty && (visible === 0 && hasFilterableCards);
            if ($tplModalTabEmpty.length) {
                $tplModalTabEmpty.prop('hidden', !shouldShowEmpty);
            }
        }

        let selectedCvId = null;
        /** Monotonic id so only the latest /cv/load response may apply to the UI */
        let loadCvRequestId = 0;
        let loadCvXhr = null;
        window.__cvBuilderDirty = window.__cvBuilderDirty || false;
        window.__cvBuilderHydrating = window.__cvBuilderHydrating || false;
        let pendingAction = null;

        const $unsavedModal = $('#cv-unsaved-modal');
        const $unsavedSave = $('#cv-unsaved-save');
        const $unsavedDiscard = $('#cv-unsaved-discard');
        const $unsavedCancel = $('#cv-unsaved-cancel');

        function setResumeTriggerLabel(text) {
            $resumeTriggerText.text(text || 'Resume');
        }

        function openUnsavedModal(action) {
            pendingAction = typeof action === 'function' ? action : null;
            $unsavedModal.addClass('is-open').attr('aria-hidden', 'false');
        }

        function closeUnsavedModal() {
            pendingAction = null;
            $unsavedModal.removeClass('is-open').attr('aria-hidden', 'true');
            $unsavedSave.prop('disabled', false).text('Save');
        }

        function proceedPendingAction() {
            const action = pendingAction;
            closeUnsavedModal();
            if (typeof action === 'function') action();
        }

        function saveCurrentCv(opts) {
            const options = opts || {};
            const cvTitle = $('#cv-title').val() || 'My CV';
            const cvData = collectFormData();
            const csrfToken = $('meta[name="csrf-token"]').attr('content') || cvBuilderConfig.csrfToken;

            return $.ajax({
                url: cvBuilderConfig.routes.save,
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                data: {
                    _token: csrfToken,
                    template_slug: cvBuilderConfig.templateSlug,
                    title: cvTitle,
                    cv_data: cvData,
                    cv_id: selectedCvId || null
                }
            }).done(function(resp) {
                if (resp && resp.success) {
                    window.__cvBuilderDirty = false;
                    if (resp.cv_id) selectedCvId = String(resp.cv_id);
                    if (typeof loadSavedCVsList === 'function') loadSavedCVsList();
                    showToast('success', 'Saved');
                    if (typeof options.onSuccess === 'function') options.onSuccess(resp);
                } else {
                    showToast('error', (resp && resp.message) || 'Unable to save');
                    if (typeof options.onError === 'function') options.onError(resp);
                }
            }).fail(function(xhr) {
                const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Unable to save';
                showToast('error', msg);
                if (typeof options.onError === 'function') options.onError(xhr);
            });
        }

        // Save Resume popover (replaces "Get Tips" button)
        const $saveResumeTrigger = $('#cv-personal-save-resume');
        const $saveResumePopover = $('#cv-save-resume-popover');
        const $saveResumeTitleField = $('#cv-save-resume-title-field');
        const $saveResumeTitleInput = $('#cv-save-resume-title');
        const $saveResumeCancel = $('#cv-save-resume-cancel');
        const $saveResumeConfirm = $('#cv-save-resume-confirm');

        function isAlreadySavedResume() {
            return !!selectedCvId;
        }

        function closeSaveResumePopover() {
            if (!$saveResumePopover.length) return;
            $saveResumePopover.prop('hidden', true).attr('aria-hidden', 'true');
            $saveResumeTrigger.attr('aria-expanded', 'false');
            $saveResumeConfirm.prop('disabled', false).text('Save');
        }

        function openSaveResumePopover() {
            if (!$saveResumePopover.length) return;

            const saved = isAlreadySavedResume();
            const currentTitle = String($('#cv-title').val() || '').trim();

            if (saved) {
                $saveResumeTitleField.prop('hidden', true).attr('aria-hidden', 'true');
                $saveResumeConfirm.text('Save');
            } else {
                $saveResumeTitleField.prop('hidden', false).attr('aria-hidden', 'false');
                $saveResumeConfirm.text('Save');
                $saveResumeTitleInput.val(currentTitle);
            }

            $saveResumePopover.prop('hidden', false).attr('aria-hidden', 'false');
            $saveResumeTrigger.attr('aria-expanded', 'true');

            setTimeout(function() {
                if (!saved) {
                    $saveResumeTitleInput.trigger('focus');
                } else {
                    $saveResumeConfirm.trigger('focus');
                }
            }, 0);
        }

        function toggleSaveResumePopover() {
            if (!$saveResumePopover.length) return;
            if ($saveResumePopover.prop('hidden')) openSaveResumePopover();
            else closeSaveResumePopover();
        }

        $saveResumeTrigger.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            // If already saved, clicking should just save/update (no popover)
            if (isAlreadySavedResume()) {
                closeSaveResumePopover();
                const $btn = $(this);
                const originalHtml = $btn.html();
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin" aria-hidden="true"></i><span>Saving...</span>');
                saveCurrentCv({
                    onSuccess: function(resp) {
                        if (resp && resp.cv && resp.cv.title) {
                            $('#cv-title').val(resp.cv.title || '');
                            setResumeTriggerLabel(resp.cv.title);
                        }
                        $btn.prop('disabled', false).html(originalHtml);
                    },
                    onError: function() {
                        $btn.prop('disabled', false).html(originalHtml);
                    }
                });
                return;
            }

            toggleSaveResumePopover();
        });

        $saveResumePopover.on('click', function(e) {
            e.stopPropagation();
        });

        $saveResumeCancel.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeSaveResumePopover();
        });

        $saveResumeConfirm.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Only apply title for new resumes; existing ones keep their title unless edited in the list
            if (!isAlreadySavedResume()) {
                $('#cv-title').val(String($saveResumeTitleInput.val() || '').trim());
            }

            $saveResumeConfirm.prop('disabled', true).text('Saving...');
            saveCurrentCv({
                onSuccess: function(resp) {
                    if (resp && resp.cv && resp.cv.title) {
                        $('#cv-title').val(resp.cv.title || '');
                        setResumeTriggerLabel(resp.cv.title);
                    }
                    closeSaveResumePopover();
                },
                onError: function() {
                    $saveResumeConfirm.prop('disabled', false).text('Save');
                }
            });
        });

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') closeSaveResumePopover();
        });

        $(document).on('click', function(e) {
            if (!$saveResumePopover.length) return;
            if ($(e.target).closest('#cv-personal-save-wrap').length) return;
            closeSaveResumePopover();
        });

        // Unsaved modal buttons
        $unsavedCancel.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeUnsavedModal();
        });
        $unsavedDiscard.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            window.__cvBuilderDirty = false;
            proceedPendingAction();
        });
        $unsavedSave.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $unsavedSave.prop('disabled', true).text('Saving...');
            saveCurrentCv({
                onSuccess: function() {
                    proceedPendingAction();
                },
                onError: function() {
                    $unsavedSave.prop('disabled', false).text('Save');
                }
            });
        });
        $unsavedModal.on('click', function(e) {
            if ($(e.target).hasClass('cv-unsaved-modal__backdrop')) {
                closeUnsavedModal();
            }
        });

        // Leaving the page: use native prompt (browser-controlled)
        window.addEventListener('beforeunload', function(e) {
            if (!window.__cvBuilderDirty) return;
            e.preventDefault();
            e.returnValue = '';
        });

        // Intercept leave-page links if dirty (templates tab)
        $(document).on('click', '.cv-builder-toolbar__tab--link', function(e) {
            const href = $(this).attr('href');
            if (!href) return;
            if (!window.__cvBuilderDirty) return;
            e.preventDefault();
            openUnsavedModal(function() {
                window.location.href = href;
            });
        });

        // Template modal open
        $tplTrigger.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeCreatePopover();
            closeResumeDropdown();
            $resumeList.find('.cv-resume-item__menu.is-open').removeClass('is-open').attr('aria-hidden', 'true');
            toggleTemplateModal();
        });

        $('#cv-template-modal-close').on('click', function(e) {
            e.preventDefault();
            closeTemplateModal();
        });

        $tplModal.on('click', '.cv-template-modal__backdrop', function(e) {
            e.preventDefault();
            closeTemplateModal();
        });

        $tplModal.on('click', '.cv-template-tabs__btn', function(e) {
            e.preventDefault();
            const $btn = $(this);
            const filter = String($btn.data('tab') || 'all');
            $tplModal.find('.cv-template-tabs__btn').removeClass('is-active').attr('aria-selected', 'false');
            $btn.addClass('is-active').attr('aria-selected', 'true');
            $tplModalGrid.attr('aria-labelledby', $btn.attr('id') || 'cv-modal-tab-all');
            applyTemplateModalFilter(filter);
        });

        $modalTabPrev.on('click', function() {
            if ($modalTabScroll[0]) {
                $modalTabScroll[0].scrollBy({ left: -modalTabScrollStep, behavior: 'smooth' });
            }
        });
        $modalTabNext.on('click', function() {
            if ($modalTabScroll[0]) {
                $modalTabScroll[0].scrollBy({ left: modalTabScrollStep, behavior: 'smooth' });
            }
        });
        if ($modalTabScroll.length) {
            $modalTabScroll.on('scroll', updateTemplateModalTabScrollNav);
        }
        $(window).on('resize', updateTemplateModalTabScrollNav);
        updateTemplateModalTabScrollNav();

        // Navigate to another template — carry cv_id so the same resume loads on the new template page
        $(document).on('click', 'a.cv-template-modal__pick', function(e) {
            const rawHref = $(this).attr('href');
            if (!rawHref || rawHref === '#') return;
            const href = appendCvIdToUrl(rawHref);
            e.preventDefault();
            closeTemplateModal();
            if (window.__cvBuilderDirty) {
                openUnsavedModal(function() {
                    window.location.href = href;
                });
            } else {
                window.location.href = href;
            }
        });

        const $createTrigger = $('#cv-header-create-trigger');
        const $createPopover = $('#cv-resume-create-popover');

        function closeCreatePopover() {
            if (!$createPopover.length) return;
            $createPopover.prop('hidden', true).attr('aria-hidden', 'true');
            $createTrigger.attr('aria-expanded', 'false');
        }

        function openCreatePopover() {
            if (!$createPopover.length) return;
            $createPopover.prop('hidden', false).attr('aria-hidden', 'false');
            $createTrigger.attr('aria-expanded', 'true');
        }

        function toggleCreatePopover() {
            if (!$createPopover.length) return;
            if ($createPopover.prop('hidden')) {
                openCreatePopover();
            } else {
                closeCreatePopover();
            }
        }

        $createTrigger.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $resumeList.find('.cv-resume-item__menu.is-open').removeClass('is-open').attr('aria-hidden', 'true');
            toggleCreatePopover();
        });

        $(document).on('click', '.cv-resume-create-popover__item--resume', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const href = $(this).attr('data-href');
            if (!href) return;
            closeCreatePopover();
            const go = function() {
                window.location.href = href;
            };
            if (window.__cvBuilderDirty) {
                openUnsavedModal(go);
            } else {
                go();
            }
        });

        const $resumeDropdownFeedback = $('#cv-resume-dropdown-feedback');

        function clearResumeDropdownFeedback() {
            if (!$resumeDropdownFeedback.length) return;
            const prev = $resumeDropdownFeedback.data('hideTimer');
            if (prev) clearTimeout(prev);
            $resumeDropdownFeedback.removeData('hideTimer');
            $resumeDropdownFeedback
                .removeClass('cv-resume-dropdown__feedback--success cv-resume-dropdown__feedback--error')
                .empty()
                .prop('hidden', true)
                .attr('aria-hidden', 'true');
        }

        function showResumeDropdownFeedback(message, variant, autoHideMs) {
            if (!$resumeDropdownFeedback.length || !message) return;
            variant = variant || 'success';
            const ms = typeof autoHideMs === 'number' ? autoHideMs : 5000;
            clearResumeDropdownFeedback();
            $resumeDropdownFeedback
                .removeClass('cv-resume-dropdown__feedback--success cv-resume-dropdown__feedback--error')
                .addClass('cv-resume-dropdown__feedback--' + variant)
                .text(message)
                .prop('hidden', false)
                .attr('aria-hidden', 'false');
            if (ms > 0) {
                const t = setTimeout(function() {
                    clearResumeDropdownFeedback();
                }, ms);
                $resumeDropdownFeedback.data('hideTimer', t);
            }
        }

        function closeResumeDropdown() {
            if (!$resumeDropdown.length) return;
            closeCreatePopover();
            clearResumeDropdownFeedback();
            $resumeDropdown.removeClass('is-open');
            $resumeTrigger.attr('aria-expanded', 'false');
        }

        function openResumeDropdown() {
            if (!$resumeDropdown.length) return;
            $resumeDropdown.addClass('is-open');
            $resumeTrigger.attr('aria-expanded', 'true');
        }

        const LOAD_ALL_MIN_RESUMES = 5;
        /** Max rows shown in the My Resumes dropdown; use Load All / Projects for the rest */
        const RESUME_DROPDOWN_VISIBLE_MAX = 5;

        function setLoadAllFooterVisibility(resumeCount) {
            const $footer = $('#cv-resume-loadall-footer');
            if (!$footer.length) return;
            const show = resumeCount > LOAD_ALL_MIN_RESUMES;
            $footer.prop('hidden', !show);
        }

        function renderResumeList(cvs) {
            if (!$resumeList.length) return;
            $resumeList.empty();

            if (!cvs || !cvs.length) {
                $resumeList.append('<div class="cv-resume-dropdown__empty">No resumes yet</div>');
                setLoadAllFooterVisibility(0);
                return;
            }

            // Keep selected CV pinned at top
            const sorted = Array.isArray(cvs) ? cvs.slice() : [];
            if (selectedCvId) {
                sorted.sort(function(a, b) {
                    if (String(a.id) === String(selectedCvId)) return -1;
                    if (String(b.id) === String(selectedCvId)) return 1;
                    return 0;
                });
            }

            const visible = sorted.slice(0, RESUME_DROPDOWN_VISIBLE_MAX);

            visible.forEach(function(cv) {
                const name = cv.title || 'Untitled CV';
                const dateStr = cv.updated_at ? new Date(cv.updated_at).toLocaleDateString() : '';
                const $menu = $('<div class="cv-resume-item__menu" aria-hidden="true">')
                    .append(
                        $('<button type="button" class="cv-resume-item__menu-btn">')
                            .append('<i class="far fa-pen-to-square" aria-hidden="true"></i>')
                            .append('<span>Edit title</span>')
                            .on('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                const $row = $(this).closest('.cv-resume-item');
                                const currentTitle = $row.attr('data-cv-title') || 'Resume';
                                const $actions = $row.find('.cv-resume-item__actions');
                                // close menu
                                $menu.removeClass('is-open').attr('aria-hidden', 'true');

                                // remove any existing popover
                                $resumeList.find('.cv-resume-edit-popover').remove();

                                const $popover = $('<div class="cv-resume-edit-popover" role="dialog" aria-label="Edit title">');
                                $popover.on('click', function(ev) {
                                    ev.stopPropagation();
                                });
                                $popover.append('<div class="cv-resume-edit-popover__title">Edit title</div>');

                                const $rowWrap = $('<div class="cv-resume-edit-popover__row">');
                                const $input = $('<input type="text" class="cv-resume-edit-popover__input">').val(currentTitle);
                                const $ok = $('<button type="button" class="cv-resume-edit-popover__ok" aria-label="Save title">')
                                    .append('<i class="fas fa-check" aria-hidden="true"></i>');

                                $rowWrap.append($input).append($ok);
                                $popover.append($rowWrap);

                                $actions.append($popover);
                                setTimeout(function() { $input.trigger('focus').select(); }, 0);

                                function applyTitle(newTitleRaw) {
                                    const newTitle = (newTitleRaw || '').trim() || 'Untitled CV';
                                    const cvId = $row.attr('data-cv-id');
                                    if (!cvId || !cvBuilderConfig.routes.updateTitle) return;

                                    const csrfToken = $('meta[name="csrf-token"]').attr('content') || cvBuilderConfig.csrfToken;
                                    $.ajax({
                                        url: cvBuilderConfig.routes.updateTitle.replace('CV_ID', cvId),
                                        method: 'POST',
                                        data: {
                                            _token: csrfToken,
                                            title: newTitle
                                        },
                                        success: function(resp) {
                                            if (resp && resp.success && resp.cv) {
                                                const finalTitle = resp.cv.title || newTitle;
                                                $row.attr('data-cv-title', finalTitle);
                                                $row.find('.cv-resume-item__name').text(finalTitle);
                                                setResumeTriggerLabel(finalTitle);

                                                // Update hidden select option label (keep existing date suffix if present)
                                                const $opt = $loadSelect.find('option[value=\"' + cvId + '\"]');
                                                if ($opt.length) {
                                                    const existing = $opt.text();
                                                    const suffix = existing.includes('(') ? existing.slice(existing.indexOf(' (')) : (dateStr ? ' (' + dateStr + ')' : '');
                                                    $opt.text(finalTitle + suffix);
                                                }

                                                showToast('success', 'Title updated');
                                            } else {
                                                showToast('error', (resp && resp.message) || 'Unable to update title');
                                            }
                                        },
                                        error: function(xhr) {
                                            const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Unable to update title';
                                            showToast('error', msg);
                                        }
                                    });
                                }

                                $ok.on('click', function(ev) {
                                    ev.preventDefault();
                                    ev.stopPropagation();
                                    applyTitle($input.val());
                                    $popover.remove();
                                });

                                $input.on('keydown', function(ev) {
                                    if (ev.key === 'Enter') {
                                        ev.preventDefault();
                                        applyTitle($input.val());
                                        $popover.remove();
                                    } else if (ev.key === 'Escape') {
                                        ev.preventDefault();
                                        $popover.remove();
                                    }
                                });
                            })
                    )
                    .append(
                        $('<button type="button" class="cv-resume-item__menu-btn cv-resume-item__menu-btn--danger">')
                            .append('<i class="far fa-trash-can" aria-hidden="true"></i>')
                            .append('<span>Delete</span>')
                            .on('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                const $row = $(this).closest('.cv-resume-item');
                                const cvId = $row.attr('data-cv-id');
                                if (!cvId || !cvBuilderConfig.routes.deleteCV) return;
                                const $actions = $row.find('.cv-resume-item__actions');
                                // close menu
                                $menu.removeClass('is-open').attr('aria-hidden', 'true');

                                // remove any existing popovers
                                $resumeList.find('.cv-resume-edit-popover').remove();
                                $resumeList.find('.cv-resume-delete-popover').remove();

                                const $popover = $('<div class="cv-resume-delete-popover" role="dialog" aria-label="Delete resume">');
                                $popover.on('click', function(ev) { ev.stopPropagation(); });
                                $popover.append('<div class="cv-resume-delete-popover__title">Delete resume</div>');
                                $popover.append('<div class="cv-resume-delete-popover__desc">Are you sure? This can\\\'t be undone.</div>');

                                const $btnRow = $('<div class="cv-resume-delete-popover__actions">');
                                const $cancel = $('<button type="button" class="cv-resume-delete-popover__btn cv-resume-delete-popover__btn--cancel">Cancel</button>');
                                const $del = $('<button type="button" class="cv-resume-delete-popover__btn cv-resume-delete-popover__btn--delete">Delete</button>');
                                $btnRow.append($cancel).append($del);
                                $popover.append($btnRow);
                                $actions.append($popover);

                                $cancel.on('click', function(ev) {
                                    ev.preventDefault();
                                    ev.stopPropagation();
                                    $popover.remove();
                                });

                                $del.on('click', function(ev) {
                                    ev.preventDefault();
                                    ev.stopPropagation();
                                    $del.prop('disabled', true).text('Deleting...');

                                    const csrfToken = $('meta[name="csrf-token"]').attr('content') || cvBuilderConfig.csrfToken;
                                    $.ajax({
                                        url: cvBuilderConfig.routes.deleteCV.replace('CV_ID', cvId),
                                        method: 'POST',
                                        data: {
                                            _token: csrfToken,
                                            _method: 'DELETE'
                                        },
                                        success: function(resp) {
                                            if (resp && resp.success) {
                                                const deletedId = String(cvId);
                                                const wasSelected = selectedCvId && String(selectedCvId) === deletedId;

                                                $resumeList.find('.cv-resume-item__menu.is-open').removeClass('is-open').attr('aria-hidden', 'true');
                                                $resumeList.find('.cv-resume-edit-popover').remove();
                                                $resumeList.find('.cv-resume-delete-popover').remove();

                                                if (wasSelected) {
                                                    selectedCvId = null;
                                                }

                                                loadSavedCVsList(function(response) {
                                                    if (!response || !response.success) return;
                                                    showResumeDropdownFeedback('Resume deleted', 'success');
                                                    if (wasSelected && response.cvs && response.cvs.length > 0) {
                                                        selectedCvId = String(response.cvs[0].id);
                                                        renderResumeList(response.cvs);
                                                        applySelectedResumeToList();
                                                        if ($loadSelect.find('option[value="' + selectedCvId + '"]').length) {
                                                            $loadSelect.val(String(selectedCvId));
                                                        }
                                                        setResumeTriggerLabel(
                                                            $resumeList.find('.cv-resume-item[data-cv-id="' + selectedCvId + '"]').attr('data-cv-title') || 'Resume'
                                                        );
                                                        loadCvIntoBuilderInPlace(selectedCvId, {
                                                            skipGlobalLoadedToast: true,
                                                            syncUrlCvId: true
                                                        });
                                                    } else if (wasSelected) {
                                                        selectedCvId = null;
                                                    }
                                                });
                                            } else {
                                                $del.prop('disabled', false).text('Delete');
                                                showResumeDropdownFeedback((resp && resp.message) || 'Unable to delete', 'error');
                                            }
                                        },
                                        error: function(xhr) {
                                            $del.prop('disabled', false).text('Delete');
                                            const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Unable to delete';
                                            showResumeDropdownFeedback(msg, 'error');
                                        }
                                    });
                                });
                            })
                    );

                const $moreBtn = $('<button type="button" class="cv-resume-item__more" aria-label="More">')
                    .append('<i class="fas fa-ellipsis-vertical" aria-hidden="true"></i>')
                    .on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        // Close other open menus
                        $resumeList.find('.cv-resume-item__menu.is-open').not($menu).removeClass('is-open').attr('aria-hidden', 'true');
                        const willOpen = !$menu.hasClass('is-open');
                        $menu.toggleClass('is-open', willOpen).attr('aria-hidden', willOpen ? 'false' : 'true');
                    });

                const $row = $('<div class="cv-resume-item" role="button" tabindex="0">')
                    .attr('data-cv-id', cv.id)
                    .attr('data-cv-title', name)
                    .append($('<div class="cv-resume-item__name">').text(name))
                    .append(
                        $('<div class="cv-resume-item__actions">')
                            .append(
                                $('<button type="button" class="cv-resume-item__duplicate">')
                                    .attr('aria-label', 'Duplicate resume')
                                    .append('<i class="far fa-clone" aria-hidden="true"></i>')
                                    .append('<span>Duplicate</span>')
                            )
                            .append($moreBtn)
                            .append($menu)
                    );

                if (selectedCvId && String(cv.id) === String(selectedCvId)) {
                    $row.addClass('is-selected');
                }
                $resumeList.append($row);
            });
            setLoadAllFooterVisibility(sorted.length);
        }

        function applySelectedResumeToList() {
            if (!selectedCvId || !$resumeList.length) return;
            const $row = $resumeList.find('.cv-resume-item[data-cv-id="' + selectedCvId + '"]');
            if (!$row.length) return;
            $resumeList.find('.cv-resume-item').removeClass('is-selected');
            $row.addClass('is-selected');
            // Move selected to top (before first resume item, after header/empty is already removed when list exists)
            $row.prependTo($resumeList);
        }

        function appendCvIdToUrl(href) {
            if (!href || !selectedCvId) return href;
            try {
                const u = new URL(href, window.location.origin);
                u.searchParams.set('cv_id', String(selectedCvId));
                return u.pathname + u.search + u.hash;
            } catch (err) {
                return href;
            }
        }

        function stripCvIdFromUrl() {
            if (typeof history.replaceState !== 'function') return;
            try {
                const u = new URL(window.location.href);
                if (!u.searchParams.has('cv_id')) return;
                u.searchParams.delete('cv_id');
                const qs = u.searchParams.toString();
                history.replaceState({}, '', u.pathname + (qs ? '?' + qs : '') + u.hash);
            } catch (e) { /* ignore */ }
        }

        function getCvIdFromUrl() {
            try {
                const v = new URLSearchParams(window.location.search).get('cv_id');
                return v != null && String(v).trim() !== '' ? String(v).trim() : null;
            } catch (e) {
                return null;
            }
        }

        /** When true, the next #load-cv-select change hydrates via AJAX (post-refresh); avoids redirect loops */
        let suppressCvUrlNavigationOnce = false;

        function navigateToCvWithPageReload(cvId) {
            try {
                const u = new URL(window.location.href);
                u.searchParams.set('cv_id', String(cvId));
                window.location.assign(u.pathname + u.search + u.hash);
            } catch (e) {
                window.location.href = window.location.pathname + '?cv_id=' + encodeURIComponent(String(cvId));
            }
        }

        function maybeLoadCvFromQuery(response) {
            if (!response || !response.success || !response.cvs || !response.cvs.length) return;
            let qId = null;
            try {
                qId = new URLSearchParams(window.location.search).get('cv_id');
            } catch (e) {
                return;
            }
            if (!qId) return;
            const $opt = $loadSelect.find('option[value="' + qId + '"]');
            if (!$opt.length) {
                stripCvIdFromUrl();
                return;
            }
            selectedCvId = String(qId);
            suppressCvUrlNavigationOnce = true;
            $loadSelect.val(String(qId)).trigger('change');
        }

        function loadSavedCVsList(doneCallback) {
            $.ajax({
                url: cvBuilderConfig.routes.saved,
                method: 'GET',
                success: function(response) {
                    if (response.success && response.cvs && response.cvs.length > 0) {
                        $loadSelect.empty().append('<option value="">-- My CVs/Resumes --</option>');
                        response.cvs.forEach(function(cv) {
                            const date = new Date(cv.updated_at).toLocaleDateString();
                            const optionText = (cv.title || 'Untitled CV') + ' (' + date + ')';
                            $loadSelect.append('<option value="' + cv.id + '">' + optionText + '</option>');
                        });
                        renderResumeList(response.cvs);
                        applySelectedResumeToList();
                        if (selectedCvId) {
                            const $selOpt = $loadSelect.find('option[value="' + selectedCvId + '"]');
                            if ($selOpt.length) $loadSelect.val(String(selectedCvId));
                        }
                        setResumeTriggerLabel(selectedCvId ? ($resumeList.find('.cv-resume-item[data-cv-id="' + selectedCvId + '"]').attr('data-cv-title') || 'Resume') : '-- My CVs/Resumes --');
                    } else {
                        $loadSelect.empty().append('<option value="">' + (response.message || 'No saved CVs found') + '</option>');
                        renderResumeList([]);
                        setResumeTriggerLabel('Resume');
                    }
                    if (typeof doneCallback === 'function') {
                        doneCallback(response);
                    }
                },
                error: function(xhr) {
                    // Handle errors gracefully
                    if (xhr.status === 401) {
                        $loadSelect.empty().append('<option value="">Please login to load saved CVs</option>');
                        renderResumeList([]);
                        setResumeTriggerLabel('Resume');
                    } else {
                        $loadSelect.empty().append('<option value="">Unable to load saved CVs</option>');
                        renderResumeList([]);
                        setResumeTriggerLabel('Resume');
                    }
                    if (typeof doneCallback === 'function') {
                        doneCallback(null);
                    }
                }
            });
        }

        function postDuplicateCvFromRow(cvId, $btn) {
            if (!cvBuilderConfig.routes.duplicateCV) return;
            const csrfToken = $('meta[name="csrf-token"]').attr('content') || cvBuilderConfig.csrfToken;
            $btn.prop('disabled', true);
            $.ajax({
                url: cvBuilderConfig.routes.duplicateCV.replace('CV_ID', cvId),
                method: 'POST',
                data: { _token: csrfToken }
            })
                .done(function(resp) {
                    if (!resp || !resp.success || !resp.cv) {
                        showResumeDropdownFeedback((resp && resp.message) || 'Unable to duplicate', 'error');
                        return;
                    }
                    const newId = String(resp.cv.id);
                    const dupTitle = String((resp.cv.title || 'Untitled CV')).trim();
                    selectedCvId = newId;
                    loadSavedCVsList(function(response) {
                        if (!response || !response.success) return;
                        showResumeDropdownFeedback('Duplicated: ' + dupTitle, 'success');
                        if ($loadSelect.find('option[value="' + newId + '"]').length) {
                            $loadSelect.val(String(newId));
                        }
                        setResumeTriggerLabel(dupTitle || 'Resume');
                        applySelectedResumeToList();
                        loadCvIntoBuilderInPlace(newId, {
                            skipGlobalLoadedToast: true,
                            syncUrlCvId: true
                        });
                    });
                })
                .fail(function(xhr) {
                    const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Unable to duplicate';
                    showResumeDropdownFeedback(msg, 'error');
                })
                .always(function() {
                    $btn.prop('disabled', false);
                });
        }

        $resumeList.on('click', '.cv-resume-item__duplicate', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const $btn = $(this);
            const cvId = $btn.closest('.cv-resume-item').attr('data-cv-id');
            if (!cvId) return;
            const run = function() {
                postDuplicateCvFromRow(cvId, $btn);
            };
            if (window.__cvBuilderDirty) {
                openUnsavedModal(run);
                return;
            }
            run();
        });

        function collapseAllAddedSections() {
            $form.find('.added-section').each(function() {
                const $section = $(this);
                $section.addClass('is-collapsed');
                $section.find('.added-section__toggle').attr('aria-expanded', 'false');
            });
        }

        /**
         * Tear down section UI from a previously loaded CV so the next load cannot
         * merge old sections into collectFormData() or the preview.
         */
        function resetBuilderSectionsForCvLoad() {
            $form.find('.added-section').remove();
            addedSections.clear();
            Object.keys(availableSections).forEach(function(sectionKey) {
                delete sectionEntryCounts[sectionKey];
            });
        }

        /** API may return cv_data as object, null, or (rarely) a JSON string */
        function normalizeCvDataPayload(raw) {
            if (raw == null) return {};
            if (typeof raw === 'string') {
                try {
                    const parsed = JSON.parse(raw);
                    return parsed && typeof parsed === 'object' && !Array.isArray(parsed) ? parsed : {};
                } catch (e) {
                    return {};
                }
            }
            if (typeof raw === 'object' && !Array.isArray(raw)) return raw;
            return {};
        }

        function loadCVData(cvData) {
            cvData = (cvData && typeof cvData === 'object') ? cvData : {};

            resetBuilderSectionsForCvLoad();

            $nameInput.val(cvData.name != null ? String(cvData.name) : '').trigger('input');
            $jobTitleInput.val(cvData.job_title != null ? String(cvData.job_title) : '').trigger('input');
            $emailInput.val(cvData.email != null ? String(cvData.email) : '').trigger('input');
            $phoneInput.val(cvData.phone != null ? String(cvData.phone) : '').trigger('input');
            // Location: single field "City, Country" — merge from address or city/country
            let locationStr = '';
            if (cvData.address && String(cvData.address).trim()) {
                locationStr = String(cvData.address).trim();
            } else {
                const c = (cvData.city && String(cvData.city).trim()) ? String(cvData.city).trim() : '';
                const co = (cvData.country && String(cvData.country).trim()) ? String(cvData.country).trim() : '';
                locationStr = c && co ? (c + ', ' + co) : (c || co);
            }
            $cityInput.val(locationStr).trigger('input');
            setResumeVisibilityFromData(cvData);
            $summaryInput.val(cvData.summary != null ? String(cvData.summary) : '').trigger('input');
            if (cvData.photo) {
                photoData = cvData.photo;
                $photoPreview.attr('src', photoData);
                $photoPreviewContainer.prop('hidden', false);
                $removePhoto.prop('hidden', false);
                $photoCircle.addClass('has-photo');
            } else {
                photoData = null;
                $photoPreview.attr('src', '');
                $photoPreviewContainer.prop('hidden', true);
                $removePhoto.prop('hidden', true);
                $photoCircle.removeClass('has-photo');
            }

            syncPersonalExtraPanelOpen();

            setTimeout(function() {
                handleFormChange();
            }, 100);

            Object.keys(availableSections).forEach(function(sectionKey) {
                if (cvData[sectionKey] && cvData[sectionKey].length > 0) {
                    const sectionConfig = availableSections[sectionKey];
                    
                    if (!addedSections.has(sectionKey)) {
                        // Create section with first entry
                        const $sectionFields = generateSectionFields(sectionKey, sectionConfig);
                        $('#btn-add-sections').before($sectionFields);
                        addedSections.add(sectionKey);

                        const debouncedHandler = debounce(handleFormChange, 300);
                        $sectionFields.find('input, textarea, select').on('input change', debouncedHandler);
                    }

                    const $section = $('#section-' + sectionKey);
                    const $entriesContainer = $section.find('.entries-container');
                    
                    // Clear existing entries (keep the structure)
                    $entriesContainer.find('.entry-container').remove();
                    
                    // Set entry count before creating entries
                    sectionEntryCounts[sectionKey] = 0;

                    // Create entries for each item in the saved data
                    cvData[sectionKey].forEach(function(item, index) {
                        // Create entry (first one needs to be created, others too)
                        const $newEntry = generateEntryFields(sectionKey, sectionConfig, index);
                        $entriesContainer.append($newEntry);
                        
                        // Populate fields for this entry
                        Object.keys(item).forEach(function(field) {
                            const $field = $newEntry.find('input[name="' + sectionKey + '[' + index + '][' + field + ']"], textarea[name="' + sectionKey + '[' + index + '][' + field + ']"], select[name="' + sectionKey + '[' + index + '][' + field + ']"]');
                            if ($field.length) {
                                $field.val(item[field] || '');
                                // Trigger change event for select elements to ensure proper update
                                if ($field.is('select')) {
                                    $field.trigger('change');
                                }
                            }
                        });

                        // Initialize Quill editors after values are set (so HTML hydrates)
                        initRichTextEditors($newEntry);
                        
                        // Attach event handlers
                        const debouncedHandler = debounce(handleFormChange, 300);
                        $newEntry.find('input, textarea, select').on('input change', debouncedHandler);
                    });

                    // Normalize "Present" end-date UI (experience only)
                    if (sectionKey === 'experience') {
                        syncExperienceEndDateUi($section);
                    }

                    // Update entry count
                    sectionEntryCounts[sectionKey] = cvData[sectionKey].length;
                    
                    // Experience/Education/Skills use list view; refresh it after loading data
                    if (sectionKey === 'experience') renderExperienceList($section);
                    if (sectionKey === 'education') renderEducationList($section);
                    if (sectionKey === 'skills') renderSkillsList($section);
                    if (sectionKey === 'certifications' || sectionKey === 'awards' || sectionKey === 'projects' || sectionKey === 'languages' || sectionKey === 'references') {
                        renderGenericList(sectionKey, $section);
                    }

                    // Show/hide remove buttons based on entry count
                    if (cvData[sectionKey].length > 1) {
                        $entriesContainer.find('.btn-remove-entry').show();
                    } else {
                        $entriesContainer.find('.btn-remove-entry').hide();
                    }
                }
            });

            collapseAllAddedSections();

            setTimeout(function() {
                const freshData = collectFormData();
                updatePreview(freshData);
            }, 500);
        }

        // Custom dropdown open/close
        $resumeTrigger.on('click', function(e) {
            e.preventDefault();
            if ($resumeDropdown.hasClass('is-open')) {
                closeResumeDropdown();
            } else {
                closeCreatePopover();
                openResumeDropdown();
            }
        });

        $resumeDropdown.on('click', function(e) {
            if ($(e.target).closest('.cv-resume-dropdown__header-create-wrap').length) return;
            closeCreatePopover();
        });

        $(document).on('click', function(e) {
            if (!$resumeDropdown.length) return;
            if ($(e.target).closest('#cv-resume-dropdown').length) return;
            $resumeList.find('.cv-resume-item__menu.is-open').removeClass('is-open').attr('aria-hidden', 'true');
            $resumeList.find('.cv-resume-edit-popover').remove();
            $resumeList.find('.cv-resume-delete-popover').remove();
            closeResumeDropdown();
        });

        $(document).on('keydown', function(e) {
            if (e.key !== 'Escape') return;
            if ($tplModal.length && $tplModal.hasClass('is-open')) {
                closeTemplateModal();
                e.stopPropagation();
                return;
            }
            if ($createPopover.length && !$createPopover.prop('hidden')) {
                closeCreatePopover();
                e.stopPropagation();
                return;
            }
            $resumeList.find('.cv-resume-item__menu.is-open').removeClass('is-open').attr('aria-hidden', 'true');
            $resumeList.find('.cv-resume-edit-popover').remove();
            $resumeList.find('.cv-resume-delete-popover').remove();
            closeResumeDropdown();
        });


        // Selecting a resume: full page reload with ?cv_id= so each CV starts from a clean JS/DOM state
        $resumeList.on('click', '.cv-resume-item', function(e) {
            // If the user clicked inside actions (duplicate / menu / popover), don't load the CV
            if ($(e.target).closest('.cv-resume-item__actions').length) {
                return;
            }
            const cvId = $(this).attr('data-cv-id');
            if (!cvId) return;

            const doSwitch = function() {
                closeResumeDropdown();
                navigateToCvWithPageReload(cvId);
            };

            if (window.__cvBuilderDirty) {
                openUnsavedModal(doSwitch);
                return;
            }
            doSwitch();
        });

        $resumeList.on('keydown', '.cv-resume-item', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).trigger('click');
            }
        });

        /**
         * Load CV JSON into the builder without a full page navigation.
         * @param {string} cvId
         * @param {{ syncUrlCvId?: boolean, skipGlobalLoadedToast?: boolean }} [opts]
         */
        function loadCvIntoBuilderInPlace(cvId, opts) {
            opts = opts || {};
            cvId = String(cvId || '');
            if (!cvId) return;

            selectedCvId = cvId;
            applySelectedResumeToList();

            $loadSelect.prop('disabled', true);
            $resumeTrigger.prop('disabled', true);
            if (!opts.skipGlobalLoadedToast) {
                hideToast();
            }

            const requestId = ++loadCvRequestId;
            if (loadCvXhr && typeof loadCvXhr.abort === 'function') {
                try {
                    loadCvXhr.abort();
                } catch (eAbort) { /* ignore */ }
            }

            loadCvXhr = $.ajax({
                url: cvBuilderConfig.routes.load.replace('CV_ID', cvId),
                method: 'GET',
                cache: false,
                success: function(response) {
                    if (requestId !== loadCvRequestId) return;
                    if (response.success && response.cv) {
                        window.__cvBuilderHydrating = true;
                        $('#cv-title').val(response.cv.title || '');
                        setResumeTriggerLabel(response.cv.title || 'Resume');
                        selectedCvId = String(response.cv.id || cvId);
                        applySelectedResumeToList();

                        if ($loadSelect.find('option[value="' + selectedCvId + '"]').length) {
                            $loadSelect.val(String(selectedCvId));
                        }

                        if (opts.syncUrlCvId && typeof history.replaceState === 'function') {
                            try {
                                const u = new URL(window.location.href);
                                u.searchParams.set('cv_id', String(selectedCvId));
                                const qs = u.searchParams.toString();
                                history.replaceState({}, '', u.pathname + (qs ? '?' + qs : '') + u.hash);
                            } catch (eUrl) { /* ignore */ }
                        }

                        try {
                            const payload = normalizeCvDataPayload(response.cv.cv_data);
                            loadCVData(payload);
                            if (!opts.skipGlobalLoadedToast) {
                                showToast('success', 'CV loaded successfully!');
                            }
                        } catch (error) {
                            showToast('error', 'Error loading CV data: ' + error.message);
                        }
                        setTimeout(function() {
                            window.__cvBuilderHydrating = false;
                            window.__cvBuilderDirty = false;
                        }, 0);
                    } else {
                        showToast('error', response.message || 'Error loading CV');
                    }
                },
                error: function(xhr) {
                    if (requestId !== loadCvRequestId) return;
                    if (xhr && (xhr.status === 0 || xhr.statusText === 'abort')) return;
                    let errorMessage = 'Error loading CV. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    showToast('error', errorMessage);
                },
                complete: function() {
                    if (requestId !== loadCvRequestId) return;
                    $loadSelect.prop('disabled', false);
                    $resumeTrigger.prop('disabled', false);
                    window.__cvBuilderHydrating = false;
                }
            });
        }

        $loadSelect.on('change', function() {
            const cvId = $(this).val();
            if (!cvId) {
                return;
            }

            const urlCvId = getCvIdFromUrl();
            const sameAsUrl = suppressCvUrlNavigationOnce || String(cvId) === String(urlCvId || '');
            if (!sameAsUrl) {
                navigateToCvWithPageReload(cvId);
                return;
            }
            suppressCvUrlNavigationOnce = false;

            loadCvIntoBuilderInPlace(String(cvId), {});
        });

        loadSavedCVsList(function(response) {
            maybeLoadCvFromQuery(response);
        });

        // Modal functions
        function populateModal() {
            const $sectionsList = $('#sections-list');
            $sectionsList.empty();

            Object.keys(availableSections).forEach(function(sectionKey) {
                const section = availableSections[sectionKey];
                const isAdded = addedSections.has(sectionKey);

                const $option = $('<div class="section-option">')
                    .attr('data-section-key', sectionKey)
                    .attr('role', 'button')
                    .attr('tabindex', isAdded ? '-1' : '0')
                    .append(
                        $('<div class="section-option__icon" aria-hidden="true">').html(section.iconSvg || '')
                    )
                    .append(
                        $('<div class="section-option__content">')
                            .append($('<div class="section-option__name">').text(section.name || ''))
                            .append($('<div class="section-option__desc">').text(section.description || ''))
                            .append(isAdded ? $('<div class="section-option__added">(Added)</div>') : '')
                    );

                if (isAdded) {
                    $option.addClass('is-added').attr('aria-disabled', 'true');
                } else {
                    $option.attr('aria-disabled', 'false');
                }

                $sectionsList.append($option);
            });
        }

        function openModal() {
            populateModal();
            $('#add-sections-modal').addClass('active');
        }

        function closeModal() {
            $('#add-sections-modal').removeClass('active');
            // no multi-select; nothing to reset
        }

        // Import Resume
        const $importResumeTrigger = $('#cv-import-resume-trigger, #cv-import-resume-trigger-toolbar');
        const $importResumeInput = $('#cv-import-resume-input');
        let pendingResumeImportFile = null;
        let pendingResumeImportId = null;
        let resumeImportInFlight = false;

        function isAllowedResumeFile(file) {
            if (!file) return false;
            const name = String(file.name || '').toLowerCase();
            const type = String(file.type || '').toLowerCase();
            const looksLikeImage = type.startsWith('image/');
            const looksLikePdf = type === 'application/pdf' || name.endsWith('.pdf');
            const looksLikeDocx =
                type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ||
                name.endsWith('.docx');
            return looksLikeImage || looksLikePdf || looksLikeDocx;
        }

        $importResumeTrigger.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (!$importResumeInput.length) {
                showToast('error', 'Import input not found');
                return;
            }
            $importResumeInput.trigger('click');
        });

        $importResumeInput.on('change', function() {
            const file = (this.files && this.files[0]) ? this.files[0] : null;
            if (!file) return;

            // Basic validation (kept simple for MVP)
            const maxBytes = 3 * 1024 * 1024; // 3MB
            if (!isAllowedResumeFile(file)) {
                pendingResumeImportFile = null;
                $(this).val('');
                showToast('error', 'Unsupported file. Please upload PDF, DOCX, or an image.');
                return;
            }
            if (file.size && file.size > maxBytes) {
                pendingResumeImportFile = null;
                $(this).val('');
                showToast('error', 'File is too large. Please upload a file up to 3MB.');
                return;
            }

            pendingResumeImportFile = file;
            pendingResumeImportId = null;
            showToast('success', 'Selected: ' + file.name);

            // Upload immediately (Step 3)
            const uploadUrl = (cvBuilderConfig && cvBuilderConfig.routes) ? cvBuilderConfig.routes.importUpload : '';
            if (!uploadUrl) {
                showToast('info', 'Upload route not configured yet.', 4500);
                return;
            }
            if (resumeImportInFlight) {
                showToast('info', 'Upload already in progress…', 3000);
                return;
            }

            resumeImportInFlight = true;
            showToast('info', 'Uploading resume…', 4000);

            const fd = new FormData();
            fd.append('resume', file);
            fd.append('template_slug', cvBuilderConfig.templateSlug || '');

            $.ajax({
                url: uploadUrl,
                method: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': cvBuilderConfig.csrfToken || ''
                },
                success: function(resp) {
                    if (resp && resp.success && resp.import_id) {
                        pendingResumeImportId = String(resp.import_id);
                        showToast('success', 'Uploaded. Import ID: ' + pendingResumeImportId, 5000);
                        // Step 4: extract text
                        const extractTpl = (cvBuilderConfig && cvBuilderConfig.routes) ? cvBuilderConfig.routes.importExtract : '';
                        if (!extractTpl) {
                            showToast('info', 'Next: extract text + parse fields (Step 4–5).', 4500);
                            return;
                        }

                        const extractUrl = String(extractTpl).replace('IMPORT_ID', encodeURIComponent(pendingResumeImportId));
                        showToast('info', 'Extracting text…', 4000);

                        $.ajax({
                            url: extractUrl,
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': cvBuilderConfig.csrfToken || ''
                            },
                            success: function(r2) {
                                if (r2 && r2.success) {
                                    const method = r2.method ? String(r2.method) : 'unknown';
                                    const len = r2.raw_text ? String(r2.raw_text).length : 0;
                                    showToast('success', 'Text extracted (' + method + '). ' + len + ' chars.', 6000);

                                    const parseTpl = (cvBuilderConfig && cvBuilderConfig.routes) ? cvBuilderConfig.routes.importParse : '';
                                    if (!parseTpl) {
                                        showToast('info', 'Parse route not configured.', 4000);
                                        return;
                                    }

                                    const parseUrl = String(parseTpl).replace('IMPORT_ID', encodeURIComponent(pendingResumeImportId));
                                    showToast('info', 'Parsing resume with Gemini…', 5000);

                                    $.ajax({
                                        url: parseUrl,
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': cvBuilderConfig.csrfToken || ''
                                        },
                                        success: function(r3) {
                                            if (r3 && r3.success && r3.parsed_cv) {
                                                try {
                                                    window.__cvBuilderHydrating = true;
                                                    loadCVData(r3.parsed_cv);
                                                    showToast('success', 'Resume imported — please review your details.', 8000);
                                                    setTimeout(function() {
                                                        window.__cvBuilderHydrating = false;
                                                        window.__cvBuilderDirty = true;
                                                    }, 0);
                                                } catch (err) {
                                                    showToast('error', 'Could not apply parsed data: ' + (err && err.message ? err.message : String(err)));
                                                }
                                            } else {
                                                showToast('error', (r3 && r3.message) ? r3.message : 'Parse failed');
                                            }
                                        },
                                        error: function(xhr3) {
                                            let msg3 = 'Parse failed. Please try again.';
                                            if (xhr3 && xhr3.status === 419) msg3 = 'Session expired. Please refresh and try again.';
                                            if (xhr3 && xhr3.status === 503 && xhr3.responseJSON && xhr3.responseJSON.message) {
                                                msg3 = xhr3.responseJSON.message;
                                            }
                                            if (xhr3 && xhr3.responseJSON && xhr3.responseJSON.message) msg3 = xhr3.responseJSON.message;
                                            showToast('error', msg3);
                                        }
                                    });
                                } else {
                                    showToast('error', (r2 && r2.message) ? r2.message : 'Extraction failed');
                                }
                            },
                            error: function(xhr2) {
                                let msg2 = 'Extraction failed. Please try again.';
                                if (xhr2 && xhr2.status === 419) msg2 = 'Session expired. Please refresh and try again.';
                                if (xhr2 && xhr2.responseJSON && xhr2.responseJSON.message) msg2 = xhr2.responseJSON.message;
                                showToast('error', msg2);
                            }
                        });
                    } else {
                        showToast('error', (resp && resp.message) ? resp.message : 'Upload failed');
                    }
                },
                error: function(xhr) {
                    // Common auth/session issues in Laravel
                    if (xhr && (xhr.status === 401 || xhr.status === 403)) {
                        showToast('error', 'Please login to import a resume.');
                        return;
                    }
                    if (xhr && xhr.status === 419) {
                        showToast('error', 'Session expired. Please refresh and try again.');
                        return;
                    }

                    let msg = 'Upload failed. Please try again.';
                    if (xhr && xhr.responseJSON) {
                        if (xhr.responseJSON.message) msg = xhr.responseJSON.message;
                        // Validation errors
                        if (xhr.responseJSON.errors && xhr.responseJSON.errors.resume && xhr.responseJSON.errors.resume[0]) {
                            msg = xhr.responseJSON.errors.resume[0];
                        }
                    }
                    showToast('error', msg);
                },
                complete: function() {
                    resumeImportInFlight = false;
                }
            });
        });

        $('#btn-add-sections').on('click', openModal);
        $('#add-sections-modal-close').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeModal();
        });
        $('#add-sections-modal').on('click', function(e) {
            if ($(e.target).hasClass('modal-overlay')) {
                closeModal();
            }
        });

        // Click-to-add (no footer buttons)
        $('#sections-list').on('click', '.section-option', function(e) {
            e.preventDefault();
            const $option = $(this);
            const sectionKey = String($option.attr('data-section-key') || '');
            if (!sectionKey) return;
            if (addedSections.has(sectionKey)) return;

            const sectionConfig = availableSections[sectionKey];
            if (!sectionConfig) return;

            const $sectionFields = generateSectionFields(sectionKey, sectionConfig);
            $('#btn-add-sections').before($sectionFields);
            addedSections.add(sectionKey);

            const debouncedHandler = debounce(handleFormChange, 300);
            $sectionFields.find('input, textarea').on('input change', debouncedHandler);

            // Init Quill editors inside the newly added section
            initRichTextEditors($sectionFields);

            // If Experience/Education is being added for the first time, open editor directly
            if (sectionKey === 'experience') openExperienceEntryEditor($sectionFields, 0);
            if (sectionKey === 'education') openEducationEntryEditor($sectionFields, 0);
            if (sectionKey === 'skills') openSkillsEntryEditor($sectionFields, 0);
            if (sectionKey === 'certifications' || sectionKey === 'awards' || sectionKey === 'projects' || sectionKey === 'languages' || sectionKey === 'references') {
                openGenericEntryEditor(sectionKey, $sectionFields, 0);
            }

            handleFormChange();
            closeModal();
        });

        function closeEndDateMenus() {
            $('.cv-end-date-mode-menu').prop('hidden', true).attr('aria-hidden', 'true');
            $('.cv-end-date-mode-trigger').attr('aria-expanded', 'false');
        }

        // Experience end date mode: custom dropdown behavior (delegated)
        $form.on('click', '.cv-end-date-mode-trigger', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const $btn = $(this);
            // Prefer the menu that belongs to the clicked trigger (date-row caret vs full-width dropdown)
            let $menu = $btn.siblings('.cv-end-date-mode-menu').first();
            if (!$menu.length) {
                $menu = $btn.parent().find('.cv-end-date-mode-menu').first();
            }
            if (!$menu.length) {
                const $group = $btn.closest('.form-group');
                $menu = $group.find('.cv-end-date-mode-menu').filter(function() {
                    return $(this).closest('.cv-end-date-date-row').length > 0;
                }).first();
                if (!$menu.length) {
                    $menu = $group.find('.cv-end-date-mode-menu').first();
                }
            }
            if (!$menu.length) return;

            const isOpen = !$menu.prop('hidden');
            closeEndDateMenus();
            if (!isOpen) {
                $menu.prop('hidden', false).attr('aria-hidden', 'false');
                $btn.attr('aria-expanded', 'true');
            }
        });

        $form.on('click', '.cv-end-date-mode-item', function(e) {
            e.preventDefault();
            const $item = $(this);
            const mode = String($item.attr('data-mode') || '').trim(); // present|date
            const $group = $item.closest('.form-group');
            const $modeValue = $group.find('input.cv-end-date-mode-value').first();
            if (!$modeValue.length) return;

            $modeValue.val(mode);
            syncExperienceEndDateUi($group);
            closeEndDateMenus();

            // trigger preview update
            const $endInput = $group.find('input.cv-end-date-input').first();
            if ($endInput.length) $endInput.trigger('input');
        });

        $(document).on('click', function() {
            closeEndDateMenus();
        });

        $form.on('input', 'input.cv-end-date-input', function() {
            const $endInput = $(this);
            const val = String($endInput.val() || '').trim();
            if (!val) return;
            const $group = $endInput.closest('.form-group');
            const $modeValue = $group.find('input.cv-end-date-mode-value').first();
            if ($modeValue.length && String($modeValue.val() || '') !== 'date') {
                $modeValue.val('date');
                syncExperienceEndDateUi($group);
            }
        });

        // Keyboard support for cards
        $('#sections-list').on('keydown', '.section-option', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).trigger('click');
            }
        });

        // Generate a single entry form for a section
        function generateEntryFields(sectionKey, sectionConfig, entryIndex) {
            const $entryContainer = $('<div>')
                .addClass('entry-container')
                .attr('data-entry-index', entryIndex)
                .attr('data-section-key', sectionKey);

            // Per-entry flags (used by Experience/Education/Skills list view)
            if (listViewSections.has(sectionKey)) {
                $entryContainer.append(
                    $('<input type="hidden">')
                        .attr('name', sectionKey + '[' + entryIndex + '][is_hidden]')
                        .addClass('cv-entry-flag-hidden')
                        .val('')
                );
            }

            const $entryHeader = $('<div>')
                .addClass('entry-header')
                .append(
                    $('<h5>').html(sectionConfig.name + ' Entry #' + (entryIndex + 1))
                );

            // Add remove entry button (only show if more than 1 entry)
            const $removeEntryBtn = $('<button>')
                .addClass('btn-remove-entry')
                .attr('type', 'button')
                .attr('aria-label', 'Remove entry')
                .html('<i class="far fa-trash-can" aria-hidden="true"></i>')
                .on('click', function() {
                    removeEntry(sectionKey, entryIndex);
                });

            // Initially hide if it's the first entry
            if (entryIndex === 0) {
                $removeEntryBtn.hide();
            }

            $entryHeader.append($removeEntryBtn);
            $entryContainer.append($entryHeader);

            // Create form fields for this entry
            sectionConfig.fields.forEach(function(field) {
                const $formGroup = $('<div>').addClass('form-group');
                if (sectionKey === 'experience' && (field.name === 'title' || field.name === 'company')) {
                    $formGroup.addClass('entry-field--full');
                }
                if (sectionKey === 'education' && (field.name === 'degree' || field.name === 'institution')) {
                    $formGroup.addClass('entry-field--full');
                }
                const $label = $('<label>').text(field.label);
                $formGroup.append($label);

                if (field.type === 'textarea') {
                    const $input = $('<textarea>')
                        .attr('name', sectionKey + '[' + entryIndex + '][' + field.name + ']')
                        .attr('placeholder', field.placeholder || '')
                        .addClass('form-control');

                    // Rich text editor for description field (Quill -> sync HTML into textarea)
                    if (field.name === 'description') {
                        const editorId = 'cv-rt-' + sectionKey + '-' + entryIndex + '-' + field.name + '-' + Date.now();
                        const $wrap = $('<div class="cv-richtext">');

                        const $toolbar = $('<div class="cv-richtext__toolbar">')
                            .append('<button type="button" class="cv-richtext__btn ql-bold" aria-label="Bold"></button>')
                            .append('<button type="button" class="cv-richtext__btn ql-italic" aria-label="Italic"></button>')
                            .append('<button type="button" class="cv-richtext__btn ql-underline" aria-label="Underline"></button>')
                            .append('<span class="cv-richtext__sep" aria-hidden="true"></span>')
                            .append('<button type="button" class="cv-richtext__btn ql-list" value="ordered" aria-label="Numbered list"></button>')
                            .append('<button type="button" class="cv-richtext__btn ql-list" value="bullet" aria-label="Bulleted list"></button>')
                            .append('<button type="button" class="cv-richtext__btn ql-link" aria-label="Link"></button>')
                            .append('<span class="cv-richtext__sep" aria-hidden="true"></span>')
                            .append('<button type="button" class="cv-richtext__btn ql-align" value="" aria-label="Align left"></button>')
                            .append('<button type="button" class="cv-richtext__btn ql-align" value="center" aria-label="Align center"></button>')
                            .append('<button type="button" class="cv-richtext__btn ql-align" value="right" aria-label="Align right"></button>')
                            .append('<button type="button" class="cv-richtext__btn ql-align" value="justify" aria-label="Justify"></button>');

                        const $editor = $('<div class="cv-richtext__editor">').attr('id', editorId);

                        $input
                            .addClass('cv-richtext__source')
                            .attr('data-richtext', 'quill')
                            .attr('data-richtext-editor', editorId)
                            .prop('hidden', true)
                            .attr('aria-hidden', 'true');

                        $wrap.append($toolbar).append($editor).append($input);
                        $formGroup.append($wrap);
                    } else {
                        $formGroup.append($input);
                    }
                } else if (field.type === 'select') {
                    const $select = $('<select>')
                        .attr('name', sectionKey + '[' + entryIndex + '][' + field.name + ']')
                        .addClass('form-control');
                    
                    if (field.options && Array.isArray(field.options)) {
                        field.options.forEach(function(option) {
                            const $option = $('<option>')
                                .attr('value', option.value)
                                .text(option.text);
                            $select.append($option);
                        });
                    }
                    
                    $formGroup.append($select);
                } else {
                    // Experience end date: dropdown that swaps to date field (caret stays available)
                    if (sectionKey === 'experience' && field.name === 'end_date') {
                        const $modeValue = $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', sectionKey + '[' + entryIndex + '][end_date_mode]')
                            .addClass('cv-end-date-mode-value')
                            .val('present');

                        const $modeDropdown = $('<div>')
                            .addClass('cv-end-date-mode-dropdown')
                            .css({ position: 'relative' });

                        const $modeTrigger = $('<button>')
                            .attr('type', 'button')
                            .addClass('cv-end-date-mode-trigger')
                            .attr('aria-haspopup', 'menu')
                            .attr('aria-expanded', 'false')
                            .css({
                                width: '100%',
                                display: 'flex',
                                alignItems: 'center',
                                justifyContent: 'space-between',
                                gap: '10px',
                                padding: '6px 14px',
                                borderRadius: '10px',
                                border: '1px solid #e6e6e6',
                                background: '#f3f5f8',
                                fontWeight: '600',
                                fontSize: '0.85rem'
                            })
                            .append(
                                $('<span>')
                                    .addClass('cv-end-date-mode-trigger-label')
                                    .css({
                                        flex: '1 1 auto',
                                        minWidth: 0,
                                        maxWidth: '80px',
                                        overflow: 'hidden',
                                        whiteSpace: 'nowrap',
                                        textOverflow: 'ellipsis',
                                        display: 'block',
                                    })
                                    .attr('title', 'Currently work here')
                                    .text('Currently work here')
                            )
                            .append($('<i class="fas fa-chevron-down" aria-hidden="true">').css({ opacity: 0.8 }));

                        const $modeMenu = $('<div>')
                            .addClass('cv-end-date-mode-menu')
                            .attr('role', 'menu')
                            .prop('hidden', true)
                            .attr('aria-hidden', 'true')
                            .css({
                                position: 'absolute',
                                zIndex: 20,
                                left: 0,
                                right: 0,
                                width: '150px',
                                top: 'calc(100% + 6px)',
                                background: '#fff',
                                border: '1px solid #e6e6e6',
                                borderRadius: '10px',
                                overflow: 'hidden',
                                fontSize: '0.85rem',
                                boxShadow: '0 10px 30px rgba(0,0,0,0.08)'
                            });

                        const $itemPresent = $('<button type="button">')
                            .addClass('cv-end-date-mode-item')
                            .attr('role', 'menuitem')
                            .attr('data-mode', 'present')
                            .css({ width: '100%', textAlign: 'left', padding: '12px 14px', background: 'transparent', border: 0, cursor: 'pointer' })
                            .text('Currently work here');

                        const $itemDate = $('<button type="button">')
                            .addClass('cv-end-date-mode-item')
                            .attr('role', 'menuitem')
                            .attr('data-mode', 'date')
                            .css({ width: '100%', textAlign: 'left', padding: '12px 14px', background: 'transparent', border: 0, cursor: 'pointer' })
                            .text('End date');

                        $modeMenu.append($itemPresent).append($itemDate);
                        $modeDropdown.append($modeTrigger).append($modeMenu);

                        const $input = $('<input>')
                            .attr('type', field.type)
                            .attr('name', sectionKey + '[' + entryIndex + '][' + field.name + ']')
                            .attr('placeholder', field.placeholder || '')
                            .addClass('form-control cv-end-date-input');

                        const $dateRow = $('<div>')
                            .addClass('cv-end-date-date-row')
                            .css({ display: 'none', gap: '10px', alignItems: 'center' });

                        const $caretBtn = $('<button>')
                            .attr('type', 'button')
                            .addClass('cv-end-date-mode-trigger')
                            .attr('aria-haspopup', 'menu')
                            .attr('aria-expanded', 'false')
                            .attr('aria-label', 'Change end date mode')
                            .css({
                                flex: '0 0 auto',
                                width: '44px',
                                height: '44px',
                                display: 'inline-flex',
                                alignItems: 'center',
                                justifyContent: 'center',
                                borderRadius: '10px',
                                border: '1px solid #e6e6e6',
                                background: '#f3f5f8',
                                cursor: 'pointer'
                            })
                            .append($('<i class="fas fa-chevron-down" aria-hidden="true">').css({ opacity: 0.8 }));

                        const $dateMenu = $('<div>')
                            .addClass('cv-end-date-mode-menu')
                            .attr('role', 'menu')
                            .prop('hidden', true)
                            .attr('aria-hidden', 'true')
                            .css({
                                position: 'absolute',
                                zIndex: 20,
                                right: 0,
                                top: 'calc(100% + 6px)',
                                width: '240px',
                                background: '#fff',
                                border: '1px solid #e6e6e6',
                                borderRadius: '10px',
                                overflow: 'hidden',
                                boxShadow: '0 10px 30px rgba(0,0,0,0.08)'
                            })
                            .append($itemPresent.clone())
                            .append($itemDate.clone());

                        const $dateMenuWrap = $('<div>')
                            .css({ position: 'relative', flex: '0 0 auto' })
                            .append($caretBtn)
                            .append($dateMenu);

                        // show end date input in date mode; keep dropdown caret to change mode
                        $dateRow.append(
                            $('<div>').css({ flex: '1 1 auto' }).append($input)
                        ).append($dateMenuWrap);

                        $formGroup.append($modeValue).append($modeDropdown).append($dateRow);
                    } else {
                        const $input = $('<input>')
                            .attr('type', field.type)
                            .attr('name', sectionKey + '[' + entryIndex + '][' + field.name + ']')
                            .attr('placeholder', field.placeholder || '')
                            .addClass('form-control');
                        $formGroup.append($input);
                    }
                }

                $entryContainer.append($formGroup);
            });

            return $entryContainer;
        }

        // Generate section container with first entry
        function generateSectionFields(sectionKey, sectionConfig) {
            const sectionId = 'section-' + sectionKey;
            const collapseBodyId = sectionId + '-body';

            const $sectionContainer = $('<div>')
                .addClass('added-section')
                .attr('id', sectionId)
                .attr('data-section-key', sectionKey);

            const $toggle = $('<button>')
                .attr('type', 'button')
                .addClass('added-section__toggle')
                .attr('aria-expanded', 'true')
                .attr('aria-controls', collapseBodyId)
                .attr('aria-label', 'Show or hide ' + sectionConfig.name)
                .append(
                    $('<span class="added-section__chev" aria-hidden="true">')
                        .html('<i class="fas fa-chevron-up"></i>')
                );

            const $title = $('<h4>')
                .addClass('added-section__title')
                .append(
                    $('<span class="added-section__icon" aria-hidden="true">').html(sectionConfig.iconSvg || '')
                )
                .append(
                    $('<span class="added-section__text">').text(sectionConfig.name || '')
                );

            const $sectionHeader = $('<div>')
                .addClass('section-header')
                .append(
                    $('<div>')
                        .addClass('section-header__start')
                        .append($toggle)
                        .append($title)
                )
                .append(
                    $('<div class="section-header__actions">')
                        .append(
                            $('<button type="button" class="btn-section-tips cv-soon" aria-disabled="true" tabindex="-1" data-tooltip="Coming soon">')
                                .append('<i class="fas fa-lightbulb" aria-hidden="true"></i>')
                                .append('<span>Get Tips</span>')
                        )
                        .append(
                            $('<button>')
                                .addClass('btn-remove-section')
                                .attr('type', 'button')
                                .attr('aria-label', 'Delete section')
                                .html('<i class="far fa-trash-can" aria-hidden="true"></i>')
                                .on('click', function(ev) {
                                    ev.stopPropagation();
                                    const sectionLabel = sectionKey === 'experience'
                                        ? 'WORK EXPERIENCE'
                                        : (sectionConfig && sectionConfig.name ? String(sectionConfig.name).toUpperCase() : 'SECTION');
                                    openDeleteSectionModal(sectionKey, sectionLabel);
                                })
                        )
                );

            $sectionContainer.append($sectionHeader);

            const $entriesContainer = $('<div>')
                .addClass('entries-container')
                .attr('data-section-key', sectionKey);

            // Initialize entry count for this section
            sectionEntryCounts[sectionKey] = 1;

            // Add first entry
            const $firstEntry = generateEntryFields(sectionKey, sectionConfig, 0);
            $entriesContainer.append($firstEntry);

            // List-view sections: start in list view; others show full form by default
            let $addEntryBtn;
            let $listWrap = null;
            let $editorWrap = null;
            if (listViewSections.has(sectionKey)) {
                $listWrap = $('<div class="cv-section-list-view">')
                    .append('<div class="cv-section-list" role="list"></div>')
                    .append(
                        $('<div class="cv-section-list__footer">')
                            .append('<button type="button" class="cv-section-list__add"><i class="fas fa-plus" aria-hidden="true"></i><span>Add Entry</span></button>')
                    );

                $editorWrap = $('<div class="cv-section-editor-view" hidden aria-hidden="true">')
                    .append($entriesContainer);
                $editorWrap.append(
                    '<div class="cv-section-editor-view__footer">' +
                    '  <button type="button" class="cv-section-editor-view__done cv-section-editor-view__done--cta">' +
                    '    <i class="fas fa-check" aria-hidden="true"></i>' +
                    '    <span>Done</span>' +
                    '  </button>' +
                    '</div>'
                );

                // Hide entries initially (list view)
                $entriesContainer.find('.entry-container').prop('hidden', true).attr('aria-hidden', 'true');

                $addEntryBtn = $listWrap.find('.cv-section-list__add');
                $addEntryBtn.on('click', function() {
                    addEntryToSection(sectionKey, sectionConfig);
                    // open the newest entry
                    const newIndex = (sectionEntryCounts[sectionKey] || 1) - 1;
                    if (sectionKey === 'education') openEducationEntryEditor($sectionContainer, newIndex);
                    else if (sectionKey === 'skills') openSkillsEntryEditor($sectionContainer, newIndex);
                    else if (sectionKey === 'certifications' || sectionKey === 'awards' || sectionKey === 'projects' || sectionKey === 'languages' || sectionKey === 'references') openGenericEntryEditor(sectionKey, $sectionContainer, newIndex);
                    else openExperienceEntryEditor($sectionContainer, newIndex);
                });
            } else {
                // Add "Add Another Entry" button
                $addEntryBtn = $('<button>')
                    .addClass('btn-add-entry')
                    .attr('type', 'button')
                    .html('➕ Add Another ' + sectionConfig.name)
                    .on('click', function() {
                        addEntryToSection(sectionKey, sectionConfig);
                    });
            }

            const $body = $('<div>')
                .addClass('added-section__body')
                .attr('id', collapseBodyId)
                .append(listViewSections.has(sectionKey) ? $listWrap : $entriesContainer)
                .append(listViewSections.has(sectionKey) ? $editorWrap : $addEntryBtn);

            $sectionContainer.append($body);

            // Attach event handlers to form fields
            const debouncedHandler = debounce(handleFormChange, 300);
            $sectionContainer.find('input, textarea, select').on('input change', debouncedHandler);

            if (sectionKey === 'experience') renderExperienceList($sectionContainer);
            if (sectionKey === 'education') renderEducationList($sectionContainer);
            if (sectionKey === 'skills') renderSkillsList($sectionContainer);
            if (sectionKey === 'certifications' || sectionKey === 'awards' || sectionKey === 'projects' || sectionKey === 'languages' || sectionKey === 'references') {
                renderGenericList(sectionKey, $sectionContainer);
            }

            return $sectionContainer;
        }

        function renderExperienceList($section) {
            const $list = $section.find('.cv-section-list');
            const $entries = $section.find('.entries-container .entry-container');
            if (!$list.length) return;
            $list.empty();
            $entries.each(function() {
                const $entry = $(this);
                const idx = Number($entry.attr('data-entry-index'));
                const title = String($entry.find('input[name^="experience[' + idx + '][title]"]').val() || '').trim() || 'Job Title';
                const company = String($entry.find('input[name^="experience[' + idx + '][company]"]').val() || '').trim();
                const isHidden = String($entry.find('input[name^="experience[' + idx + '][is_hidden]"]').val() || '').trim() === '1';

                const $row = $('<div class="cv-section-list__row" role="listitem">')
                    .attr('draggable', 'true')
                    .attr('data-entry-index', String(idx))
                    .append('<span class="cv-section-list__handle" aria-hidden="true" title="Drag to reorder"><i class="fas fa-grip-vertical"></i></span>')
                    .append(
                        $('<button type="button" class="cv-section-list__text" aria-label="Edit entry">')
                            .append($('<span class="cv-section-list__title">').text(title))
                            .append(company ? $('<span class="cv-section-list__company">').text(', ' + company) : '')
                            .on('click', function(e) {
                                e.preventDefault();
                                openExperienceEntryEditor($section, idx);
                            })
                    )
                    .append(
                        $('<button type="button" class="cv-section-list__open" aria-label="Hide/unhide in preview">')
                            .html(isHidden ? '<i class="far fa-eye-slash" aria-hidden="true"></i>' : '<i class="far fa-eye" aria-hidden="true"></i>')
                            .on('click', function(e) {
                                e.preventDefault();
                                const $flag = $entry.find('input[name^="experience[' + idx + '][is_hidden]"]');
                                const nowHidden = String($flag.val() || '').trim() !== '1';
                                $flag.val(nowHidden ? '1' : '');
                                renderExperienceList($section);
                                handleFormChange();
                            })
                    );

                $list.append($row);
            });
        }

        function renderEducationList($section) {
            const $list = $section.find('.cv-section-list');
            const $entries = $section.find('.entries-container .entry-container');
            if (!$list.length) return;
            $list.empty();
            $entries.each(function() {
                const $entry = $(this);
                const idx = Number($entry.attr('data-entry-index'));
                const degree = String($entry.find('input[name^="education[' + idx + '][degree]"]').val() || '').trim() || 'Degree';
                const institution = String($entry.find('input[name^="education[' + idx + '][institution]"]').val() || '').trim();
                const isHidden = String($entry.find('input[name^="education[' + idx + '][is_hidden]"]').val() || '').trim() === '1';

                const $row = $('<div class="cv-section-list__row" role="listitem">')
                    .attr('draggable', 'true')
                    .attr('data-entry-index', String(idx))
                    .append('<span class="cv-section-list__handle" aria-hidden="true" title="Drag to reorder"><i class="fas fa-grip-vertical"></i></span>')
                    .append(
                        $('<button type="button" class="cv-section-list__text" aria-label="Edit entry">')
                            .append($('<span class="cv-section-list__title">').text(degree))
                            .append(institution ? $('<span class="cv-section-list__company">').text(', ' + institution) : '')
                            .on('click', function(e) {
                                e.preventDefault();
                                openEducationEntryEditor($section, idx);
                            })
                    )
                    .append(
                        $('<button type="button" class="cv-section-list__open" aria-label="Hide/unhide in preview">')
                            .html(isHidden ? '<i class="far fa-eye-slash" aria-hidden="true"></i>' : '<i class="far fa-eye" aria-hidden="true"></i>')
                            .on('click', function(e) {
                                e.preventDefault();
                                const $flag = $entry.find('input[name^="education[' + idx + '][is_hidden]"]');
                                const nowHidden = String($flag.val() || '').trim() !== '1';
                                $flag.val(nowHidden ? '1' : '');
                                renderEducationList($section);
                                handleFormChange();
                            })
                    );

                $list.append($row);
            });
        }

        function renderSkillsList($section) {
            const $list = $section.find('.cv-section-list');
            const $entries = $section.find('.entries-container .entry-container');
            if (!$list.length) return;
            $list.empty();
            $entries.each(function() {
                const $entry = $(this);
                const idx = Number($entry.attr('data-entry-index'));
                const skill = String($entry.find('input[name^="skills[' + idx + '][skill]"]').val() || '').trim() || 'Skill';
                const level = String($entry.find('select[name^="skills[' + idx + '][level]"]').val() || '').trim();
                const isHidden = String($entry.find('input[name^="skills[' + idx + '][is_hidden]"]').val() || '').trim() === '1';

                const $row = $('<div class="cv-section-list__row" role="listitem">')
                    .attr('draggable', 'true')
                    .attr('data-entry-index', String(idx))
                    .append('<span class="cv-section-list__handle" aria-hidden="true" title="Drag to reorder"><i class="fas fa-grip-vertical"></i></span>')
                    .append(
                        $('<button type="button" class="cv-section-list__text" aria-label="Edit entry">')
                            .append($('<span class="cv-section-list__title">').text(skill))
                            .append(level ? $('<span class="cv-section-list__company">').text(', ' + level) : '')
                            .on('click', function(e) {
                                e.preventDefault();
                                openSkillsEntryEditor($section, idx);
                            })
                    )
                    .append(
                        $('<button type="button" class="cv-section-list__open" aria-label="Hide/unhide in preview">')
                            .html(isHidden ? '<i class="far fa-eye-slash" aria-hidden="true"></i>' : '<i class="far fa-eye" aria-hidden="true"></i>')
                            .on('click', function(e) {
                                e.preventDefault();
                                const $flag = $entry.find('input[name^="skills[' + idx + '][is_hidden]"]');
                                const nowHidden = String($flag.val() || '').trim() !== '1';
                                $flag.val(nowHidden ? '1' : '');
                                renderSkillsList($section);
                                handleFormChange();
                            })
                    );

                $list.append($row);
            });
        }

        function _getEntryFieldValue(sectionKey, idx, fieldName, $entry) {
            const selectorBase = sectionKey + '[' + idx + '][' + fieldName + ']';
            const $field = $entry.find('input[name^="' + selectorBase + '"], textarea[name^="' + selectorBase + '"], select[name^="' + selectorBase + '"]');
            if (!$field.length) return '';
            return String($field.val() || '').trim();
        }

        function renderGenericList(sectionKey, $section) {
            const $list = $section.find('.cv-section-list');
            const $entries = $section.find('.entries-container .entry-container');
            if (!$list.length) return;
            $list.empty();

            const cfg = listViewSummaryFields[sectionKey] || {};
            const primaryField = cfg.primary || (availableSections[sectionKey] && availableSections[sectionKey].fields && availableSections[sectionKey].fields[0] ? availableSections[sectionKey].fields[0].name : '');
            const secondaryField = cfg.secondary || '';

            $entries.each(function() {
                const $entry = $(this);
                const idx = Number($entry.attr('data-entry-index'));
                const primary = _getEntryFieldValue(sectionKey, idx, primaryField, $entry) || (primaryField ? primaryField.replace(/_/g, ' ') : 'Entry');
                const secondary = secondaryField ? _getEntryFieldValue(sectionKey, idx, secondaryField, $entry) : '';
                const isHidden = String($entry.find('input[name^="' + sectionKey + '[' + idx + '][is_hidden]"]').val() || '').trim() === '1';

                const $row = $('<div class="cv-section-list__row" role="listitem">')
                    .attr('draggable', 'true')
                    .attr('data-entry-index', String(idx))
                    .append('<span class="cv-section-list__handle" aria-hidden="true" title="Drag to reorder"><i class="fas fa-grip-vertical"></i></span>')
                    .append(
                        $('<button type="button" class="cv-section-list__text" aria-label="Edit entry">')
                            .append($('<span class="cv-section-list__title">').text(primary || 'Entry'))
                            .append(secondary ? $('<span class="cv-section-list__company">').text(', ' + secondary) : '')
                            .on('click', function(e) {
                                e.preventDefault();
                                openGenericEntryEditor(sectionKey, $section, idx);
                            })
                    )
                    .append(
                        $('<button type="button" class="cv-section-list__open" aria-label="Hide/unhide in preview">')
                            .html(isHidden ? '<i class="far fa-eye-slash" aria-hidden="true"></i>' : '<i class="far fa-eye" aria-hidden="true"></i>')
                            .on('click', function(e) {
                                e.preventDefault();
                                const $flag = $entry.find('input[name^="' + sectionKey + '[' + idx + '][is_hidden]"]');
                                const nowHidden = String($flag.val() || '').trim() !== '1';
                                $flag.val(nowHidden ? '1' : '');
                                renderGenericList(sectionKey, $section);
                                handleFormChange();
                            })
                    );

                $list.append($row);
            });
        }

        function _openEntryEditorCommon($section, entryIndex) {
            const $listWrap = $section.find('.cv-section-list-view');
            const $editorWrap = $section.find('.cv-section-editor-view');
            const $entries = $section.find('.entries-container .entry-container');
            $entries.prop('hidden', true).attr('aria-hidden', 'true');
            const $target = $section.find('.entries-container .entry-container[data-entry-index="' + entryIndex + '"]');
            $target.prop('hidden', false).attr('aria-hidden', 'false');
            $listWrap.prop('hidden', true).attr('aria-hidden', 'true');
            $editorWrap.prop('hidden', false).attr('aria-hidden', 'false');
            initRichTextEditors($target);
            setTimeout(function() {
                $target.find('input, textarea, select').first().trigger('focus');
            }, 0);
        }

        function _closeEntryEditorCommon($section) {
            const $listWrap = $section.find('.cv-section-list-view');
            const $editorWrap = $section.find('.cv-section-editor-view');
            const $entries = $section.find('.entries-container .entry-container');
            $entries.prop('hidden', true).attr('aria-hidden', 'true');
            $editorWrap.prop('hidden', true).attr('aria-hidden', 'true');
            $listWrap.prop('hidden', false).attr('aria-hidden', 'false');
        }

        // Drag & drop reorder for Experience list
        let __expDragFromIdx = null;
        $form.on('dragstart', '#section-experience .cv-section-list__row', function(e) {
            __expDragFromIdx = $(this).attr('data-entry-index');
            try { e.originalEvent.dataTransfer.effectAllowed = 'move'; } catch (_) {}
            $(this).addClass('is-dragging');
        });
        $form.on('dragend', '#section-experience .cv-section-list__row', function() {
            $(this).removeClass('is-dragging');
        });
        $form.on('dragover', '#section-experience .cv-section-list__row', function(e) {
            e.preventDefault();
            try { e.originalEvent.dataTransfer.dropEffect = 'move'; } catch (_) {}
        });
        $form.on('drop', '#section-experience .cv-section-list__row', function(e) {
            e.preventDefault();
            const $targetRow = $(this);
            const toIdx = $targetRow.attr('data-entry-index');
            const fromIdx = __expDragFromIdx;
            if (fromIdx === null || fromIdx === undefined) return;
            if (String(fromIdx) === String(toIdx)) return;

            const $section = $('#section-experience');
            const $entriesContainer = $section.find('.entries-container');
            const $fromEntry = $entriesContainer.find('.entry-container[data-entry-index="' + fromIdx + '"]');
            const $toEntry = $entriesContainer.find('.entry-container[data-entry-index="' + toIdx + '"]');
            if (!$fromEntry.length || !$toEntry.length) return;

            // Move the entry containers to match the list order
            const toPos = $toEntry.index();
            if ($fromEntry.index() < toPos) $toEntry.after($fromEntry);
            else $toEntry.before($fromEntry);

            // Reindex names/indices so everything stays consistent
            reindexSectionEntries('experience');
            renderExperienceList($section);
            handleFormChange();
        });

        // Drag & drop reorder for Education list
        let __eduDragFromIdx = null;
        $form.on('dragstart', '#section-education .cv-section-list__row', function(e) {
            __eduDragFromIdx = $(this).attr('data-entry-index');
            try { e.originalEvent.dataTransfer.effectAllowed = 'move'; } catch (_) {}
            $(this).addClass('is-dragging');
        });
        $form.on('dragend', '#section-education .cv-section-list__row', function() {
            $(this).removeClass('is-dragging');
        });
        $form.on('dragover', '#section-education .cv-section-list__row', function(e) {
            e.preventDefault();
            try { e.originalEvent.dataTransfer.dropEffect = 'move'; } catch (_) {}
        });
        $form.on('drop', '#section-education .cv-section-list__row', function(e) {
            e.preventDefault();
            const $targetRow = $(this);
            const toIdx = $targetRow.attr('data-entry-index');
            const fromIdx = __eduDragFromIdx;
            if (fromIdx === null || fromIdx === undefined) return;
            if (String(fromIdx) === String(toIdx)) return;

            const $section = $('#section-education');
            const $entriesContainer = $section.find('.entries-container');
            const $fromEntry = $entriesContainer.find('.entry-container[data-entry-index="' + fromIdx + '"]');
            const $toEntry = $entriesContainer.find('.entry-container[data-entry-index="' + toIdx + '"]');
            if (!$fromEntry.length || !$toEntry.length) return;

            const toPos = $toEntry.index();
            if ($fromEntry.index() < toPos) $toEntry.after($fromEntry);
            else $toEntry.before($fromEntry);

            reindexSectionEntries('education');
            renderEducationList($section);
            handleFormChange();
        });

        function openExperienceEntryEditor($section, entryIndex) {
            _openEntryEditorCommon($section, entryIndex);
        }

        function closeExperienceEntryEditor($section) {
            _closeEntryEditorCommon($section);
            renderExperienceList($section);
        }

        function openEducationEntryEditor($section, entryIndex) {
            _openEntryEditorCommon($section, entryIndex);
        }

        function closeEducationEntryEditor($section) {
            _closeEntryEditorCommon($section);
            renderEducationList($section);
        }

        // Drag & drop reorder for Skills list
        let __skillsDragFromIdx = null;
        $form.on('dragstart', '#section-skills .cv-section-list__row', function(e) {
            __skillsDragFromIdx = $(this).attr('data-entry-index');
            try { e.originalEvent.dataTransfer.effectAllowed = 'move'; } catch (_) {}
            $(this).addClass('is-dragging');
        });
        $form.on('dragend', '#section-skills .cv-section-list__row', function() {
            $(this).removeClass('is-dragging');
        });
        $form.on('dragover', '#section-skills .cv-section-list__row', function(e) {
            e.preventDefault();
            try { e.originalEvent.dataTransfer.dropEffect = 'move'; } catch (_) {}
        });
        $form.on('drop', '#section-skills .cv-section-list__row', function(e) {
            e.preventDefault();
            const $targetRow = $(this);
            const toIdx = $targetRow.attr('data-entry-index');
            const fromIdx = __skillsDragFromIdx;
            if (fromIdx === null || fromIdx === undefined) return;
            if (String(fromIdx) === String(toIdx)) return;

            const $section = $('#section-skills');
            const $entriesContainer = $section.find('.entries-container');
            const $fromEntry = $entriesContainer.find('.entry-container[data-entry-index="' + fromIdx + '"]');
            const $toEntry = $entriesContainer.find('.entry-container[data-entry-index="' + toIdx + '"]');
            if (!$fromEntry.length || !$toEntry.length) return;

            const toPos = $toEntry.index();
            if ($fromEntry.index() < toPos) $toEntry.after($fromEntry);
            else $toEntry.before($fromEntry);

            reindexSectionEntries('skills');
            renderSkillsList($section);
            handleFormChange();
        });

        function openSkillsEntryEditor($section, entryIndex) {
            _openEntryEditorCommon($section, entryIndex);
        }

        function closeSkillsEntryEditor($section) {
            _closeEntryEditorCommon($section);
            renderSkillsList($section);
        }

        // Drag & drop reorder for generic list sections
        const __genericDragFromIdx = {};
        $form.on('dragstart', '#section-certifications .cv-section-list__row, #section-awards .cv-section-list__row, #section-projects .cv-section-list__row, #section-languages .cv-section-list__row, #section-references .cv-section-list__row', function(e) {
            const $row = $(this);
            const $section = $row.closest('.added-section');
            const sectionId = String($section.attr('id') || '');
            const sectionKey = sectionId.replace(/^section-/, '');
            __genericDragFromIdx[sectionKey] = $row.attr('data-entry-index');
            try { e.originalEvent.dataTransfer.effectAllowed = 'move'; } catch (_) {}
            $row.addClass('is-dragging');
        });
        $form.on('dragend', '#section-certifications .cv-section-list__row, #section-awards .cv-section-list__row, #section-projects .cv-section-list__row, #section-languages .cv-section-list__row, #section-references .cv-section-list__row', function() {
            $(this).removeClass('is-dragging');
        });
        $form.on('dragover', '#section-certifications .cv-section-list__row, #section-awards .cv-section-list__row, #section-projects .cv-section-list__row, #section-languages .cv-section-list__row, #section-references .cv-section-list__row', function(e) {
            e.preventDefault();
            try { e.originalEvent.dataTransfer.dropEffect = 'move'; } catch (_) {}
        });
        $form.on('drop', '#section-certifications .cv-section-list__row, #section-awards .cv-section-list__row, #section-projects .cv-section-list__row, #section-languages .cv-section-list__row, #section-references .cv-section-list__row', function(e) {
            e.preventDefault();
            const $targetRow = $(this);
            const $section = $targetRow.closest('.added-section');
            const sectionId = String($section.attr('id') || '');
            const sectionKey = sectionId.replace(/^section-/, '');
            const toIdx = $targetRow.attr('data-entry-index');
            const fromIdx = __genericDragFromIdx[sectionKey];
            if (fromIdx === null || fromIdx === undefined) return;
            if (String(fromIdx) === String(toIdx)) return;

            const $entriesContainer = $section.find('.entries-container');
            const $fromEntry = $entriesContainer.find('.entry-container[data-entry-index="' + fromIdx + '"]');
            const $toEntry = $entriesContainer.find('.entry-container[data-entry-index="' + toIdx + '"]');
            if (!$fromEntry.length || !$toEntry.length) return;

            const toPos = $toEntry.index();
            if ($fromEntry.index() < toPos) $toEntry.after($fromEntry);
            else $toEntry.before($fromEntry);

            reindexSectionEntries(sectionKey);
            renderGenericList(sectionKey, $section);
            handleFormChange();
        });

        function openGenericEntryEditor(sectionKey, $section, entryIndex) {
            _openEntryEditorCommon($section, entryIndex);
        }

        function closeGenericEntryEditor(sectionKey, $section) {
            _closeEntryEditorCommon($section);
            renderGenericList(sectionKey, $section);
        }

        // Add a new entry to an existing section
        function addEntryToSection(sectionKey, sectionConfig) {
            const $section = $('#section-' + sectionKey);
            if ($section.length === 0) return;

            const $entriesContainer = $section.find('.entries-container');
            const currentCount = sectionEntryCounts[sectionKey] || 0;
            const newEntryIndex = currentCount;

            // Create new entry
            const $newEntry = generateEntryFields(sectionKey, sectionConfig, newEntryIndex);
            $entriesContainer.append($newEntry);

            // Update entry count
            sectionEntryCounts[sectionKey] = newEntryIndex + 1;

            // Show remove buttons for all entries (since we now have more than 1)
            $entriesContainer.find('.btn-remove-entry').show();

            // Attach event handlers
            const debouncedHandler = debounce(handleFormChange, 300);
            $newEntry.find('input, textarea, select').on('input change', debouncedHandler);

            // Init Quill editor for the new entry (if any)
            initRichTextEditors($newEntry);

            // Update preview
            handleFormChange();

            if (sectionKey === 'experience') {
                const $section = $('#section-' + sectionKey);
                renderExperienceList($section);
            }
            if (sectionKey === 'education') {
                const $section = $('#section-' + sectionKey);
                renderEducationList($section);
            }
            if (sectionKey === 'skills') {
                const $section = $('#section-' + sectionKey);
                renderSkillsList($section);
            }
            if (sectionKey === 'certifications' || sectionKey === 'awards' || sectionKey === 'projects' || sectionKey === 'languages' || sectionKey === 'references') {
                const $section = $('#section-' + sectionKey);
                renderGenericList(sectionKey, $section);
            }
        }

        // Remove a specific entry from a section
        function removeEntry(sectionKey, entryIndex) {
            const $section = $('#section-' + sectionKey);
            if ($section.length === 0) return;

            const $entriesContainer = $section.find('.entries-container');
            const $entryToRemove = $entriesContainer.find('.entry-container[data-entry-index="' + entryIndex + '"]');

            if ($entryToRemove.length === 0) return;

            // Remove the entry
            $entryToRemove.fadeOut(200, function() {
                $(this).remove();

                // Re-index remaining entries
                reindexSectionEntries(sectionKey);

                // Update entry count
                const remainingEntries = $entriesContainer.find('.entry-container').length;
                sectionEntryCounts[sectionKey] = remainingEntries;

                // Hide remove buttons if only 1 entry remains
                if (remainingEntries === 1) {
                    $entriesContainer.find('.btn-remove-entry').hide();
                }

                // Update preview
                handleFormChange();
            });
        }

        // Re-index entries after removal (to keep indices sequential)
        function reindexSectionEntries(sectionKey) {
            const $section = $('#section-' + sectionKey);
            if ($section.length === 0) return;

            const $entriesContainer = $section.find('.entries-container');
            const $entries = $entriesContainer.find('.entry-container');

            $entries.each(function(newIndex) {
                const $entry = $(this);
                const oldIndex = parseInt($entry.attr('data-entry-index'));

                // Update data attribute
                $entry.attr('data-entry-index', newIndex);

                // Update entry header number
                $entry.find('h5').html($entry.find('h5').text().replace(/#\d+/, '#' + (newIndex + 1)));

                // Update all input/textarea names
                $entry.find('input, textarea').each(function() {
                    const $field = $(this);
                    const name = $field.attr('name');
                    if (name) {
                        // Replace old index with new index in name attribute
                        const newName = name.replace(/\[\d+\]\[/, '[' + newIndex + '][');
                        $field.attr('name', newName);
                    }
                });
            });
        }

        // Multi-select add removed (sections are added on click)

        function removeSection(sectionKey) {
            const $section = $('#section-' + sectionKey);
            if ($section.length) {
                $section.fadeOut(200, function() {
                    $(this).remove();
                    addedSections.delete(sectionKey);
                    // Clear entry count for this section
                    delete sectionEntryCounts[sectionKey];
                    handleFormChange();
                });
            }
        }

        // Delete section confirmation modal
        const $deleteModal = $('#cv-delete-section-modal');
        const $deleteBackdrop = $('#cv-delete-section-backdrop');
        const $deleteClose = $('#cv-delete-section-close');
        const $deleteCancel = $('#cv-delete-section-cancel');
        const $deleteConfirm = $('#cv-delete-section-confirm');
        const $deleteCheck = $('#cv-delete-section-confirm-check');
        const $deleteTitle = $('#cv-delete-section-title');
        let pendingDeleteSectionKey = null;

        function setDeleteConfirmEnabled(enabled) {
            $deleteConfirm.prop('disabled', !enabled);
            $deleteConfirm.attr('aria-disabled', enabled ? 'false' : 'true');
        }

        function openDeleteSectionModal(sectionKey, sectionLabel) {
            pendingDeleteSectionKey = sectionKey;
            $deleteTitle.text(`Delete “${sectionLabel}” section?`);
            $deleteCheck.prop('checked', false);
            setDeleteConfirmEnabled(false);

            $deleteModal.removeAttr('hidden').attr('aria-hidden', 'false');
            $('body').addClass('cv-modal-open');
        }

        function closeDeleteSectionModal() {
            pendingDeleteSectionKey = null;
            $deleteModal.attr('aria-hidden', 'true').attr('hidden', 'hidden');
            $('body').removeClass('cv-modal-open');
        }

        $deleteCheck.on('change', function() {
            setDeleteConfirmEnabled($(this).is(':checked'));
        });

        $deleteConfirm.on('click', function() {
            if ($(this).prop('disabled')) return;
            if (!pendingDeleteSectionKey) return;
            removeSection(pendingDeleteSectionKey);
            closeDeleteSectionModal();
        });

        $deleteCancel.on('click', closeDeleteSectionModal);
        $deleteClose.on('click', closeDeleteSectionModal);
        $deleteBackdrop.on('click', closeDeleteSectionModal);

        $(document).on('keydown', function(e) {
            if ($deleteModal.attr('aria-hidden') === 'false' && (e.key === 'Escape' || e.key === 'Esc')) {
                closeDeleteSectionModal();
            }
        });

        // Save CV legacy button (if present): route through saveCurrentCv()
        $('#btn-save-cv').on('click', function() {
            const $btn = $(this);
            const $message = $('#save-message');
            $btn.prop('disabled', true).text('Saving...');
            if ($message.length) $message.hide().removeClass('success error');

            saveCurrentCv({
                onSuccess: function(resp) {
                    if ($message.length) {
                        $message.addClass('success').text((resp && resp.message) || 'Saved').fadeIn();
                    }
                    setTimeout(function() { $btn.prop('disabled', false).text('💾 Save CV'); }, 700);
                },
                onError: function() {
                    if ($message.length) $message.addClass('error').text('Unable to save').fadeIn();
                    $btn.prop('disabled', false).text('💾 Save CV');
                }
            });
        });

        // Export PDF functionality
        $('#btn-export-pdf').on('click', function() {
            const $btn = $(this);
            const $message = $('#export-message');
            
            $btn.prop('disabled', true).html('<span class="cv-builder-toolbar__download-text">Generating PDF...</span><i class="fas fa-spinner fa-spin cv-builder-toolbar__download-icon" aria-hidden="true"></i>');
            $message.hide().removeClass('success error');

            const cvData = collectFormData();
            
            // Get CSRF token from meta tag (fresh token) or use config token
            const csrfToken = $('meta[name="csrf-token"]').attr('content') || cvBuilderConfig.csrfToken;

            // Create a form and submit it to download PDF
            const form = $('<form>', {
                'method': 'POST',
                'action': cvBuilderConfig.routes.exportPDF
            });

            form.append($('<input>', {
                'type': 'hidden',
                'name': '_token',
                'value': csrfToken
            }));

            form.append($('<input>', {
                'type': 'hidden',
                'name': 'cv_data',
                'value': JSON.stringify(cvData)
            }));

            $('body').append(form);
            form.submit();
            form.remove();

            // Re-enable button after a delay (in case of error)
            setTimeout(function() {
                $btn.prop('disabled', false).html('<span class="cv-builder-toolbar__download-text">Download</span><i class="fas fa-file-arrow-down cv-builder-toolbar__download-icon" aria-hidden="true"></i>');
            }, 3000);
        });
    }

    // Expose to global scope
    window.CVBuilder = {
        init: initCVBuilder
    };

})(jQuery);

