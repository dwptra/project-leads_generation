@extends('layout')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="mt-4">Leads</h1>
            <div class="d-flex justify-content-end ">
                <a class="btn btn-primary btn-excel ml-2" href="/leadsCreate">
                    <i class="fa-solid fa-plus mr-2"></i>Create New
                </a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Owner ID</th>
                            <th>Brand</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Instagram</th>
                            <th>Tiktok</th>
                            <th>Other</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $user)
                        
                        <tr>
                            <th>{{$user->id}}</th>
                            <th>{{$user->owner_id}}</th>
                            <th>{{$user->brand}}</th>
                            <th>{{$user->name}}</th>
                            <th>{{$user->phone}}</th>
                            <th>{{$user->email}}</th>
                            <th>{{$user->instagram}}</th>
                            <th>{{$user->tiktok}}</th>
                            <th>{{$user->other}}</th>
                            <th>{{$user->status}}</th>
                            <td>
                                <div class="d-flex">
                                    <a title="Edit" class="btn btn-dark me-1" title="Edit" href="{{ route('leadsEdit', $user['id']) }}"><i class="bi bi-pencil-square"></i></a>
                                    <form>
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