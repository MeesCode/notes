@extends('layouts.app')

@section('content')
<h1>{{ __('Reset Password') }}</h1>

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div class="field">
        <label for="email">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" class="input @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
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
        {{ __('Reset Password') }}
    </button>
</form>
@endsection
