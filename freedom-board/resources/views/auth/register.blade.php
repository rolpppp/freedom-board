@extends('layouts.app')

@section('content')
<div class="form-container">
    <h1>Register</h1>
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="success">{!! session('success') !!}</div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required value="{{ old('username') }}">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit">Register</button>
    </form>
    <div class="login-link">
        Already have an account? <a href="{{ route('login') }}">Login here</a>
    </div>
</div>
@endsection
