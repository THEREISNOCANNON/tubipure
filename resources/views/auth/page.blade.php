<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
</div>
@extends('layouts.auth', ['title' => match ($mode) {
    'signup' => 'Create your account',
    'forgot' => 'Reset your password',
    'reset' => 'Choose a new password',
    default => 'Log in',
}])

@section('content')
<main class="auth-page" data-auth-mode="{{ $mode }}" data-reset-token="{{ $token ?? '' }}">
    <aside class="auth-story" aria-label="About TubiPure">
        <a class="auth-brand" href="{{ url('/') }}" aria-label="TubiPure home">
            <img src="{{ asset('images/tubipure-logo.png') }}" alt="">
            <span><b>TubiPure</b><small>Clean water, healthier you</small></span>
        </a>
        <div class="auth-story-copy">
            <span class="auth-eyebrow"><i></i> Pure water delivery</span>
            <h1>Fresh water.<br><em>Made simple.</em></h1>
            <p>Order your refill, manage deliveries, and keep your household stocked with clean water.</p>
            <div class="auth-points">
                <div><span class="auth-check" aria-hidden="true">✓</span><span><b>Easy refills</b><small>Request water in just a few steps.</small></span></div>
                <div><span class="auth-check" aria-hidden="true">✓</span><span><b>Know what’s next</b><small>Track your delivery from your account.</small></span></div>
            </div>
        </div>
        <div class="auth-watermark" aria-hidden="true"><span></span><span></span><span></span></div>
        <p class="auth-story-note">TubiPure · Clean water, delivered with care</p>
    </aside>

<section class="auth-panel">
        <button class="theme-toggle auth-theme-toggle" type="button" data-theme-toggle aria-label="Switch to dark mode" title="Switch to dark mode" aria-pressed="false">
            <svg class="theme-icon-moon" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20.4 15.4A8.5 8.5 0 018.6 3.6 8.5 8.5 0 1020.4 15.4Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <svg class="theme-icon-sun" width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="1.8"/><path d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
        </button>
        <a class="auth-mobile-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/tubipure-logo.png') }}" alt="">
            <span>Tubi<b>Pure</b></span>
        </a>
        <div class="auth-card">
            <a class="auth-back" href="{{ url('/') }}"><span aria-hidden="true">←</span> Back to TubiPure</a>
            <div class="auth-heading">
                <span class="auth-kicker">{{ $mode === 'signup' ? 'GET STARTED' : ($mode === 'login' ? 'WELCOME BACK' : 'ACCOUNT SUPPORT') }}</span>
                <h2 id="authTitle">
                    @if ($mode === 'signup') Create your account
                    @elseif ($mode === 'forgot') Reset your password
                    @elseif ($mode === 'reset') Choose a new password
                    @else Welcome back
                    @endif
                </h2>
                <p id="authDescription">
                    @if ($mode === 'signup') Join TubiPure to request and track deliveries.
                    @elseif ($mode === 'forgot') Enter your email and we’ll send a reset link if an account matches.
                    @elseif ($mode === 'reset') Set a new password for your TubiPure account.
                    @else Log in to manage your water deliveries.
                    @endif
                </p>
            </div>

            <form id="authForm" novalidate>
                @if ($mode === 'signup')
                    <div class="auth-field" data-field="name">
                        <label for="authName">Full name</label>
                        <input id="authName" name="name" type="text" autocomplete="name" maxlength="255" placeholder="e.g. Maria Santos" required>
                        <small class="auth-field-error"></small>
                    </div>
                    <div class="auth-field" data-field="contact">
                        <label for="authContact">Contact number</label>
                        <input id="authContact" name="contact" type="tel" autocomplete="tel" maxlength="11" inputmode="numeric" placeholder="09XXXXXXXXX" required>
                        <small class="auth-field-error"></small>
                    </div>
                @endif

                @if ($mode !== 'reset')
                    <div class="auth-field" data-field="email">
                        <label for="authEmail">Email address</label>
                        <input id="authEmail" name="email" type="email" autocomplete="email" maxlength="255" placeholder="you@example.com" value="{{ $email ?? '' }}" required>
                        <small class="auth-field-error"></small>
                    </div>
                @else
                    <div class="auth-field" data-field="email">
                        <label for="authEmail">Email address</label>
                        <input id="authEmail" name="email" type="email" autocomplete="email" maxlength="255" placeholder="you@example.com" value="{{ $email ?? '' }}" required>
                        <small class="auth-field-error"></small>
                    </div>
                @endif

                @if ($mode === 'login' || $mode === 'signup' || $mode === 'reset')
                    <div class="auth-field" data-field="password">
                        <div class="auth-label-row"><label for="authPassword">{{ $mode === 'reset' ? 'New password' : 'Password' }}</label>@if ($mode === 'login')<a href="{{ route('password.request') }}">Forgot password?</a>@endif</div>
                        <div class="auth-password-wrap">
                            <input id="authPassword" name="password" type="password" autocomplete="{{ $mode === 'login' ? 'current-password' : 'new-password' }}" minlength="10" placeholder="{{ $mode === 'login' ? 'Enter your password' : 'At least 10 characters' }}" required>
                            <button class="auth-password-toggle" type="button" data-toggle-password="authPassword" aria-label="Show password">Show</button>
                        </div>
                        <small class="auth-field-error"></small>
                    </div>
                @endif

                @if ($mode === 'signup' || $mode === 'reset')
                    <div class="auth-field" data-field="password_confirmation">
                        <label for="authPasswordConfirmation">Confirm password</label>
                        <div class="auth-password-wrap">
                            <input id="authPasswordConfirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="10" placeholder="Enter it again" required>
                            <button class="auth-password-toggle" type="button" data-toggle-password="authPasswordConfirmation" aria-label="Show password">Show</button>
                        </div>
                        <small class="auth-field-error"></small>
                    </div>
                @endif

                <input type="hidden" name="token" value="{{ $token ?? '' }}">
                <p class="auth-feedback" id="authFeedback" role="status" aria-live="polite"></p>
                <button class="auth-submit" id="authSubmit" type="submit">
                    <span class="auth-submit-label">
                        @if ($mode === 'signup') Create account
                        @elseif ($mode === 'forgot') Send reset link
                        @elseif ($mode === 'reset') Save new password
                        @else Log in
                        @endif
                    </span>
                    <span class="auth-submit-arrow" aria-hidden="true">→</span>
                    <span class="auth-spinner" aria-hidden="true"></span>
                </button>
            </form>

            <div class="auth-switch">
                @if ($mode === 'login')
                    <span>New to TubiPure?</span> <a href="{{ route('signup') }}">Create an account</a>
                @elseif ($mode === 'signup')
                    <span>Already have an account?</span> <a href="{{ route('login') }}">Log in</a>
                @else
                    <a href="{{ route('login') }}">Back to log in</a>
                @endif
            </div>
            <p class="auth-security"><span aria-hidden="true">◈</span> Your account details are protected.</p>
        </div>
    </section>
</main>
@endsection
