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
            <a class="btn btn-primary btn-excel ml-2 mb-2" href="{{ route('user.create') }}">
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
                            <th>Email</th>
                            <th>Role</th>
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
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created_At</th>
                            <th>Updated_At</th>
                            @if (Auth::user()->role == 'admin')
                            <th>Action</th>
                            @endif
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($users as $user)

                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role == 'admin')
                                <span class="badge badge-danger px-2">{{ $user->role }}</span>
                                @else
                                <span class="badge badge-primary px-2">{{ $user->role }}</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>{{ $user->updated_at->format('Y-m-d H:i:s') }}</td>
                            @if (Auth::user()->role == 'admin')
                            <td>
                                <div class="d-flex">
                                    <a title="Edit" class="btn btn-success me-1" title="Edit"
                                        href="{{ route('user.edit', $user->id) }}}"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('user.delete', $user->id) }}" method="post"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        @if (Auth::user()->id == $user->id)

                                        @else
                                        <button title="Delete" class="btn btn-danger" type="submit"><i
                                                class="bi bi-trash"></i></button>
                                        @endif
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
@endsection
