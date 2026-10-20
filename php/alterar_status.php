<?php

include 'conexao.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    die("Cadastro inválido.");
}

// Busca o status atual
$stmt = $conn->prepare("SELECT ativo FROM professores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    die("Cadastro não encontrado.");
}

$pessoa = $resultado->fetch_assoc();

$stmt->close();

// Inverte o status
$novo_status = ($pessoa['ativo'] == 1) ? 0 : 1;

$atualiza = $conn->prepare(
    "UPDATE professores SET ativo = ? WHERE id = ?"
);

$atualiza->bind_param("ii", $novo_status, $id);

if ($atualiza->execute()) {

    header("Location: listar_professores.php");
    exit;

} else {

    die("Erro ao alterar o status.");
}

$atualiza->close();
$conn->close();

?>