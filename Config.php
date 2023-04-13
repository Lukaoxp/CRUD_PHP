<?php

//Configurações para BD;
$host = 'localhost';
$usuario = 'root';
$senha = 'admin';
$database = 'crud';
$port = 3306;

//Iniciar Conexao
$conexaoDb = new mysqli($host, $usuario, $senha, $database, $port);

if ($conexaoDb->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conexaoDb->connect_error);
}
