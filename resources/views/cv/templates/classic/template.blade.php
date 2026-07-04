{{-- Classic CV Template - formal single-column resume --}}
@php
    $name = $data['name'] ?? 'Your Name';
    $location = trim(($data['city'] ?? '') . ((isset($data['city'], $data['country']) && $data['city'] !== '' && $data['country'] !== '') ? ', ' : '') . ($data['country'] ?? ''));
    $defaultSectionOrder = ['experience', 'education', 'awards', 'projects', 'skills', 'languages', 'certifications', 'references', 'custom'];
    $savedLayoutOrder = isset($data['section_layout']['main']) && is_array($data['section_layout']['main']) ? $data['section_layout']['main'] : [];
    $savedSectionOrder = !empty($savedLayoutOrder)
        ? $savedLayoutOrder
        : (isset($data['section_order']) && is_array($data['section_order']) ? $data['section_order'] : []);
    $sectionOrder = array_values(array_unique(array_merge(
        array_values(array_filter($savedSectionOrder, fn ($key) => in_array($key, $defaultSectionOrder, true))),
        $defaultSectionOrder
    )));
    $sectionOrderMap = array_flip($sectionOrder);
    $sectionStyle = fn ($key) => 'order: ' . (($sectionOrderMap[$key] ?? 99) + 1) . ';';
    $fontOptions = [
        'classic' => '"Times New Roman", Times, serif',
        'georgia' => 'Georgia, "Times New Roman", serif',
        'arial' => 'Arial, Helvetica, sans-serif',
        'inter' => 'Inter, Arial, Helvetica, sans-serif',
        'poppins' => 'Poppins, Arial, Helvetica, sans-serif',
        'roboto' => 'Roboto, Arial, Helvetica, sans-serif',
    ];
    $fontKey = isset($data['font_family']) && is_string($data['font_family']) && array_key_exists($data['font_family'], $fontOptions)
        ? $data['font_family']
        : 'classic';
    $fontStack = $fontOptions[$fontKey];
@endphp

