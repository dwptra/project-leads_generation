@extends('layout')
@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">User</h1>
        <div class="card mb-4">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($users as $user)
                        
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>*************</td>
                            <td>
                                <div class="d-flex">
                                    <a title="Edit" class="btn btn-dark me-1" title="Edit" href="/user/edit"><i class="bi bi-pencil-square"></i></a>
                                    <form action="">
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