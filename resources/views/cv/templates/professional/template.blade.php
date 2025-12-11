{{-- Professional CV Template --}}
<div class="cv-template professional">
    <div class="cv-header">
        <div class="header-content">
            <h1 class="name">{{ $data['name'] ?? 'Your Name' }}</h1>
            <div class="contact-info">
                @if(isset($data['email']) && !empty($data['email']))
                    <span class="contact-item">
                        <i class="icon">✉</i>
                        {{ $data['email'] }}
                    </span>
                @endif
                @if(isset($data['phone']) && !empty($data['phone']))
                    <span class="contact-item">
                        <i class="icon">📞</i>
                        {{ $data['phone'] }}
                    </span>
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
        
        @if(isset($data['certifications']) && count($data['certifications']) > 0)
        <section class="certifications">
            <h2 class="section-title">Certifications</h2>
            <div class="section-content">
                @foreach($data['certifications'] as $cert)
                <div class="certification-item">
                    <div class="item-header">
                        <h3 class="item-title">{{ $cert['name'] ?? 'Certification Name' }}</h3>
                        <span class="item-period">{{ $cert['date'] ?? 'Date' }}</span>
                    </div>
                    <p class="item-issuer">{{ $cert['issuer'] ?? 'Issuing Organization' }}</p>
                    @if(isset($cert['credential_id']) && !empty($cert['credential_id']))
                        <p class="item-credential">ID: {{ $cert['credential_id'] }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </section>
        @endif
        
        @if(isset($data['awards']) && count($data['awards']) > 0)
        <section class="awards">
            <h2 class="section-title">Awards & Recognition</h2>
            <div class="section-content">
                @foreach($data['awards'] as $award)
                <div class="award-item">
                    <div class="item-header">
                        <h3 class="item-title">{{ $award['title'] ?? 'Award Title' }}</h3>
                        <span class="item-period">{{ $award['date'] ?? 'Date' }}</span>
                    </div>
                    <p class="item-organization">{{ $award['organization'] ?? 'Organization' }}</p>
                    @if(isset($award['description']) && !empty($award['description']))
                    <div class="item-description">
                        <p>{{ $award['description'] }}</p>
                    </div>
                    @endif
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
                <div class="project-item">
                    <div class="item-header">
                        <h3 class="item-title">{{ $project['name'] ?? 'Project Name' }}</h3>
                        @if(isset($project['link']) && !empty($project['link']))
                            <a href="{{ $project['link'] }}" target="_blank" class="project-link">🔗 View</a>
                        @endif
                    </div>
                    @if(isset($project['technologies']) && !empty($project['technologies']))
                        <p class="item-technologies">{{ $project['technologies'] }}</p>
                    @endif
                    @if(isset($project['description']) && !empty($project['description']))
                    <div class="item-description">
                        <p>{{ $project['description'] }}</p>
                    </div>
                    @endif
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
                    <div class="skill-item">
                        <span class="skill-name">{{ $skill['skill'] ?? 'Skill' }}</span>
                        @if(isset($skill['level']) && !empty($skill['level']))
                            <span class="skill-level">{{ $skill['level'] }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        
        @if(isset($data['languages']) && count($data['languages']) > 0)
        <section class="languages">
            <h2 class="section-title">Languages</h2>
            <div class="section-content">
                <div class="languages-list">
                    @foreach($data['languages'] as $lang)
                    <div class="language-item">
                        <span class="language-name">{{ $lang['language'] ?? 'Language' }}</span>
                        @if(isset($lang['proficiency']) && !empty($lang['proficiency']))
                            <span class="language-proficiency">{{ $lang['proficiency'] }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        
        @if(isset($data['references']) && count($data['references']) > 0)
        <section class="references">
            <h2 class="section-title">References</h2>
            <div class="section-content">
                <div class="references-list">
                    @foreach($data['references'] as $ref)
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

