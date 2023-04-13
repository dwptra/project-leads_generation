@extends('layout')
@section('content')
<main>

    <div class="container-fluid px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="mt-4">Histories Leads</h1>

            {{-- Alert --}}
            @if (Session::get('historiesDelete'))
            <div class="alert alert-success">
                {{ Session::get('historiesDelete')}}
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            </div>
            @endif

            
        {{-- Tabel HIstory Leads --}}

        </div>
        <div class="card mb-4">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Lead ID</th>
                            <th>Status</th>
                            <th>History Date</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'owner')
                            <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($histories as $history)

                        <tr>
                            <th>{{ $history->id }}</th>
                            <th>{{ $history->leads_id }}</th>
                            <th>{{ $history->status }}</th>
                            <th>{{ $history->history_date }}</th>
                            <th>{{ $history->created_at->format('Y-m-d H:i:s') }}</th>
                            <th>{{ $history->updated_at->format('Y-m-d H:i:s') }}</th>
                            @if (Auth::user()->role == 'admin' || Auth::user()->role == 'owner')
                            <td>
                                <div class="d-flex">
                                    <form action="{{ route('historiesDelete', $history['id']) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Delete"
                                            onclick="return confirm('Are you sure you want to delete this history?')"
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
