@extends ('layout.template')
@section('content')

<div class="container mt-3">
    <div class="alert alert-secondary rounded-3 shadow-sm mb-4 p-4">
        <h4 class="text-center mb-0">Selamat Datang di Halaman Pembelian</h4>
    </div>

    <form method="GET" action="{{ route('order.riwayat') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="date" name="filter_date" class="form-control" value="{{ request('filter_date') }}" placeholder="Pilih Tanggal">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari Data</button>
                <a href="{{ route('order.riwayat')}}" type="submit" class="btn btn-primary">Reset</a>
            </div>
        </div>
    </form>

    <div class="d-flex justify-content-between mb-4 align-items-center">
        <h5 class="fw-bold text-uppercase">Daftar Pembelian</h5>
        <a href="{{ route('order.export-excel') }}" class="btn btn-primary btn-lg shadow-sm">Export Excel</a>
        {{-- Enhanced button style to "btn-primary btn-lg shadow-sm" --}}
    </div>

    <table class="table table-striped table-hover align-middle shadow-sm border">
        <thead class="bg-dark text-white">
            {{-- Professional header style with dark background --}}
            <tr>
                <th class="text-center">No</th>
                <th>Pembeli</th>
                <th>Obat</th>
                <th>Total Bayar</th>
                <th>Kasir</th>
                <th>Tanggal Pembelian</th> {{-- New Column Header --}}
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($riwayat as $item)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $item['name_customer'] }}</td>
                <td>
                    <ul class="list-group list-group-flush ps-2">
                        {{-- Grouped list items with "list-group" for consistent styling --}}
                        @foreach ($item['medicines'] as $medicine)
                        <li class="list-group-item bg-transparent border-0 p-0">
                            <span class="fw-bold">{{ $medicine['name_medicine'] }}</span> : 
                            Rp. {{ number_format($medicine['price'], 0, ',', '.') }} x 
                            <small>{{ $medicine['qty'] }}</small> = 
                            Rp. {{ number_format($medicine['sub_price'], 0, ',', '.') }}
                        </li>
                        @endforeach
                    </ul>
                </td>
                <td>Rp. {{ number_format($item['total_price'], 0, ',', '.') }}</td>
                <td>{{ $item['user']['name'] }}</td>
                <td>{{ \Carbon\Carbon::parse($item['created_at'])->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td> {{-- Updated Date Format --}}
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        @if ($riwayat->count())
            {{ $riwayat->links() }}
        @endif
    </div>
</div>
@endsection
