<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            width: 58mm;
        }

        .center { text-align: center; }
        .line { border-top: 1px dashed #000; margin: 5px 0; }

        table {
            width: 100%;
        }

        td {
            font-size: 11px;
        }
    </style>
</head>

<body onload="window.print()">

<div class="center">
    <b>KLINIK SEHAT</b><br>
    Jl. Contoh No. 123
</div>

<div class="line"></div>

Invoice: {{ $transaksi->invoice }}<br>
Pasien: {{ $transaksi->pasien->nama }}<br>
Tanggal: {{ $transaksi->tanggal }}

<div class="line"></div>

<table>
@foreach($transaksi->detail as $d)
<tr>
    <td>
        {{ $d->obat->nama_obat ?? $d->tindakan->nama_tindakan }}
    </td>
</tr>
<tr>
    <td>
        {{ $d->qty }} x {{ number_format($d->harga) }}
    </td>
</tr>
@endforeach
</table>

<div class="line"></div>

<b>Total: Rp {{ number_format($transaksi->total) }}</b>

<div class="line"></div>

<div class="center">
    Terima Kasih
</div>

</body>
</html>