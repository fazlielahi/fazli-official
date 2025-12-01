{{-- Classic CV Template --}}
{{-- This is a placeholder template structure --}}
<div class="cv-template classic">
    <div class="cv-header">
        <h1>{{ $data['name'] ?? 'Your Name' }}</h1>
        <p>{{ $data['email'] ?? 'your.email@example.com' }}</p>
        <p>{{ $data['phone'] ?? 'Your Phone' }}</p>
    </div>
    
    <div class="cv-body">
        @if(isset($data['summary']))
        <section class="summary">
            <h2>Summary</h2>
            <p>{{ $data['summary'] }}</p>
        </section>
        @endif
        
        @if(isset($data['experience']) && count($data['experience']) > 0)
        <section class="experience">
            <h2>Experience</h2>
            @foreach($data['experience'] as $exp)
            <div class="experience-item">
                <h3>{{ $exp['title'] ?? 'Job Title' }}</h3>
                <p class="company">{{ $exp['company'] ?? 'Company Name' }}</p>
                <p class="period">{{ $exp['period'] ?? 'Period' }}</p>
                <p>{{ $exp['description'] ?? 'Description' }}</p>
            </div>
            @endforeach
        </section>
        @endif
        
        @if(isset($data['education']) && count($data['education']) > 0)
        <section class="education">
            <h2>Education</h2>
            @foreach($data['education'] as $edu)
            <div class="education-item">
                <h3>{{ $edu['degree'] ?? 'Degree' }}</h3>
                <p class="institution">{{ $edu['institution'] ?? 'Institution' }}</p>
                <p class="period">{{ $edu['period'] ?? 'Period' }}</p>
            </div>
            @endforeach
        </section>
        @endif
    </div>
</div>


