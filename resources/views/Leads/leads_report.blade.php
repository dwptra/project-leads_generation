@extends('layout')
@section('content')
<main>
    <div class="container-fluid px-4">
            <h1 class="mt-4">Report Leads</h1>
            <form method="GET" action="{{ route('leadsReport') }}">
                <div class="row">
                    <div class="col-sm-6 pr-sm-2">
                        <div class="form-group">
                            <label for="owner_id">Owner</label>
                            <select class="form-control" name="owner_id">
                                <option value="all" selected>All</option>
                                @foreach ($owners as $owner)
                                    <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 pr-sm-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status">
                                <option value="all" selected>All</option>
                                <option value="new">New</option>
                                <option value="contacted">Contacted</option>
                                <option value="qualified">Qualified</option>
                                <option value="lost">Lost</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark mb-5">Generate</button>
            </form>            

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
                                        href="{{ route('leadsEdit', $user['id']) }}"><i
                                            class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('leadsDelete', $user['id']) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this leads?')"
                                            class="btn btn-dark me-1" type="submit"><i class="bi bi-trash"></i></button>
                                    </form>
                                    <a class="btn btn-dark" href="{{ route('leadsHistories', $user->id) }}" data-toggle="modal" data-target="#modalHistory{{ $user->id }}">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
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
