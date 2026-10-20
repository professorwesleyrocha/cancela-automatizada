<?php

include "conexao.php";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $codigo = trim($_POST["codigo"]);
    $tipo = $_POST["tipo"];
    $ativo = isset($_POST["ativo"]) ? 1 : 0;

    if ($nome == "" || $codigo == "") {
        $mensagem = "Preencha o nome e o código.";
    } else {

        // Verifica se o código já existe
        $verifica = $conn->prepare("SELECT id FROM professores WHERE codigo = ?");
        $verifica->bind_param("s", $codigo);
        $verifica->execute();
        $resultado = $verifica->get_result();

        if ($resultado->num_rows > 0) {

            $mensagem = "Este código/matrícula já está cadastrado.";

        } else {

            $sql = $conn->prepare(
                "INSERT INTO professores (nome, codigo, tipo, ativo)
                 VALUES (?, ?, ?, ?)"
            );

            $sql->bind_param("sssi", $nome, $codigo, $tipo, $ativo);

            if ($sql->execute()) {
                $mensagem = "Cadastro realizado com sucesso!";
            } else {
                $mensagem = "Erro ao cadastrar.";
            }

            $sql->close();
        }

        $verifica->close();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Pessoas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .ativo {
            margin-top: 20px;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background: #198754;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #157347;
        }

        .mensagem {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: white;
        }
        
    </style>
</head>

<body>

<div class="container">

    <h2>Cadastro de Pessoas</h2>

    <?php if ($mensagem != ""): ?>
        <div class="mensagem">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" required>

        <label for="codigo">Matrícula / Código</label>
        <input type="text" id="codigo" name="codigo" required>

        <label for="tipo">Tipo</label>
        <select id="tipo" name="tipo" required>

            <option value="Aluno">🎓 Aluno</option>
            <option value="Professor">👨‍🏫 Professor</option>

        </select>

        <div class="ativo">
            <label>
                <input type="checkbox" name="ativo" value="1" checked>
                Cadastro ativo
            </label>
        </div>

        <button type="submit">Cadastrar</button>

    </form>

</div>

</body>
</html>
