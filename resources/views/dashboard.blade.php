@extends('layout')
@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Hi, {{ auth()->user()->name }}</li>
            @if (Session::get('notAllowed'))
                <div class="alert alert-danger w-100" role="alert">
                    {{ Session::get('notAllowed')}}
                    <button type="button" class="btn-close float-end" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif            
        </ol>
    </div>
</main>
@endsection
