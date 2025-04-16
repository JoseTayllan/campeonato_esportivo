<?php 
session_start();
$restrito_para = ['Administrador', 'Organizador'];
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php';
?>

<?php include '../cabecalho/header.php'; ?>
<?php 
$tipo_usuario = strtolower(trim($_SESSION['usuario_tipo']));
if ($tipo_usuario === 'administrador') {
    include '../cabecalho/tabela_administrativa.php';
} else {
    include '../cabecalho/tabela.php';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Campeonato</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
    <h2 class="mb-4">Cadastro de Campeonato</h2>

    <?php include '../partials/mensagens.php'; ?>

    <form action="../../../routes/championships.php" method="POST">
        <!-- Dados do Campeonato -->
        <div class="mb-3">
            <label class="form-label">Nome do Campeonato</label>
            <input type="text" class="form-control" name="nome" placeholder="Ex: Copa Estudantil 2025" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" name="descricao" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Temporada</label>
            <input type="number" class="form-control" name="temporada" min="1900" max="2100" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Formato</label>
            <select class="form-control" name="formato" required>
                <option value="">Selecione</option>
                <option value="Pontos Corridos">Pontos Corridos</option>
                <option value="Mata-Mata">Mata-Mata</option>
                <option value="Fase de Grupos">Fase de Grupos</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Regulamento</label>
            <textarea class="form-control" name="regulamento" required></textarea>
        </div>

        <!-- Times Participantes -->
        <div class="mb-3">
            <label class="form-label">Times Participantes</label>
            <div class="border p-3 rounded" style="max-height: 200px; overflow-y: auto;">
                <?php
                $resultTimes = $conn->query("SELECT id, nome FROM times ORDER BY nome ASC");
                while ($time = $resultTimes->fetch_assoc()) {
                    echo "<div class='form-check'>
                            <input class='form-check-input' type='checkbox' name='times[]' value='{$time['id']}' id='time_{$time['id']}'>
                            <label class='form-check-label' for='time_{$time['id']}'>{$time['nome']}</label>
                          </div>";
                }
                ?>
            </div>
        </div>

        <!-- Fase Inicial -->
        <hr>
        <h4>Fase Inicial</h4>
        <div class="mb-3">
            <label class="form-label">Nome da Fase</label>
            <select class="form-control" name="fase_nome" required>
                <option value="Fase de Grupos">Fase de Grupos</option>
                <option value="Oitavas de Final">Oitavas de Final</option>
                <option value="Quartas de Final">Quartas de Final</option>
                <option value="Semifinal">Semifinal</option>
                <option value="Final">Final</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ordem de Execução da Fase</label>
            <input type="number" class="form-control" name="fase_ordem" min="1" required>
            <small class="text-muted">Define em que ordem a fase acontecerá no campeonato.</small>
        </div>

        <!-- Rodadas da Fase -->
        <hr>
        <h5>Rodada 1</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Número</label>
                <input type="number" class="form-control" name="rodada1_numero" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tipo</label>
                <select class="form-control" name="rodada1_tipo" required>
                    <option value="Ida">Ida</option>
                    <option value="Volta">Volta</option>
                </select>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Descrição</label>
                <input type="text" class="form-control" name="rodada1_descricao">
            </div>
        </div>

        <h5>Rodada 2</h5>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Número</label>
                <input type="number" class="form-control" name="rodada2_numero" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Tipo</label>
                <select class="form-control" name="rodada2_tipo" required>
                    <option value="Ida">Ida</option>
                    <option value="Volta">Volta</option>
                </select>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label">Descrição</label>
                <input type="text" class="form-control" name="rodada2_descricao">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar Campeonato</button>
    </form>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
