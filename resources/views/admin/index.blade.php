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

        @default
            <div class="text-center py-12">
                <h2 class="text-2xl font-bold text-gray-800">Welcome to Admin Dashboard</h2>
                <p class="text-gray-600 mt-2">Select a section from the sidebar to manage.</p>
            </div>
    @endswitch
@endsection
