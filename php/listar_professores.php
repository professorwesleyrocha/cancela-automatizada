<?php
include "conexao.php";

// Busca todos os cadastrados
$sql = "SELECT id, nome, codigo, tipo, ativo FROM professores ORDER BY nome ASC";
$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Pessoas Cadastradas</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 900px;
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

        .topo {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .botao {
            display: inline-block;
            padding: 10px 15px;
            background: #198754;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .botao:hover {
            background: #157347;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #198754;
            color: white;
            padding: 12px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .ativo {
            color: #198754;
            font-weight: bold;
        }

        .inativo {
            color: #dc3545;
            font-weight: bold;
        }

        .acoes a {
            margin: 2px;
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            display: inline-block;
        }

        .editar {
            background: #0d6efd;
        }

        .status {
            background: #6c757d;
        }

        .excluir {
            background: #dc3545;
        }

    </style>
</head>

<body>

<div class="container">

    <h2>👥 Pessoas Cadastradas</h2>

    <div class="topo">

        <a href="cadastro_professores.php" class="botao">
            + Novo Cadastro
        </a>

        <a href="index.php" class="botao">
            Voltar
        </a>

    </div>

    <table>
        <tr>
            <th>Nome</th>
            <th>Matrícula / Código</th>
            <th>Tipo</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        <?php if ($resultado->num_rows > 0): ?>
            <?php while ($pessoa = $resultado->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($pessoa['nome']) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($pessoa['codigo']) ?>
                    </td>

                    <td>
                        <?php if ($pessoa['tipo'] == 'Aluno'): ?>
                            🎓 Aluno
                        <?php else: ?>
                            👨‍🏫 Professor
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($pessoa['ativo'] == 1): ?>
                            <span class="ativo">
                                ● Ativo
                            </span>
                        <?php else: ?>
                            <span class="inativo">
                                ● Inativo
                            </span>
                        <?php endif; ?>
                    </td>

                    <td class="acoes">
                        <a
                            href="editar_professor.php?id=<?= $pessoa['id'] ?>"
                            class="editar">
                            Editar
                        </a>
                        <a
                            href="alterar_status.php?id=<?= $pessoa['id'] ?>"
                            class="status">
                            Ativar/Desativar
                        </a>
                    </td>
                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="5">
                    Nenhuma pessoa cadastrada.
                </td>
            </tr>

        <?php endif; ?>

    </table>

</div>

</body>
</html>

<?php
$conn->close();
?>