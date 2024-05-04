@extends('layouts.cms')

@section('content')
    <div class="admin-user-details">
        <div class="row">
            <div class="col-4 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                <div class="avatar-container">
                    <img src="{{ $user->avatar }}" alt="{{ $user->name }}">
                </div>
            </div>
            <div class="col-8 col-sm-8 col-md-9 col-lg-10 col-xl-10">
                <div class="mb-3">
                    <label for="name" class="form-label">{{ trans('name') }}</label>
                    <input type="text" class="form-control" id="name" value="{{ $user->name }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ trans('email_address') }}</label>
                    <input type="text" class="form-control" id="email" value="{{ $user->email }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">{{ trans('dob') }}</label>
                    <input type="text" class="form-control" id="dob"
                        value="{{ date('d/m/Y', strtotime($user->dob)) }}" disabled>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">{{ trans('gender') }}</label>
                    <input type="text" class="form-control" id="gender" value="{{ $user->getGender() }}" disabled>
                </div>
                <div class="mb-4">
                    <label for="role" class="form-label">{{ trans('role') }}</label>
                    <input type="text" class="form-control" id="role" value="{{ $user->getRoleLongName() }}"
                        disabled>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" @if ($user->isActive()) checked @endif
                        disabled>
                    <label class="form-check-label">{{ trans('is_account_active') }}</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" @if ($user->isVerified()) checked @endif
                        disabled>
                    <label class="form-check-label">{{ trans('is_email_verified') }}</label>
                </div>
                <div class="d-flex align-items-center justify-content-end gap-2">
                    <a href="{{ query('callbackUrl') }}" class="btn btn-primary">{{ trans('go_back') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="<?php echo assets('/vendor/adminUserDetails.bundle.js'); ?>"></script>
@endpush
