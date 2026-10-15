<?php

include "conexao.php";

$data = date("Y-m-d");
$hora = date("H:i:s");
$evento = "CANCELA_ABRIU";

$sql = "INSERT INTO acessos (data_acesso, hora_acesso, evento)
        VALUES ('$data', '$hora', '$evento')";

if ($conn->query($sql) === TRUE) {
    echo "Acesso registrado com sucesso!";
} else {
    echo "Erro ao registrar: " . $conn->error;
}

$conn->close();

?>
