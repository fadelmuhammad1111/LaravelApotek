<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;
USE PDF;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $orders = Order::with('user')->simplePaginate(10);
        return view('order.kasir.index', compact("orders"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $medicines = Medicine::all();
        return view("order.kasir.create", compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name_customer' => 'required|max:50',
            'medicines' => 'required',
        ]);

        $arrayDistinct = array_count_values($request->medicines);
        $arrayMedicines = [];

        foreach($arrayDistinct as $id => $count) {
            $medicines = Medicine::where('id', $id)->first();

            if ($medicines ['stock'] <  $count) {
                $valueBefore = [
                    "name_customer" => $request->name_customer,
                    "medicines" => $request->medicines
                ];
               $msg = "Obat " . $medicines['name'] . " Sisa stok : " .  $medicines['stock'] . " Tidak dapat melakukan progres pembelian!";
               return redirect()->back()->withInput()->with('failed', $msg);
            } else {
                $medicines['stock'] -= $count;
                $medicines->save();
            }

            $subPrice = $medicines['price'] * $count;


            $arrayItem = [
                "id" => $id,
                "name_medicine" => $medicines['name'],
                "qty" => $count,
                "price" => $medicines['price'],
                "sub_price" => $subPrice,
            ];

            array_push($arrayMedicines, $arrayItem);
        }

        $totalPrice = 0;
        foreach($arrayMedicines as $item) {
            $totalPrice += (int)$item['sub_price'];
        };

        $pricePpn = $totalPrice + ($totalPrice * 0.01);

        $proses = Order::create([
            'user_id' => Auth::user()->id,
            'medicines' => $arrayMedicines,
            'name_customer'  => $request->name_customer,
            'total_price' => $pricePpn
        ]);

        if($proses) {
            $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at','DESC')->first();
            return redirect()->route('kasir.order.print', $order['id']);
        } else {
            return redirect()->back()->with('failed', 'Gagal membuat data pembelian');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $order = Order::find($id);
        return view('order.kasir.print', compact('order'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function downloadPdf($id) 
    {
        // Ambil data berdasarkan id yang ada di struk dan dipastikan terformat array
        $order = Order::find($id)->toArray();
        // Kita akan share data dengan inisial awal agar bisa digunakan ke blade manapun
        view()->share('order', $order);
        // ini akan meload view halaman downloadnya
        $pdf = PDF::loadview('order.kasir.download-pdf', $order);
        return $pdf->download('invoice.pdf');
        
    }

    public function riwayat(Request $request)
{
    $query = Order::query();

    if ($request->filled('filter_date')) {
        $query->whereDate('created_at', $request->filter_date);
    }

    $riwayat = $query->Simplepaginate(10);
    return view('order.admin.index', compact('riwayat'));
}


    public function exportExcel()
    {
        return Excel::download(new OrderExport, 'rekap-pembelian.xlsx');
    }



}
