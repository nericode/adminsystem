@extends('layout.app')

@section('container')

<form action="{{ route('login') }}" method="post">
	{{ csrf_field() }}
	<div class="form-group">
		<label for="user">Usuario ID</label>
		<input type="text" class="form-control" name="user" placeholder="Ingrese su usuario ID">
	</div>
	<div class="form-group">
		<label for="password">Contraseña</label>
		<input type="password" class="form-control" name="password" placeholder="Ingrese su contraseña">
	</div>
	<button type="submit" class="btn btn-default">Iniciar sesiòn</button>
</form>
@endsection