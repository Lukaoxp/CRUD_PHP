<!-- Geração do formulário em tela -->
<!DOCTYPE html>
<html>

<head>
	<title>Cadastro de clientes</title>
</head>

<body>
	<h2>Formulário de Cadastro de clientes</h2>
	<form name="cadastro_usuario" method="post" action="">
		<br>
		<?php
		//Inclusão das functions do QueryDb
		include_once("./Crud/QueryDb.php");

		// Obtenção dos inputs em forma de array e caso botão tenha sido apertado, chama a função para inserirCliente()
		$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

		if ($dados['button'] != '') {
			inserirCliente($dados['nome'], $dados['data_nascimento'], $dados['cpf'], $dados['telefone'], $dados['email']);
		}

		?>
		<label for="nome">Nome*: </label>
		<input type="text" name="nome" id="nome" placeholder="Nome Completo " required><br><br>

		<label for="data_nascimento">Data de Nascimento*: </label>
		<input type="date" name="data_nascimento" required><br><br>

		<label for="cpf">CPF*: </label>
		<input type="text" name="cpf" required><br><br>

		<label for="telefone">Telefone:</label>
		<input type="tel" name="telefone"><br><br>

		<!-- Campo para inserção do E-mail já com validação -->
		<label for="email">E-mail:</label>
		<input type="email" id="email" name="email"><br><br>

		<input type="submit" value="Cadastrar" name="button"><br><br>

		* = Campo Obrigatório


	</form>
</body>

</html>