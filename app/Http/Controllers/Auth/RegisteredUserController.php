<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Station;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;


class RegisteredUserController extends Controller
{

    /**
     * Display registration page
     */
    public function create(): View
    {

        $stations = Station::where('status','active')
            ->orderBy('station_code')
            ->get();


        return view('auth.register', compact('stations'));

    }



    /**
     * Store new station user
     */
    public function store(Request $request): RedirectResponse
    {


        $request->validate([

            'full_name' => [
                'required',
                'string',
                'max:255'
            ],


            'nic_number' => [
                'required',
                'string',
                'max:20',
                'unique:users,nic_number'
            ],


            'whatsapp_mobile' => [
                'required',
                'string',
                'max:15'
            ],


            'station_id' => [
                'required',
                'exists:stations,id',
                'unique:users,station_id'
            ],


            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ]

        ]);





        $user = User::create([


            'full_name' => $request->full_name,


            'nic_number' => $request->nic_number,


            'whatsapp_mobile' => $request->whatsapp_mobile,


            'station_id' => $request->station_id,


            'password' => Hash::make($request->password),


            // Station User Role
            // user_roles table:
            // 1 = Station User
            // 2 = Super Admin

            'role_id' => 1,


            'status' => 'active'


        ]);





        event(new Registered($user));



        Auth::login($user);



        return redirect(route('dashboard', absolute: false));

    }

}