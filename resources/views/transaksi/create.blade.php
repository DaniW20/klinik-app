<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaksi Klinik
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="/transaksi/store" method="POST">
                @csrf

                {{-- PASIEN --}}
                <div class="mb-4">
                    <label class="font-bold">Pasien</label>
                    <select name="pasien_id" required class="border rounded w-full p-2">
                        <option value="">-- Pilih Pasien --</option>

                        @foreach($pasien as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- OBAT --}}
                <h3 class="font-bold mt-4 mb-2">Obat</h3>

                @foreach($obat as $o)
                    <div class="obat-item flex items-center gap-2 mb-2 border p-2 rounded"
                         data-harga="{{ $o->harga }}">

                        <input type="checkbox"
                               class="obat-check"
                               name="obat[{{ $o->id }}][checked]"
                               value="1">

                        <span class="w-1/2">
                            {{ $o->nama_obat }}
                            (Rp {{ number_format($o->harga) }}) |
                            Stok: {{ $o->stok }}
                        </span>

                        <input type="number"
                               class="obat-qty border w-20 p-1 rounded"
                               name="obat[{{ $o->id }}][qty]"
                               value="1"
                               min="1">
                    </div>
                @endforeach

                {{-- TINDAKAN --}}
                <h3 class="font-bold mt-4 mb-2">Tindakan</h3>

                @foreach($tindakan as $t)
                    <div class="tindakan-item mb-2"
                         data-harga="{{ $t->harga }}">

                        <input type="checkbox"
                               class="tindakan-check"
                               name="tindakan_id[]"
                               value="{{ $t->id }}">

                        {{ $t->nama_tindakan }}
                        (Rp {{ number_format($t->harga) }})
                    </div>
                @endforeach

                {{-- TOTAL --}}
                <h3 class="font-bold mt-4 text-lg">
                    Total: Rp <span id="total">0</span>
                </h3>

                {{-- BUTTON --}}
                <div class="mt-6">
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded">
                        Simpan Transaksi
                    </button>
                </div>

            </form>

        </div>
    </div>

    {{-- REALTIME SCRIPT --}}
    <script>
        function hitungTotal() {
            let total = 0;

            // OBAT
            document.querySelectorAll('.obat-item').forEach(item => {
                let check = item.querySelector('.obat-check');
                let qty = item.querySelector('.obat-qty').value;

                if (check.checked) {
                    total += item.dataset.harga * qty;
                }
            });

            // TINDAKAN
            document.querySelectorAll('.tindakan-item').forEach(item => {
                let check = item.querySelector('.tindakan-check');

                if (check.checked) {
                    total += parseInt(item.dataset.harga);
                }
            });

            document.getElementById('total').innerText =
                total.toLocaleString('id-ID');
        }

        document.addEventListener('input', hitungTotal);
        document.addEventListener('change', hitungTotal);

        hitungTotal();
    </script>

</x-app-layout>