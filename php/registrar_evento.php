<?php

include "conexao.php";

// Verifica se recebeu o evento
if (!isset($_GET["evento"])) {
    die("Evento não informado.");
}

$evento = $_GET["evento"];

// Permite somente os eventos do Arduino
if ($evento != "CANCELA_ABRIU" && $evento != "CANCELA_FECHOU") {
    die("Evento inválido.");
}

// Data e hora atuais
$data = date("Y-m-d");
$hora = date("H:i:s");

// Grava no banco
$sql = "INSERT INTO acessos (data_acesso, hora_acesso, evento)
        VALUES ('$data', '$hora', '$evento')";

if ($conn->query($sql) === TRUE) {
    echo "Evento registrado com sucesso!";
} else {
    echo "Erro ao registrar: " . $conn->error;
}

$conn->close();

?>