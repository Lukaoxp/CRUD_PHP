<!-- Formulario pedindo o codigo do cliente para exclusão -->
<!DOCTYPE html>
<html>
<head>
	<title>Excluir Cliente</title>
</head>
<body>
	<h2>Excluir Cliente</h2>
	<?php 
		include_once("./Crud/QueryDb.php");
		
		//Array com filtro no input para validação se houve click no botão
		$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
		if ($dados['button'] != ''){
			//Chamada do método
			apagarCliente($dados['codigo']);
		}
		?>
	<form method="post" action="">
		<label for="Codigo_cliente">Codigo do Cliente:</label>
		<input type="text" id="Codigo" name="codigo"><br><br>
		<input type="submit" value="Excluir" name="button">
	</form>
</body>
</html>
