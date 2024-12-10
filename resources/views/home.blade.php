@extends('layout.template')

@section('content')
    <div class="jumbotron py-4 px-5" style="background: linear-gradient(135deg, #2c3e50, #3498db); color: #f9f9f9; border-radius: 15px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
        @if (Session::get('failed'))
            <div class="alert alert-danger" style="font-size: 1.1em; background-color: #e74c3c; color: #fff; border: none; border-radius: 10px;">
                {{ Session::get('failed') }}
            </div>
        @endif

        @if (Session::get('login'))
            <div class="alert alert-warning" style="font-size: 1.1em; background-color: #f1c40f; color: #fff; border: none; border-radius: 10px;">
                {{ Session::get('login') }}
            </div>
        @endif
        
        <h1 class="display-4" style="font-family: 'Playfair Display', serif; font-size: 2.8em; font-weight: bold;">
            Selamat Datang {{ Auth::user()->name }}!
        </h1>
        <hr class="my-4" style="border-color: #ecf0f1;">
        
        <p style="font-size: 1.25em; line-height: 1.6; color: #ecf0f1;">
            Aplikasi ini digunakan hanya oleh pegawai administrator APOTEK. Digunakan untuk mengelola data obat, penyetokan, juga pembelian (kasir).
        </p>
    </div>
@endsection
