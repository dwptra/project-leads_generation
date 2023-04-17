@extends('layout')
@section('content')
<main>
    <div class="container-fluid px-4">
            <h1 class="mt-4">Report Leads</h1>
            <form method="GET" action="{{ route('generate.report') }}">
                <div class="row">
                    <div class="col-sm-6 pr-sm-2">
                        <div class="form-group">
                            <label for="owner">Owner</label>
                            <select class="form-control" name="owner">
                                <option value="all" {{ Request::input('owner') == 'all' ? 'selected' : '' }}>All</option>
                                @foreach ($owners as $owner)
                                    <option value="{{ $owner->id }}" {{ Request::input('owner') == $owner->id ? 'selected' : '' }}>{{ $owner->name }}</option>
                                @endforeach
                            </select>                            
                        </div>
                    </div>
                    <div class="col-sm-6 pr-sm-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status">
                                <option value="all" {{ Request::input('status') == 'all' ? 'selected' : '' }}>All</option>
                                <option value="MQL" {{ Request::input('status') == 'MQL' ? 'selected' : '' }}>MQL</option>
                                <option value="PQL" {{ Request::input('status') == 'PQL' ? 'selected' : '' }}>PQL</option>
                                <option value="SQL" {{ Request::input('status') == 'SQL' ? 'selected' : '' }}>SQL</option>
                                <option value="SrQL" {{ Request::input('status') == 'SrQL' ? 'selected' : '' }}>SrQL</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-dark ">Generate</button>
                <hr>
            </form>            
            <div class="d-flex justify-content-end mt-4">
                <a class="btn btn-success btn-excel mb-3" href="">
                    <i class="fa-solid fa-file-excel mr-1"></i> Excel
                </a>
                <a class="btn btn-danger btn-excel mb-3 ml-2" href="">
                    <i class="fa-solid fa-print me-1"></i> Print   
                </a>
            </div>

        {{-- Tabel Leads --}}
        <div class="card">
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
                            <th>History Date</th>
                            <th>Status</th>
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
                            <th>{{ '-' }}</th>
                            <th>{{  $user->status }}</th>
                        </tr>
                        @endforeach
                          
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
