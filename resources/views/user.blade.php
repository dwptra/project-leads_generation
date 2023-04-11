@extends('layout')
@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">User</h1>
        <div class="d-flex justify-content-end ">
            <a class="btn btn-primary btn-excel ml-2 mb-2" href="/createLeads">
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
                                    <a title="Edit" class="btn btn-dark me-1" title="Edit" href="/user/edit"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('user.delete', $user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Delete" class="btn btn-dark" type="submit"><i class="bi bi-trash"></i></button>
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