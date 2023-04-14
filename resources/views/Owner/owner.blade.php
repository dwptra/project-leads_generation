@extends('layout')
@section('content')
<main>
    <div class="container-fluid px-4">
        {{-- Heading --}}
        <h1 class="mt-4">User</h1>

        {{-- Alert --}}
        @if (Session::get('createUser'))
        <div class="alert alert-success">
            {{ Session::get('createUser')}}
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
        @endif
        @if (Session::get('userDelete'))
        <div class="alert alert-success">
            {{ Session::get('userDelete')}}
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
        @endif
        @if (Session::get('userUpdate'))
        <div class="alert alert-success">
            {{ Session::get('userUpdate')}}
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        </div>
        @endif

        {{-- Create New Button --}}
        @if (Auth::user()->role == 'admin')
        <div class="d-flex justify-content-end ">
            <a class="btn btn-dark btn-excel ml-2 mb-2" data-toggle="modal" data-target="#ownerCreateModal">
                <i class="fa-solid fa-plus ml-2"></i> Create New
            </a>
        </div>
        @endif

        {{-- Datatable --}}
        <div class="card mb-4">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Created_At</th>
                            <th>Updated_At</th>
                            @if (Auth::user()->role == 'admin')
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Created_At</th>
                            <th>Updated_At</th>
                            @if (Auth::user()->role == 'admin')
                            <th>Action</th>
                            @endif
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($owners as $owner)

                        <tr>
                            <td>{{ $owner->id }}</td>
                            <td>{{ $owner->name }}</td>
                            <td>{{ $owner->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $owner->updated_at->format('Y-m-d H:i:s') }}</td>
                            @if (Auth::user()->role == 'admin')
                            <td>
                                <div class="d-flex">
                                    <a title="Edit" class="btn btn-dark me-1" title="Edit"
                                        href="{{ route('owner.edit', $owner->id) }}}"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('owner.delete', $owner->id) }}" method="post"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Delete" class="btn btn-dark" type="submit"><i
                                                class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>


{{-- Modal Create --}}
<div class="modal fade" id="ownerCreateModal" tabindex="-1" role="dialog" aria-labelledby="ownerCreateModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ownerCreateModal">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="owner.post">
                    @csrf
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Nama:</label>
                        <input type="text" class="form-control" id="recipient-name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</div>
@endsection
