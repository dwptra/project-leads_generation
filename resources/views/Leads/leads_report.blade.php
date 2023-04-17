@extends('layout')
@section('content')

<style>
    table,
    td,
    th {
        border: 1px solid #ddd;
        text-align: left;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        padding: 15px;
    }
</style>

<main>
    <div class="container-fluid px-4">
            <h1 class="mt-4">Report Leads</h1>
            <form method="GET" action="{{ route('generate.report') }}">
                <div class="row">
                    <div class="col-sm-6 pr-sm-2">
                        <div class="form-group">
                            <label for="owner">Owner</label>
                            <select class="form-control" name="owner" required>
                                <option value="" selected disabled>Select</option>
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
                            <select class="form-control" name="status" required>
                                <option value="" selected disabled>Select</option>
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
                <a class="btn btn-success btn-excel mb-3" href="{{ route('exportLeadsToExcel') }}">
                    <i class="fa-solid fa-file-excel mr-1"></i> Excel
                </a>
                <a class="btn btn-danger btn-excel mb-3 ml-2" href="{{ route('leadPrintable')}}" target="_blank">
                    <i class="fa-solid fa-print me-1"></i> Print   
                </a>
            </div>
        </form>

        {{-- Tabel Leads --}}
        <div class="card mb-4">
            <div class="card-body">
                <table>
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
                            <th>History Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $user)
                        <tr>
                            <td>{{ $user->id}}</td>
                            <td>{{ $user->name}}</td>
                            <td>{{ $user->owner ? $user->owner->name : '-' }}</td>
                            <td>{{ $user->brand ?? '-' }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>{{ $user->email ?? '-' }}</td>
                            <td>{{ $user->instagram ?? '-' }}</td>
                            <td>{{ $user->tiktok ?? '-' }}</td>
                            <td>{{ $user->other ?? '-' }}</td>
                            <td>{{ $user->history->isNotEmpty() ? $user->history->sortByDesc('history_date')->first()->history_date : '-' }}
                            </td>
                            <td>{{ $user->status }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
