<x-guest-layout>

<form method="POST" action="{{ route('register') }}">

@csrf



<!-- Full Name -->

<div>

<label>
Full Name
</label>


<input 
class="block mt-1 w-full"
type="text"
name="full_name"
value="{{old('full_name')}}"
required
autofocus>


@error('full_name')

<p>{{ $message }}</p>

@enderror

</div>





<!-- NIC Number -->

<div class="mt-4">

<label>
NIC Number
</label>


<input 
class="block mt-1 w-full"
type="text"
name="nic_number"
value="{{old('nic_number')}}"
required>


@error('nic_number')

<p>{{ $message }}</p>

@enderror


</div>





<!-- WhatsApp -->

<div class="mt-4">

<label>
WhatsApp Mobile Number
</label>


<input 
class="block mt-1 w-full"
type="text"
name="whatsapp_mobile"
value="{{old('whatsapp_mobile')}}"
required>


@error('whatsapp_mobile')

<p>{{ $message }}</p>

@enderror


</div>






<!-- Station -->

<div class="mt-4">

<label>
Station
</label>


<select 
name="station_id"
class="block mt-1 w-full"
required>


<option value="">
Select Station
</option>



@foreach($stations as $station)


<option value="{{ $station->id }}">

{{ $station->station_code }}
-
{{ $station->station_name }}

</option>


@endforeach


</select>


@error('station_id')

<p>{{ $message }}</p>

@enderror


</div>







<!-- Password -->

<div class="mt-4">


<label>
Password
</label>


<input
class="block mt-1 w-full"
type="password"
name="password"
required>


@error('password')

<p>{{ $message }}</p>

@enderror


</div>








<!-- Confirm Password -->

<div class="mt-4">


<label>
Confirm Password
</label>


<input
class="block mt-1 w-full"
type="password"
name="password_confirmation"
required>


</div>








<div class="flex items-center justify-end mt-4">


<a 
class="underline text-sm text-gray-600"
href="{{route('login')}}">
Already registered?
</a>



<button 
class="ms-4">
Register
</button>


</div>



</form>

</x-guest-layout>