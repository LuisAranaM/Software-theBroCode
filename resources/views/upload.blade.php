<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>upload</title>
</head>
<body>
	<form action = "ImportClients" method = "post" enctype = "multipart/form-data">
		<label> Upload file : </label>
		<input type = "file" name = "file" />
		<input type = "hidden" value = "{{ csrf_token() }}" name = "_token" />
		<input type = "submit" value = "Upload">
	</form>
</body>
</html>