{{-- Modern CV Template - PDF-friendly design with CSS Grid only --}}
<div class="cv-template modern">
    <div class="cv-page">
        <!-- Top Green Bar -->
        <div class="top-green">
            <!-- Photo Container Box - Aligned with Left Sidebar -->
            <div class="photo-container-box">
                <div class="photo-box">
                    <div class="profile-placeholder">
                        @if(isset($data['photo']) && !empty($data['photo']))
                            <img src="{{ $data['photo'] }}" alt="Profile Photo" class="profile-photo">
                        @else
                            @php
                                $name = $data['name'] ?? 'Your Name';
                                $nameParts = array_filter(explode(' ', trim($name))); // Remove empty parts
                                $firstInitial = !empty($nameParts) ? strtoupper(substr(reset($nameParts), 0, 1)) : 'Y';
                                // Get last name initial (last word), or if only one word, use second character of that word
                                if (count($nameParts) > 1) {
                                    $lastInitial = strtoupper(substr(end($nameParts), 0, 1));
                                } else {
                                    // If only one word, use second character if available, otherwise repeat first
                                    $singleWord = reset($nameParts);
                                    $lastInitial = strlen($singleWord) > 1 ? strtoupper(substr($singleWord, 1, 1)) : $firstInitial;
                                }
                            @endphp
                            <span class="initials">{{ $firstInitial }}{{ $lastInitial }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="top-content cv-header">
                @php
                    $name = $data['name'] ?? 'Your Name';
                    $nameParts = array_filter(explode(' ', trim($name))); // Remove empty parts
                    $firstInitial = !empty($nameParts) ? strtoupper(substr(reset($nameParts), 0, 1)) : 'Y';
                    // Get last name initial (last word), or if only one word, use second character of that word
                    if (count($nameParts) > 1) {
                        $lastInitial = strtoupper(substr(end($nameParts), 0, 1));
                    } else {
                        // If only one word, use second character if available, otherwise repeat first
                        $singleWord = reset($nameParts);
                        $lastInitial = strlen($singleWord) > 1 ? strtoupper(substr($singleWord, 1, 1)) : $firstInitial;
                    }
                @endphp
                <div class="logo-circle">{{ $firstInitial }}{{ $lastInitial }}</div>
                <h1 class="name">{{ $name }}</h1>
                <p class="subtitle">{{ $data['job_title'] ?? 'Professional' }}</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="main-content">
            <!-- Left Green Vertical Section -->
            <div class="left-green">
                <!-- Education Section -->
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
                            <div class="item-meta">
                                <span class="item-period">{{ $edu['period'] ?? 'Period' }}</span>
                                @if(isset($edu['location']) && !empty($edu['location']))
                                    <span class="item-location">{{ $edu['location'] }}</span>
                                @endif
                            </div>
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
                            @if(isset($data['email']) && !empty($data['email']))
                            <div class="contact-item">
                                <span class="contact-icon"><i class="fas fa-envelope"></i></span>
                                <span class="contact-text-wrapper">
                                    <span class="contact-text">{{ $data['email'] }}</span>
                                </span>
                            </div>
                            @endif
                            
                            @if(isset($data['phone']) && !empty($data['phone']))
                            <div class="contact-item">
                                <span class="contact-icon"><i class="fas fa-phone"></i></span>
                                <span class="contact-text-wrapper">
                                    <span class="contact-text">{{ $data['phone'] }}</span>
                                </span>
                            </div>
                            @endif
                            
                            @if((isset($data['city']) && !empty($data['city'])) || (isset($data['country']) && !empty($data['country'])))
                            <div class="contact-item">
                                <span class="contact-icon"><i class="fas fa-map-marker-alt"></i></span>
                                <span class="contact-text-wrapper">
                                    <span class="contact-text">{{ ($data['city'] ?? '') . ($data['city'] && $data['country'] ? ', ' : '') . ($data['country'] ?? '') }}</span>
                                </span>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>

                <!-- References Section -->
                @if(isset($data['references']) && count($data['references']) > 0)
                <section class="references">
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

                <!-- Languages Section (sidebar — matches builder preview / PDF) -->
                @if(isset($data['languages']) && count($data['languages']) > 0)
                <section class="languages">
                    <h2 class="section-title">LANGUAGES</h2>
                    <div class="section-content">
                        <div class="languages-list">
                            @foreach($data['languages'] as $lang)
                            @if(isset($lang['is_hidden']) && (string) $lang['is_hidden'] === '1')
                                @continue
                            @endif
                            <div class="language-item">
                                <div class="language-name-row">
                                    <span class="language-name">{{ $lang['language'] ?? 'Language' }}</span>
                                    @if(isset($lang['proficiency']) && !empty($lang['proficiency']))
                                    <span class="language-proficiency-badge">{{ $lang['proficiency'] }}</span>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                @endif
            </div>

            <!-- Right Content Area -->
            <div class="right-content">
                <!-- Summary Section -->
                @if(isset($data['summary']) && !empty($data['summary']))
                <section class="summary">
                    <h2 class="section-title">ABOUT ME</h2>
                    <div class="section-content">
                        <p>{{ $data['summary'] }}</p>
                    </div>
                </section>
                @endif

                <!-- Experience Section -->
                @if(isset($data['experience']) && count($data['experience']) > 0)
                <section class="experience">
                    <h2 class="section-title">JOB EXPERIENCE</h2>
                    <div class="section-content">
                        @foreach($data['experience'] as $exp)
                        @if(isset($exp['is_hidden']) && (string) $exp['is_hidden'] === '1')
                            @continue
                        @endif
                        <div class="experience-item">
                            <h3 class="item-title">{{ $exp['title'] ?? $exp['position'] ?? 'Position' }}</h3>
                            <div class="item-meta">
                                <span class="item-company">{{ $exp['company'] ?? 'Company' }}</span>
                                <span class="item-period">{{ $exp['period'] ?? 'Period' }}</span>
                            </div>
                            @if(isset($exp['description']) && !empty($exp['description']))
                            <div class="item-description">{!! $exp['description'] !!}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <!-- Awards Section (under Experience) -->
                @if(isset($data['awards']) && count($data['awards']) > 0)
                <section class="awards">
                    <h2 class="section-title">AWARDS</h2>
                    <div class="section-content">
                        @foreach($data['awards'] as $award)
                        @if(isset($award['is_hidden']) && (string) $award['is_hidden'] === '1')
                            @continue
                        @endif
                        <div class="award-item">
                            <div class="item-title-row">
                                <h3 class="item-title">{{ $award['title'] ?? 'Award' }}</h3>
                                @if(isset($award['period']) && !empty($award['period']))
                                <span class="item-period">{{ $award['period'] }}</span>
                                @endif
                            </div>
                            @if(isset($award['organization']) && !empty($award['organization']))
                            <div class="item-organization">{{ $award['organization'] }}</div>
                            @endif
                            @if(isset($award['description']) && !empty($award['description']))
                            <div class="item-description">{!! $award['description'] !!}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                <!-- Projects Section (under Experience) -->
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

                <!-- Skills Section -->
                @if(isset($data['skills']) && count($data['skills']) > 0)
                <section class="skills">
                    <h2 class="section-title">SKILLS</h2>
                    <div class="section-content">
                        <div class="skills-list">
                            @foreach($data['skills'] as $skill)
                            @if(isset($skill['is_hidden']) && (string) $skill['is_hidden'] === '1')
                                @continue
                            @endif
                            <div class="skill-item">
                                <div class="skill-name-row">
                                    <span class="skill-name">{{ $skill['skill'] ?? 'Skill' }}</span>
                                    @if(isset($skill['level']) && !empty($skill['level']))
                                    <span class="skill-level-badge">{{ $skill['level'] }}</span>
                                    @endif
                                </div>
                                @if(isset($skill['level']) && !empty($skill['level']))
                                <div class="skill-progress-container">
                                    <div class="skill-progress-bar" style="width: {{ $skill['level'] === 'Expert' ? '100' : ($skill['level'] === 'Advanced' ? '75' : ($skill['level'] === 'Intermediate' ? '50' : '25')) }}%;"></div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                @endif

                <!-- Certifications Section -->
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
                            <div class="item-meta">
                                @if(isset($cert['issuer']) && !empty($cert['issuer']))
                                <span class="item-issuer">{{ $cert['issuer'] }}</span>
                                @endif
                                @if(isset($cert['date']) && !empty($cert['date']))
                                <span class="item-date">{{ $cert['date'] }}</span>
                                @endif
                            </div>
                            @if(isset($cert['credential_id']) && !empty($cert['credential_id']))
                            <p class="item-credential">Credential ID: {{ $cert['credential_id'] }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif

                @include('cv.templates.partials.custom-section', ['data' => $data])
            </div>
        </div>
    </div>
</div>
