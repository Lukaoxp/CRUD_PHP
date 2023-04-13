<!-- Formulario de atualização -->
<!DOCTYPE html>
<html>

<head>
    <title>Alteração de Cliente</title>
</head>

<body>
    <h2>Alteração de Cliente</h2>
    <!-- Formulário recebe o código do cliente para ser feita a busca no banco -->
    <form method="post" name='codigo_cliente' action="">
        <label for="Codigo_cliente">Codigo do Cliente:</label>
        <input type="text" id="Codigo" name="codigo"><br><br>
        <input type="submit" value="Selecionar" name="button">
    </form><br>

    <?php
    include_once "./Crud/QueryDb.php";
    include_once "./Crud/Validacoes.php";

    //Criação de array com filtro para o primeiro formulário
    $filtros_busca = array('codigo' => FILTER_SANITIZE_NUMBER_INT);
    $dadosBusca = filter_input_array(INPUT_POST, $filtros_busca);

    //Validação se o cliente cliclou em selecionar e se informou um código
    if (!empty($dadosBusca)) {
        if (empty($dadosBusca['codigo'])) {
            echo "O codigo deve ser informado";
        } else {
            $codigo = $dadosBusca['codigo'];
            $cliente = consultaDados($codigo);
            // Caso tenha sido informado o cliente, mostra o formulário para alteração
            if ($cliente != '') {
    ?>

                <!-- Formulário para alteração do cliente, exibindo nos campos os valores atuais no banco-->
                <form method="post" action="">
                    <h3>Informações do cliente selecionado:</h3>
                    <p>Codigo: <?php echo $cliente["codigo"]; ?></p>
                    <input type="hidden" name="codigo" id="codigo" value="<?php echo $cliente["codigo"]; ?>">

                    <label for="nome">Nome:</label>
                    <input type="text" name="nome_completo" id="nome_completo" value="<?php echo $cliente["nome_completo"]; ?>"><br><br>

                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" name="data_nascimento" id="data_nascimento" value="<?php echo $cliente["data_nascimento"]; ?>"><br><br>

                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" id="cpf" value="<?php echo $cliente["cpf"]; ?>"><br><br>

                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" id="telefone" value="<?php echo $cliente["telefone"]; ?>"><br><br>

                    <label for="email">E-mail:</label>
                    <input type="email" name="email" id="email" value="<?php echo $cliente["email"]; ?>"><br><br>

                    <input type="submit" value="Atualizar" name='button2'>
                </form>
    <?php
                //Criação do array com filtro para o segundo formulario
                $filtrosAtualizar =  array(
                    'codigo' => FILTER_SANITIZE_NUMBER_INT,
                    'nome_completo' => FILTER_SANITIZE_STRING,
                    'data_nascimento' => FILTER_SANITIZE_STRING,
                    'cpf' => FILTER_SANITIZE_STRING,
                    'telefone' => FILTER_SANITIZE_STRING,
                    'email' => FILTER_SANITIZE_EMAIL,
                    'button2' => FILTER_SANITIZE_STRING
                );
                $dadosAtualizados = filter_input_array(INPUT_POST, $filtrosAtualizar);

                //Validação se foi clicado em atualizar
                if ($dadosAtualizados['button2'] == 'Atualizar') {
                    //atualização do array
                    $dadosAtualizados = filter_input_array(INPUT_POST, $filtrosAtualizar);
                    if ($dadosAtualizados === $cliente) {
                        echo "Nenhuma alteração a ser feita";
                    } else {
                        //chamada da variavel de atualização
                        atualizarCliente($dadosAtualizados, $cliente);
                    }
                }
            }
        }
    } else {
        // Enquanto não foi informado código do cliente no formulario 1, exibirá a mensagem
        echo "<p>Favor informar o código do cliente.</p>";
    }
    ?>
</body>

</html>