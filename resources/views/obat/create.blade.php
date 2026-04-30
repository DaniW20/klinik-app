<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Obat
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">
                 @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

                <form action="/obat" method="POST">
                    @csrf

                    <div class="mb-4">
                        <input type="text" name="nama_obat"
                               class="w-full border rounded px-3 py-2"
                               placeholder="Nama Obat">
                    </div>

                    <div class="mb-4">
                        <input type="number" name="harga"
                               class="w-full border rounded px-3 py-2"
                               placeholder="Harga">
                    </div>

                    <div class="mb-4">
                        <input type="number" name="stok"
                               class="w-full border rounded px-3 py-2"
                               placeholder="Stok">
                    </div>

                    <button class="bg-blue-500 text-white px-4 py-2 rounded">
                        Simpan
                    </button>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>