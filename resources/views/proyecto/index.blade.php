{{--@extends('welcome') --}}
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset = "UTF-8">
		<tittle>Document</tittle>
	</head>
	<body>
		
			<h3 class = "ui top attached blue header block segment">
				File Upload
			</h3>
			<div class ="ui buttom attached segment"></div>
				<form action="{{ route('proyecto.store') }}" method="post" enctype="multipart/form-data">
					{{ csrf_field() }}
					<input type="file" name="archivo" id = "file">
					<button type = "submit" class = "ui teal button">Cargar</button>
				</form>
			</div>
		
	</body>
</html>