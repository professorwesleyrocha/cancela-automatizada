<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoramento da Cancela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>
<style>
    .titulo-cancela {
        color: #0F4BAA;
        text-align: center;
        font-weight: bold;
        margin: 0;
    }

    .titulo-cabecalho {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .icone-cancela {
        width: 100px;
        height: auto;
    }

    /* Menu */
    .navbar-brand {
        font-weight: bold;
    }

</style>

<body class="bg-light">

<!-- MENU -->

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        <a class="navbar-brand" href="index.php">
            Cancela Escolar
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

                <!-- Início -->

                <li class="nav-item">

                    <a class="nav-link" href="index.php">
                        🏠 Início
                    </a>

                </li>

                <!-- Pessoas -->

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

                <!-- Acessos -->

                <li class="nav-item">

                    <a class="nav-link" href="listar_acessos.php">

                        📋 Acessos

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>


<!-- CONTEÚDO PRINCIPAL -->

<div class="container py-5">

    <div class="titulo-cabecalho">

        <img
            src="img/cancela.png"
            class="icone-cancela"
            alt="Cancela">

        <h1 class="titulo-cancela">

            MONITORAMENTO EM TEMPO REAL - CANCELA ESCOLAR

        </h1>

    </div>


    <!-- PAINEL COMPLETO -->

    <div id="statusCancela">

        Carregando informações...

    </div>

</div>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>
<!-- Atualização do painel -->

<script>
function atualizarPainel() {
    fetch("atualizar.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("statusCancela").innerHTML = data;
        })
        .catch(error => {
            console.log("Erro ao atualizar:", error);
        });

}

// Atualiza imediatamente
atualizarPainel();
// Atualiza a cada 2 segundos
setInterval(atualizarPainel, 2000);

</script>
</body>
</html>