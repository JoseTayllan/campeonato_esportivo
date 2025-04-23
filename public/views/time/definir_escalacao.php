<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/controllers/escalacaoController.php';
require_once __DIR__ . '/../../../app/middleware/verifica_time_logado.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$partida_id = $_GET['partida_id'] ?? null;
$time_id = $_SESSION['time_id'] ?? null;

if (!$partida_id || !$time_id) {
    echo "<div class='alert alert-danger'>Partida ou time não definidos corretamente.</div>";
    exit;
}

$controller = new EscalacaoController($conn);
$jogadores = $controller->obterJogadoresTime($time_id);
$escalacao_existente = $controller->buscarEscalacaoDaPartida($partida_id);

$capitao_id = null;
foreach ($escalacao_existente as $esc) {
    if ($esc['capitao'] == 1) {
        $capitao_id = $esc['jogador_id'];
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Definir Escalação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Definir Escalação</h2>

    <form action="../../../routes/escalacao.php" method="post">
        <input type="hidden" name="partida_id" value="<?= $partida_id ?>">

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Jogador</th>
                    <th class="text-center">Titular?</th>
                    <th class="text-center">Capitão?</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jogadores as $index => $jogador): ?>
                    <?php
                        $id = $jogador['id'];
                        $titular_checked = '';
                        $capitao_checked = '';

                        if (!empty($escalacao_existente) && isset($escalacao_existente[$id])) {
                            if ($escalacao_existente[$id]['titular'] == 1) {
                                $titular_checked = 'checked';
                            }
                            if ($escalacao_existente[$id]['capitao'] == 1) {
                                $capitao_checked = 'checked';
                            }
                        }
                    ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($jogador['nome']) ?>
                            <input type="hidden" name="escalacao[<?= $index ?>][jogador_id]" value="<?= $id ?>">
                        </td>
                        <td class="text-center">
                            <input type="checkbox" name="escalacao[<?= $index ?>][titular]" value="1" <?= $titular_checked ?>>
                        </td>
                        <td class="text-center">
                            <input type="radio" name="capitao" value="<?= $id ?>" <?= $capitao_checked ?>>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <a href="../../../routes/agenda_time.php" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Salvar Escalação</button>
        </div>
    </form>
</div>
</body>
</html>
