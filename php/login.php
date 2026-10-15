<?php
include "conexao.php";

$mensagem = "";
$tipoMensagem = "";
$acessoAutorizado = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $matricula = trim($_POST["matricula"]);

    // =====================================
    // PROCURA O PROFESSOR
    // =====================================

    $sql = "SELECT id, nome
            FROM professores
            WHERE codigo = ?
            AND ativo = 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matricula);
    $stmt->execute();

    $resultado = $stmt->get_result();

    // =====================================
    // MATRÍCULA INVÁLIDA
    // =====================================

    if ($resultado->num_rows == 0) {

        $mensagem = "Matrícula não encontrada ou professor inativo.";
        $tipoMensagem = "danger";

    } else {

        // =====================================
        // PROFESSOR ENCONTRADO
        // =====================================

        $professor = $resultado->fetch_assoc();

        $professor_id = $professor["id"];
        $nome = $professor["nome"];

        // =====================================
        // SOLICITA ABERTURA DA CANCELA
        // =====================================

        $url = "http://localhost:5000/abrir";

        $opcoes = [
            "http" => [
                "method" => "GET",
                "timeout" => 5
            ]
        ];

        $contexto = stream_context_create($opcoes);

        $resposta = @file_get_contents($url, false, $contexto);

        // =====================================
        // VERIFICA RESPOSTA DO PYTHON
        // =====================================

        if ($resposta === "OK") {

            // =================================
            // REGISTRA O ACESSO
            // =================================

            $sqlRegistro = "
                INSERT INTO acessos
                (professor_id, data_acesso, hora_acesso, evento)
                VALUES (?, CURDATE(), CURTIME(), ?)
            ";

            $stmtRegistro = $conn->prepare($sqlRegistro);

            $evento = "CANCELA_ABRIU";

            $stmtRegistro->bind_param(
                "is",
                $professor_id,
                $evento
            );

            $stmtRegistro->execute();

            $stmtRegistro->close();

            // =================================
            // ACESSO AUTORIZADO
            // =================================

            $mensagem = "Acesso autorizado!<br>
                         Professor: <strong>"
                         . htmlspecialchars($nome)
                         . "</strong>";

            $tipoMensagem = "success";

            $acessoAutorizado = true;

        } else {

            // =================================
            // PYTHON INDISPONÍVEL
            // =================================
            $mensagem = "Sistema da cancela indisponível.";
            $tipoMensagem = "warning";
        }
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Controle de Acesso</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container">

        <div class="row justify-content-center align-items-center"
             style="min-height: 100vh;">

            <div class="col-md-5 col-lg-4">

                <div class="card shadow">

                    <div class="card-body p-5 text-center">

                        <div class="display-1 mb-3">
                            
                        </div>

                        <h2 class="mb-2">
                            Controle de Acesso
                        </h2>

                        <p class="text-muted mb-4">
                            Digite sua matrícula para acessar a escola
                        </p>


                        <?php if ($mensagem != ""): ?>

                            <div class="alert alert-<?= $tipoMensagem ?>">

                                <?= $mensagem ?>

                            </div>

                        <?php endif; ?>


                        <form method="POST">

                            <div class="mb-4 text-start">

                                <label
                                    for="matricula"
                                    class="form-label"
                                >
                                    Matrícula do Professor
                                </label>

                                <input
                                    type="text"
                                    class="form-control form-control-lg"
                                    id="matricula"
                                    name="matricula"
                                    placeholder="Digite sua matrícula"
                                    autocomplete="off"
                                    required
                                >

                            </div>
                            <button
                                type="submit"
                                class="btn btn-primary btn-lg w-100">
                                ENTRAR
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>


<?php if ($acessoAutorizado): ?>

<script>

    setTimeout(function() {

        window.location.href = "login.php";

    }, 3000);

</script>

<?php endif; ?>


</body>

</html>
