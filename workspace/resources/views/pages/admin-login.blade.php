@extends('layouts.base')

@section('content')
    <form method="post" class="login-form">
        {!! csrfInput() !!}
        <input type="hidden" name="callbackUrl" value="{{ query('callbackUrl') }}">
        <div class="logo-container">
            <img src="{{ assets('/images/logo-transparent.png') }}" alt="Logo">
            <h5 class="text-center">{{ trans('cms_title') }}</h5>
        </div>
        <div class="form-container">
            <h4 class="text-center mb-2">{{ trans('login') }}</h4>
            <p class="text-center mb-4">{{ trans('welcome') }}</p>
            <div class="mb-3">
                <label for="email" class="form-label required">{{ trans('email_address') }}</label>
                <input type="text" name="email" id="email" class="form-control" placeholder="name@example.com"
                    value="{{ old('email') }}">
                <small class="text-danger">{{ flash('email') }}</small>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label required">{{ trans('password') }}</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="{{ trans('password_placeholder') }}">
                    <button class="btn btn-outline-secondary" type="button" id="toggle-show-password" data-show="false"
                        data-show-icon="bi bi-eye-fill" data-hide-icon="bi bi-eye-slash-fill">
                        <i class="bi bi-eye-fill"></i>
                    </button>
                </div>
                <small class="text-danger">{{ flash('password') }}</small>
            </div>
            <div class="mb-4">
                <button name="login" type="submit" class="btn btn-primary w-100">{{ trans('login') }}</button>
            </div>
        </div>
        <div class="d-flex align-items-center gap-1 my-4">
            <i class="bi bi-sun-fill"></i>
            <div class="form-check form-switch" style="padding-left: 2.7rem">
                <input class="form-check-input" type="checkbox" role="switch" id="switch-theme" />
            </div>
            <i class="bi bi-moon-fill" style="font-size: 11px;"></i>
        </div>
        <div class="text-center">
            <small>Copyright @ngmthaq ©️ 2024 - {{ date('Y') }}</small>
        </div>
    </form>
@endsection

@push('js')
    <script src="<?php echo assets('/vendor/adminLogin.bundle.js'); ?>"></script>
@endpush
