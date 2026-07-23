<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Edit User — {{ $user->full_name }}</h2></x-slot>

    <div class="py-8 max-w-lg mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" class="mt-1 block w-full rounded-md border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIC Number</label>
                    <input type="text" name="nic_number" value="{{ old('nic_number', $user->nic_number) }}" class="mt-1 block w-full rounded-md border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">WhatsApp Mobile</label>
                    <input type="text" name="whatsapp_mobile" value="{{ old('whatsapp_mobile', $user->whatsapp_mobile) }}" class="mt-1 block w-full rounded-md border-gray-300" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Station</label>
                    <select name="station_id" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">-- None --</option>
                        @foreach ($stations as $station)
                            <option value="{{ $station->id }}" {{ old('station_id', $user->station_id) == $station->id ? 'selected' : '' }}>
                                {{ $station->station_code }} — {{ $station->station_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">Save</button>
            </form>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-semibold mb-3">Set Custom Password</h3>
            <form method="POST" action="{{ route('admin.users.update-password', $user) }}" class="space-y-3">
                @csrf @method('PUT')
                <input type="password" name="new_password" placeholder="New password" class="block w-full rounded-md border-gray-300" required>
                <input type="password" name="new_password_confirmation" placeholder="Confirm password" class="block w-full rounded-md border-gray-300" required>
                <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-md">Update Password</button>
            </form>
        </div>
    </div>
</x-app-layout>