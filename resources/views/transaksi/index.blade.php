

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Data transaksi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="/transaksi/create"
               class="bg-blue-500 text-white px-4 py-2 rounded">
                + Tambah
            </a>

            <div class="bg-white mt-4 shadow rounded p-4 overflow-x-auto">

                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                              <th>Pasien</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $t)
                        <tr class="border-b">
                          <td>{{ $t->pasien->nama }}</td>
                            <td>{{ $t->total }}</td>
                            <td>{{ $t->tanggal }}</td>
                            <td>
                            <a href="/transaksi/{{ $t->id }}">Detail</a>
                            <a href="/transaksi/print/{{ $t->id }}"
                            target="_blank"
                            class="bg-green-600 text-white px-3 py-1 rounded">
                            Print
                            </a>
                            <a href="/transaksi/thermal/{{ $t->id }}"
                            target="_blank"
                            class="bg-black text-white px-3 py-1 rounded">
                            Print Thermal
                            </a>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

        </div>
    </div>
</x-app-layout>