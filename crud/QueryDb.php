<?php
// inclui a pagina de validações para chamada de funções
include "Validacoes.php";

//Função para inserir um novo cliente no banco de dados
function inserirCliente($nome, $dataNascimento, $cpf, $telefone, $email)
{

  //Cria a mascara do telefone
  $telefone = mascaraTelefone($telefone);

  //Inclui a conexão da base de dados
  include './Config.php';

  //Chamado da função validaCpf;
  if (validaCpf($cpf)) {

    //Se o CPF não constar na base, insere o novo cliente
    $sql =  "INSERT INTO clientes (nome_completo, data_nascimento, cpf, telefone, email) valorS ('$nome', '$dataNascimento', '$cpf', '$telefone', '$email')";

    //Caso haja erro com a query e conexão, exibe
    if (mysqli_query($conexaoDb, $sql)) {
      return true;
    } else {
      echo "Erro ao inserir cliente: " . mysqli_error($conexaoDb);
      return false;

      //Fecha a conexão do banco;  
      mysqli_close($conexaoDb);
    }
  } else { //Caso já conste no banco, é exibido em tela
    echo "<div style='color: red; font-weight: bold;'>CPF já consta na base de dados</div><br>";
    //Fecha a conexão do banco;
    mysqli_close($conexaoDb);
  }
}

// Função para listar todos os clientes do banco de dados
function listarClientes()
{
  //Inclui a conexão da base de dados
  include './Config.php';

  //Busca todos os clientes
  $sql = "SELECT * FROM clientes";
  $resultado = $conexaoDb->query($sql);

  if ($resultado->num_rows > 0) {
    // Exibe a lista de clientes
    echo "<h3>Lista de Clientes</h3>";
    echo '<style>table, th, td {border: 1px solid black;}</style>';
    echo "<table>";
    echo "<tr><th>Codigo</th><th>Nome Completo</th><th>Data de Nascimento</th><th>CPF</th><th>Telefone</th><th>Email</th></tr>";

    while ($coluna = $resultado->fetch_assoc()) {
      echo "<tr>";
      echo "<td>" . $coluna["codigo"] . "</td>";
      echo "<td>" . $coluna["nome_completo"] . "</td>";
      echo "<td>" . $coluna["data_nascimento"] . "</td>";
      echo "<td>" . $coluna["cpf"] . "</td>";
      echo "<td>" . $coluna["telefone"] . "</td>";
      echo "<td>" . $coluna["email"] . "</td>";
      echo "</tr>";
    }

    echo "</table>";
  } else {
    echo "Nenhum cliente cadastrado.";
  }
  //Fecha a conexão do banco; 
  mysqli_close($conexaoDb);
}


// Função para atualizar os dados de um cliente no banco de dados
function atualizarCliente($dadosAtualizados, $cliente)
{
  $codigoCliente = $cliente['codigo'];
  $resultadoComparacao = comparaDados($dadosAtualizados, $cliente);
  $sql = gerarQueryUpdate($resultadoComparacao, $codigoCliente);

  //Inclui a conexão da base de dados
  include './Config.php';

  //Caso haja erro com a query e conexão, exibe
  if (mysqli_query($conexaoDb, $sql)) {
    return true;
  } else {
    echo "Erro ao atualizar cliente: " . mysqli_error($conexaoDb);
    return false;
  }
  //Fecha a conexão do banco; 
  mysqli_close($conexaoDb);
}

// Função para apagar um cliente do banco de dados
function apagarCliente($codigo)
{
  //Inclui a conexão da base de dados
  include './Config.php';

  $sql = "DELETE FROM clientes WHERE codigo = $codigo";

  //Caso haja erro com a query e conexão, exibe
  if (mysqli_query($conexaoDb, $sql)) {
    echo "<div style='color: green; font-weight: bold;'>Cliente apagado com sucesso</div><br>";
    return true;
  } else {
    echo "Erro ao apagar cliente: " . mysqli_error($conexaoDb);
    return false;
  }
  //Fecha a conexão do banco; 
  mysqli_close($conexaoDb);
}