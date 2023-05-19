@extends('layout')
@section('content')
<main>
    <div class="container-fluid px-4">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="mt-4">Create Leads</h1>
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

        {{-- Form Create Leads --}}

        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('leads.post') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="phone">Name</label>
                        <input name="name" type="text" class="form-control" id="phone" required>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 pr-sm-2">
                            <div class="form-group">
                                <label for="name">Owner</label>
                                <select class="form-control" aria-label=".form-select-sm example" name="owner_id">
                                    <option value="" selected>Select</option>                                                                    
                                    @foreach ($owners as $owner)
                                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                                    @endforeach
                                </select>                                
                            </div>
                        </div>
                        <div class="col-sm-6 pl-sm-2">
                            <div class="form-group">
                                <label for="email">Brand</label>
                                <input name="brand" type="text" class="form-control" id="email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 pr-sm-2">
                            <div class="form-group">
                                <label for="name">Phone</label>
                                <input name="phone" type="number" class="form-control" id="name">
                            </div>
                        </div>
                        <div class="col-sm-6 pl-sm-2">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input name="email" type="email" class="form-control" id="email">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 pr-sm-2">
                            <div class="form-group">
                                <label for="instagram">Instagram</label>
                                <input name="instagram" type="TEXT" class="form-control" id="name">
                            </div>
                        </div>
                        <div class="col-sm-6 pl-sm-2">
                            <div class="form-group">
                                <label for="tiktok">Tiktok</label>
                                <input name="tiktok" type="text" class="form-control" id="email">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="other">Other</label>
                        <input name="other" type="text" class="form-control" id="other">
                    </div>
                    <div class="d-flex justify-content-end ">
                        <button type="submit" class="btn btn-success">Save</button>
                        <a class="btn btn-danger btn-excel ml-2" href="{{ route('leads') }}">
                            Cancel
                        </a>
                    </div>
                </form>                
            </div>
        </div>
    </div>
</main>
@endsection
