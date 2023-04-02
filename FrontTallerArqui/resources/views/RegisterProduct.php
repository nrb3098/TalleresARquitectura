<!DOCTYPE html>
<html>
<head>
	<title>Registrar Producto</title>
	<style>
		body {
			background-color: #F5F5F5;
			font-family: Arial, sans-serif;
		}
		h1 {
			color: #4285F4;
		}
		form {
			background-color: #FFFFFF;
			border: 1px solid #CCCCCC;
			padding: 20px;
			border-radius: 5px;
			box-shadow: 0px 0px 10px #CCCCCC;
			max-width: 500px;
			margin: 0 auto;
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
	<h1>Registrar Producto</h1>
	<form>
    @csrf
    <label for="Id">Id:</label>
    <input type="number" id="Id" name="Id"><br>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre"><br>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion"></textarea><br>

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="precio"><br>

    <label for="stock">Stock:</label>
    <input type="number" id="stock" name="stock"><br>

    <label for="proveedor">Proveedor:</label>
    <input type="text" id="proveedor" name="proveedor"><br>

    <input type="submit" value="Registrar Producto">
    <input type="reset" value="Limpiar">
</form>
</body>
<script>
  const form = document.querySelector('form');

  form.addEventListener('submit', function(event) {
    event.preventDefault(); // Evita que el formulario se envíe normalmente

    // Crea la petición SOAP y configura los encabezados y el cuerpo
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://localhost:8081/registerProduct');
    xhr.setRequestHeader('Content-Type', 'application/xml');

    const requestBody = `<product>
        <id>${form.Id.value}</id>
        <nombre>${form.nombre.value}</nombre>
        <descripcion>${form.descripcion.value}</descripcion>
        <precio>${form.precio.value}</precio>
        <stock>${form.stock.value}</stock>
        <proveedor>${form.proveedor.value}</proveedor>
      </product>`;

    // Envía la petición SOAP
    xhr.send(requestBody);
	xhr.close();
  });
</script>
</html>
