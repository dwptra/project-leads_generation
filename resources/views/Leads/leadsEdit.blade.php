@extends('layout')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="mt-4">Edit Leads</h1>
            <div class="d-flex justify-content-end ">
                <a class="btn btn-dark btn-excel ml-2" href="/leads">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>

        {{-- Alert jika error --}}

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Form edit leads --}}

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('leadsUpdate', $user['id']) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group mt-2">
                        <label for="phone">Name</label>
                        <input name="name" type="text" class="form-control" id="phone" value="{{ $user['name'] }}" required>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-sm-6 pr-sm-2">
                            <div class="form-group">
                                <label for="name">Owner ID</label>
                                <select class="form-control" aria-label=".form-select-sm example" name="owner_id">
                                    <option value="" {{ empty($user['owner_id']) ? ' selected' : ' ' }}>Null</option>
                                    @foreach($owner as $data)
                                        <option value="{{$data['id']}}" {{ $user['owner_id'] == $data['id'] ? 'selected' : '' }}>{{$data['id']}}</option>
                                    @endforeach
                                </select>                              
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Brand</label>
                                <input name="brand" type="text" class="form-control" id="brand"
                                    value="{{ $user['brand'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-sm-6 pr-sm-2">
                            <div class="form-group">
                                <label for="name">Phone</label>
                                <input name="phone" type="number" class="form-control" id="name"
                                    value="{{ $user['phone'] }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" type="email" class="form-control" id="email"
                                    value="{{ $user['email'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-sm-6 pr-sm-2">
                            <div class="form-group">
                                <label for="instagram">Instagram</label>
                                <input name="instagram" type="TEXT" class="form-control" id="name"
                                    value="{{ $user['instagram'] }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="tiktok">Tiktok</label>
                                <input name="tiktok" type="text" class="form-control" id="email"
                                    value="{{ $user['tiktok'] }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label for="phone">Other</label>
                        <input name="other" type="text" class="form-control" id="other" value="{{ $user['other'] }}">
                    </div>
                    <div class="form-group mt-2">
                        <label for="tiktok">Status</label>
                        <select class="form-control" aria-label=".form-select-sm example" name="status">
                            <option value="MQL" {{ $user['status'] == 'MQL' ? 'selected' : '' }}>MQL</option>
                            <option value="SQL" {{ $user['status'] == 'SQL' ? 'selected' : '' }}>SQL</option>
                            <option value="PQL" {{ $user['status'] == 'PQL' ? 'selected' : '' }}>PQL</option>
                            <option value="SrQL" {{ $user['status'] == 'SrQL' ? 'selected' : '' }}>SrQL</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
