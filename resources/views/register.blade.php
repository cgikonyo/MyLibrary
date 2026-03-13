@extends('layouts.app')

@section('content')
    <h1>Register</h1>

    <form method="POST" action="{{ url('register') }}" id="register-form">
        @csrf

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>
            @error('first_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
            @error('last_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" required>
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <p class="mt-3">Already have an account? <a href="{{ route('login') }}">Login</a></p>

    <!-- form validation -->
    <script>
        document.getElementById('register-form').addEventListener('submit', function (e) {
            var required = this.querySelectorAll('[required]');
            for (var i = 0; i < required.length; i++) {
                if (!required[i].value.trim()) {
                    alert(required[i].name.replace('_', ' ') + ' is required');
                    required[i].focus();
                    e.preventDefault();
                    return false;
                }
            }
        });
    </script>
@endsection
