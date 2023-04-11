@extends('layout')

@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="mt-4">Update User</h1>
            <div class="d-flex justify-content-end ">
                <a class="btn btn-dark btn-excel ml-2" href="{{ route('user.index') }}">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <form method="post" action="{{ route('user.update', $users->id) }}">
                    @csrf
                    @method('PATCH')
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="form-group mt-2">
                        <label for="name">Name</label>
                        <input name="name" type="text" class="form-control" id="name" value="{{ $users->name }}">
                    </div>
                    <div class="form-group mt-2">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control" id="password">
                    </div>
                    <button type="submit" class="btn btn-dark mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
