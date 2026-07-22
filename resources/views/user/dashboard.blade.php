<!DOCTYPE html>

<html>

<head>

<title>
Station User Dashboard
</title>


<meta name="viewport" content="width=device-width, initial-scale=1">


</head>



<body>


<h1>
AOT Railway Staff Management System
</h1>



<h2>
Station User Dashboard
</h2>



<h3>
Welcome:
{{ auth()->user()->full_name }}
</h3>




<p>

NIC:

{{ auth()->user()->nic_number }}

</p>




<p>

Station:

{{ auth()->user()->station->station_name ?? 'No Station Assigned' }}

</p>





<br>


<form method="POST" action="{{ route('logout') }}">

@csrf


<button type="submit">

Logout

</button>


</form>



</body>


</html>