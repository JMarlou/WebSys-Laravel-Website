<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    
    <!-- Link to consolidated CSS file -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="login-container">
    
    <div class="login-box">
        {{-- Page Title --}}
        <h2>Admin Login</h2>

        {{-- Link to view public resume (redirects to public page) --}}
        <a href="{{ route('public.resume', 1) }}" class="admin-login-link">
            View Public Resume
        </a>

        {{--DISPLAY VALIDATION ERRORS
            Shows any errors from failed login attempt--}}

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- LOGIN FORM
             Submits to route('login') which calls AuthController@login--}}
        <form method="POST" action="{{ route('login') }}">
            {{-- CSRF Token - Required for all POST requests in Laravel --}}
            @csrf
            
            {{-- Username Input --}}
            {{-- old('username') keeps the value if validation fails --}}
            <input type="text" 
                   name="username" 
                   placeholder="Username" 
                   value="{{ old('username') }}" 
                   required>
            
            {{-- Password Input --}}
            {{-- Password is NOT kept if validation fails (security) --}}
            <input type="password" 
                   name="password" 
                   placeholder="Password" 
                   required>
            
            {{-- Submit Button --}}
            <button type="submit">Login</button>
        </form>
    </div>

</div>

</body>
</html>