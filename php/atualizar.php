<?php
include "conexao.php";

// =====================================
// ÚLTIMO EVENTO
// =====================================

$sql = "SELECT acessos.*, professores.nome
        FROM acessos
        LEFT JOIN professores
        ON acessos.professor_id = professores.id
        ORDER BY acessos.id DESC
        LIMIT 1";

$resultado = $conn->query($sql);
$ultimo = $resultado->fetch_assoc();


// =====================================
// TOTAL DE ABERTURAS
// =====================================

$sqlTotal = "SELECT COUNT(*) AS total
             FROM acessos
             WHERE evento = 'CANCELA_ABRIU'";

$resultadoTotal = $conn->query($sqlTotal);
$totalAberturas = $resultadoTotal->fetch_assoc()["total"];

// =====================================
// HISTÓRICO
// =====================================

$sqlHistorico = "SELECT acessos.*, professores.nome
                 FROM acessos
                 LEFT JOIN professores
                 ON acessos.professor_id = professores.id
                 ORDER BY acessos.id DESC
                 LIMIT 10";

$historico = $conn->query($sqlHistorico);
?>

<!-- =====================================
     CARDS
===================================== -->

<div class="row g-4 mb-4">

    <!-- STATUS -->
    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body text-center p-4">

                <h5 class="text-muted">STATUS DA CANCELA</h5>

                <?php if ($ultimo): ?>

                        <?php
                        $dataHoraEvento = strtotime(
                            $ultimo["data_acesso"] . " " . $ultimo["hora_acesso"]
                        );

                        $tempoDecorrido = time() - $dataHoraEvento;

                        if (
                            $ultimo["evento"] == "CANCELA_ABRIU"
                            && $tempoDecorrido < 3
                        ):
                        ?>

                            <div class="display-4 my-3">🟢</div>
                            <h2 class="text-success">ABERTA</h2>

                        <?php else: ?>

                            <div class="display-4 my-3">🔴</div>
                            <h2 class="text-danger">FECHADA</h2>

                        <?php endif; ?>

                    <?php else: ?>

                        <h2>Sem registros</h2>

                    <?php endif; ?>

            </div>
        </div>
    </div>


    <!-- TOTAL DE ABERTURAS -->
    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body text-center p-4">

                <h5 class="text-muted">TOTAL DE ABERTURAS</h5>

                <div class="display-1 my-3">🔢</div>

                <h1><?= $totalAberturas ?></h1>

                <p class="text-muted">
                    aberturas registradas
                </p>

            </div>
        </div>
    </div>

    <!-- ÚLTIMO EVENTO -->
    <div class="col-md-4">
        <div class="card shadow h-100">
            <div class="card-body text-center p-4">

                <h5 class="text-muted">ÚLTIMO EVENTO</h5>

                <?php if ($ultimo): ?>

                    <div class="display-4 my-3">🕐</div>

                    <h4>
                        <?= $ultimo["evento"] ?>
                    </h4>

                    <?php if (!empty($ultimo["nome"])): ?>

                        <p class="mb-1">
                            👨‍🏫 <?= htmlspecialchars($ultimo["nome"]) ?>
                        </p>

                    <?php endif; ?>

                    <p class="mb-1">
                        📅 <?= date("d/m/Y", strtotime($ultimo["data_acesso"])) ?>
                    </p>

                    <p>
                        🕐 <?= $ultimo["hora_acesso"] ?>
                    </p>

                <?php else: ?>

                    <h4>Nenhum evento</h4>

                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

<!-- =====================================
     HISTÓRICO
===================================== -->

<div class="card shadow">

    <div class="card-body">

        <h3 class="mb-3">
            📋 Histórico da Cancela
        </h3>

        <div class="table-responsive">

            <table class="table table-striped table-hover">

                <thead class="table-dark">

                    <tr>
                        <th>ID</th>
                        <th>Professor</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Evento</th>
                    </tr>

                </thead>

                <tbody>

                    <?php while ($registro = $historico->fetch_assoc()): ?>

                        <tr>

                            <td>
                                <?= $registro["id"] ?>
                            </td>

                            <td>

                                <?php if (!empty($registro["nome"])): ?>

                                    👨‍🏫
                                    <?= htmlspecialchars($registro["nome"]) ?>

                                <?php else: ?>
                                    —
                                <?php endif; ?>

                            </td>

                            <td>
                                <?= date(
                                    "d/m/Y",
                                    strtotime($registro["data_acesso"])
                                ) ?>
                            </td>

                            <td>
                                <?= $registro["hora_acesso"] ?>
                            </td>

                            <td>

                                <?php if ($registro["evento"] == "CANCELA_ABRIU"): ?>

                                    <span class="badge bg-success">
                                        🟢 CANCELA ABRIU
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-danger">
                                        🔴 CANCELA FECHOU
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?php
$conn->close();
?>

<script src="js/status_cancela.js"></script>

<script>
    setTimeout(function() {
        location.reload();
    }, 1000);
</script>

