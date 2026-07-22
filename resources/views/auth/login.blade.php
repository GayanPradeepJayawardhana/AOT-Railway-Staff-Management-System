<x-guest-layout>


<form method="POST" action="{{ route('login') }}">

@csrf





<!-- NIC -->

<div>


<label>
NIC Number
</label>


<input
class="block mt-1 w-full"
type="text"
name="nic_number"
value="{{old('nic_number')}}"
required
autofocus>



@error('nic_number')

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


</div>








<!-- Remember -->


<div class="block mt-4">


<label>


<input
type="checkbox"
name="remember">


Remember Me


</label>


</div>








<div class="flex items-center justify-end mt-4">


@if (Route::has('password.request'))

<a 
class="underline text-sm"
href="{{route('password.request')}}">
Forgot password?
</a>


@endif





<button class="ms-4">

Login

</button>



</div>


</form>


</x-guest-layout>