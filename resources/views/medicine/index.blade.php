@extends ('layout.template')
@section('content')

@if(Session::get('success'))
    <div class="alert alert-success" style="font-size: 1.1em; color: #155724; background-color: #d4edda; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0, 128, 0, 0.1);">
        {{ Session::get('success') }}
    </div>
@endif

@if(Session::get('deleted'))
    <div class="alert alert-warning" style="font-size: 1.1em; color: #856404; background-color: #fff3cd; border-radius: 8px; box-shadow: 0px 4px 10px rgba(255, 193, 7, 0.1);">
        {{ Session::get('deleted') }}
    </div>
@endif

<div class="table-responsive" style="background-color: #ffffff; padding: 20px; border-radius: 15px; box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);">
    <table class="table table-hover" style="width: 100%; border-collapse: collapse;">
        <thead style="background-color: #34495e; color: #ecf0f1;">
            <tr>
                <th style="padding: 15px; text-align: left; border-bottom: 3px solid #bdc3c7;">No</th>
                <th style="padding: 15px; text-align: left; border-bottom: 3px solid #bdc3c7;">Nama</th>
                <th style="padding: 15px; text-align: left; border-bottom: 3px solid #bdc3c7;">Tipe</th>
                <th style="padding: 15px; text-align: left; border-bottom: 3px solid #bdc3c7;">Harga</th>
                <th style="padding: 15px; text-align: left; border-bottom: 3px solid #bdc3c7;">Stok</th>
                <th style="padding: 15px; text-align: center; border-bottom: 3px solid #bdc3c7;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($medicines as $item)
                <tr style="border-bottom: 1px solid #ddd; transition: background-color 0.3s;">
                    <td style="padding: 15px;">{{ $no++ }}</td>
                    <td style="padding: 15px;">{{ $item['name'] }}</td>
                    <td style="padding: 15px;">{{ $item['type'] }}</td>
                    <td style="padding: 15px;">{{ $item['price'] }}</td>
                    <td style="padding: 15px;">{{ $item['stock'] }}</td>
                    <td class="d-flex justify-content-center" style="padding: 15px;">
                        <a href="{{ route('medicine.edit', $item['id']) }}" class="btn btn-primary me-3" style="background-color: #3498db; border: none; border-radius: 20px; padding: 10px 20px; font-size: 0.9em; color: white; transition: background-color 0.3s;">
                            Edit
                        </a>
                        <form action="{{ route('medicine.delete', $item['id']) }}" method="POST" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" style="background-color: #e74c3c; border: none; border-radius: 20px; padding: 10px 20px; font-size: 0.9em; color: white; transition: background-color 0.3s;">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
