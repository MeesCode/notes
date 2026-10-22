@extends('layouts.app')

@section('content')
<h1>{{ __('Verify Your Email Address') }}</h1>

@if (session('resent'))
    <div class="alert" role="alert">
        {{ __('A fresh verification link has been sent to your email address.') }}
    </div>
@endif

<div class="muted">
    {{ __('Before proceeding, please check your email for a verification link.') }}
    {{ __('If you did not receive the email') }},
    <form method="POST" action="{{ route('verification.resend') }}" style="display: inline">
        @csrf
        <button type="submit" class="link-btn">{{ __('click here to request another') }}</button>.
    </form>
</div>
@endsection
