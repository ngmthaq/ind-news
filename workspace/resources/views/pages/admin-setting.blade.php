@extends('layouts.cms')

@section('content')
    <form id="setting-form" action="/admin/setting/save.html" method="post">
        <div class="row">
            <div class="mb-4 col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                <label for="theme-mode" class="form-label required">{{ trans('theme_mode') }}</label>
                <select class="form-select" id="theme-mode" name="theme">
                    <option value="light">{{ trans('light_mode') }}</option>
                    <option value="dark">{{ trans('dark_mode') }}</option>
                </select>
            </div>
            <div class="mb-4 col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4">
                <label for="language" class="form-label required">{{ trans('language') }}</label>
                <select class="form-select" id="language" name="language">
                    <option value="vi">Tiếng Việt</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="mb-4">
                <label for="seo-title" class="form-label required">{{ trans('seo_title') }}</label>
                <input type="text" class="form-control" id="seo-title" name="title" placeholder="Industry News">
            </div>
            <div class="mb-4">
                <label for="seo-keywords" class="form-label required">{{ trans('seo_keywords') }}</label>
                <input type="text" class="form-control" id="seo-keywords" name="keywords" placeholder="industry, news">
            </div>
            <div class="mb-4">
                <label for="seo-url" class="form-label required">{{ trans('seo_url') }}</label>
                <input type="text" class="form-control" id="seo-url" name="url" placeholder="https://example.com">
            </div>
            <div class="mb-4">
                <label for="seo-file" class="form-label required">{{ trans('seo_image') }}</label>
                <input class="form-control" type="file" id="seo-file" name="file">
            </div>
            <div class="mb-4">
                <label for="seo-desc" class="form-label required">{{ trans('seo_description') }}</label>
                <textarea type="text" class="form-control" id="seo-desc" name="description" placeholder="Industry News Description"
                    rows="6"></textarea>
            </div>
            <div class="d-flex align-items-center justify-content-end">
                <button type="submit" class="btn btn-primary" style="min-width: 160px;">
                    {{ trans('save') }}
                </button>
            </div>
        </div>
    </form>
@endsection

@push('js')
    <script src="<?php echo assets('/vendor/adminSetting.bundle.js'); ?>"></script>
@endpush
