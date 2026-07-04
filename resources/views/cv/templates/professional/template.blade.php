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
    $defaultLayout = [
        'left' => ['summary', 'experience', 'projects'],
        'right' => ['awards', 'skills', 'education', 'certifications', 'languages', 'references'],
    ];
    $validLayoutSections = ['summary', 'experience', 'education', 'awards', 'projects', 'skills', 'languages', 'certifications', 'references', 'custom'];
    $savedLayout = isset($data['section_layout']) && is_array($data['section_layout']) ? $data['section_layout'] : [];
    $leftLayout = array_values(array_filter($savedLayout['left'] ?? [], fn ($key) => in_array($key, $validLayoutSections, true)));
    $rightLayout = array_values(array_filter($savedLayout['right'] ?? [], fn ($key) => in_array($key, $validLayoutSections, true)));
    if (empty($leftLayout) && empty($rightLayout)) {
        $leftLayout = $defaultLayout['left'];
        $rightLayout = $defaultLayout['right'];
    }
    foreach ($validLayoutSections as $sectionKey) {
        if (!in_array($sectionKey, $leftLayout, true) && !in_array($sectionKey, $rightLayout, true)) {
            if (in_array($sectionKey, $defaultLayout['right'], true)) {
                $rightLayout[] = $sectionKey;
            } else {
                $leftLayout[] = $sectionKey;
            }
        }
    }
    $layoutColumn = fn ($key) => in_array($key, $rightLayout, true) ? 'right' : 'left';
    $columns = [
        'left' => ['class' => 'primary-column', 'sections' => $leftLayout],
        'right' => ['class' => 'secondary-column', 'sections' => $rightLayout],
    ];
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
            @foreach($columns as $columnKey => $column)
                <div class="{{ $column['class'] }}">
                    @foreach($column['sections'] as $sectionKey)
                        @switch($sectionKey)
                            @case('summary')
                                @if(isset($data['summary']) && !empty($data['summary']))
                                    <section class="summary" data-layout-column="{{ $layoutColumn('summary') }}">
                                        <h2 class="section-title">SUMMARY</h2>
                                        <div class="section-content">
                                            <p>{{ $data['summary'] }}</p>
                                        </div>
                                    </section>
                                @endif
                                @break

                            @case('experience')
                                @if(isset($data['experience']) && count($data['experience']) > 0)
                                    <section class="experience" data-layout-column="{{ $layoutColumn('experience') }}">
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
                                @break

                            @case('projects')
                                @if(isset($data['projects']) && count($data['projects']) > 0)
                                    <section class="projects" data-layout-column="{{ $layoutColumn('projects') }}">
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
                                @break

                            @case('awards')
                                @if(isset($data['awards']) && count($data['awards']) > 0)
                                    <section class="awards" data-layout-column="{{ $layoutColumn('awards') }}">
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
                                @break

                            @case('skills')
                                @if(isset($data['skills']) && count($data['skills']) > 0)
                                    <section class="skills" data-layout-column="{{ $layoutColumn('skills') }}">
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
                                @break

                            @case('education')
                                @if(isset($data['education']) && count($data['education']) > 0)
                                    <section class="education" data-layout-column="{{ $layoutColumn('education') }}">
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
                                @break

                            @case('certifications')
                                @if(isset($data['certifications']) && count($data['certifications']) > 0)
                                    <section class="certifications" data-layout-column="{{ $layoutColumn('certifications') }}">
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
                                @break

                            @case('languages')
                                @if(isset($data['languages']) && count($data['languages']) > 0)
                                    <section class="languages" data-layout-column="{{ $layoutColumn('languages') }}">
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
                                @break

                            @case('references')
                                @if(isset($data['references']) && count($data['references']) > 0)
                                    <section class="references" data-layout-column="{{ $layoutColumn('references') }}">
                                        <h2 class="section-title">REFERENCES</h2>
                                        <div class="section-content">
                                            <div class="references-list">
                                                @foreach($data['references'] as $ref)
                                                    @if(isset($ref['is_hidden']) && (string) $ref['is_hidden'] === '1')
                                                        @continue
                                                    @endif
                                                    <div class="reference-item">
                                                        <h3 class="ref-name">{{ $ref['name'] ?? 'Name' }}</h3>
                                                        @if(isset($ref['position']) && !empty($ref['position']))
                                                            <p class="ref-position">{{ $ref['position'] }}</p>
                                                        @endif
                                                        @if(isset($ref['company']) && !empty($ref['company']))
                                                            <p class="ref-company">{{ $ref['company'] }}</p>
                                                        @endif
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
                                @break

                            @case('custom')
                                @include('cv.templates.partials.custom-section', ['data' => $data, 'layoutColumn' => $layoutColumn])
                                @break
                        @endswitch
                    @endforeach
                </div>
            @endforeach
        </main>
    </div>
</div>
