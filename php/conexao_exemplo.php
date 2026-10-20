
<?php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'cancela';

$connect = mysqli_connect($host, $usuario, $senha, $banco);

if (!$connect) {
    die('Erro ao conectar ao banco de dados.');
}

mysqli_set_charset($connect, 'utf8mb4');
