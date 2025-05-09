<?php if (!isset($time_id)) { die('Acesso direto não permitido.'); } ?>
<?php require_once __DIR__ . '/../../includes/assinatura_sec.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Adicionar Jogador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="card p-4 shadow">
            <h2 class="mb-4">Adicionar Jogador</h2>
            <form action="/campeonato_esportivo/routes/time/jogador.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="time_id" value="<?= $time_id ?>">

                <div class="mb-3">
                    <label>Nome do Jogador</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Posição</label>
                    <select name="posicao" class="form-select" required>
                      <option value="">Selecione a posição</option>
                      <option value="Goleiro">Goleiro</option>
                      <option value="Zagueiro">Zagueiro</option>
                      <option value="Lateral">Lateral</option>
                      <option value="Volante">Volante</option>
                      <option value="Meia">Meia</option>
                      <option value="Atacante">Atacante</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Idade</label>
                    <input type="number" name="idade" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nacionalidade</label>
                    <input type="text" name="nacionalidade" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Imagem do Jogador</label>
                    <input type="file" name="imagem" class="form-control" accept="image/*">
                </div>
                
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="dashboard_time.php" class="btn btn-secondary">Voltar</a>
            </form>
        </div>
    </div>
</body>
</html>
