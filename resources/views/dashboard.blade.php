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

        @foreach($owners as $owner)
        <div class="row">
            <h3>{{ $owner->name }}</h3>
            @php
                $mqlCount = App\Models\Leads::where('owner_id', $owner->id)->where('status', 'MQL')->count();
                $pqlCount = App\Models\Leads::where('owner_id', $owner->id)->where('status', 'PQL')->count();
                $sqlCount = App\Models\Leads::where('owner_id', $owner->id)->where('status', 'SQL')->count();
                $srqlCount = App\Models\Leads::where('owner_id', $owner->id)->where('status', 'SrQL')->count();
            @endphp
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary text-white mb-4">
                    <div class="card-body">MQL</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="small text-white">Total : {{ $mqlCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-success text-white mb-4">
                    <div class="card-body">PQL</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="small text-white">Total : {{ $pqlCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">SQL</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="small text-white">Total : {{ $sqlCount }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-danger text-white mb-4">
                    <div class="card-body">SrQL</div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="small text-white">Total : {{ $srqlCount }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</main>
@endsection