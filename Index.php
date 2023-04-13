<!-- Formulário para seleção de opções do CRUD -->
<!-- tela de formulário, onde se obtem a ação do usuário -->
<!DOCTYPE html>
<html>

<head>
	<title>Gerenciamento de Clientes</title>
</head>

<body>
	<h1>Gerenciamento de Clientes</h1>
	<ul>
		<li><a href="Index.php?acao=cadastrar">Cadastrar Cliente</a></li>
		<li><a href="Index.php?acao=listar">Listar Clientes</a></li>
		<li><a href="Index.php?acao=atualizar">Atualizar Cliente</a></li>
		<li><a href="Index.php?acao=apagar">Apagar Cliente</a></li>
	</ul>

	<?php

	// Verifica se foi selecionada alguma ação
	if (isset($_GET["acao"])) {
		$acao = $_GET["acao"];

		// Executa a ação selecionada
		switch ($acao) {
			case "cadastrar":
				//Exibe o formulário de Cadastro de clientes
				include_once "Models/Cadastro.php";
				break;
			case "listar":
				// Lista todos os clientes cadastrados
				include_once "Crud/QueryDb.php";
				listarClientes();
				break;
			case "atualizar":
				include_once "Models/Atualizar.php";
				break;
			case "apagar":
				include_once "Models/Apagar.php";
				break;
		}
	}
	?>
</body>

</html>