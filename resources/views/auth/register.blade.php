@extends('layouts.app')

@section('title', __('ui.nav.create_account'))

@section('content')
    <div class="form-wrap"><div class="form-card">
        <h1>{{ __('ui.auth.register_title') }}</h1>
        @if ($errors->any())<div class="notice error">{{ __('ui.auth.correct_errors') }}</div>@endif
        <form method="POST" action="{{ route('register.store') }}">@csrf
            <div class="field"><label for="name">{{ __('ui.auth.name') }}</label><input id="name" name="name" value="{{ old('name') }}" required>@error('name')<div class="field-error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="email">{{ __('ui.auth.email') }}</label><input id="email" name="email" type="email" value="{{ old('email') }}" required>@error('email')<div class="field-error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="role">{{ __('ui.auth.role') }}</label><select id="role" name="role" required><option value="buyer" @selected(old('role', 'buyer') === 'buyer')>{{ __('ui.auth.buyer') }}</option><option value="seller" @selected(old('role') === 'seller')>{{ __('ui.auth.seller') }}</option></select>@error('role')<div class="field-error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="password">{{ __('ui.auth.password_hint') }}</label><input id="password" name="password" type="password" required>@error('password')<div class="field-error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="password_confirmation">{{ __('ui.auth.confirm_password') }}</label><input id="password_confirmation" name="password_confirmation" type="password" required></div>
            <button class="button" type="submit">{{ __('ui.auth.create_account') }}</button>
        </form>
        <div class="auth-foot">{{ __('ui.auth.already_registered') }} <a href="{{ route('login') }}">{{ __('ui.auth.login_link') }}</a></div>
    </div></div>
@endsection