<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'db_academia';

$conexao = new mysqli($host, $usuario, $senha, $banco);

if($conexao->connect_error){
    die("Não foi possível estabelecer a conexão: ".$conexao->connect_errno);
}
?>