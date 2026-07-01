{{-- Professional CV Template - compact two-column executive layout --}}
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

<div class="cv-template professional" style="--cv-font-family: {{ $fontStack }}; --cv-heading-font-family: {{ $fontStack }};">
    <div class="cv-page">
        <header class="cv-header">
            <h1 class="name">{{ $name }}</h1>
            <p class="subtitle">{{ $data['job_title'] ?? 'Professional' }}</p>
            <div class="contact-info">
                @if(isset($data['phone']) && !empty($data['phone']))
                    <span class="contact-item"><i class="fas fa-phone"></i> {{ $data['phone'] }}</span>
                @endif
                @if(isset($data['email']) && !empty($data['email']))
                    <span class="contact-item"><i class="fas fa-envelope"></i> {{ $data['email'] }}</span>
                @endif
                @if($location !== '')
                    <span class="contact-item"><i class="fas fa-map-marker-alt"></i> {{ $location }}</span>
                @endif
                @if(isset($data['linkedin']) && !empty($data['linkedin']))
                    <span class="contact-item"><i class="fab fa-linkedin"></i> {{ $data['linkedin'] }}</span>
                @endif
            </div>
        </header>

        <main class="professional-columns">
            <div class="primary-column">
                @if(isset($data['summary']) && !empty($data['summary']))
                    <section class="summary">
                        <h2 class="section-title">SUMMARY</h2>
                        <div class="section-content">
                            <p>{{ $data['summary'] }}</p>
                        </div>
                    </section>
                @endif

                @if(isset($data['experience']) && count($data['experience']) > 0)
                    <section class="experience">
                        <h2 class="section-title">EXPERIENCE</h2>
                        <div class="section-content">
                            @foreach($data['experience'] as $exp)
                                @if(isset($exp['is_hidden']) && (string) $exp['is_hidden'] === '1')
                                    @continue
                                @endif
                                <div class="experience-item">
                                    <h3 class="item-title">{{ $exp['title'] ?? $exp['position'] ?? 'Position' }}</h3>
                                    <div class="item-meta">
                                        <span>{{ $exp['company'] ?? 'Company' }}</span>
                                        @if(isset($exp['period']) && !empty($exp['period']))
                                            <span>{{ $exp['period'] }}</span>
                                        @endif
                                        @if(isset($exp['location']) && !empty($exp['location']))
                                            <span>{{ $exp['location'] }}</span>
                                        @endif
                                    </div>
                                    @if(isset($exp['description']) && !empty($exp['description']))
                                        <div class="item-description">{!! $exp['description'] !!}</div>
                                    @endif
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
            </div>

            <aside class="secondary-column">
                @if(isset($data['awards']) && count($data['awards']) > 0)
                    <section class="awards">
                        <h2 class="section-title">KEY ACHIEVEMENTS</h2>
                        <div class="section-content">
                            @foreach($data['awards'] as $award)
                                @if(isset($award['is_hidden']) && (string) $award['is_hidden'] === '1')
                                    @continue
                                @endif
                                <div class="award-item">
                                    <h3 class="item-title">{{ $award['title'] ?? 'Achievement' }}</h3>
                                    @if(isset($award['organization']) && !empty($award['organization']))
                                        <p class="item-organization">{{ $award['organization'] }}</p>
                                    @endif
                                    @if(isset($award['description']) && !empty($award['description']))
                                        <div class="item-description">{!! $award['description'] !!}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if(isset($data['skills']) && count($data['skills']) > 0)
                    <section class="skills">
                        <h2 class="section-title">SKILLS</h2>
                        <div class="section-content">
                            <div class="skills-list">
                                @foreach($data['skills'] as $skill)
                                    @if(isset($skill['is_hidden']) && (string) $skill['is_hidden'] === '1')
                                        @continue
                                    @endif
                                    <span class="skill-item">{{ $skill['skill'] ?? 'Skill' }}</span>
                                @endforeach
                            </div>
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
                                    <p class="item-institution">{{ $edu['institution'] ?? 'Institution' }}</p>
                                    @if(isset($edu['period']) && !empty($edu['period']))
                                        <p class="item-period">{{ $edu['period'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if(isset($data['certifications']) && count($data['certifications']) > 0)
                    <section class="certifications">
                        <h2 class="section-title">TRAINING / COURSES</h2>
                        <div class="section-content">
                            @foreach($data['certifications'] as $cert)
                                @if(isset($cert['is_hidden']) && (string) $cert['is_hidden'] === '1')
                                    @continue
                                @endif
                                <div class="certification-item">
                                    <h3 class="item-title">{{ $cert['name'] ?? 'Certification Name' }}</h3>
                                    @if(isset($cert['issuer']) && !empty($cert['issuer']))
                                        <p class="item-issuer">{{ $cert['issuer'] }}</p>
                                    @endif
                                    @if(isset($cert['date']) && !empty($cert['date']))
                                        <p class="item-period">{{ $cert['date'] }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if(isset($data['languages']) && count($data['languages']) > 0)
                    <section class="languages">
                        <h2 class="section-title">LANGUAGES</h2>
                        <div class="section-content">
                            <div class="languages-list">
                                @foreach($data['languages'] as $lang)
                                    @if(isset($lang['is_hidden']) && (string) $lang['is_hidden'] === '1')
                                        @continue
                                    @endif
                                    <span class="language-item">{{ $lang['language'] ?? 'Language' }}{{ isset($lang['proficiency']) && $lang['proficiency'] !== '' ? ' - ' . $lang['proficiency'] : '' }}</span>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif
            </aside>
        </main>
    </div>
</div>
