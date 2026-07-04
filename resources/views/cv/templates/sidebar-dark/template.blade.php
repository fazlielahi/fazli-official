{{-- Sidebar Dark CV Template --}}
@php
    $name = $data['name'] ?? 'Your Name';
    $location = trim(($data['city'] ?? '') . ((isset($data['city'], $data['country']) && $data['city'] !== '' && $data['country'] !== '') ? ', ' : '') . ($data['country'] ?? ''));
    $fontOptions = [
        'classic' => 'Arial, Helvetica, sans-serif',
        'georgia' => 'Georgia, "Times New Roman", serif',
        'arial' => 'Arial, Helvetica, sans-serif',
        'inter' => 'Inter, Arial, Helvetica, sans-serif',
        'poppins' => 'Poppins, Arial, Helvetica, sans-serif',
        'roboto' => 'Roboto, Arial, Helvetica, sans-serif',
    ];
    $fontKey = isset($data['font_family']) && is_string($data['font_family']) && array_key_exists($data['font_family'], $fontOptions)
        ? $data['font_family']
        : 'arial';
    $fontStack = $fontOptions[$fontKey];
@endphp

<div class="cv-template sidebar-dark" style="--cv-font-family: {{ $fontStack }}; --cv-heading-font-family: {{ $fontStack }};">
    <div class="cv-page">
        <aside class="sidebar-panel">
            <div class="photo-box">
                <div class="profile-placeholder">
                    @if(isset($data['photo']) && !empty($data['photo']))
                        <img src="{{ $data['photo'] }}" alt="Profile Photo" class="profile-photo">
                    @else
                        @php
                            $nameParts = array_filter(explode(' ', trim($name)));
                            $firstInitial = !empty($nameParts) ? strtoupper(substr(reset($nameParts), 0, 1)) : 'Y';
                            $lastInitial = count($nameParts) > 1 ? strtoupper(substr(end($nameParts), 0, 1)) : 'N';
                        @endphp
                        <span class="initials">{{ $firstInitial }}{{ $lastInitial }}</span>
                    @endif
                </div>
            </div>

            <header class="cv-header">
                <h1 class="name">{{ $name }}</h1>
                <p class="subtitle">{{ $data['job_title'] ?? 'Software Engineer' }}</p>
            </header>

            <div class="sidebar-content">
                <section class="contact">
                    <h2 class="section-title">CONTACT</h2>
                    <div class="section-content">
                        <div class="contact-info">
                            @if(isset($data['phone']) && !empty($data['phone']))
                                <div class="contact-item">
                                    <span class="contact-icon"><i class="fas fa-phone"></i></span>
                                    <span class="contact-text-wrapper"><span class="contact-text">{{ $data['phone'] }}</span></span>
                                </div>
                            @endif
                            @if(isset($data['email']) && !empty($data['email']))
                                <div class="contact-item">
                                    <span class="contact-icon"><i class="fas fa-envelope"></i></span>
                                    <span class="contact-text-wrapper"><span class="contact-text">{{ $data['email'] }}</span></span>
                                </div>
                            @endif
                            @if($location !== '')
                                <div class="contact-item">
                                    <span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span>
                                    <span class="contact-text-wrapper"><span class="contact-text">{{ $location }}</span></span>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                @if(isset($data['skills']) && count($data['skills']) > 0)
                    <section class="skills">
                        <h2 class="section-title">SKILLS</h2>
                        <div class="section-content">
                            <ul class="skills-list">
                                @foreach($data['skills'] as $skill)
                                    @if(isset($skill['is_hidden']) && (string) $skill['is_hidden'] === '1')
                                        @continue
                                    @endif
                                    <li class="skill-item">{{ $skill['skill'] ?? 'Skill' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </section>
                @endif

                @if(isset($data['languages']) && count($data['languages']) > 0)
                    <section class="languages">
                        <h2 class="section-title">LANGUAGES</h2>
                        <div class="section-content">
                            <ul class="languages-list">
                                @foreach($data['languages'] as $lang)
                                    @if(isset($lang['is_hidden']) && (string) $lang['is_hidden'] === '1')
                                        @continue
                                    @endif
                                    <li class="language-item">
                                        <span class="language-name">{{ $lang['language'] ?? 'Language' }}</span>
                                        @if(isset($lang['proficiency']) && !empty($lang['proficiency']))
                                            <span class="language-proficiency">{{ $lang['proficiency'] }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </section>
                @endif

                @if(isset($data['references']) && count($data['references']) > 0)
                    <section class="references">
                        <h2 class="section-title">REFERENCES</h2>
                        <div class="section-content">
                            @foreach($data['references'] as $ref)
                                @if(isset($ref['is_hidden']) && (string) $ref['is_hidden'] === '1')
                                    @continue
                                @endif
                                <div class="reference-item">
                                    <strong>{{ $ref['name'] ?? 'Name' }}</strong>
                                    @if(isset($ref['position']) && !empty($ref['position']))
                                        <span>{{ $ref['position'] }}</span>
                                    @endif
                                    @if(isset($ref['phone']) && !empty($ref['phone']))
                                        <span>{{ $ref['phone'] }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>
        </aside>

        <main class="right-content">
            @if(isset($data['summary']) && !empty($data['summary']))
                <section class="summary">
                    <h2 class="section-title">PROFILE</h2>
                    <div class="section-content">
                        <p>{{ $data['summary'] }}</p>
                    </div>
                </section>
            @endif

            @if(isset($data['experience']) && count($data['experience']) > 0)
                <section class="experience">
                    <h2 class="section-title">WORK EXPERIENCE</h2>
                    <div class="section-content">
                        @foreach($data['experience'] as $exp)
                            @if(isset($exp['is_hidden']) && (string) $exp['is_hidden'] === '1')
                                @continue
                            @endif
                            <div class="experience-item">
                                <div class="item-title-row">
                                    <h3 class="item-title">{{ $exp['title'] ?? $exp['position'] ?? 'Position' }}</h3>
                                    @if(isset($exp['period']) && !empty($exp['period']))
                                        <span class="item-period">{{ $exp['period'] }}</span>
                                    @endif
                                </div>
                                <p class="item-company">{{ $exp['company'] ?? 'Company' }}{{ isset($exp['location']) && !empty($exp['location']) ? ' - ' . $exp['location'] : '' }}</p>
                                @if(isset($exp['description']) && !empty($exp['description']))
                                    <div class="item-description">{!! $exp['description'] !!}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if(isset($data['education']) && count($data['education']) > 0)
                <section class="education">
                    <h2 class="section-title">EDUCATION</h2>
                    <div class="section-content">
                        @foreach($data['education'] as $edu)
                            @if(isset($edu['is_hidden']) && (string) $edu['is_hidden'] === '1')
                                @continue
                            @endif
                            <div class="education-item">
                                <h3 class="item-title">{{ $edu['degree'] ?? 'Degree' }}</h3>
                                @if(isset($edu['period']) && !empty($edu['period']))
                                    <p class="item-period">{{ $edu['period'] }}</p>
                                @endif
                                <p class="item-company">{{ $edu['institution'] ?? 'Institution' }}{{ isset($edu['location']) && !empty($edu['location']) ? ', ' . $edu['location'] : '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if(isset($data['projects']) && count($data['projects']) > 0)
                <section class="projects">
                    <h2 class="section-title">PROJECTS</h2>
                    <div class="section-content">
                        @foreach($data['projects'] as $project)
                            @if(isset($project['is_hidden']) && (string) $project['is_hidden'] === '1')
                                @continue
                            @endif
                            <div class="project-item">
                                <h3 class="item-title">{{ $project['name'] ?? 'Project' }}</h3>
                                @if(isset($project['description']) && !empty($project['description']))
                                    <div class="item-description">{!! $project['description'] !!}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @if(isset($data['awards']) && count($data['awards']) > 0)
                <section class="awards">
                    <h2 class="section-title">ACHIEVEMENTS</h2>
                    <div class="section-content">
                        @foreach($data['awards'] as $award)
                            @if(isset($award['is_hidden']) && (string) $award['is_hidden'] === '1')
                                @continue
                            @endif
                            <div class="award-item">
                                <h3 class="item-title">{{ $award['title'] ?? 'Achievement' }}</h3>
                                @if(isset($award['description']) && !empty($award['description']))
                                    <div class="item-description">{!! $award['description'] !!}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            @include('cv.templates.partials.custom-section', ['data' => $data])

            @if(isset($data['certifications']) && count($data['certifications']) > 0)
                <section class="certifications">
                    <h2 class="section-title">CERTIFICATIONS</h2>
                    <div class="section-content">
                        @foreach($data['certifications'] as $cert)
                            @if(isset($cert['is_hidden']) && (string) $cert['is_hidden'] === '1')
                                @continue
                            @endif
                            <div class="certification-item">
                                <h3 class="item-title">{{ $cert['name'] ?? 'Certification Name' }}</h3>
                                @if(isset($cert['issuer']) && !empty($cert['issuer']))
                                    <p class="item-company">{{ $cert['issuer'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>
    </div>
</div>
