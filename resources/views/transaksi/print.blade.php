<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial; font-size: 12px; }
        .header { text-align: center; }
        .logo { width: 80px; }
        .title { font-size: 18px; font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; }
    </style>
</head>
<body>

<div class="header">
    <!-- LOGO -->
    <img class="logo" src="{{ public_path('logo.png') }}" />

    <div class="title">KLINIK SEHAT</div>
    <small>Jl. Contoh No. 123</small>
</div>

<div class="divider"></div>

<!-- INVOICE -->
<p>
    <b>Invoice:</b> {{ $transaksi->invoice }} <br>
    <b>Pasien:</b> {{ $transaksi->pasien->nama }} <br>
    <b>Tanggal:</b> {{ $transaksi->tanggal }}
</p>

<div class="divider"></div>

<!-- DETAIL -->
<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Subtotal</th>
        </tr>
    </thead>

    <tbody>
        @foreach($transaksi->detail as $d)
        <tr>
            <td>
                @if($d->jenis == 'obat')
                    {{ $d->obat->nama_obat }}
                @else
                    {{ $d->tindakan->nama_tindakan }}
                @endif
            </td>
            <td>{{ $d->qty }}</td>
            <td>{{ number_format($d->harga) }}</td>
            <td>{{ number_format($d->subtotal) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="divider"></div>

<h3>Total: Rp {{ number_format($transaksi->total) }}</h3>

<div class="divider"></div>

<!-- QR CODE -->
<div style="text-align:center; margin-top:10px;">
    <p>QR Code</p>

    <img src="data:image/png;base64,{{ $qr }}" width="120">
</div>

</body>
</html>