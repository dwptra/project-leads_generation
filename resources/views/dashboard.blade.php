@extends('layout')
@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        @if (Session::get('notAllowed'))
        <div class="alert alert-danger w-100" role="alert">
            {{ Session::get('notAllowed')}}
            <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Hi, {{ auth()->user()->name }}</li>
        </ol>

        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">Users Account</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="small text-white">Total : {{ $userCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">Leads</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="small text-white">Total : {{ $leadsCount }}</p>
                    </div>
                </div>
            </div>
        </div>
</main>
@endsection
