@extends('layouts.app')

@section('content')
<h1>{{ __('Register') }}</h1>
<p class="muted">{{ __('Create an account to start taking notes.') }}</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="field">
        <label for="name">{{ __('Name') }}</label>
        <input id="name" type="text" class="input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        @error('name')
            <span class="field-error" role="alert">{{ $message }}</span>
        @enderror
    </div>

    <div class="field">
        <label for="email">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" class="input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        @error('email')
            <span class="field-error" role="alert">{{ $message }}</span>
        @enderror
    </div>

    <div class="field">
        <label for="password">{{ __('Password') }}</label>
        <input id="password" type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        @error('password')
            <span class="field-error" role="alert">{{ $message }}</span>
        @enderror
    </div>

    <div class="field">
        <label for="password-confirm">{{ __('Confirm Password') }}</label>
        <input id="password-confirm" type="password" class="input" name="password_confirmation" required autocomplete="new-password">
    </div>

    <button type="submit" class="btn btn-primary btn-block">
        {{ __('Register') }}
    </button>

    <div class="auth-links">
        <a href="{{ route('login') }}">{{ __('Already have an account? Login') }}</a>
    </div>
</form>
@endsection
