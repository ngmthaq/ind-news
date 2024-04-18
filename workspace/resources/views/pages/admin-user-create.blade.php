@extends('layouts.cms')

@section('content')
    <form method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="mb-3">
                    <label for="email" class="form-label required">{{ trans('email_address') }}</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="mb-3">
                    <label for="name" class="form-label required">{{ trans('name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nguyen Van A">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="mb-3">
                    <label for="dob" class="form-label required">{{ trans('dob') }}</label>
                    <input type="date" class="form-control" id="dob" name="dob">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="mb-3">
                    <label for="gender" class="form-label required">{{ trans('gender') }}</label>
                    <select class="form-select" id="gender" name="gender">
                        <option value="1">{{ trans('male') }}</option>
                        <option value="2">{{ trans('female') }}</option>
                        <option value="3">{{ trans('other') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="mb-3">
                    <label for="role" class="form-label required">{{ trans('role') }}</label>
                    <select class="form-select" id="role" name="role">
                        <option value="1">{{ trans('user') }}</option>
                        <option value="2">{{ trans('admin_long_name') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="mb-3">
                    <label for="avatar" class="form-label">{{ trans('avatar') }}</label>
                    <input type="file" class="form-control" id="avatar" name="avatar">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="mb-3">
                    <label for="password" class="form-label required">{{ trans('default_password') }}</label>
                    <input type="text" class="form-control" id="password" name="password"
                        value="{{ $defaultPassword }}" readonly>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                <div class="mb-3">
                    <label for="need-verify-email" class="form-label required">{{ trans('need_verify_email') }}</label>
                    <select class="form-select" id="need-verify-email" name="need-verify-email">
                        <option value="0">{{ trans('no') }}</option>
                        <option value="1">{{ trans('yes') }}</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-end gap-2">
                    <a href="/admin/mng/users.html" class="btn btn-danger">{{ trans('cancel') }}</a>
                    <button class="btn btn-secondary" type="reset">{{ trans('reset') }}</button>
                    <button class="btn btn-primary" type="submit">{{ trans('create') }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('js')
    <script src="<?php echo assets('/vendor/adminUserCreate.bundle.js'); ?>"></script>
@endpush
