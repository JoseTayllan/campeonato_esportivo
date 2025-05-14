<?php if (!isset($jogadores, $partida_id)) { die('Acesso direto não permitido.'); } ?>
<?php include_once __DIR__ . '/../../includes/assinatura_sec.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Definir Escalação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media (max-width: 768px) {
            .table td, .table th {
                font-size: 0.85rem;
                padding: 0.4rem;
            }
        }
    </style>
</head>

<body class="bg-light d-flex flex-column min-vh-100">
<main class="flex-grow-1">
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Definir Escalação</h2>

        <form action="/campeonato_esportivo/routes/time/escalacao.php" method="post">
            <input type="hidden" name="partida_id" value="<?= $partida_id ?>">

            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Imagem</th>
                            <th>Jogador</th>
                            <th>Titular?</th>
                            <th>Capitão?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jogadores as $index => $jogador): ?>
                            <?php
                                $id = $jogador['id'];
                                $titular_checked = isset($escalacao_existente[$id]) && $escalacao_existente[$id]['titular'] == 1 ? 'checked' : '';
                                $capitao_checked = isset($escalacao_existente[$id]) && $escalacao_existente[$id]['capitao'] == 1 ? 'checked' : '';
                                $imagemCaminho = (!empty($jogador['imagem']))
                                    ? "/campeonato_esportivo/public/img/jogadores/{$jogador['imagem']}"
                                    : "/campeonato_esportivo/public/img/perfil_padrao/perfil_padrao.png";
                            ?>
                            <tr>
                                <td class="text-center" style="width: 60px;">
                                    <img src="<?= $imagemCaminho ?>" alt="Imagem do jogador" class="rounded-circle" style="width: 48px; height: 48px; object-fit: cover;">
                                </td>
                                <td class="text-start">
                                    <?= htmlspecialchars($jogador['nome']) ?>
                                    <input type="hidden" name="escalacao[<?= $index ?>][jogador_id]" value="<?= $id ?>">
                                </td>
                                <td>
                                    <input type="checkbox" name="escalacao[<?= $index ?>][titular]" value="1" <?= $titular_checked ?>>
                                </td>
                                <td>
                                    <input type="radio" name="capitao" value="<?= $id ?>" <?= $capitao_checked ?>>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="/campeonato_esportivo/routes/time/agenda_time.php" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Salvar Escalação</button>
            </div>
        </form>
    </div>
</main>

<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
<script src="/campeonato_esportivo/assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
