@extends('layouts.cms')

@section('content')
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4">
        <form class="input-group" style="max-width: 500px" title="{{ trans('search_user_placeholder') }}">
            <input type="text" class="form-control" name="filter" placeholder="{{ trans('search_user_placeholder') }}"
                value="{{ query('filter', '') }}">
            <input type="hidden" name="page" value="1">
            <button class="input-group-text btn btn-primary" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
        <a href="/admin/mng/users/create.html" class="btn btn-primary flex-shrink-0" title="{{ trans('add_new_user') }}">
            <i class="bi bi-plus-lg"></i>
            {{ trans('add_new_user') }}
        </a>
    </div>
    <div class="table-sticky-container" style="height: 560px">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" style="width: 5%">#</th>
                    <th scope="col" style="width: 15%">
                        {{ trans('email_address') }}
                    </th>
                    <th scope="col" style="width: 15%">
                        {{ trans('name') }}
                    </th>
                    <th scope="col" style="width: 15%">
                        {{ trans('dob') }}
                    </th>
                    <th scope="col" style="width: 15%">
                        {{ trans('gender') }}
                    </th>
                    <th scope="col" style="width: 15%">
                        {{ trans('role') }}
                    </th>
                    <th scope="col" style="width: 10%">
                        {{ trans('status') }}
                    </th>
                    <th scope="col" style="width: 10%">
                        {{ trans('action') }}
                    </th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @if (isset($pagination) && isset($pagination->data) && count($pagination->data) > 0)
                    @foreach ($pagination->data as $index => $user)
                        <tr>
                            <th style="vertical-align: middle" scope="row" title="{{ $index + 1 }}">
                                {{ $pagination->offset + $index + 1 }}
                            </th>
                            <td style="vertical-align: middle" title="{{ $user->email }}">
                                {{ $user->email }}
                            </td>
                            <td style="vertical-align: middle" title="{{ $user->name }}">
                                {{ $user->name }}
                            </td>
                            <td style="vertical-align: middle" title="{{ date('d/m/Y', strtotime($user->dob)) }}">
                                {{ date('d/m/Y', strtotime($user->dob)) }}
                            </td>
                            <td style="vertical-align: middle" title="{{ $user->getGender() }}">
                                {{ $user->getGender() }}
                            </td>
                            <td style="vertical-align: middle" title="{{ $user->getRole() }}">
                                {{ $user->getRole() }}
                            </td>
                            <td style="vertical-align: middle">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        @if ($user->isActive()) checked @endif
                                        data-action="{{ route('/admin/mng/users/edit.json') }}"
                                        data-id="{{ $user->id }}">
                                </div>
                            </td>
                            <td>
                                <a class=" btn btn-sm btn-outline-primary"
                                    href="{{ route('/admin/mng/users/show.html', ['id' => $user->id]) }}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a class="btn btn-sm btn-outline-warning"
                                    href="{{ route('/admin/mng/users/edit.html', ['id' => $user->id]) }}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="8" class="text-center p-3">
                            {{ trans('no_data') }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    @if (isset($pagination) && isset($pagination->data) && count($pagination->data) > 0)
        <div class="d-flex align-items-center justify-content-between gap-2  mt-3">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link @if ($pagination->currentPage === 1) disabled @endif"
                            href="{{ route('/admin/mng/users.html', array_merge(query(), ['page' => 1])) }}">
                            <i class="bi bi-chevron-bar-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link @if ($pagination->currentPage === 1) disabled @endif"
                            href="{{ route('/admin/mng/users.html', array_merge(query(), ['page' => $pagination->prevPage])) }}">
                            <i class="bi bi-chevron-left"></i>
                        </a>
                    </li>
                    @for ($i = 1; $i <= $pagination->totalPages; $i++)
                        <li class="page-item">
                            <a class="page-link @if ($pagination->currentPage === $i) active @endif"
                                href="{{ route('/admin/mng/users.html', array_merge(query(), ['page' => $i])) }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor
                    <li class="page-item">
                        <a class="page-link @if ($pagination->currentPage === $pagination->totalPages) disabled @endif"
                            href="{{ route('/admin/mng/users.html', array_merge(query(), ['page' => $pagination->nextPage])) }}">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link @if ($pagination->currentPage === $pagination->totalPages) disabled @endif"
                            href="{{ route('/admin/mng/users.html', array_merge(query(), ['page' => $pagination->totalPages])) }}">
                            <i class="bi bi-chevron-bar-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <div>
                <small>
                    {{ trans('pagination_desc', [
                        'from' => $pagination->fromItems,
                        'to' => $pagination->toItems,
                        'total' => $pagination->totalItems,
                    ]) }}
                </small>
            </div>
        </div>
    @endif
@endsection

@push('js')
    <script src="<?php echo assets('/vendor/adminUserManagement.bundle.js'); ?>"></script>
@endpush
