@extends('layout')

@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="mt-4">Update User</h1>
            <div class="d-flex justify-content-end ">
                <a class="btn btn-success btn-excel ml-2" data-toggle="modal"
                data-target="#changePassword{{ $users->id }}">
                    <i class="fa-solid fa-lock mr-1"></i> Change Password
                </a>
                <a class="btn btn-danger btn-excel ml-2" href="{{ route('user.index') }}">
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
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input name="name" type="text" class="form-control" id="name" value="{{ $users->name }}" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="email">Email<span class="text-danger">*</span></label>
                        <input name="email" type="email" class="form-control" id="email" value="{{ $users->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Roles<span class="text-danger">*</span></label>
                        <select class="form-control" aria-label=".form-select-sm example" name="role" required>
                            <option value="admin" {{ $users->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ $users->role == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="changePassword{{ $users->id }}" tabindex="-1" role="dialog" aria-labelledby="changePassword"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePassword">Edit Owner</h5>
            </div>
            <form method="post" action="{{ route('change.password', $users->id) }}">
                <div class="modal-body">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Password<span class="text-danger">*</span></label>
                        <input name="password" type="password" class="form-control" id="recipient-name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
