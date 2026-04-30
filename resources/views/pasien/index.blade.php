<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Data Pasien
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <a href="/pasien/create"
               class="bg-blue-500 text-white px-4 py-2 rounded">
                + Tambah
            </a>

            <div class="bg-white mt-4 shadow rounded p-4 overflow-x-auto">

                <table class="w-full">
                    <thead>
                        <tr class="text-left border-b">
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>Tanggal Lahir</th>
                            <th>Aksi</th>
                            
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($data as $d)
                        <tr class="border-b">
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->alamat }}</td>
                            <td>{{ $d->no_hp }}</td>
                            <td>{{ $d->tanggal_lahir }}</td>
                         <td>
                            <a href="/pasien/{{ $d->id }}/edit" class="text-blue-500">Edit</a>

                            <form action="{{ route('pasien.destroy', $d->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 px-3 py-1 rounded" type="submit" onclick="return confirm('Yakin?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

        </div>
    </div>
</x-app-layout>