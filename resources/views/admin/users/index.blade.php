<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Manage Users</h2></x-slot>

    <div class="py-8 max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="GET" class="mb-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, NIC or station code" class="rounded-md border-gray-300 w-full sm:w-1/2">
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-md">Search</button>
            </form>

            <table class="w-full text-sm">
                <thead><tr class="text-left text-gray-500 border-b"><th class="py-2">Name</th><th>NIC</th><th>Station</th><th>WhatsApp</th><th>Status</th><th colspan="3"></th></tr></thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $user->full_name }}</td>
                            <td>{{ $user->nic_number }}</td>
                            <td>{{ $user->station->station_code ?? '—' }}</td>
                            <td>{{ $user->whatsapp_mobile }}</td>
                            <td>{{ ucfirst($user->status) }}</td>
                            <td><a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:underline">Edit</a></td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" onsubmit="return confirm('Reset password for this user?')">
                                    @csrf
                                    <button class="text-yellow-600 hover:underline">Reset Password</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $users->links() }}</div>
        </div>
    </div>
</x-app-layout>