@extends('layout.template')

@section('content')
<div id="msg-success" class="alert alert-success d-none" role="alert"></div>

<table class="table table-hover table-responsive" style="border-radius: 10px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
    <thead class="bg-light">
        <tr>
            <th class="text-center" style="width: 5%;">No</th>
            <th>Nama Obat</th>
            <th class="text-center">Tipe</th>
            <th class="text-center">Stok</th>
            <th class="text-center" style="width: 15%;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($medicine as $item)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $item['name'] }}</td>
                <td class="text-center">{{ ucfirst($item['type']) }}</td>
                <td class="text-center {{ $item['stock'] <= 3 ? 'text-danger' : 'text-success' }}">
                    {{ $item['stock'] }}
                </td>
                <td class="text-center">
                    <button onclick="edit({{ $item['id'] }})" class="btn btn-primary btn-sm" style="border-radius: 20px;">Tambah Stock</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal for Editing Stock -->
<div class="modal fade" id="edit-stock" tabindex="-1" aria-labelledby="editStockLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 10px;">
            <div class="modal-header" style="background-color: #007bff; color: white;">
                <h5 class="modal-title" id="editStockLabel">Ubah Data Stok</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form-stock">
                <div class="modal-body">
                    <div id="msg" class="alert d-none"></div>
                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Obat:</label>
                        <input type="text" class="form-control" id="name" name="name" disabled style="background-color: #f8f9fa;">
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok Obat:</label>
                        <input type="number" class="form-control" id="stock" name="stock" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function edit(id) {
        var url = "{{ route('medicine.stock.edit', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function(res) {
                $('#edit-stock').modal('show');
                $('#id').val(res.id);
                $('#name').val(res.name);
                $('#stock').val(res.stock);
            }
        });
    }

    $('#form-stock').submit(function(e) {
        e.preventDefault();

        var id = $('#id').val();
        var urlForm = "{{ route('medicine.stock.update', ':id') }}";
        urlForm = urlForm.replace(':id', id);

        var data = {
            stock: $('#stock').val()
        };

        $.ajax({
            type: "PATCH",
            url: urlForm,
            data: data,
            cache: false,
            success: function(data) {
                $("#edit-stock").modal('hide');
                sessionStorage.reloadAfterPageLoad = true;
                window.location.reload();
            },
            error: function(data) {
                $('#msg').removeClass('d-none').addClass('alert-danger');
                $('#msg').text(data.responseJSON.message);
            }
        });
    });

    $(function() {
        if (sessionStorage.reloadAfterPageLoad) {
            $("#msg-success").removeClass("d-none").text("Berhasil menambahkan data stok!");
            sessionStorage.clear();
        }
    });
</script>
@endpush
@endsection
