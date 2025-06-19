@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="w-100" style="max-width: 400px;">
        <h2 class="mb-4 text-center fw-light">Welcome.</h2>

        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                <input id="email" type="email" class="form-control border-0 border-bottom rounded-0 shadow-none" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2 position-relative">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input id="password" type="password" class="form-control border-0 border-bottom rounded-0 shadow-none pe-5" name="password" required>
                <i class="bi bi-eye-slash position-absolute top-50 end-0 translate-middle-y me-3" role="button" onclick="togglePassword(this)"></i>
                @error('password')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <a href="{{ route('password.request') }}" class="small text-muted">Lost your password?</a>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <div class="d-flex justify-content-between gap-2">
                <button type="submit" class="btn btn-outline-dark w-100">Log in</button>
                <a href="{{ route('register') }}" class="btn btn-outline-dark w-100">Register</a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(icon) {
    const input = document.getElementById('password');
    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
    input.setAttribute('type', type);
    icon.classList.toggle('bi-eye');
    icon.classList.toggle('bi-eye-slash');
}
</script>
@endsection