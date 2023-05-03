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
                <a class="btn btn-dark btn-excel ml-2 mb-2" href="{{ route('leads.create') }}">
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
                            <th>Owner</th>
                            <th>Brand</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Instagram</th>
                            <th>Tiktok</th>
                            <th>Other</th>
                            <th>Status</th>
                            @if (Auth::user()->role == 'admin')
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $user)

                        <tr>
                            <th>{{ $user->id}}</th>
                            <th>{{ $user->name}}</th>
                            <th>{{ $user->owner ? $user->owner->name : '-' }}</th>
                            <th>{{ $user->brand ?? '-' }}</th>
                            <th>{{ $user->phone ?? '-' }}</th>
                            <th>{{ $user->email ?? '-' }}</th>
                            <th>{{ $user->instagram ?? '-' }}</th>
                            <th>{{ $user->tiktok ?? '-' }}</th>
                            <th>{{ $user->other ?? '-' }}</th>
                            <th>{{  $user->status }}</th>
                            @if(Auth::user()->role == 'admin')
                            <td>
                                <div class="d-flex">
                                    <a title="Edit" class="btn btn-dark me-1" title="Edit"
                                        href="{{ route('leads.edit', $user['id']) }}"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('leads.delete', $user['id']) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this leads?')"
                                            class="btn btn-dark me-1" type="submit"><i class="bi bi-trash"></i></button>
                                    </form>
                                    <a class="btn btn-dark" href="{{ route('leads.histories', $user->id) }}" data-toggle="modal" data-target="#modalHistory{{ $user->id }}">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                          
                        
                    </tbody>
                </table>
                {{-- Modal --}}
                <div class="container mt-5">
                    <!-- button trigger modal -->
                  
                    <!-- modal -->
                    @foreach ($leads as $user)
                    <div class="modal" id="modalHistory{{ $user->id }}">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <!-- header modal -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Lead History</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <!-- body modal -->
                                <div class="modal-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Lead</th>
                                                <th>Status</th>
                                                <th>History Date</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Keterangan</th>
                                            </tr>   
                                        </thead>
                                        <tbody>
                                            @foreach ($histories as $history)
                                            @if ($history->leads_id == $user->id)
                                            <tr>
                                                <td>{{ $history->id }}</td>
                                                <td>{{ $history->leads->name }}</td>
                                                <td>{{ $history->status }}</td>
                                                <td>{{ $history->history_date }}</td>
                                                <td>{{ $history->created_at }}</td>
                                                <td>{{ $history->updated_at }}</td>
                                                <td>{{ $history->keterangan }}</td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- footer modal -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
