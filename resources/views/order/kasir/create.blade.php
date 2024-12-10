@extends('layout.template')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg p-4" style="max-width: 600px; margin: 0 auto; border-radius: 15px; background-color: #f8f9fa;">
            <form action="{{ route('kasir.order.store') }}" method="POST">
                
                @csrf
                @if($errors->any())
                    <ul class="alert alert-danger p-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                @if (Session::get('failed'))
                    <div class="alert alert-danger">{{ Session::get('failed') }}</div>
                @endif

                <div class="text-center mb-3">
                    <h4 class="fw-bold" style="font-size: 1.4rem; color: #2c3e50;">Konfirmasi Pembelian</h4>
                    <p style="font-size: 1rem; color: #34495e;"><strong>Penanggung Jawab: </strong>{{ Auth::user()->name }}</p>
                </div>

                <div class="mb-3">
                    <label for="name_customer" class="form-label label-style">Nama Pembeli</label>
                    <input type="text" name="name_customer" id="name_customer" class="form-control form-control-lg" placeholder="Masukan Nama Pembeli" value="{{ old('name_customer') }}" required>
                </div>

                @if (old('medicines'))
                    @foreach (old("medicines") as $no => $item)
                        <div class="mb-4 row" id="medicines-{{ $no }}">
                            <label for="medicines" class="col-sm-3 col-form-label label-style">
                                Obat {{ $no + 1 }}
                                @if ($no > 0)
                                    <span class="delete-button" onclick="deleteSelect('medicines-{{ $no }}')">X</span>
                                @endif
                            </label>
                            <div class="col-sm-9">
                                <select name="medicines[]" class="form-select form-select-lg" required>
                                    <option selected hidden disabled>Pesanan 1</option>
                                    @foreach ($medicines as $medItem)
                                        <option value="{{ $medItem['id'] }}">{{ $medItem['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="mb-4 row" id="medicines-0">
                        <label for="medicines" class="col-sm-3 col-form-label label-style">Obat</label>
                        <div class="col-sm-9">
                            <select name="medicines[]" class="form-select form-select-lg" required>
                                <option selected hidden disabled>Pesanan 1</option>
                                @foreach ($medicines as $medItem)
                                    <option value="{{ $medItem['id'] }}">{{ $medItem['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif

                <div id="medicines-wrap"></div>
                
                <!-- Add Medicine Button -->
                <p class="text-success" id="add-select" style="cursor: pointer; font-weight: 500; font-size: 16px; transition: color 0.3s ease;">
                    + Tambah Obat
                </p>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-block mt-3">Konfirmasi Pembelian</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
<script>
    let no = 1;
    $("#add-select").on("click", function() {
        let html = `<div class="mb-4 row" id="medicines-${no}">
                        <label for="medicines" class="col-sm-3 col-form-label label-style">Obat ${no + 1}</label>
                        <div class="col-sm-9">
                            <select name="medicines[]" class="form-select form-select-lg" required>
                                <option selected hidden disabled>Pesanan ${no + 1}</option>
                                @foreach ($medicines as $medItem)
                                    <option value="{{ $medItem['id'] }}">{{ $medItem['name'] }}</option>
                                @endforeach
                            </select>
                            <span class="delete-button" onclick="deleteSelect('medicines-${no}')">X</span>
                        </div>
                    </div>`;

        $("#medicines-wrap").append(html);
        no++;
    });

    function deleteSelect(elementId){
        let elementIdForDelete = "#" + elementId;
        $(elementIdForDelete).remove();
        no--;
    }
</script>
@endpush

<style>
/* Label Styling */
.label-style {
    font-size: 1rem;
    font-weight: 500;
    color: #555;
    transition: color 0.2s ease, transform 0.2s ease;
}

/* Hover effect on labels */
.label-style:hover {
    color: #3498db;
    transform: translateX(2px);
}

/* Add Select Hover Styling */
#add-select {
    color: #3498db;
    cursor: pointer;
    font-weight: 500;
    font-size: 1rem;
    transition: color 0.2s ease;
}

#add-select:hover {
    color: #2980b9;
}

/* Button Styling */
button {
    background-color: #3498db;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 16px;
    font-weight: 600;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

button:hover {
    background-color: #2980b9;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Card Styling */
.card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
}

/* Alert Styling */
.alert {
    margin-bottom: 15px;
    border-radius: 8px;
    padding: 15px;
    background-color: #f8d7da;
    color: #721c24;
    font-size: 14px;
    border: 1px solid #f5c6cb;
}

/* Delete Button Styling */
.delete-button {
    color: #e74c3c;
    font-weight: 600;
    margin-left: 10px;
    cursor: pointer;
    font-size: 16px;
    transition: color 0.3s ease;
}

.delete-button:hover {
    color: #c0392b;
}

/* Form Select Styling */
.form-select {
    border-radius: 8px;
    padding: 12px;
    font-size: 15px;
    background-color: #fff;
    border: 1px solid #ccc;
    transition: border-color 0.3s ease;
}

.form-select:hover, .form-select:focus {
    border-color: #3498db;
    outline: none;
}

/* General Body and Form Styling */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f9f9f9;
    color: #333;
    margin: 0;
    padding: 0;
}

.container {
    padding: 20px;
}

.form-control {
    border-radius: 8px;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ddd;
    transition: border-color 0.3s ease;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
}
</style>
