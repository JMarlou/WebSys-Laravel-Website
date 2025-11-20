<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>

<!-- Top right links -->
<div class="top-right-links">
    <a href="{{ route('public.resume', ['id' => $info->id ?? 1]) }}" target="_blank">View Public Resume</a>
    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit">Logout</button>
    </form>
</div>

<!-- Success message -->
@if (session('success'))
    <p class="success-msg">{{ session('success') }}</p>
@endif

<!-- Personal Info Form -->
<form method="POST" action="{{ route('update.resume') }}">
    @csrf
    <div class="card">
        <h2>Personal Information</h2>
        <div class="personal-info-grid">
            <input type="text" name="name" value="{{ old('name', $info->name ?? '') }}" placeholder="Full Name" required>
            <input type="text" name="title" value="{{ old('title', $info->title ?? '') }}" placeholder="Job Title">
            <input type="text" name="location" value="{{ old('location', $info->location ?? '') }}" placeholder="Location">
            <input type="text" name="phone" value="{{ old('phone', $info->phone ?? '') }}" placeholder="Phone">
            <input type="email" name="email" value="{{ old('email', $info->email ?? '') }}" placeholder="Email" required>
            <input type="text" name="github" value="{{ old('github', $info->github ?? '') }}" placeholder="GitHub URL">
            <textarea name="summary" placeholder="Summary">{{ old('summary', $info->summary ?? '') }}</textarea>
        </div>
        <button type="submit" class="update-btn">Update Personal Info</button>
    </div>
</form>

<!-- Education Section -->
<div class="card">
    <h2>Education</h2>

    <!-- Add New Education Form -->
    <div class="add-form">
        <h3>Add Education</h3>
        <form method="POST" action="{{ route('education.add') }}">
            @csrf
            <input type="text" name="level" placeholder="Level (e.g., Primary, Secondary, College)" required>
            <input type="text" name="school" placeholder="School Name" required>
            <input type="text" name="years" placeholder="Years (e.g., 2020-2024)" required>
            <button type="submit" class="btn-add">Add Education</button>
        </form>
    </div>

    <!-- List of Education -->
    <div class="item-list">
        @foreach($education as $edu)
            <div class="item">
                <div class="item-content">
                    <strong>{{ $edu->level }}</strong> - {{ $edu->school }}<br>
                    <small>{{ $edu->years }}</small>
                </div>
                <div class="item-actions">
                    <form method="POST" action="{{ route('education.delete', $edu->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Delete this education?')">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Skills Section -->
<div class="card">
    <h2>Technical Skills</h2>

    <!-- Add Skill -->
    <div class="add-form">
        <h3>Add Skill</h3>
        <form method="POST" action="{{ route('skill.add') }}">
            @csrf
            <input type="text" name="skill" placeholder="Skill Name" required>
            <button type="submit" class="btn-add">Add Skill</button>
        </form>
    </div>

    <!-- List of Skills -->
    <div class="item-list">
        @foreach($skills as $skill)
            <div class="item">
                <div class="item-content">{{ $skill->skill }}</div>
                <div class="item-actions">
                    <form method="POST" action="{{ route('skill.delete', $skill->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Delete this skill?')">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Experience Section -->
<div class="card">
    <h2>Experience</h2>

    <div class="add-form">
        <h3>Add Experience</h3>
        <form method="POST" action="{{ route('experience.add') }}">
            @csrf
            <textarea name="description" placeholder="Experience Description" rows="3" required></textarea>
            <button type="submit" class="btn-add">Add Experience</button>
        </form>
    </div>

    <div class="item-list">
        @foreach($experiences as $exp)
            <div class="item">
                <div class="item-content">{{ $exp->description }}</div>
                <div class="item-actions">
                    <form method="POST" action="{{ route('experience.delete', $exp->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete" onclick="return confirm('Delete this experience?')">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
