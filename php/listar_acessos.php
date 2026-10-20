<?php

include 'conexao.php';

// Busca os acessos junto com o nome e código da pessoa
$sql = "SELECT 
            acessos.id,
            professores.nome,
            professores.codigo,
            acessos.data_acesso,
            acessos.hora_acesso,
            acessos.evento
        FROM acessos
        INNER JOIN professores 
            ON acessos.professor_id = professores.id
        ORDER BY acessos.id DESC";

$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Histórico de Acessos</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">


<!-- MENU -->

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            🚧 Cancela Escolar
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#menuPrincipal"
            aria-controls="menuPrincipal"
            aria-expanded="false"
            aria-label="Abrir menu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">

                    <a class="nav-link" href="index.php">
                        🏠 Início
                    </a>

                </li>

                <li class="nav-item dropdown">

                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown">

                        👥 Pessoas

                    </a>

                    <ul class="dropdown-menu">

                        <li>
                            <a
                                class="dropdown-item"
                                href="cadastro_professores.php">

                                ➕ Cadastrar pessoa

                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item"
                                href="listar_professores.php">

                                👥 Pessoas cadastradas

                            </a>
                        </li>

                    </ul>

                </li>

                <li class="nav-item">

                    <a class="nav-link active" href="listar_acessos.php">

                        📋 Acessos

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>


<!-- CONTEÚDO -->

<div class="container py-5">

    <div class="card shadow">

        <div class="card-body">

            <h2 class="text-center text-primary mb-4">
                📋 Histórico de Acessos
            </h2>


            <div class="table-responsive">

                <table class="table table-hover table-bordered align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>Nome</th>

                            <th>Código</th>

                            <th>Data</th>

                            <th>Hora</th>

                            <th>Evento</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if ($resultado->num_rows > 0): ?>

                        <?php while ($acesso = $resultado->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($acesso['nome']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($acesso['codigo']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($acesso['data_acesso']) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($acesso['hora_acesso']) ?>
                                </td>

                                <td>

                                    <span class="badge bg-success">

                                        <?= htmlspecialchars($acesso['evento']) ?>

                                    </span>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="5" class="text-center">

                                Nenhum acesso registrado.

                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>
<?php
$conn->close();
?>