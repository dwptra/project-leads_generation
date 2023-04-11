@extends('layout')
@section('content')
<main>
    @if (Session::get('createUser'))
    <div class="alert alert-success">
        {{ Session::get('createUser')}}
        <a href="#" style="text-decoration: none" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
    @endif
    @if (Session::get('userDelete'))
    <div class="alert alert-success">
        {{ Session::get('userDelete')}}
        <a href="#" style="text-decoration: none" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    </div>
    @endif

    <div class="container-fluid px-4">
        <h1 class="mt-4">User</h1>
        <div class="d-flex justify-content-end ">
            <a class="btn btn-dark btn-excel ml-2 mb-2" href="{{ route('user.create') }}">
                <i class="fa-solid fa-plus ml-2"></i> Create New
            </a>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Password</th>
                            <th>Created_At</th>
                            <th>Updated_At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Password</th>
                            <th>Created_At</th>
                            <th>Updated_At</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($users as $user)

                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>*************</td>
                            <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $user->updated_at->format('Y-m-d H:i:s') }}</td>
                            <td>
                                <div class="d-flex">
                                    <a title="Edit" class="btn btn-dark me-1" title="Edit" href="/user/edit"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('user.delete', $user->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Delete" class="btn btn-dark" type="submit"><i
                                                class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection