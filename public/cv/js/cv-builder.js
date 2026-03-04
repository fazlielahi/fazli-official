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
            save: ''
        },
        csrfToken: ''
    };

    // Initialize CV Builder
    function initCVBuilder(config) {
        cvBuilderConfig = config;

        const $form = $('#cv-form');
        const $preview = $('#cv-preview');
        const $pagesWrapper = $preview.find('.cv-pages-wrapper');
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
        const $countryInput = $form.find('input[name="country"]');
        const $summaryInput = $form.find('textarea[name="summary"]');
        const $photoInput = $('#photo-upload');
        const $photoPreview = $('#photo-preview');
        const $photoPreviewContainer = $('#photo-preview-container');
        let photoData = null;

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
                icon: '💼',
                fields: [
                    { name: 'title', label: 'Job Title', type: 'text', placeholder: 'e.g., Senior Developer' },
                    { name: 'company', label: 'Company', type: 'text', placeholder: 'e.g., Tech Company Inc.' },
                    { name: 'period', label: 'Period', type: 'text', placeholder: 'e.g., Jan 2020 - Present' },
                    { name: 'description', label: 'Description (Optional)', type: 'textarea', placeholder: 'Brief description of your role and achievements' }
                ]
            },
            'education': {
                name: 'Education',
                icon: '🎓',
                fields: [
                    { name: 'degree', label: 'Degree', type: 'text', placeholder: 'e.g., Bachelor of Science in Computer Science' },
                    { name: 'institution', label: 'Institution', type: 'text', placeholder: 'e.g., University Name' },
                    { name: 'period', label: 'Period', type: 'text', placeholder: 'e.g., 2016 - 2020' }
                ]
            },
            'certifications': {
                name: 'Certifications',
                icon: '🏆',
                fields: [
                    { name: 'name', label: 'Certification Name', type: 'text', placeholder: 'e.g., AWS Certified Solutions Architect' },
                    { name: 'issuer', label: 'Issuing Organization', type: 'text', placeholder: 'e.g., Amazon Web Services' },
                    { name: 'date', label: 'Date', type: 'text', placeholder: 'e.g., January 2023' },
                    { name: 'credential_id', label: 'Credential ID (Optional)', type: 'text', placeholder: 'e.g., ABC123' }
                ]
            },
            'awards': {
                name: 'Awards',
                icon: '⭐',
                fields: [
                    { name: 'title', label: 'Award Title', type: 'text', placeholder: 'e.g., Employee of the Year' },
                    { name: 'organization', label: 'Organization', type: 'text', placeholder: 'e.g., Company Name' },
                    { name: 'date', label: 'Date', type: 'text', placeholder: 'e.g., 2023' },
                    { name: 'description', label: 'Description (Optional)', type: 'textarea', placeholder: 'Brief description of the award' }
                ]
            },
            'languages': {
                name: 'Languages',
                icon: '🌐',
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
                icon: '💼',
                fields: [
                    { name: 'name', label: 'Project Name', type: 'text', placeholder: 'e.g., E-commerce Platform' },
                    { name: 'description', label: 'Description', type: 'textarea', placeholder: 'Brief description of the project' },
                    { name: 'technologies', label: 'Technologies Used', type: 'text', placeholder: 'e.g., PHP, Laravel, MySQL' },
                    { name: 'link', label: 'Project Link (Optional)', type: 'text', placeholder: 'https://example.com' }
                ]
            },
            'skills': {
                name: 'Skills',
                icon: '🛠️',
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
                icon: '📞',
                fields: [
                    { name: 'name', label: 'Name', type: 'text', placeholder: 'Full Name' },
                    { name: 'position', label: 'Position', type: 'text', placeholder: 'e.g., Senior Manager' },
                    { name: 'company', label: 'Company', type: 'text', placeholder: 'Company Name' },
                    { name: 'email', label: 'Email', type: 'email', placeholder: 'email@example.com' },
                    { name: 'phone', label: 'Phone (Optional)', type: 'text', placeholder: '+1234567890' }
                ]
            }
        };

        // Collect form data
        function collectFormData() {
            try {
                // Combine city and country into a single address string
                const addressParts = [];
                if ($cityInput.val()) addressParts.push($cityInput.val());
                if ($countryInput.val()) addressParts.push($countryInput.val());
                const fullAddress = addressParts.join(', ');
                
                const data = {
                    name: $nameInput.val() || '',
                    job_title: $jobTitleInput.val() || '',
                    email: $emailInput.val() || '',
                    phone: $phoneInput.val() || '',
                    address: fullAddress, // Combined address for template display
                    city: $cityInput.val() || '',
                    country: $countryInput.val() || '',
                    summary: $summaryInput.val() || '',
                    photo: photoData || ''
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

                return data;
            } catch (error) {
                return formData;
            }
        }

        // Escape HTML to prevent XSS
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Generate section item HTML - Template-agnostic (uses standard class names)
        function generateSectionItem(sectionKey, item) {
            let html = '';
            
            if (sectionKey === 'experience') {
                html = '<div class="experience-item">' +
                    '<div class="item-header">' +
                    '<div class="item-title-row">' +
                    '<h3 class="item-title">' + escapeHtml(item.title || 'Job Title') + '</h3>' +
                    (item.period ? '<span class="item-period">' + escapeHtml(item.period) + '</span>' : '') +
                    '</div>' +
                    (item.company ? '<p class="item-company">' + escapeHtml(item.company) + '</p>' : '') +
                    '</div>' +
                    (item.description ? '<div class="item-description"><p>' + escapeHtml(item.description) + '</p></div>' : '') +
                    '</div>';
            } else if (sectionKey === 'education') {
                html = '<div class="education-item">' +
                    '<div class="item-header">' +
                    '<div class="item-title-row">' +
                    '<h3 class="item-title">' + escapeHtml(item.degree || 'Degree') + '</h3>' +
                    (item.period ? '<span class="item-period">' + escapeHtml(item.period) + '</span>' : '') +
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
                    (item.description ? '<div class="item-description"><p>' + escapeHtml(item.description) + '</p></div>' : '') +
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
                    (item.description ? '<div class="item-description"><p>' + escapeHtml(item.description) + '</p></div>' : '') +
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
                const $template = $preview.find('.cv-template');
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
                const hasContactIcons = $template.find('.contact-icon').length > 0;
                
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

                // Update summary
                const $summarySection = $template.find('.summary');
                if (data.summary && data.summary.trim()) {
                    if ($summarySection.length === 0) {
                        // Create summary section if it doesn't exist
                        const $cvBody = $template.find('.cv-body');
                        if ($cvBody.length > 0) {
                            $cvBody.prepend(
                                '<section class="summary">' +
                                '<h2 class="section-title">Professional Summary</h2>' +
                                '<div class="section-content"><p></p></div>' +
                                '</section>'
                            );
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

        // Listen to form input changes
        $form.on('input change', 'input, textarea, select', function() {
            handleFormChange();
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
                    $photoPreviewContainer.show();
                    handleFormChange();
                };
                reader.onerror = function() {
                    alert('Error reading file. Please try again.');
                    $photoInput.val('');
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle photo removal
        $('#remove-photo').on('click', function() {
            photoData = null;
            $photoInput.val('');
            $photoPreview.attr('src', '');
            $photoPreviewContainer.hide();
            handleFormChange();
        });

        // Load initial photo if exists in template
        const $initialPhoto = $preview.find('.profile-photo');
        if ($initialPhoto.length > 0 && $initialPhoto.attr('src')) {
            photoData = $initialPhoto.attr('src');
            $photoPreview.attr('src', photoData);
            $photoPreviewContainer.show();
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
            
            // Use section-based page breaking
            distributeSectionsAcrossPages($firstPage, $content);
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
                return;
            }
            
            // Content overflows - find which section causes overflow
            // Use offsetTop which is relative to offsetParent (more reliable)
            let firstOverflowSectionIndex = -1;
            
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
            
            // Now hide sections on first page that overflow (we already have all sections visible from measurement)
            if (firstOverflowSectionIndex >= 0) {
                $allSections.each(function(index) {
                    if (index >= firstOverflowSectionIndex) {
                        // Hide sections that should move to next page
                        $(this).css({
                            'display': 'none',
                            'visibility': 'hidden'
                        });
                    } else {
                        // Ensure sections that fit are visible
                        $(this).css({
                            'display': '',
                            'visibility': 'visible'
                        });
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
                            return;
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
                
                // Restore original states on first page
                $allSections.each(function(index) {
                    if (index >= firstOverflowSectionIndex) {
                        $(this).css({
                            'display': 'none',
                            'visibility': 'hidden'
                        });
                    } else {
                        $(this).css({
                            'display': originalStates[index].display || '',
                            'visibility': originalStates[index].visibility || 'visible'
                        });
                    }
                });
                
                // Remove header from continuation page
                $contentClone.find('.cv-header, .top-green, .top-content').remove();
                
                // Hide sections that should stay on first page, show only overflow sections
                const $cloneSections = $contentClone.find('section');
                $cloneSections.each(function(index) {
                    if (index < firstOverflowSectionIndex) {
                        // Hide sections that are on first page
                        $(this).css({
                            'display': 'none',
                            'visibility': 'hidden'
                        });
                    } else {
                        // Show sections that overflow - explicitly reset
                        $(this).css({
                            'display': 'block',
                            'visibility': 'visible'
                        });
                    }
                });
                
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
            } else {
                // All sections fit - remove continuation pages
                $firstPage.nextAll('.cv-page-container').remove();
            }
        }
        
        // Initial preview update - delay slightly to ensure CSS is loaded
        setTimeout(function() {
            formData = collectFormData();
            // Only update if there's actual data or if template is not already rendered
            const templateClass = cvBuilderConfig.templateSlug || 'classic';
            const hasExistingTemplate = $preview.find('.cv-template.' + templateClass).length > 0;
            const hasData = formData.name || formData.email || formData.phone || formData.summary || formData.photo;
            if (!hasExistingTemplate || hasData) {
                updatePreview(formData);
            }
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
        const $loadBtn = $('#btn-load-cv');
        const $loadMessage = $('#load-message');

        function loadSavedCVsList() {
            $.ajax({
                url: cvBuilderConfig.routes.saved,
                method: 'GET',
                success: function(response) {
                    if (response.success && response.cvs && response.cvs.length > 0) {
                        $loadSelect.empty().append('<option value="">-- Select a saved CV --</option>');
                        response.cvs.forEach(function(cv) {
                            const date = new Date(cv.updated_at).toLocaleDateString();
                            const optionText = (cv.title || 'Untitled CV') + ' (' + date + ')';
                            $loadSelect.append('<option value="' + cv.id + '">' + optionText + '</option>');
                        });
                        $('#btn-load-cv').show();
                    } else {
                        $loadSelect.empty().append('<option value="">' + (response.message || 'No saved CVs found') + '</option>');
                        $('#btn-load-cv').hide();
                    }
                },
                error: function(xhr) {
                    // Handle errors gracefully
                    if (xhr.status === 401) {
                        $loadSelect.empty().append('<option value="">Please login to load saved CVs</option>');
                    } else {
                        $loadSelect.empty().append('<option value="">Unable to load saved CVs</option>');
                    }
                    $('#btn-load-cv').hide();
                }
            });
        }

        function loadCVData(cvData) {
            if (cvData.name) {
                $nameInput.val(cvData.name).trigger('input');
            }
            if (cvData.job_title) {
                $jobTitleInput.val(cvData.job_title).trigger('input');
            }
            if (cvData.email) {
                $emailInput.val(cvData.email).trigger('input');
            }
            if (cvData.phone) {
                $phoneInput.val(cvData.phone).trigger('input');
            }
            // Handle address - if we have combined address, try to split it, otherwise use individual fields
            if (cvData.address) {
                // Try to split combined address (format: "City, Country")
                const addressParts = cvData.address.split(',').map(s => s.trim());
                if (addressParts.length >= 2) {
                    $cityInput.val(addressParts[0] || '').trigger('input');
                    $countryInput.val(addressParts[1] || '').trigger('input');
                } else if (addressParts.length === 1) {
                    // If only one part, assume it's city
                    $cityInput.val(addressParts[0] || '').trigger('input');
                }
            }
            // Also check for individual fields (for backward compatibility)
            if (cvData.city) {
                $cityInput.val(cvData.city).trigger('input');
            }
            if (cvData.country) {
                $countryInput.val(cvData.country).trigger('input');
            }
            if (cvData.summary) {
                $summaryInput.val(cvData.summary).trigger('input');
            }
            if (cvData.photo) {
                photoData = cvData.photo;
                $photoPreview.attr('src', photoData);
                $photoPreviewContainer.show();
            } else {
                photoData = null;
                $photoPreview.attr('src', '');
                $photoPreviewContainer.hide();
            }

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
                        
                        // Attach event handlers
                        const debouncedHandler = debounce(handleFormChange, 300);
                        $newEntry.find('input, textarea, select').on('input change', debouncedHandler);
                    });

                    // Update entry count
                    sectionEntryCounts[sectionKey] = cvData[sectionKey].length;
                    
                    // Show/hide remove buttons based on entry count
                    if (cvData[sectionKey].length > 1) {
                        $entriesContainer.find('.btn-remove-entry').show();
                    } else {
                        $entriesContainer.find('.btn-remove-entry').hide();
                    }
                }
            });

            setTimeout(function() {
                const freshData = collectFormData();
                updatePreview(freshData);
            }, 500);
        }

        $loadSelect.on('change', function() {
            if ($(this).val()) {
                $loadBtn.show();
            } else {
                $loadBtn.hide();
            }
        });

        $loadBtn.on('click', function() {
            const cvId = $loadSelect.val();
            if (!cvId) return;

            $loadBtn.prop('disabled', true).text('Loading...');
            $loadMessage.hide().removeClass('success error');

            $.ajax({
                url: cvBuilderConfig.routes.load.replace('CV_ID', cvId),
                method: 'GET',
                success: function(response) {
                    if (response.success && response.cv) {
                        $('#cv-title').val(response.cv.title || '');

                        if (response.cv.cv_data) {
                            try {
                                loadCVData(response.cv.cv_data);

                                $loadMessage
                                    .removeClass('error')
                                    .addClass('success')
                                    .text('CV loaded successfully!')
                                    .fadeIn();
                            } catch (error) {
                                $loadMessage
                                    .removeClass('success')
                                    .addClass('error')
                                    .text('Error loading CV data: ' + error.message)
                                    .fadeIn();
                            }
                        } else {
                            $loadMessage
                                .removeClass('success')
                                .addClass('error')
                                .text('CV data is empty')
                                .fadeIn();
                        }
                    } else {
                        $loadMessage
                            .removeClass('success')
                            .addClass('error')
                            .text(response.message || 'Error loading CV')
                            .fadeIn();
                    }
                    setTimeout(function() {
                        $loadBtn.prop('disabled', false).text('Load CV');
                    }, 100);
                },
                error: function(xhr) {
                    let errorMessage = 'Error loading CV. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    $loadMessage
                        .addClass('error')
                        .text(errorMessage)
                        .fadeIn();
                    $loadBtn.prop('disabled', false).text('Load CV');
                }
            });
        });

        loadSavedCVsList();

        // Modal functions
        function populateModal() {
            const $sectionsList = $('#sections-list');
            $sectionsList.empty();

            Object.keys(availableSections).forEach(function(sectionKey) {
                const section = availableSections[sectionKey];
                const isAdded = addedSections.has(sectionKey);

                const $option = $('<div class="section-option">')
                    .append(
                        $('<input>')
                            .attr('type', 'checkbox')
                            .attr('id', 'section-' + sectionKey)
                            .attr('data-section-key', sectionKey)
                            .prop('disabled', isAdded)
                            .prop('checked', isAdded)
                    )
                    .append(
                        $('<label>')
                            .attr('for', 'section-' + sectionKey)
                            .html(section.icon + ' ' + section.name + (isAdded ? ' <span style="color: green;">(Added)</span>' : ''))
                    );

                $sectionsList.append($option);
            });
        }

        function openModal() {
            populateModal();
            $('#add-sections-modal').addClass('active');
        }

        function closeModal() {
            $('#add-sections-modal').removeClass('active');
            $('#sections-list input[type="checkbox"]').prop('checked', false);
        }

        $('#btn-add-sections').on('click', openModal);
        $('#btn-close-modal').on('click', closeModal);
        $('#add-sections-modal').on('click', function(e) {
            if ($(e.target).hasClass('modal-overlay')) {
                closeModal();
            }
        });

        // Generate a single entry form for a section
        function generateEntryFields(sectionKey, sectionConfig, entryIndex) {
            const $entryContainer = $('<div>')
                .addClass('entry-container')
                .attr('data-entry-index', entryIndex);

            const $entryHeader = $('<div>')
                .addClass('entry-header')
                .append(
                    $('<h5>').html(sectionConfig.name + ' Entry #' + (entryIndex + 1))
                );

            // Add remove entry button (only show if more than 1 entry)
            const $removeEntryBtn = $('<button>')
                .addClass('btn-remove-entry')
                .attr('type', 'button')
                .html('🗑️ Remove Entry')
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
                const $label = $('<label>').text(field.label);
                $formGroup.append($label);

                if (field.type === 'textarea') {
                    const $input = $('<textarea>')
                        .attr('name', sectionKey + '[' + entryIndex + '][' + field.name + ']')
                        .attr('placeholder', field.placeholder || '')
                        .addClass('form-control');
                    $formGroup.append($input);
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
                    const $input = $('<input>')
                        .attr('type', field.type)
                        .attr('name', sectionKey + '[' + entryIndex + '][' + field.name + ']')
                        .attr('placeholder', field.placeholder || '')
                        .addClass('form-control');
                    $formGroup.append($input);
                }

                $entryContainer.append($formGroup);
            });

            return $entryContainer;
        }

        // Generate section container with first entry
        function generateSectionFields(sectionKey, sectionConfig) {
            const sectionId = 'section-' + sectionKey;
            const $sectionContainer = $('<div>')
                .addClass('added-section')
                .attr('id', sectionId)
                .attr('data-section-key', sectionKey);

            const $sectionHeader = $('<div>')
                .addClass('section-header')
                .append(
                    $('<h4>').html(sectionConfig.icon + ' ' + sectionConfig.name)
                )
                .append(
                    $('<button>')
                        .addClass('btn-remove-section')
                        .attr('type', 'button')
                        .text('Remove Section')
                        .on('click', function() {
                            removeSection(sectionKey);
                        })
                );

            $sectionContainer.append($sectionHeader);

            // Create entries container
            const $entriesContainer = $('<div>')
                .addClass('entries-container')
                .attr('data-section-key', sectionKey);
            $sectionContainer.append($entriesContainer);

            // Initialize entry count for this section
            sectionEntryCounts[sectionKey] = 1;

            // Add first entry
            const $firstEntry = generateEntryFields(sectionKey, sectionConfig, 0);
            $entriesContainer.append($firstEntry);

            // Add "Add Another Entry" button
            const $addEntryBtn = $('<button>')
                .addClass('btn-add-entry')
                .attr('type', 'button')
                .html('➕ Add Another ' + sectionConfig.name)
                .on('click', function() {
                    addEntryToSection(sectionKey, sectionConfig);
                });

            $sectionContainer.append($addEntryBtn);

            // Attach event handlers to form fields
            const debouncedHandler = debounce(handleFormChange, 300);
            $sectionContainer.find('input, textarea, select').on('input change', debouncedHandler);

            return $sectionContainer;
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

            // Update preview
            handleFormChange();
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

        $('#btn-add-selected-sections').on('click', function() {
            const selectedSections = [];

            $('#sections-list input[type="checkbox"]:checked').each(function() {
                const sectionKey = $(this).data('section-key');
                if (sectionKey && !addedSections.has(sectionKey)) {
                    selectedSections.push(sectionKey);
                }
            });

            if (selectedSections.length === 0) {
                alert('Please select at least one section to add.');
                return;
            }

            selectedSections.forEach(function(sectionKey) {
                const sectionConfig = availableSections[sectionKey];
                const $sectionFields = generateSectionFields(sectionKey, sectionConfig);

                $('#btn-add-sections').before($sectionFields);
                addedSections.add(sectionKey);

                const debouncedHandler = debounce(handleFormChange, 300);
                $sectionFields.find('input, textarea').on('input change', debouncedHandler);
            });

            handleFormChange();
            closeModal();
        });

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

        // Save CV functionality
        $('#btn-save-cv').on('click', function() {
            const $btn = $(this);
            const $message = $('#save-message');
            const cvTitle = $('#cv-title').val() || 'My CV';

            $btn.prop('disabled', true).text('Saving...');
            $message.hide().removeClass('success error');

            const cvData = collectFormData();
            
            // Get CSRF token from meta tag (fresh token) or use config token
            const csrfToken = $('meta[name="csrf-token"]').attr('content') || cvBuilderConfig.csrfToken;

            $.ajax({
                url: cvBuilderConfig.routes.save,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    _token: csrfToken,
                    template_slug: cvBuilderConfig.templateSlug,
                    title: cvTitle,
                    cv_data: cvData
                },
                success: function(response) {
                    if (response.success) {
                        $message
                            .addClass('success')
                            .text(response.message)
                            .fadeIn();

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
                    } else if (xhr.status === 419) {
                        errorMessage = 'Session expired. Please refresh the page and try again.';
                    }

                    $message
                        .addClass('error')
                        .text(errorMessage)
                        .fadeIn();
                    $btn.prop('disabled', false).text('💾 Save CV');
                }
            });
        });

        // Export PDF functionality
        $('#btn-export-pdf').on('click', function() {
            const $btn = $(this);
            const $message = $('#export-message');
            
            $btn.prop('disabled', true).html('⏳ Generating PDF...');
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
                $btn.prop('disabled', false).html('📄 Download PDF');
            }, 3000);
        });
    }

    // Expose to global scope
    window.CVBuilder = {
        init: initCVBuilder
    };

})(jQuery);

