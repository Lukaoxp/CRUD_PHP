<?php
//Funcao para validação de CPF Unico
function validaCpf($cpf)
{
  //Inclui a conexão da base de dados
  include './Config.php';
  //consulta o Cpf informado no cadastro
  $sql = "SELECT * FROM clientes where cpf = $cpf";
  $resultado = mysqli_query($conexaoDb, $sql);
  //caso tenha retorno de mais de uma linha, é retornado que já está cadastrado
  if ($resultado->num_rows > 0) {
    return false;
  } else {
    return true;
  }
}

//Funcao para mascarar telefone
function mascaraTelefone($telefone)
{
  // Remove todos os caracteres não numéricos do número de telefone informado pelo usuario
  $telefoneNumerico = preg_replace("/[^0-9]/", "", $telefone);
  //Obtem a quantidade de digitos do telefone para inserir os caracteres da máscara
  $quantidadeDigitos = strlen($telefoneNumerico);
  if ($quantidadeDigitos == 0) {
    return "";
  } else {
    // Formata o número de telefone com a máscara contendo o (XX) nos dois primeiros digitos e - antes dos quatro ultimos 
    $telefoneFormatado = "(" . substr($telefoneNumerico, 0, 2) . ")" . substr($telefoneNumerico, 2, $quantidadeDigitos - 6) . "-" . substr($telefoneNumerico, ($quantidadeDigitos - 4));
    return $telefoneFormatado;
  }
}

//Funcao para comparar os dados presentes no banco de dados com os dados que o usuario informou para alteração.
//retorna um array com os valores dos campos que tiveram alteracao e outro que retorna os valores originais.
function comparaDados($dadosAtualizados, $cliente)
{
  //Para cada campo da string $dadosAtualizados é comparado para verificar se existe na string $cliente
  //Em seguida é feita a analise se são diferentes e o resultado recebe somente os valores diferentes;
  foreach ($dadosAtualizados as $campo => $valorAtualizado) {
    if (!empty($cliente[$campo])) {
      $valorBase = $cliente[$campo];
      if ($valorAtualizado != $valorBase) {
        $atualizado[$campo] = $valorAtualizado;
        $original[$campo] = $cliente[$campo];
      }
    }
  }
  //chamada de função para adicionar aspas aos valores das variaveis
  $atualizado = addAspasValores($atualizado);
  $original = addAspasValores($original);

  $resultado = array([$atualizado], [$original]);
  return $resultado;

}

//Funcao para consultar se o cliente do código informado existe na base
function consultaDados($codigo)
{
  // Conecta ao banco de dados
  include_once "./Config.php";

  // Busca as informações no banco de dados
  $sql = "SELECT * FROM clientes WHERE codigo = $codigo";
  $resultado = mysqli_query($conexaoDb, $sql);

  //se retornar ao menos uma linha existe cliente com o codigo informado
  if (mysqli_num_rows($resultado) > 0) {
    $cliente = mysqli_fetch_assoc($resultado);
    return $cliente;
  } else {
    echo "Não foi encontrado nenhum cliente com o código informado.";
    return '';
  }
  // Fecha a conexão com o banco de dados
  mysqli_close($conexaoDb);
}

//funcao para separar o array entre dois outros que serão utilizados para gerar a query de update automaticamente
function gerarQueryUpdate($resultadoComparacao, $codigoCliente)
{
  //Quebra dos arrays de $resultadoComparacao
  foreach ($resultadoComparacao as $array1) {
    foreach ($array1 as $array2) {
      foreach ($array2 as $campo => $valor) {
        $arrays[] = "$campo = $valor";
      }
    }
  }

  $qntdRegistros = count($arrays);

  for ($i = 0; $i < $qntdRegistros; $i++) {
    if ($i < $qntdRegistros / 2) {
      $updatesArray[] = $arrays[$i];
    } else {
      $whereArray[] = $arrays[$i];
    }
  }

  return concatenaQuery($updatesArray, $whereArray, $codigoCliente);
}

//Função que concatena a query de update
function concatenaQuery($updatesArray, $whereArray, $codigoCliente)
{
  //string recebe o implode dos arrays. Com tratativa para não trazer o índice
  $impUpdate = implode(', ', array_map(function ($value) {
    return substr($value, strpos($value, '=') + 2);
  }, $updatesArray));

  $impWhere = implode(' AND ', array_map(function ($value) {
    return substr($value, strpos($value, '=') + 2);
  }, $whereArray));

  // gera a query
  $sql = "UPDATE clientes SET $impUpdate WHERE $impWhere AND codigo = $codigoCliente";
  return $sql;
}

//Função para adicionar Aspas nos Valores alterados a fim de serem utilizados na query.
function addAspasValores($array)
{
  $comAspas = [];
  foreach ($array as $campo => $valor) {
    $comAspas[] = "$campo = '$valor'";
  }
  return $comAspas;
}
