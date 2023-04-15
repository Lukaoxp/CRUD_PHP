<?php

//Configurações para BD;
$host = '';
$usuario = '';
$senha = '';
$database = '';
$port = ;

//Iniciar Conexao
$conexaoDb = new mysqli($host, $usuario, $senha, $database, $port);

if ($conexaoDb->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conexaoDb->connect_error);
}
