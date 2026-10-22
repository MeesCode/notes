@extends('layouts.app')

@section('content')
<h1>{{ __('Login') }}</h1>
<p class="muted">{{ __('Welcome back! Sign in to see your notes.') }}</p>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="field">
        <label for="email">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" class="input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
            <span class="field-error" role="alert">{{ $message }}</span>
        @enderror
    </div>

    <div class="field">
        <label for="password">{{ __('Password') }}</label>
        <input id="password" type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        @error('password')
            <span class="field-error" role="alert">{{ $message }}</span>
        @enderror
    </div>

    <label class="check">
        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        {{ __('Remember Me') }}
    </label>

    <button type="submit" class="btn btn-primary btn-block">
        {{ __('Login') }}
    </button>

    <div class="auth-links">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
        @endif
        @if (Route::has('register'))
            <a href="{{ route('register') }}">{{ __('Register') }}</a>
        @endif
    </div>
</form>
@endsection
