<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $info->name }} - Resume</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

{{-- ADMIN LOGIN LINK (Top Right)
     Fixed position link to admin login page--}}

<a href="{{ route('login') }}" class="admin-login-link" style="position: fixed; top: 20px; right: 20px; background: white; padding: 10px 20px; border-radius: 5px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); text-decoration: none; color: #667eea; font-weight: 500;">Admin Login</a>

{{-- RESUME HEADER SECTION
     Contains profile photo, name, title, and contact info--}}
<div class="resume-header">
    <div class="container">
        
        {{-- Profile Section (Photo + Name + Title) --}}
        <div class="profile">
            {{-- Profile Picture --}}
            <img src="{{ asset('Images/profile.jpg') }}" 
                 alt="{{ $info->name }}'s profile picture">
            
            {{-- Name and Job Title --}}
            <div>
                <h1>{{ $info->name }}</h1>
                <p>{{ $info->title }}</p>
            </div>
        </div>

        {{-- Contact Details Grid --}}
        <div class="contacts-grid">
            {{-- Location --}}
            @if($info->location)
                <div class="contact-item">
                    <span>📍</span> {{ $info->location }}
                </div>
            @endif

            {{-- Phone Number --}}
            @if($info->phone)
                <div class="contact-item">
                    <span>📞</span> {{ $info->phone }}
                </div>
            @endif

            {{-- Email Address (clickable mailto link) --}}
            <div class="contact-item">
                <span>✉️</span> 
                <a href="mailto:{{ $info->email }}">{{ $info->email }}</a>
            </div>

            {{-- GitHub Profile Link --}}
            @if($info->github)
                <div class="contact-item">
                    <span>🐱</span> 
                    <a href="{{ $info->github }}" target="_blank">{{ $info->github }}</a>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- SUMMARY SECTION
     Brief professional summary or bio --}}
@if($info->summary)
<div class="card">
    <h2>Summary</h2>
    <p>{{ $info->summary }}</p>
</div>
@endif

{{-- EDUCATION SECTION
     Display all education records grouped by level--}}
@if($education->count() > 0)
<div class="card">
    <h2>Education</h2>
    
    {{-- Loop through all education records --}}
    @foreach($education as $edu)
        <p class="font-medium mt-2">{{ $edu->level }}:</p>
        <ul>
            <li>{{ $edu->school }} ({{ $edu->years }})</li>
        </ul>
    @endforeach
</div>
@endif

{{-- SKILLS SECTION
     Display skills as small boxes/badges next to each other--}}
@if($skills->count() > 0)
<div class="card">
    <h2>Technical Skills</h2>
    <div class="skills-container">
        {{-- Loop through all skills and display as badges --}}
        @foreach($skills as $skill)
            <span class="skill-badge">{{ $skill->skill }}</span>
        @endforeach
    </div>
</div>
@endif

{{-- EXPERIENCE SECTION
     Work experience and achievements--}}
@if($experiences->count() > 0)
<div class="card">
    <h2>Experience</h2>
    <ul>
        {{-- Loop through all experience entries --}}
        @foreach($experiences as $exp)
            <li>{{ $exp->description }}</li>
        @endforeach
    </ul>
</div>
@endif

</body>
</html>