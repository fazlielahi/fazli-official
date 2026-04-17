{{-- Classic CV Template --}}
<div class="cv-template classic">
    <div class="cv-header">
        <div class="header-content">
            <h1 class="name">{{ $data['name'] ?? 'Your Name' }}</h1>
            <div class="contact-info">
                @if(isset($data['email']) && !empty($data['email']))
                    <span class="contact-item">{{ $data['email'] }}</span>
                @endif
                @if(isset($data['phone']) && !empty($data['phone']))
                    <span class="contact-separator">|</span>
                    <span class="contact-item">{{ $data['phone'] }}</span>
                @endif
            </div>
        </div>
    </div>
    
    <div class="cv-body">
        @if(isset($data['summary']) && !empty($data['summary']))
        <section class="summary">
            <h2 class="section-title">Professional Summary</h2>
            <div class="section-content">
                <p>{{ $data['summary'] }}</p>
            </div>
        </section>
        @endif
        
        @if(isset($data['experience']) && count($data['experience']) > 0)
        <section class="experience">
            <h2 class="section-title">Professional Experience</h2>
            <div class="section-content">
                @foreach($data['experience'] as $exp)
                @if(isset($exp['is_hidden']) && (string) $exp['is_hidden'] === '1')
                    @continue
                @endif
                <div class="experience-item">
                    <div class="item-header">
                        <div class="item-title-row">
                            <h3 class="item-title">{{ $exp['title'] ?? 'Job Title' }}</h3>
                            <span class="item-period">{{ $exp['period'] ?? 'Period' }}</span>
                        </div>
                        <p class="item-company">{{ $exp['company'] ?? 'Company Name' }}</p>
                    </div>
                    @if(isset($exp['description']) && !empty($exp['description']))
                    <div class="item-description">
                        {!! $exp['description'] !!}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </section>
        @endif
        
        @if(isset($data['education']) && count($data['education']) > 0)
        <section class="education">
            <h2 class="section-title">Education</h2>
            <div class="section-content">
                @foreach($data['education'] as $edu)
                @if(isset($edu['is_hidden']) && (string) $edu['is_hidden'] === '1')
                    @continue
                @endif
                <div class="education-item">
                    <div class="item-header">
                        <div class="item-title-row">
                            <h3 class="item-title">{{ $edu['degree'] ?? 'Degree' }}</h3>
                            <div class="item-meta">
                                <span class="item-period">{{ $edu['period'] ?? 'Period' }}</span>
                                @if(isset($edu['location']) && !empty($edu['location']))
                                    <span class="item-location">{{ $edu['location'] }}</span>
                                @endif
                            </div>
                        </div>
                        <p class="item-institution">{{ $edu['institution'] ?? 'Institution' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif
        
        @if(isset($data['skills']) && count($data['skills']) > 0)
        <section class="skills">
            <h2 class="section-title">Skills</h2>
            <div class="section-content">
                <div class="skills-list">
                    @foreach($data['skills'] as $skill)
                    @if(isset($skill['is_hidden']) && (string) $skill['is_hidden'] === '1')
                        @continue
                    @endif
                    <span class="skill-item">
                        {{ $skill['skill'] ?? 'Skill' }}
                        @if(isset($skill['level']) && !empty($skill['level']))
                            <span class="skill-level">({{ $skill['level'] }})</span>
                        @endif
                    </span>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        
        @if(isset($data['certifications']) && count($data['certifications']) > 0)
        <section class="certifications">
            <h2 class="section-title">Certifications</h2>
            <div class="section-content">
                @foreach($data['certifications'] as $cert)
                @if(isset($cert['is_hidden']) && (string) $cert['is_hidden'] === '1')
                    @continue
                @endif
                <div class="certification-item">
                    <div class="item-header">
                        <div class="item-title-row">
                            <h3 class="item-title">{{ $cert['name'] ?? 'Certification Name' }}</h3>
                            <span class="item-period">{{ $cert['date'] ?? 'Date' }}</span>
                        </div>
                        <p class="item-issuer">{{ $cert['issuer'] ?? 'Issuing Organization' }}</p>
                        @if(isset($cert['credential_id']) && !empty($cert['credential_id']))
                            <p class="item-credential">Credential ID: {{ $cert['credential_id'] }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif
        
        @if(isset($data['projects']) && count($data['projects']) > 0)
        <section class="projects">
            <h2 class="section-title">Projects</h2>
            <div class="section-content">
                @foreach($data['projects'] as $project)
                @if(isset($project['is_hidden']) && (string) $project['is_hidden'] === '1')
                    @continue
                @endif
                <div class="project-item">
                    <div class="item-header">
                        <div class="item-title-row">
                            <h3 class="item-title">{{ $project['name'] ?? 'Project Name' }}</h3>
                            @if(isset($project['link']) && !empty($project['link']))
                                <a href="{{ $project['link'] }}" target="_blank" class="project-link">View Project</a>
                            @endif
                        </div>
                        @if(isset($project['technologies']) && !empty($project['technologies']))
                            <p class="item-technologies">{{ $project['technologies'] }}</p>
                        @endif
                    </div>
                    @if(isset($project['description']) && !empty($project['description']))
                    <div class="item-description">
                        {!! $project['description'] !!}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </section>
        @endif
        
        @if(isset($data['languages']) && count($data['languages']) > 0)
        <section class="languages">
            <h2 class="section-title">Languages</h2>
            <div class="section-content">
                <div class="languages-list">
                    @foreach($data['languages'] as $lang)
                    @if(isset($lang['is_hidden']) && (string) $lang['is_hidden'] === '1')
                        @continue
                    @endif
                    <div class="language-item">
                        <span class="language-name">{{ $lang['language'] ?? 'Language' }}</span>
                        @if(isset($lang['proficiency']) && !empty($lang['proficiency']))
                            <span class="language-proficiency">- {{ $lang['proficiency'] }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        
        @if(isset($data['awards']) && count($data['awards']) > 0)
        <section class="awards">
            <h2 class="section-title">Awards & Recognition</h2>
            <div class="section-content">
                @foreach($data['awards'] as $award)
                @if(isset($award['is_hidden']) && (string) $award['is_hidden'] === '1')
                    @continue
                @endif
                <div class="award-item">
                    <div class="item-header">
                        <div class="item-title-row">
                            <h3 class="item-title">{{ $award['title'] ?? 'Award Title' }}</h3>
                            <span class="item-period">{{ $award['date'] ?? 'Date' }}</span>
                        </div>
                        <p class="item-organization">{{ $award['organization'] ?? 'Organization' }}</p>
                    </div>
                    @if(isset($award['description']) && !empty($award['description']))
                    <div class="item-description">
                        {!! $award['description'] !!}
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </section>
        @endif
        
        @if(isset($data['references']) && count($data['references']) > 0)
        <section class="references">
            <h2 class="section-title">References</h2>
            <div class="section-content">
                <div class="references-list">
                    @foreach($data['references'] as $ref)
                    @if(isset($ref['is_hidden']) && (string) $ref['is_hidden'] === '1')
                        @continue
                    @endif
                    <div class="reference-item">
                        <h3 class="ref-name">{{ $ref['name'] ?? 'Name' }}</h3>
                        <p class="ref-position">{{ $ref['position'] ?? 'Position' }}</p>
                        <p class="ref-company">{{ $ref['company'] ?? 'Company' }}</p>
                        @if(isset($ref['email']) && !empty($ref['email']))
                            <p class="ref-email">{{ $ref['email'] }}</p>
                        @endif
                        @if(isset($ref['phone']) && !empty($ref['phone']))
                            <p class="ref-phone">{{ $ref['phone'] }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    </div>
</div>
