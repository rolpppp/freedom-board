@extends('layouts.app')

@section('content')
<div class="form-container">
    <h1>Login</h1>
    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required value="{{ old('username') }}">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    <div class="register-link">
        Don't have an account? <a href="{{ route('register') }}">Register here</a>
    </div>
</div>
@endsection
