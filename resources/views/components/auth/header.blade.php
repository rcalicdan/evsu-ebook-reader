<!-- resources/views/components/auth/header.blade.php -->
<div class="auth-header">
    <div class="auth-header-content">
        <div class="auth-header-logo">
            <img src="{{ asset('images/logo.jpg') }}" alt="EVSU Logo" class="header-logo">
        </div>
        <div class="auth-header-text">
            <h1>{{ $title ?? 'Eastern Visayas State University' }}</h1>
            <p>{{ $subtitle ?? 'eBook Management System' }}</p>
        </div>
    </div>
</div>