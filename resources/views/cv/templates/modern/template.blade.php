{{-- Modern CV Template - Matching modern.html design with JS-compatible classes --}}
<div class="cv-template modern">
    <div class="cv-page">
        <!-- Top Green Bar -->
        <div class="top-green">
            <div class="top-content cv-header">
                <div class="logo-circle">{{ substr($data['name'] ?? 'Y', 0, 1) }}{{ substr(explode(' ', $data['name'] ?? 'N')[1] ?? 'N', 0, 1) }}</div>
                <h1 class="name">{{ $data['name'] ?? 'Your Name' }}</h1>
                
                <p class="subtitle">{{ $data['job_title'] ?? 'Professional' }}</p>
            </div>
        </div>

        <!-- Left Green Vertical Section -->
        <div class="left-green">
            <!-- Photo Box (Diamond) -->
            <div class="photo-box">
                <div class="profile-placeholder">
                    @if(isset($data['photo']) && !empty($data['photo']))
                        <img src="{{ $data['photo'] }}" alt="Profile Photo" class="profile-photo">
                    @else
                        <span class="initials">{{ substr($data['name'] ?? 'Y', 0, 1) }}{{ substr(explode(' ', $data['name'] ?? 'N')[1] ?? 'N', 0, 1) }}</span>
                    @endif
                </div>
            </div>

            <!-- Education Section -->
            @if(isset($data['education']) && count($data['education']) > 0)
            <section class="education">
                <h2 class="section-title">EDUCATION</h2>
                <div class="section-content">
                    @foreach($data['education'] as $edu)
                    <div class="education-item">
                        <h3 class="item-title">{{ $edu['degree'] ?? 'Degree' }}</h3>
                        <p class="item-institution">{{ $edu['institution'] ?? 'Institution' }}</p>
                        <span class="item-period">{{ $edu['period'] ?? 'Period' }}</span>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Contact Section -->
            <section class="contact">
                <h2 class="section-title">CONTACT</h2>
                <div class="section-content">
                    <div class="contact-info">
                        @if(isset($data['website']) && !empty($data['website']))
                        <div class="contact-item">
                            <span class="contact-icon"><i class="fas fa-globe"></i></span>
                            <div class="contact-text-wrapper">
                                <span class="contact-text">{{ $data['website'] }}</span>
                                @if(isset($data['email']) && !empty($data['email']))
                                <span class="contact-text">{{ $data['email'] }}</span>
                                @endif
                            </div>
                        </div>
                        @elseif(isset($data['email']) && !empty($data['email']))
                        <div class="contact-item">
                            <span class="contact-icon"><i class="fas fa-envelope"></i></span>
                            <div class="contact-text-wrapper">
                                <span class="contact-text">{{ $data['email'] }}</span>
                            </div>
                        </div>
                        @endif
                        @if(isset($data['phone']) && !empty($data['phone']))
                        <div class="contact-item">
                            <span class="contact-icon"><i class="fas fa-phone"></i></span>
                            <div class="contact-text-wrapper">
                                <span class="contact-text">{{ $data['phone'] }}</span>
                            </div>
                        </div>
                        @endif
                        @if(isset($data['address']) && !empty($data['address']))
                        <div class="contact-item">
                            <span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span>
                            <div class="contact-text-wrapper">
                                <span class="contact-text">{{ $data['address'] }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </section>

            <!-- Certifications Section -->
            @if(isset($data['certifications']) && count($data['certifications']) > 0)
            <section class="certifications">
                <h2 class="section-title">CERTIFICATIONS</h2>
                <div class="section-content">
                    @foreach($data['certifications'] as $cert)
                    <div class="certification-item">
                        <h3 class="item-title">{{ $cert['name'] ?? 'Certification' }}</h3>
                        <p class="item-issuer">{{ $cert['issuer'] ?? 'Issuer' }}<br>{{ $cert['date'] ?? 'Date' }}</p>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Languages Section -->
            @if(isset($data['languages']) && count($data['languages']) > 0)
            <section class="languages">
                <h2 class="section-title">LANGUAGES</h2>
                <div class="section-content">
                    @foreach($data['languages'] as $lang)
                    <div class="language-item">
                        <span class="language-name">{{ $lang['language'] ?? 'Language' }}</span>
                        @if(isset($lang['proficiency']) && !empty($lang['proficiency']))
                            <span class="language-proficiency">- {{ $lang['proficiency'] }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </section>
            @endif
        </div>

        <!-- Right Content Area -->
        <div class="right-content">
            <!-- About Me Section -->
            @if(isset($data['summary']) && !empty($data['summary']))
            <section class="summary">
                <h2 class="section-title">ABOUT ME</h2>
                <div class="section-content">
                    <p>{{ $data['summary'] }}</p>
                </div>
            </section>
            @endif

            <!-- Job Experience Section -->
            @if(isset($data['experience']) && count($data['experience']) > 0)
            <section class="experience">
                <h2 class="section-title">JOB EXPERIENCE</h2>
                <div class="section-content">
                    @foreach($data['experience'] as $exp)
                    <div class="experience-item">
                        <h3 class="item-title">{{ $exp['title'] ?? 'Job Title' }}</h3>
                        <p class="item-company">{{ $exp['company'] ?? 'Company' }} / {{ $exp['period'] ?? 'Period' }}</p>
                        @if(isset($exp['description']) && !empty($exp['description']))
                        <p class="item-description">{{ $exp['description'] }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Skills Section -->
            @if(isset($data['skills']) && count($data['skills']) > 0)
            <section class="skills">
                <h2 class="section-title">SKILLS</h2>
                <div class="section-content">
                    <ul class="skills-list">
                        @foreach($data['skills'] as $skill)
                        <li>{{ $skill['skill'] ?? 'Skill' }}</li>
                        @endforeach
                    </ul>
                </div>
            </section>
            @endif

            <!-- Projects Section -->
            @if(isset($data['projects']) && count($data['projects']) > 0)
            <section class="projects">
                <h2 class="section-title">PROJECTS</h2>
                <div class="section-content">
                    @foreach($data['projects'] as $project)
                    <div class="project-item">
                        <h3 class="item-title">{{ $project['name'] ?? 'Project Name' }}</h3>
                        @if(isset($project['technologies']) && !empty($project['technologies']))
                        <p class="item-technologies">{{ $project['technologies'] }}</p>
                        @endif
                        @if(isset($project['description']) && !empty($project['description']))
                        <p class="item-description">{{ $project['description'] }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Awards Section -->
            @if(isset($data['awards']) && count($data['awards']) > 0)
            <section class="awards">
                <h2 class="section-title">AWARDS</h2>
                <div class="section-content">
                    @foreach($data['awards'] as $award)
                    <div class="award-item">
                        <h3 class="item-title">{{ $award['title'] ?? 'Award Title' }}</h3>
                        <p class="item-organization">{{ $award['organization'] ?? 'Organization' }} / {{ $award['date'] ?? 'Date' }}</p>
                        @if(isset($award['description']) && !empty($award['description']))
                        <p class="item-description">{{ $award['description'] }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- References Section -->
            @if(isset($data['references']) && count($data['references']) > 0)
            <section class="references">
                <h2 class="section-title">REFERENCES</h2>
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
</div>
