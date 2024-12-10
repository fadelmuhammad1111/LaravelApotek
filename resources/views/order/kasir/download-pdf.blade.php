<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bukti Pembelian</title>
  <style>
    body {
      font-family: 'Courier New', Courier, monospace;
      background-color: #f8f9fa;
      color: #333;
      padding: 20px;
    }

    #receipt {
      width: 300px;
      margin: 0 auto;
      padding: 20px;
      background: #fff;
      border: 1px solid #ccc;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #receipt h2 {
      font-size: 1.2rem;
      text-align: center;
      margin-bottom: 10px;
      font-weight: bold;
      text-transform: uppercase;
    }

    #top {
      text-align: center;
      margin-bottom: 20px;
    }

    #top .info p {
      margin: 5px 0;
      font-size: 0.9rem;
      color: #555;
    }

    #table {
      width: 100%;
      margin-top: 20px;
      border-top: 1px solid #333;
      border-bottom: 1px solid #333;
      padding-bottom: 10px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    td {
      padding: 5px 0;
      text-align: left;
      font-size: 0.9rem;
    }

    .tabletitle {
      font-weight: bold;
      border-bottom: 1px solid #333;
      font-size: 1rem;
    }

    .tableitem {
      border-bottom: 1px solid #eee;
    }

    .total {
      font-weight: bold;
    }

    .payment {
      font-size: 1.2rem;
      font-weight: bold;
      color: #2ecc71;
      text-align: right;
    }

    #legalcopy {
      font-size: 0.9rem;
      text-align: center;
      color: #555;
      margin-top: 20px;
      padding-top: 10px;
      border-top: 1px solid #eee;
    }

    .btn-back {
      width: fit-content;
      padding: 8px 15px;
      color: #fff;
      background: #007bff;
      border-radius: 5px;
      text-decoration: none;
      margin: 20px auto;
    }

    .btn-back:hover {
      background: #0056b3;
    }

    .btn-print {
      display: block;
      width: fit-content;
      padding: 8px 15px;
      background: #f44336;
      color: #fff;
      text-align: end;
      border-radius: 5px;
      text-decoration: none;
      margin-top: 20px;
    }

    .btn-print:hover {
      background: #d32f2f;
    }
  </style>
</head>

<body>
<!-- <a href="{{ route('kasir.order.index') }}" class="btn-back">Kembali</a> -->
  <div id="receipt">
    <h2>Apotek Jaya Abadi</h2>
    <div id="top">
      <div class="info">
        <p>Alamat: spanjang jalan kenangan</p>
        <p>Email: apotekjayaabadi@gmail.com</p>
        <p>Phone: 000-111-2222</p>
      </div>
    </div>

    <div id="table">
      <table>
        <tr class="tabletitle">
          <td>Obat</td>
          <td>Total</td>
          <td>Harga</td>
        </tr>
        @foreach ($order['medicines'] as $medicine)
        <tr class="tableitem">
          <td>{{ $medicine['name_medicine'] }}</td>
          <td>{{ $medicine['qty'] }}</td>
          <td>Rp. {{ number_format($medicine['price'], 0, ',', '.') }}</td>
        </tr>
        @endforeach
        <tr class="tabletitle total">
          <td></td>
          <td>PPN (0,1%)</td>
          @php
              $ppn = $order['total_price'] * 0.1;
          @endphp
          <td>Rp. {{ number_format($ppn, 0, ',', '.') }}</td>
        </tr>
        <tr class="tabletitle total">
          <td></td>
          <td>Total Harga</td>
          <td class="payment">Rp. {{ number_format($order['total_price'], 0, ',', '.') }}</td>
        </tr>
      </table>
    </div>

    <div id="legalcopy">
      <p><strong>Terima kasih atas pembelian Anda!</strong> Semoga hari Anda menyenankan. Kami berharap dapat melayani Anda lagi di masa depan.</p>
    </div>
  </div>
  <!-- <a href="#" class="btn-print">Cetak (.pdf)</a> -->
</body>
</html>
