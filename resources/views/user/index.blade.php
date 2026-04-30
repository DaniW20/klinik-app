<x-app-layout>
    <div class="p-6">

        <h2 class="text-xl font-bold mb-4">Manajemen User</h2>

        <table class="w-full border">
            <tr class="bg-gray-200">
                <th class="p-2">Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>

            @foreach($users as $u)
            <tr class="border-t">
                <td class="p-2">{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role }}</td>
                <td>
                    <a href="/user/{{ $u->id }}/edit-role"
                       class="bg-blue-500 text-white px-2 py-1 rounded">
                        Edit Role
                    </a>
                </td>
            </tr>
            @endforeach
        </table>

    </div>
</x-app-layout>