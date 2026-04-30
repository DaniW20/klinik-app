<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Tindakan
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

                <form action="/tindakan/{{ $tindakan->id }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <input type="text" name="nama_tindakan"
                               value="{{ $tindakan->nama_tindakan }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <input type="number" name="harga"
                               value="{{ $tindakan->harga }}"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <button class="bg-green-500 text-white px-4 py-2 rounded">
                        Update
                    </button>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>