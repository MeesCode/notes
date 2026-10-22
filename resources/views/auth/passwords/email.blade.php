@extends('layouts.app')

@section('content')
<h1>{{ __('Reset Password') }}</h1>

@if (session('status'))
    <div class="alert" role="alert">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="field">
        <label for="email">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" class="input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        @error('email')
            <span class="field-error" role="alert">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary btn-block">
        {{ __('Send Password Reset Link') }}
    </button>

    <div class="auth-links">
        <a href="{{ route('login') }}">{{ __('Back to login') }}</a>
    </div>
</form>
@endsection
