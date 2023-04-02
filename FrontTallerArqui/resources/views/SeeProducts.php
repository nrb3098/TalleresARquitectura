<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	<title>Lista de Productos</title>
	<style>
		 /* Estilos para centrar la lista */
		 body {
			background-color: #F5F5F5;
			font-family: Arial, sans-serif;
		}
		h1 {
			color: #4285F4;
		}
      /* Estilos para la tabla */
      table {
        border-collapse: collapse;
        width: 80%;
        margin-top: 50px;
      }

      th, td {
        text-align: left;
        padding: 8px;
      }

      th {
        background-color: #4CAF50;
        color: white;
      }

      tr:nth-child(even) {
        background-color: #f2f2f2;
      }

      /* Estilos para el campo de búsqueda */
      .search-container {
        margin-top: 50px;
        margin-bottom: 50px;
        display: flex;
        justify-content: center;
      }

      input[type=text] {
        width: 30%;
        padding: 12px 20px;
        margin-right: 10px;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        background-color: #f8f8f8;
        font-size: 16px;
        background-image: url('searchicon.png');
        background-position: 10px 10px;
        background-repeat: no-repeat;
        padding-left: 40px;
      }

      input[type=button] {
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }

      input[type=button]:hover {
        background-color: #45a049;
      }
	</style>
</head>
<body>
	<h1>Lista de Productos</h1>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Descripción</th>
				<th>Precio</th>
				<th>Stock</th>
				<th>Proveedor</th>
			</tr>
		</thead>
		<tbody id="products">
		</tbody>
	</table>

	<script>
		fetch('http://localhost:8080/getAllProducts')
			.then(response => response.text())
			.then(xmlString => {
				const parser = new DOMParser();
				const xmlDoc = parser.parseFromString(xmlString, 'text/xml');
				const products = xmlDoc.getElementsByTagName('product');
				const tbody = document.getElementById('products');

				for (let i = 0; i < products.length; i++) {
					const product = products[i];
					const id = product.getElementsByTagName('id')[0].childNodes[0].nodeValue;
					const nombre = product.getElementsByTagName('nombre')[0].childNodes[0].nodeValue;
					const descripcion = product.getElementsByTagName('descripcion')[0].childNodes[0].nodeValue;
					const precio = product.getElementsByTagName('precio')[0].childNodes[0].nodeValue;
					const stock = product.getElementsByTagName('stock')[0].childNodes[0].nodeValue;
					const proveedor = product.getElementsByTagName('proveedor')[0].childNodes[0].nodeValue;

					const tr = document.createElement('tr');
					tr.innerHTML = `
						<td>${id}</td>
						<td>${nombre}</td>
						<td>${descripcion}</td>
						<td>${precio}</td>
						<td>${stock}</td>
						<td>${proveedor}</td>
					`;
					tbody.appendChild(tr);
				}
			})
			.catch(error => console.error(error));
	</script>
</body>
</html>
