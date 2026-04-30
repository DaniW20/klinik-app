<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Transaksi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- CARD INFO -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Pasien</p>
                        <p class="font-semibold">{{ $transaksi->pasien->nama }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Tanggal</p>
                        <p class="font-semibold">{{ $transaksi->tanggal }}</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Total</p>
                        <p class="font-bold text-green-600 text-lg">
                            Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Dibuat oleh</p>
                        <p class="font-semibold">{{ Auth::user()->name }}</p>
                    </div>
                </div>

            </div>

            <!-- TABLE DETAIL -->
            <div class="bg-white shadow rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-4">Detail Item</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border">Jenis</th>
                                <th class="px-4 py-2 border">Nama</th>
                                <th class="px-4 py-2 border">Qty</th>
                                <th class="px-4 py-2 border">Harga</th>
                                <th class="px-4 py-2 border">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($transaksi->detail as $d)
                            <tr class="text-center">
                                <td class="border px-4 py-2">
                                    <span class="px-2 py-1 text-xs rounded 
                                        {{ $d->jenis == 'obat' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600' }}">
                                        {{ ucfirst($d->jenis) }}
                                    </span>
                                </td>

                                <td class="border px-4 py-2 text-left">
                                    {{ $d->obat->nama_obat ?? $d->tindakan->nama_tindakan }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $d->qty }}
                                </td>

                                <td class="border px-4 py-2">
                                    Rp {{ number_format($d->harga, 0, ',', '.') }}
                                </td>

                                <td class="border px-4 py-2 font-semibold">
                                    Rp {{ number_format($d->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- BUTTON -->
                <div class="mt-6">
                    <a href="/transaksi"
                       class="inline-block bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        ← Kembali
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>