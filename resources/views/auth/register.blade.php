@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
  <div class="col-md-6">
    <h2 class="mb-4 fw-normal" style="font-size: 2rem;">Create Account.</h2>

    {{-- Global error alert --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf

      {{-- Name --}}
      <div class="mb-4">
        <label for="name" class="form-label">Full Name *</label>
        <input type="text" class="form-control border-0 border-bottom rounded-0 shadow-none"
               id="name" name="name" value="{{ old('name') }}" required autofocus>
        @error('name')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      {{-- Email --}}
      <div class="mb-4">
        <label for="email" class="form-label">Email address *</label>
        <input type="email" class="form-control border-0 border-bottom rounded-0 shadow-none"
               id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      {{-- Password --}}
      <div class="mb-4 position-relative">
        <label for="password" class="form-label">Password *</label>
        <input type="password" class="form-control border-0 border-bottom rounded-0 shadow-none"
               id="password" name="password" required>
        <span class="position-absolute end-0 top-50 translate-middle-y me-3"
              onclick="togglePassword('password')" style="cursor: pointer;">
          <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
        </span>
        @error('password')
          <small class="text-danger d-block mt-1">{{ $message }}</small>
        @enderror
      </div>

      {{-- Confirm Password --}}
      <div class="mb-4">
        <label for="password_confirmation" class="form-label">Confirm Password *</label>
        <input type="password" class="form-control border-0 border-bottom rounded-0 shadow-none"
               id="password_confirmation" name="password_confirmation" required>
        @error('password_confirmation')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>

      {{-- Submit --}}
      <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('login') }}" class="btn btn-outline-dark px-4 py-2">Back to Login</a>
        <button type="submit" class="btn btn-dark px-4 py-2">Register</button>
      </div>
    </form>
  </div>
</div>

{{-- Password Toggle Script --}}
<script>
  function togglePassword(fieldId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById('togglePasswordIcon');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('bi-eye-slash');
      icon.classList.add('bi-eye');
    } else {
      input.type = 'password';
      icon.classList.remove('bi-eye');
      icon.classList.add('bi-eye-slash');
    }
  }
</script>
@endsection
