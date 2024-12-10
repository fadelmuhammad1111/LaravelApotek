@extends('layout.template')

@section('content')
<div class="container" style="max-width: 650px; margin-top: 30px;">
    <form action="{{ route('medicine.store') }}" method="POST" class="card p-5" style="background-color: #ffffff; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.15);">
        @csrf

        <!-- Success Message -->
        @if(Session::get('success'))
            <div class="alert alert-success" style="border-radius: 5px; font-size: 1em; text-align: center; color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb;">
                {{ Session::get('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <ul class="alert alert-danger" style="border-radius: 5px; font-size: 1em; color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <!-- Form Fields -->
        <div class="mb-4 row">
            <label for="name" class="col-sm-3 col-form-label" style="font-weight: 500; color: #333; font-size: 0.9em;">Nama Obat:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="name" name="name" style="border-radius: 8px; border: 1px solid #ccc; padding: 10px; font-size: 0.95em;">
            </div>
        </div>

        <div class="mb-4 row">
            <label for="type" class="col-sm-3 col-form-label" style="font-weight: 500; color: #333; font-size: 0.9em;">Jenis Obat:</label>
            <div class="col-sm-9">
                <select class="form-select" id="type" name="type" style="border-radius: 8px; border: 1px solid #ccc; padding: 10px; font-size: 0.95em;">
                    <option selected disabled hidden>Pilih</option>
                    <option value="tablet">Tablet</option>
                    <option value="sirup">Sirup</option>
                    <option value="kapsul">Kapsul</option>
                </select>
            </div>
        </div>

        <div class="mb-4 row">
            <label for="price" class="col-sm-3 col-form-label" style="font-weight: 500; color: #333; font-size: 0.9em;">Harga Obat:</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" id="price" name="price" style="border-radius: 8px; border: 1px solid #ccc; padding: 10px; font-size: 0.95em;">
            </div>
        </div>

        <div class="mb-4 row">
            <label for="stock" class="col-sm-3 col-form-label" style="font-weight: 500; color: #333; font-size: 0.9em;">Stok Tersedia:</label>
            <div class="col-sm-9">
                <input type="number" class="form-control" id="stock" name="stock" style="border-radius: 8px; border: 1px solid #ccc; padding: 10px; font-size: 0.95em;">
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-dark mt-3" style="background-color: #333; color: #fff; border: none; border-radius: 8px; padding: 12px 20px; font-weight: 500; font-size: 1em; width: 100%; text-transform: uppercase;">
            Tambah Data
        </button>
    </form>
</div>
@endsection
