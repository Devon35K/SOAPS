@extends('admin.layout')

@section('content')
    @switch($currentPage)
        @case('Student Athletes')
            @include('admin.partials.student-athletes')
            @break

        @case('Achievement')
            @include('admin.partials.achievements')
            @break

        @case('Evaluation')
            @include('admin.partials.evaluations')
            @break

        @case('Approved Docs')
            @include('admin.partials.approved-docs')
            @break

        @case('Reports')
            @include('admin.partials.reports')
            @break

        @case('Account Approvals')
            @include('admin.partials.account-approvals')
            @break

        @case('Users')
            @include('admin.partials.users')
            @break

        @case('Create User')
            @include('admin.partials.create-user')
            @break

        @case('Edit User')
            @include('admin.partials.edit-user')
            @break

        @default
            @include('admin.partials.dashboard')
    @endswitch
@endsection
