<?php

namespace App\Http\Controllers;
use App\Models\Obat;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = \App\Models\Transaksi::with('pasien')->latest()->get();
        return view('transaksi.index', compact('data'));
    }

    public function create()
    {
        $pasien = \App\Models\Pasien::all();
        $obat = \App\Models\Obat::all();
        $tindakan = \App\Models\Tindakan::all();

        return view('transaksi.create', compact('pasien', 'obat', 'tindakan'));
    }

    public function store(Request $request)
{
    DB::beginTransaction();

    try {

        $transaksi = Transaksi::create([
            'invoice' => 'INV-' . date('Ymd') . '-' . rand(1000,9999),
            'pasien_id' => $request->pasien_id,
            'user_id' => auth()->id(),
            'tanggal' => now(),
            'total' => 0
        ]);

        $total = 0;

        // =====================
        // OBAT (AUTO KURANG STOK)
        // =====================
        if ($request->obat) {
            foreach ($request->obat as $id => $data) {

                // hanya yang dicentang
                if (!isset($data['checked'])) continue;

                $obat = Obat::findOrFail($id);
                $qty = $data['qty'];

                if ($obat->stok < $qty) {
                    throw new \Exception("Stok {$obat->nama_obat} tidak cukup");
                }

                $subtotal = $obat->harga * $qty;
                $total += $subtotal;

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'jenis' => 'obat',
                    'obat_id' => $id,
                    'qty' => $qty,
                    'harga' => $obat->harga,
                    'subtotal' => $subtotal
                ]);

                // 🔥 stok pasti jalan
                $obat->decrement('stok', $qty);
            }
        }

        // =====================
        // TINDAKAN (tidak pakai stok)
        // =====================
        if ($request->tindakan_id) {
            foreach ($request->tindakan_id as $i => $id) {

                $tindakan = \App\Models\Tindakan::findOrFail($id);

                $subtotal = $tindakan->harga;
                $total += $subtotal;

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'jenis' => 'tindakan',
                    'tindakan_id' => $id,
                    'qty' => 1,
                    'harga' => $tindakan->harga,
                    'subtotal' => $subtotal
                ]);
            }
        }

        // UPDATE TOTAL
        $transaksi->update(['total' => $total]);

        DB::commit();

        return redirect('/transaksi')->with('success', 'Transaksi berhasil');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}

    public function show($id)
    {
        $transaksi = \App\Models\Transaksi::with(['pasien', 'detail.obat', 'detail.tindakan'])
            ->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }
public function print($id)
{
    $transaksi = \App\Models\Transaksi::with(['pasien', 'detail.obat', 'detail.tindakan'])
        ->findOrFail($id);

    // 🔥 QR STABIL TANPA IMAGICK
    $result = Builder::create()
        ->writer(new PngWriter())
        ->data($transaksi->invoice)
        ->size(150)
        ->margin(10)
        ->build();

    $qr = base64_encode($result->getString());

    $pdf = Pdf::loadView('transaksi.print', compact('transaksi', 'qr'));

    return $pdf->stream('struk-'.$transaksi->invoice.'.pdf');
}

public function thermal($id)
{
    $transaksi = \App\Models\Transaksi::with(['pasien', 'detail.obat', 'detail.tindakan'])
        ->findOrFail($id);

    return view('transaksi.thermal', compact('transaksi'));
}
public function dashboardData()
{
    $today = now()->toDateString();

    return response()->json([
        'pasien' => \App\Models\Pasien::count(),
        'obat' => \App\Models\Obat::count(),
        'tindakan' => \App\Models\Tindakan::count(),

        'transaksi' => \App\Models\Transaksi::whereDate('tanggal', $today)->count(),

        'income' => \App\Models\Transaksi::whereDate('tanggal', $today)->sum('total'),
    ]);
}

public function chartData()
{
    $data = [];

    for ($i = 6; $i >= 0; $i--) {
        $date = now()->subDays($i)->toDateString();

        $total = \App\Models\Transaksi::whereDate('tanggal', $date)
            ->sum('total');

        $data[] = [
            'date' => $date,
            'total' => $total
        ];
    }

    return response()->json($data);
}

public function pieObat()
{
    $data = \Illuminate\Support\Facades\DB::table('obats')
        ->leftJoin('detail_transaksis', function ($join) {
            $join->on('obats.id', '=', 'detail_transaksis.obat_id')
                ->where('detail_transaksis.jenis', '=', 'obat');
        })
        ->select(
            'obats.nama_obat',
            \Illuminate\Support\Facades\DB::raw('COALESCE(SUM(detail_transaksis.qty),0) as total')
        )
        ->groupBy('obats.id', 'obats.nama_obat')
        ->orderByDesc('total')
        ->get();

    return response()->json($data);
}

public function dashboardAdvanced()
{
    $today = now()->toDateString();

    return response()->json([
        // KPI
        'income' => \App\Models\Transaksi::whereDate('tanggal', $today)->sum('total'),
        'transaksi' => \App\Models\Transaksi::whereDate('tanggal', $today)->count(),

        // 🔥 STOK MENIPIS (<= 10)
        'stok_menipis' => \App\Models\Obat::where('stok', '<=', 10)->get(),

        // 🔥 OBAT TERLARIS
        'top_obat' => \Illuminate\Support\Facades\DB::table('detail_transaksis')
            ->join('obats', 'detail_transaksis.obat_id', '=', 'obats.id')
            ->select('obats.nama_obat', \Illuminate\Support\Facades\DB::raw('SUM(qty) as total'))
            ->where('jenis', 'obat')
            ->groupBy('obats.nama_obat')
            ->orderByDesc('total')
            ->limit(5)
            ->get(),

        // 🔥 TRANSAKSI TERBARU
        'latest' => \App\Models\Transaksi::with('pasien')
            ->latest()
            ->limit(5)
            ->get()
    ]);
}
}
