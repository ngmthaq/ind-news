@extends('layouts.cms')

@section('content')
    <div class="admin-user-update">
        <form id="user-info-form">
            <div class="row">
                <div class="col-4 col-sm-4 col-md-3 col-lg-2 col-xl-2">
                    <div class="avatar-container">
                        <img src="{{ $user->avatar }}" alt="{{ $user->name }}" id="avatar-preview">
                        <input hidden type="file" id="avatar" name="avatar" data-default-avatar="{{ $user->avatar }}">
                        <label for="avatar">{{ trans('change_avatar') }}</label>
                    </div>
                </div>
                <div class="col-8 col-sm-8 col-md-9 col-lg-10 col-xl-10">
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ trans('email_address') }}</label>
                        <input type="text" class="form-control" id="email" value="{{ $user->email }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ trans('name') }}</label>
                        <input type="text" class="form-control" id="name" value="{{ $user->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">{{ trans('dob') }}</label>
                        <input type="date" class="form-control" id="dob"
                            value="{{ date('Y-m-d', strtotime($user->dob)) }}">
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">{{ trans('gender') }}</label>
                        <select class="form-select" id="gender" name="gender">
                            <option value="1" @if ($user->gender === Src\Models\User::MALE) selected @endif>
                                {{ trans('male') }}
                            </option>
                            <option value="2" @if ($user->gender === Src\Models\User::FEMALE) selected @endif>
                                {{ trans('female') }}
                            </option>
                            <option value="3" @if ($user->gender === Src\Models\User::OTHER) selected @endif>
                                {{ trans('other') }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="role" class="form-label">{{ trans('role') }}</label>
                        <select class="form-select" id="role" name="role">
                            <option value="1" @if ($user->role === Src\Models\User::USER) selected @endif>
                                {{ trans('user') }}
                            </option>
                            <option value="2" @if ($user->role === Src\Models\User::ADMIN) selected @endif>
                                {{ trans('admin_long_name') }}
                            </option>
                        </select>
                    </div>
                    <div class="mb-4 d-flex align-items-center gap-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="status" name="status"
                                @if ($user->isActive()) checked @endif
                                data-action="{{ route('/admin/mng/users/edit.json') }}" data-id="{{ $user->id }}">
                        </div>
                        <label for="status" class="form-label m-0 user-select-none" style="cursor: pointer">
                            {{ trans('status_long') }}
                        </label>
                    </div>
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <a href="{{ query('callbackUrl') }}" class="btn btn-danger">{{ trans('go_back') }}</a>
                        <button class="btn btn-secondary" type="reset">{{ trans('reset') }}</button>
                        <button class="btn btn-warning" type="button">{{ trans('reset_password') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('js')
    <script src="<?php echo assets('/vendor/adminUserUpdate.bundle.js'); ?>"></script>
@endpush
