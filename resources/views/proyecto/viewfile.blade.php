<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<style type = "text/css">
	.wrapper{
		margin: 0 auto;
		width: 75%;
		margin-top: :10px;
	}
</style>

</head>
<body>
	<div class="wrapper">
		<seccion class="panel panel-primary">
			<div class="panel-heading">
				Download Files laravel
			</div>
			<div class="panel-body">
				<table class = "table table.bordered">
					<thead>
						<th>Tittle</th>
						<th>Upload Date</th>
						<th>Action</th>
					</thead>
					<tbody>
						@foreach($downloads as $down)
						<tr>
							<td>{{$down->NOMBRE}}</td>
							<td>{{$down->FECHA_REGISTRO}}</td>
							<td>
								<a href="upload/{{$down->NOMBRE}}" download="{{$down->NOMBRE}}">
									<button type="button" class="btn btn-primary">
										<i class="glyphicon glyphicon-download">
											Download
										</i>
									</button>
								</a>

							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</seccion>
	</div>
</body>
</html>