<div class="cv-template classic" style="--cv-font-family: {{ $fontStack }}; --cv-heading-font-family: {{ $fontStack }};">
    <div class="cv-page">
        <header class="cv-header">
            <h1 class="name">{{ $name }}</h1>
            <p class="subtitle">{{ $data['job_title'] ?? 'Professional' }}</p>
            <div class="contact-info">
                @if(isset($data['phone']) && !empty($data['phone']))
                    <span class="contact-item contact-item--phone">
                        <span class="contact-icon"><i class="fas fa-phone"></i></span>
                        <span class="contact-text">{{ $data['phone'] }}</span>
                    </span>
                @endif
                @if(isset($data['email']) && !empty($data['email']))
                    <span class="contact-item contact-item--email">
                        <span class="contact-icon"><i class="fas fa-envelope"></i></span>
                        <span class="contact-text">{{ $data['email'] }}</span>
                    </span>
                @endif
                @if($location !== '')
                    <span class="contact-item contact-item--location">
                        <span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span>
                        <span class="contact-text">{{ $location }}</span>
                    </span>
                @endif
            </div>
        </header>

        <main class="cv-body">
            @if(isset($data['summary']) && !empty($data['summary']))
                <section class="summary">
                    <h2 class="section-title">PROFILE</h2>
                    <div class="section-content">
                        <p>{{ $data['summary'] }}</p>
                    </div>
                </section>
            @endif

            @if(isset($data['experience']) && count($data['experience']) > 0)
                <section class="experience" style="{{ $sectionStyle('experience') }}">
                    <h2 class="section-title">EXPERIENCE</h2>
                    <div class="section-content">
                        @foreach($data['experience'] as $exp)
                            @if(isset($exp['is_hidden']) && (string) $exp['is_hidden'] === '1')
                                @continue
                            @endif
                            <div class="experience-item timeline-item">
                                <div class="item-period">{{ $exp['period'] ?? 'Period' }}</div>
                                <div class="item-main">
                                    <div class="item-title-row">
                                        <h3 class="item-title">{{ $exp['title'] ?? $exp['position'] ?? 'Position' }}</h3>
                                        @if(isset($exp['location']) && !empty($exp['location']))
                                            <span class="item-location">{{ $exp['location'] }}</span>
                                        @endif
                                    </div>
                                    <p class="item-company">{{ $exp['company'] ?? 'Company' }}</p>
                                    @if(isset($exp['description']) && !empty($exp['description']))
                                        <div class="item-description">{!! $exp['description'] !!}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if(isset($data['education']) && count($data['education']) > 0)
                <section class="education" style="{{ $sectionStyle('education') }}">
                    <h2 class="section-title">EDUCATION</h2>
                    <div class="section-content">
                        @foreach($data['education'] as $edu)
                            @if(isset($edu['is_hidden']) && (string) $edu['is_hidden'] === '1')
                                @continue
                            @endif
                            <div class="education-item timeline-item">
                                <div class="item-period">{{ $edu['period'] ?? 'Period' }}</div>
                                <div class="item-main">
                                    <div class="item-title-row">
                                        <h3 class="item-title">{{ $edu['degree'] ?? 'Degree' }}</h3>
                                        @if(isset($edu['location']) && !empty($edu['location']))
                                            <span class="item-location">{{ $edu['location'] }}</span>
                                        @endif
                                    </div>
                                    <p class="item-institution">{{ $edu['institution'] ?? 'Institution' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if(isset($data['awards']) && count($data['awards']) > 0)
                <section class="awards" style="{{ $sectionStyle('awards') }}">
                    <h2 class="section-title">AWARDS</h2>
                    <div class="section-content">
                        @foreach($data['awards'] as $award)
                            @if(isset($award['is_hidden']) && (string) $award['is_hidden'] === '1')
                                @continue
                            @endif
                            <div class="award-item timeline-item">
                                <div class="item-period">{{ $award['period'] ?? '' }}</div>
                                <div class="item-main">
                                    <h3 class="item-title">{{ $award['title'] ?? 'Award' }}</h3>
                                    @if(isset($award['organization']) && !empty($award['organization']))
                                        <p class="item-organization">{{ $award['organization'] }}</p>
                                    @endif
                                    @if(isset($award['description']) && !empty($award['description']))
                                        <div class="item-description">{!! $award['description'] !!}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if(isset($data['projects']) && count($data['projects']) > 0)
                <section class="projects" style="{{ $sectionStyle('projects') }}">
                    <h2 class="section-title">PROJECTS</h2>
                    <div class="section-content">
                        @foreach($data['projects'] as $project)
                            @if(isset($project['is_hidden']) && (string) $project['is_hidden'] === '1')
                                @continue
                            @endif
                            <div class="project-item timeline-item">
                                <div class="item-main">
                                    <h3 class="item-title">{{ $project['name'] ?? 'Project' }}</h3>
                                    @if(isset($project['description']) && !empty($project['description']))
                                        <div class="item-description">{!! $project['description'] !!}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if(isset($data['skills']) && count($data['skills']) > 0)
                <section class="skills" style="{{ $sectionStyle('skills') }}">
                    <h2 class="section-title">SKILLS</h2>
                    <div class="section-content">
                        <div class="skills-list">
                            @foreach($data['skills'] as $skill)
                                @if(isset($skill['is_hidden']) && (string) $skill['is_hidden'] === '1')
                                    @continue
                                @endif
                                <div class="skill-item">
                                    <span class="skill-name">{{ $skill['skill'] ?? 'Skill' }}</span>
                                    @if(isset($skill['level']) && !empty($skill['level']))
                                        <span class="skill-level-badge">{{ $skill['level'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            @if(isset($data['languages']) && count($data['languages']) > 0)
                <section class="languages" style="{{ $sectionStyle('languages') }}">
                    <h2 class="section-title">LANGUAGES</h2>
                    <div class="section-content">
                        <div class="languages-list">
                            @foreach($data['languages'] as $lang)
                                @if(isset($lang['is_hidden']) && (string) $lang['is_hidden'] === '1')
                                    @continue
                                @endif
                                <div class="language-item">
                                    <span class="language-name">{{ $lang['language'] ?? 'Language' }}</span>
                                    @if(isset($lang['proficiency']) && !empty($lang['proficiency']))
                                        <span class="language-proficiency-badge">{{ $lang['proficiency'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            @if(isset($data['certifications']) && count($data['certifications']) > 0)
                <section class="certifications" style="{{ $sectionStyle('certifications') }}">
                    <h2 class="section-title">CERTIFICATIONS</h2>
                    <div class="section-content">
                        @foreach($data['certifications'] as $cert)
                            @if(isset($cert['is_hidden']) && (string) $cert['is_hidden'] === '1')
                                @continue
                            @endif
                            <div class="certification-item timeline-item">
                                <div class="item-period">{{ $cert['date'] ?? '' }}</div>
                                <div class="item-main">
                                    <h3 class="item-title">{{ $cert['name'] ?? 'Certification Name' }}</h3>
                                    @if(isset($cert['issuer']) && !empty($cert['issuer']))
                                        <p class="item-issuer">{{ $cert['issuer'] }}</p>
                                    @endif
                                    @if(isset($cert['credential_id']) && !empty($cert['credential_id']))
                                        <p class="item-credential">Credential ID: {{ $cert['credential_id'] }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @include('cv.templates.partials.custom-section', ['data' => $data, 'sectionStyle' => $sectionStyle])

            @if(isset($data['references']) && count($data['references']) > 0)
                <section class="references" style="{{ $sectionStyle('references') }}">
                    <h2 class="section-title">REFERENCES</h2>
                    <div class="section-content">
                        <div class="references-list">
                            @foreach($data['references'] as $ref)
                                @if(isset($ref['is_hidden']) && (string) $ref['is_hidden'] === '1')
                                    @continue
                                @endif
                                <div class="reference-item">
                                    <div class="ref-name">{{ $ref['name'] ?? 'Name' }}</div>
                                    <div class="ref-position">{{ $ref['position'] ?? 'Position' }}</div>
                                    <div class="ref-company">{{ $ref['company'] ?? 'Company' }}</div>
                                    @if(isset($ref['email']) && !empty($ref['email']))
                                        <div class="ref-email">{{ $ref['email'] }}</div>
                                    @endif
                                    @if(isset($ref['phone']) && !empty($ref['phone']))
                                        <div class="ref-phone">{{ $ref['phone'] }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif
        </main>
    </div>
</div>
