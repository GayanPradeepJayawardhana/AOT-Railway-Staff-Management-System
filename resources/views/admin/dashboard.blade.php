<!DOCTYPE html>

<html>

<head>

<title>
Super Admin Dashboard
</title>


<meta name="viewport" content="width=device-width, initial-scale=1">


</head>



<body>


<h1>
AOT Railway Staff Management System
</h1>



<h2>
Super Administrator Dashboard
</h2>




<h3>

Welcome:

{{ auth()->user()->full_name }}

</h3>




<p>

NIC:

{{ auth()->user()->nic_number }}

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