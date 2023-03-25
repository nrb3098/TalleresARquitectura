<!DOCTYPE html>
<html>
<head>
	<title>Lista de Productos</title>
	<style>
		body {
			background-color: #F5F5F5;
			font-family: Arial, sans-serif;
		}
		h1 {
			color: #4285F4;
		}
		table {
			border-collapse: collapse;
			width: 100%;
			margin-bottom: 20px;
		}
		th {
			background-color: #4285F4;
			color: #FFFFFF;
			padding: 10px;
			text-align: left;
		}
		td {
			border: 1px solid #CCCCCC;
			padding: 10px;
		}
		form {
			background-color: #FFFFFF;
			border: 1px solid #CCCCCC;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0px 0px 10px #CCCCCC;
			max-width: 500px;
			margin: 0 auto;
			margin-bottom: 20px;
		}
		label {
			display: block;
			margin-bottom: 10px;
			color: #666666;
		}
		input[type="text"], input[type="number"], textarea {
			padding: 10px;
			border: 1px solid #CCCCCC;
			border-radius: 3px;
			font-size: 16px;
			width: 100%;
			box-sizing: border-box;
			margin-bottom: 20px;
		}
		input[type="submit"], input[type="reset"] {
			background-color: #4285F4;
			color: #FFFFFF;
			padding: 10px 20px;
			border: none;
			border-radius: 3px;
			font-size: 16px;
			cursor: pointer;
			margin-right: 10px;
		}
		input[type="reset"] {
			background-color: #CCCCCC;
			color: #FFFFFF;
		}
		input[type="submit"]:hover, input[type="reset"]:hover {
			background-color: #3367D6;
		}
	</style>
</head>
<body>
	<h1>Lista de Productos</h1>
	<form action="" method="post">
		<label for="xml">Datos XML:</label>
		<textarea id="xml" name="xml"></textarea><br>

		<input type="submit" value="Cargar XML">
		<input type="reset" value="Limpiar">
	</form>

	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$xml = simplexml_load_string($_POST['xml']);
			echo '<table>';
			echo '<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Stock</th><th>Proveedor</th></tr>';
			foreach ($xml->product as $producto) {
				echo '<tr>';
				echo '<td>' . $producto->id . '</td>';
				echo '<td>' . $producto->nombre . '</td>';
				echo '<td>' . $producto->descripcion . '</td>';
				echo '<td>' . $producto->precio . '</td>';
				echo '<td>' . $producto->stock . '</td>';
				echo '<td>' . $producto->proveedor . '</td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	?>
</body>
</html>