@extends('layouts.app')

@section('content')
<h1>{{ __('Confirm Password') }}</h1>
<p class="muted">{{ __('Please confirm your password before continuing.') }}</p>

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <div class="field">
        <label for="password">{{ __('Password') }}</label>
        <input id="password" type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        @error('password')
            <span class="field-error" role="alert">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary btn-block">
        {{ __('Confirm Password') }}
    </button>

    @if (Route::has('password.request'))
        <div class="auth-links">
            <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
        </div>
    @endif
</form>
@endsection
