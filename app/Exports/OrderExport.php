<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\withHeadings;
use Maatwebsite\Excel\Concerns\withMapping;

class OrderExport implements FromCollection,withHeadings,withMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with('user')->orderBy('created_at', 'DESC')->get();
    }

    public function headings() : array {
        return [
            "ID Pembelian",
            "Nama Kasir",
            "Daftar Obat",
            "Nama Pembeli",
            "Total Harga",
            "Tanggal Pembelian"
        ];
    }

    public function map($order) : array 
    {   
        $formatWadah = '';
        foreach ($order->medicines as $key => $value) {
        $format = $key+1 . ". " . $value['name_medicine'] . " (" . $value['qty'] . 
        "pcs : Rp. " . number_format($value['sub_price'], 0,',','.') . ")";

        $formatWadah .= $format;
    }
        return [
            $order->id,
            $order->user->name,
            $formatWadah,
            $order->name_customer,
            "Rp. " . number_format($order->total_price, 0, ',','.'),
            $order->created_at->format('d F Y')
        ];
    }
}
