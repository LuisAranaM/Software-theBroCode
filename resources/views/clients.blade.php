<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>clients</title>
</head>
<body>
	<h1>Lista de cursos</h1>
	<table>
		<tr>
			<th>codigo</th>
			<th>nombre</th>
		</tr>
		@foreach($clients as $c)
		<tr>
			<td>{{ $c->codigo }}</td>
			<td>{{ $c->nombre }}</td>
		</tr>
		@endforeach
	</table>
</body>
</html>