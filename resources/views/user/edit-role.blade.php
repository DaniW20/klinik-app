<x-app-layout>
    <div class="p-6">

        <h2 class="text-xl font-bold mb-4">Edit Role</h2>

        <form action="/user/{{ $user->id }}/update-role" method="POST">
            @csrf

            <div class="mb-4">
                <label class="font-bold">Nama</label>
                <input type="text" value="{{ $user->name }}" disabled
                       class="border p-2 w-full">
            </div>

            <div class="mb-4">
                <label class="font-bold">Role</label>
                <select name="role" class="border p-2 w-full">
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="dokter" {{ $user->role == 'dokter' ? 'selected' : '' }}>Dokter</option>
                    <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                </select>
            </div>

            <button class="bg-green-500 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </form>

    </div>
</x-app-layout>