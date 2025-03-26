<?php 
session_start();
require_once __DIR__ . '/../../../config/database.php'; // Conexão com o banco
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Estatística de Jogador</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
    <h2 class="mb-4">Cadastrar Estatísticas de Jogador</h2>

    <?php include '../partials/mensagens.php'; ?>

    <form action="../../../routes/statistics.php" method="POST">
        
        <!-- Seleção da Partida -->
        <div class="mb-3">
            <label for="partida_id" class="form-label">Partida</label>
            <select class="form-control" name="partida_id" required>
                <option value="">Selecione uma partida</option>
                <?php
                $queryPartidas = "SELECT id, data FROM partidas ORDER BY data DESC";
                $resultPartidas = $conn->query($queryPartidas);
                while ($row = $resultPartidas->fetch_assoc()) {
                    $dataFormatada = date('d/m/Y', strtotime($row['data']));
                    echo "<option value='{$row['id']}'>Partida #{$row['id']} - {$dataFormatada}</option>";
                }
                ?>
            </select>
            <small class="form-text text-muted">Escolha a partida que deseja cadastrar estatísticas.</small>
        </div>

        <!-- Seleção do Jogador -->
        <div class="mb-3">
            <label for="jogador_id" class="form-label">Jogador</label>
            <select class="form-control" name="jogador_id" required>
                <option value="">Selecione um jogador</option>
                <?php
                $queryJogadores = "SELECT id, nome FROM jogadores";
                $resultJogadores = $conn->query($queryJogadores);
                while ($row = $resultJogadores->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
                ?>
            </select>
            <small class="form-text text-muted">Escolha o jogador que participou da partida.</small>
        </div>

        <!-- Campos de Estatísticas -->
        <div class="mb-3">
            <label for="gols" class="form-label">Gols</label>
            <input type="number" class="form-control" name="gols" min="0" placeholder="Ex: 2">
        </div>

        <div class="mb-3">
            <label for="assistencias" class="form-label">Assistências</label>
            <input type="number" class="form-control" name="assistencias" min="0" placeholder="Ex: 1">
        </div>

        <div class="mb-3">
            <label for="passes_completos" class="form-label">Passes Completos</label>
            <input type="number" class="form-control" name="passes_completos" min="0" placeholder="Ex: 30">
        </div>

        <div class="mb-3">
            <label for="finalizacoes" class="form-label">Finalizações</label>
            <input type="number" class="form-control" name="finalizacoes" min="0" placeholder="Ex: 5">
        </div>

        <div class="mb-3">
            <label for="faltas_cometidas" class="form-label">Faltas Cometidas</label>
            <input type="number" class="form-control" name="faltas_cometidas" min="0" placeholder="Ex: 2">
        </div>

        <div class="mb-3">
            <label for="cartoes_amarelos" class="form-label">Cartões Amarelos</label>
            <input type="number" class="form-control" name="cartoes_amarelos" min="0" placeholder="Ex: 1">
        </div>

        <div class="mb-3">
            <label for="cartoes_vermelhos" class="form-label">Cartões Vermelhos</label>
            <input type="number" class="form-control" name="cartoes_vermelhos" min="0" placeholder="Ex: 0">
        </div>

        <div class="mb-3">
            <label for="minutos_jogados" class="form-label">Minutos Jogados</label>
            <input type="number" class="form-control" name="minutos_jogados" min="0" max="90" placeholder="Ex: 75">
        </div>

        <!-- Substituições (Apenas 0 ou 1) -->
        <div class="mb-3">
            <label for="substituicoes" class="form-label">Substituições</label>
            <select class="form-control" name="substituicoes" required>
                <option value="0">Não foi substituído (0)</option>
                <option value="1">Foi substituído (1)</option>
            </select>
            <small class="form-text text-muted">Indique se o jogador foi substituído durante a partida.</small>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Estatística</button>
    </form>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
