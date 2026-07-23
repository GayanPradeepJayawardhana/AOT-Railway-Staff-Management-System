<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::with(['station', 'role']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nic_number', 'like', "%{$search}%")
                  ->orWhereHas('station', fn ($sq) => $sq->where('station_code', 'like', "%{$search}%"));
            });
        }

        $users = $query->orderBy('full_name')->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user): View
    {
        $stations = Station::orderBy('station_name')->get();

        return view('admin.users.edit', compact('user', 'stations'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'nic_number' => ['required', 'string', 'max:20', Rule::unique('users', 'nic_number')->ignore($user->id)],
            'whatsapp_mobile' => 'required|string|max:15',
            'station_id' => ['nullable', Rule::unique('users', 'station_id')->ignore($user->id), 'exists:stations,id'],
            'status' => 'required|in:active,inactive',
        ]);

        $user->update($data);

        return redirect()->route('admin.users.index')->with('status', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'User deleted successfully.');
    }

    public function resetPassword(User $user): RedirectResponse
    {
        $newPassword = Str::password(10, symbols: false);
        $user->update(['password' => Hash::make($newPassword)]);

        return redirect()->route('admin.users.index')
            ->with('status', "Password reset for {$user->full_name}. New password: {$newPassword} (share this via WhatsApp).");
    }

    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user->update(['password' => Hash::make($data['new_password'])]);

        return redirect()->route('admin.users.index')->with('status', "Password changed for {$user->full_name}.");
    }
}