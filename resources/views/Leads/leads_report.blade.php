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
<script>
    function printFilteredTable() {
        // Buat klon tabel yang akan dicetak
        var filteredTable = document.querySelector('table').cloneNode(true);

        // Dapatkan nilai dari kolom pemilik dan status yang dipilih
        var ownerValue = document.querySelector('select[name="owner"]').value;
        var statusValue = document.querySelector('select[name="status"]').value;

        // Cari semua baris di tabel klon yang tidak sesuai dengan filter
        var filteredRows = filteredTable.querySelectorAll('tbody tr:not([data-owner="' + ownerValue +
            '"]):not([data-status="' + statusValue + '"])');

        // Hapus baris yang tidak sesuai dengan filter
        filteredRows.forEach(function (row) {
            row.remove();
        });

        // Hapus kolom pemilik dan status dari tabel klon
        var filteredHeader = filteredTable.querySelector('thead tr');
        filteredHeader.removeChild(filteredHeader.children[1]);
        filteredHeader.removeChild(filteredHeader.children[8]);

        var filteredBody = filteredTable.querySelector('tbody');
        filteredBody.querySelectorAll('tr').forEach(function (row) {
            row.removeChild(row.children[1]);
            row.removeChild(row.children[8]);
        });

        // Buat jendela baru untuk mencetak tabel klon yang sudah difilter
        var printWindow = window.open('', '', 'height=' + screen.height + ',width=' + screen.width);
        printWindow.document.write('<html><head><title>Leads Report</title>');
        printWindow.document.write(
            '<style>table,th,td{border: 1px solid #ddd;text-align: left;}table {border-collapse: collapse;width: 100%;}th,td {padding: 15px;}</style>'
            );
        printWindow.document.write('</head><body>');
        printWindow.document.write(filteredTable.outerHTML);
        printWindow.document.write('</body></html>');

        // Cetak tabel klon yang sudah difilter
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }

</script>


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
                            <option value="{{ $owner->id }}"
                                {{ Request::input('owner') == $owner->id ? 'selected' : '' }}>{{ $owner->name }}
                            </option>
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
                            <option value="SrQL" {{ Request::input('status') == 'SrQL' ? 'selected' : '' }}>SrQL
                            </option>
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
            <a class="btn btn-danger btn-excel mb-3 ml-2" href="#" onclick="printFilteredTable()">
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
                        <tr data-owner="{{ $user->owner ? $user->owner->id : '' }}" data-status="{{ $user->status }}">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
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
