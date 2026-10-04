@extends('layouts.app')

@section('title', __('ui.nav.login'))

@section('content')
    <div class="form-wrap"><div class="form-card">
        <h1>{{ __('ui.auth.login_title') }}</h1>
        @if ($errors->any())<div class="notice error">{{ $errors->first() }}</div>@endif
        <form method="POST" action="{{ route('login.store') }}">@csrf
            <div class="field"><label for="email">{{ __('ui.auth.email') }}</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>@error('email')<div class="field-error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="password">{{ __('ui.auth.password') }}</label><input id="password" name="password" type="password" required>@error('password')<div class="field-error">{{ $message }}</div>@enderror</div>
            <button class="button" type="submit">{{ __('ui.auth.login') }}</button>
        </form>
        <div class="auth-foot">{{ __('ui.auth.new_here') }} <a href="{{ route('register') }}">{{ __('ui.auth.register_link') }}</a></div>
    </div></div>
@endsection