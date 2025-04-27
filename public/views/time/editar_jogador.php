<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/controllers/TeamController.php';
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../app/middleware/verifica_assinatura.php';

permite_acesso(['time', 'completo']);

$controller = new TeamController($conn);
$jogador_id = $_GET['id'] ?? null;

$jogador = $controller->buscarJogador($jogador_id);

if (!$jogador) {
    $_SESSION['mensagem_erro'] = "Jogador não encontrado.";
    header("Location: dashboard_time.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Jogador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card p-4 shadow">
        <h2 class="mb-4">Editar Jogador</h2>

        <form action="../../../routes/jogador.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="editar_jogador" value="1">
            <input type="hidden" name="jogador_id" value="<?= $jogador['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($jogador['nome']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Posição</label>
                <select name="posicao" class="form-select" required>
                    <option value="">Selecione a posição</option>
                    <option value="Goleiro" <?= ($jogador['posicao'] === 'Goleiro') ? 'selected' : '' ?>>Goleiro</option>
                    <option value="Zagueiro" <?= ($jogador['posicao'] === 'Zagueiro') ? 'selected' : '' ?>>Zagueiro</option>
                    <option value="Lateral" <?= ($jogador['posicao'] === 'Lateral') ? 'selected' : '' ?>>Lateral</option>
                    <option value="volante" <?= ($jogador['posicao'] === 'volante') ? 'selected' : '' ?>>Volante</option>
                    <option value="Meia" <?= ($jogador['posicao'] === 'Meia') ? 'selected' : '' ?>>Meia</option>
                    <option value="Atacante" <?= ($jogador['posicao'] === 'Atacante') ? 'selected' : '' ?>>Atacante</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Idade</label>
                <input type="number" name="idade" class="form-control" value="<?= (int) $jogador['idade'] ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nacionalidade</label>
                <input type="text" name="nacionalidade" class="form-control" value="<?= htmlspecialchars($jogador['nacionalidade']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagem Atual</label><br>
                <?php if (!empty($jogador['imagem'])): ?>
                    <img src="/campeonato_esportivo/public/img/jogadores/<?= $jogador['imagem'] ?>" width="100" alt="Imagem atual">
                <?php else: ?>
                    <img src="/campeonato_esportivo/public/img/perfil_padrao/perfil_padrao.png" width="100" alt="Imagem padrão">
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Nova Imagem (opcional)</label>
                <input type="file" name="imagem" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="dashboard_time.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
</body>
</html>
