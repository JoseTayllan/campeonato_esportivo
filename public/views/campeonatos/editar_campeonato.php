<?php

require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/Models/Campeonato.php';
require_once __DIR__ . '/../../includes/admin_sec.php';

$model = new Campeonato($conn);

// Pega o ID do campeonato pela URL
$id = $_GET['id'] ?? null;
if (!$id) {
    $_SESSION['mensagem_erro'] = "ID do campeonato não informado.";
    header('Location: meus_campeonatos.php');
    exit;
}

// Busca dados do campeonato
$campeonato = $model->buscarPorId($id);
if (!$campeonato) {
    $_SESSION['mensagem_erro'] = "Campeonato não encontrado.";
    header('Location: meus_campeonatos.php');
    exit;
}
?>

<link rel="stylesheet" href="/campeonato_esportivo/public/assets/css/admin.css">

<body class="d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container mt-4 container-campeonato">
            <h2>Editar Campeonato</h2>

            <?php if (!empty($_SESSION['mensagem_sucesso'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['mensagem_sucesso'];
                    unset($_SESSION['mensagem_sucesso']); ?>
                </div>
            <?php elseif (!empty($_SESSION['mensagem_erro'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['mensagem_erro'];
                    unset($_SESSION['mensagem_erro']); ?>
                </div>
            <?php endif; ?>

            <form action="/campeonato_esportivo/routes/adms/campeonatos_atualizar.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $campeonato['id'] ?>">

                <div class="mb-3">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($campeonato['nome']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Descrição</label>
                    <textarea name="descricao" class="form-control"><?= htmlspecialchars($campeonato['descricao']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Premiação</label>
                    <textarea name="premiacao" class="form-control"><?= htmlspecialchars($campeonato['premiacao']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Temporada</label>
                    <input type="text" name="temporada" class="form-control" value="<?= htmlspecialchars($campeonato['temporada']) ?>" required>
                </div>

                <div class="mb-3">
                    <label>Formato</label>
                    <select name="formato" class="form-select">
                        <option <?= $campeonato['formato'] == 'Pontos Corridos' ? 'selected' : '' ?>>Pontos Corridos</option>
                        <option <?= $campeonato['formato'] == 'Mata-Mata' ? 'selected' : '' ?>>Mata-Mata</option>
                        <option <?= $campeonato['formato'] == 'Fase de Grupos' ? 'selected' : '' ?>>Fase de Grupos</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Modalidade</label>
                    <select name="modalidade" class="form-select">
                        <option <?= $campeonato['modalidade'] == 'Futebol' ? 'selected' : '' ?>>Futebol</option>
                        <option <?= $campeonato['modalidade'] == 'Futsal' ? 'selected' : '' ?>>Futsal</option>
                        <option <?= $campeonato['modalidade'] == 'Queimada' ? 'selected' : '' ?>>Queimada</option>
                        <option <?= $campeonato['modalidade'] == 'Natação' ? 'selected' : '' ?>>Natação</option>
                        <option <?= $campeonato['modalidade'] == 'Vôlei' ? 'selected' : '' ?>>Vôlei</option>
                        <option <?= $campeonato['modalidade'] == '1x1' ? 'selected' : '' ?>>1x1</option>
                        <option <?= $campeonato['modalidade'] == '2x2' ? 'selected' : '' ?>>2x2</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="ativo" <?= $campeonato['status'] === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                        <option value="encerrado" <?= $campeonato['status'] === 'encerrado' ? 'selected' : '' ?>>Encerrado</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>QR Code da Localização (opcional)</label>
                    <?php if (!empty($campeonato['qr_code_localizacao'])): ?>
                        <div class="mb-2">
                            <img src="/campeonato_esportivo/<?= $campeonato['qr_code_localizacao'] ?>" alt="QR atual" style="max-width: 150px;">
                            <p class="small text-muted">QR atual. Para substituir, envie um novo.</p>
                        </div>
                    <?php endif; ?>
                    <input type="file" name="qr_code" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Banner do Campeonato (Bandeirão)</label>
                    <input type="file" name="banner" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>
    </main>
    <div class="mt-5">
        <?php include __DIR__ . '/../cabecalho/footer.php'; ?>
        <script src="/campeonato_esportivo/assets/js/bootstrap.bundle.min.js"></script>
    </div>

</body>