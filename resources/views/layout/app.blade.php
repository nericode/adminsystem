<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Adminsystem</title>
	
	{{-- Styleshet --}}
	<link rel="stylesheet" href="{{ asset('/pvendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/style.css') }}">

</head>
<body>

@include('layout.navbar')

<div class="container-fluid">
	@yield('container')
</div>

<script src="{{ asset('js/app.js') }}"></script>

{{-- Scripts --}}
<script src="{{ asset('/pvendor/jquery/jquery.min.js') }}"></script>

</body>
</html>