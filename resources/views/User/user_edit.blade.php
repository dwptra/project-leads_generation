@extends('layout')

@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="mt-4">Update User</h1>
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
                        <label for="email">Email</label>
                        <input name="email" type="email" class="form-control" id="email" value="{{ $users->email }}">
                    </div>
                    <div class="form-group mt-2">
                        <label for="password">Password</label>
                        <input name="password" type="password" class="form-control" id="password">
                    </div>
                    <div class="form-group">
                        <label for="name">Roles</label>
                        <select class="form-control" aria-label=".form-select-sm example" name="role">
                            <option value="admin" {{ $users->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ $users->role == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end ">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a class="btn btn-danger btn-excel ml-1" href="{{ route('user.index') }}">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
