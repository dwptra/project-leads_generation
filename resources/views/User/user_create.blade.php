@extends('layout')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="mt-4">Create User</h1>
            <div class="d-flex justify-content-end ">
                <a class="btn btn-dark btn-excel ml-2" href="{{ route('user.index') }}">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <form method="post" action="{{ route('user.post') }}">
                    @csrf
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
                        <label for="name">Name<span class="text-danger">*</label>
                        <input name="name" type="text" class="form-control" id="name" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="email">Email<span class="text-danger">*</label>
                        <input name="email" type="email" class="form-control" id="email" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="password">Passwords<span class="text-danger">*</span></label>
                        <input name="password" type="password" class="form-control" id="password" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Roles<span class="text-danger">*</label>
                        <select class="form-control" aria-label=".form-select-sm example" name="role">
                            <option value="" selected disabled>Pilih role</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->role }}">{{ $user->role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark mt-3">Create</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
