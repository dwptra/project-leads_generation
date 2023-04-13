@extends('layout')
@section('content')
<main>
   
    <div class="container-fluid px-4">
            <h1 class="mt-4">Leads</h1>

            {{-- Alert --}}
            @if (Session::get('createLeads'))
            <div class="alert alert-success">
                {{ Session::get('createLeads')}}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif
            @if (Session::get('updateLeads'))
            <div class="alert alert-success">
                {{ Session::get('updateLeads')}}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif
            @if (Session::get('deleteLeads'))
            <div class="alert alert-success">
                {{ Session::get('deleteLeads')}}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            {{-- Link ke Page Create Leads --}}

            @if (Auth::user()->role == 'admin' ||  Auth::user()->role == 'owner')
            <div class="d-flex justify-content-end ">
                <a class="btn btn-dark btn-excel ml-2 mb-2" href="/leadsCreate">
                    <i class="fa-solid fa-plus mr-2"></i> Create New
                </a>
            </div>
            @endif

        {{-- Tabel Leads --}}

        <div class="card mb-4">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Owner ID</th>
                            <th>Brand</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Instagram</th>
                            <th>Tiktok</th>
                            <th>Other</th>
                            <th>Status</th>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'owner')
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $user)

                        <tr>
                            <th>{{$user->id}}</th>
                            <th>{{$user->name}}</th>
                            <th>{{$user->owner_id}}</th>
                            <th>{{$user->brand}}</th>
                            <th>{{$user->phone}}</th>
                            <th>{{$user->email}}</th>
                            <th>{{$user->instagram}}</th>
                            <th>{{$user->tiktok}}</th>
                            <th>{{$user->other}}</th>
                            <th>{{$user->status}}</th>
                            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'owner')
                            <td>
                                <div class="d-flex">
                                    <a title="Edit" class="btn btn-dark me-1" title="Edit"
                                        href="{{ route('leadsEdit', $user['id']) }}"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('leadsDelete', $user['id']) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this leads?')"
                                            class="btn btn-dark" type="submit"><i class="bi bi-trash"></i></button>
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
