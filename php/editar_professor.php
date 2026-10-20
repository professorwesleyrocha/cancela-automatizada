<?php
include 'conexao.php';

$id = intval($_GET['id'] ?? 0);

if ($id <= 0) {
    die("Cadastro inválido.");
}

// Busca os dados atuais
$stmt = $conn->prepare("SELECT nome, codigo, tipo, ativo FROM professores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$resultado = $stmt->get_result();

if ($resultado->num_rows == 0) {
    die("Cadastro não encontrado.");
}

$pessoa = $resultado->fetch_assoc();
$stmt->close();

$mensagem = "";

// Salva as alterações
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST['nome']);
    $codigo = trim($_POST['codigo']);
    $tipo = $_POST['tipo'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;

    if ($nome == "" || $codigo == "") {

        $mensagem = "Preencha o nome e o código.";

    } else {

        // Verifica se outro cadastro já usa o mesmo código
        $verifica = $conn->prepare(
            "SELECT id FROM professores WHERE codigo = ? AND id != ?"
        );

        $verifica->bind_param("si", $codigo, $id);
        $verifica->execute();

        $resultado_verifica = $verifica->get_result();

        if ($resultado_verifica->num_rows > 0) {

            $mensagem = "Este código/matrícula já está cadastrado.";

        } else {

            $atualiza = $conn->prepare(
                "UPDATE professores 
                SET nome = ?, codigo = ?, tipo = ?, ativo = ? 
                WHERE id = ?"
            );

            $atualiza->bind_param(
                "sssii",
                $nome,
                $codigo,
                $tipo,
                $ativo,
                $id
            );

            if ($atualiza->execute()) {

                header("Location: listar_professores.php");
                exit;

            } else {

                $mensagem = "Erro ao atualizar o cadastro.";
            }

            $atualiza->close();
        }

        $verifica->close();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Cadastro</title>
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
            background: #0d6efd;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #0b5ed7;
        }

        .voltar {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #555;
            text-decoration: none;
        }

        .mensagem {
            text-align: center;
            margin-bottom: 15px;
            color: #dc3545;
            font-weight: bold;
        }

    </style>
</head>
<body>
<div class="container">
    <h2>✏️ Editar Cadastro</h2>
    <?php if ($mensagem != ""): ?>
        <div class="mensagem">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <label for="nome">Nome</label>

        <input
            type="text"
            id="nome"
            name="nome"
            value="<?= htmlspecialchars($pessoa['nome']) ?>"
            required
        >

        <label for="codigo">Matrícula / Código</label>

        <input
            type="text"
            id="codigo"
            name="codigo"
            value="<?= htmlspecialchars($pessoa['codigo']) ?>"
            required
        >

        <label for="tipo">Tipo</label>

        <select id="tipo" name="tipo" required>

            <option value="Aluno"
                <?= $pessoa['tipo'] == 'Aluno' ? 'selected' : '' ?>>
                🎓 Aluno
            </option>

            <option value="Professor"
                <?= $pessoa['tipo'] == 'Professor' ? 'selected' : '' ?>>
                👨‍🏫 Professor
            </option>

        </select>

        <div class="ativo">

            <label>

                <input
                    type="checkbox"
                    name="ativo"
                    value="1"
                    <?= $pessoa['ativo'] == 1 ? 'checked' : '' ?>
                >

                Cadastro ativo

            </label>

        </div>

        <button type="submit">
            Salvar Alterações
        </button>

    </form>

    <a href="listar_professores.php" class="voltar">
        ← Voltar para a lista
    </a>

</div>

</body>

</html>
