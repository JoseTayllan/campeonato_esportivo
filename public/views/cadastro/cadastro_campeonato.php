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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Campeonato</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2 class="mb-4">Cadastro de Campeonato</h2>

    <?php include '../partials/mensagens.php'; ?>

    <form action="../../../routes/championships.php" method="POST">

        <!-- DADOS DO CAMPEONATO -->
        <div class="mb-3">
            <label class="form-label">Nome do Campeonato</label>
            <input type="text" class="form-control" name="nome" required>
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
                <option value="">Selecione o formato</option>
                <option value="Pontos Corridos">Pontos Corridos</option>
                <option value="Mata-Mata">Mata-Mata</option>
                <option value="Fase de Grupos">Fase de Grupos</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Regulamento</label>
            <textarea class="form-control" name="regulamento" required></textarea>
        </div>

        <!-- TIMES PARTICIPANTES -->
        <div class="mb-4">
            <label class="form-label">Times Participantes</label>
            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                <?php
                $queryTimes = "SELECT id, nome FROM times ORDER BY nome ASC";
                $resultTimes = $conn->query($queryTimes);
                while ($time = $resultTimes->fetch_assoc()) {
                    echo "
                    <div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='times[]' value='{$time['id']}' id='time_{$time['id']}'>
                        <label class='form-check-label' for='time_{$time['id']}'>
                            {$time['nome']}
                        </label>
                    </div>";
                }
                ?>
            </div>
        </div>

        <!-- FASE -->
        <hr class="my-4">
        <h5>Cadastro da 1ª Fase</h5>
        <div class="mb-3">
            <label class="form-label">Nome da Fase</label>
            <select class="form-control" name="fase_nome" required>
                <option value="">Selecione a fase</option>
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
            <small class="form-text text-muted">
                Define a ordem de execução dessa fase no campeonato.
                Ex: Fase de Grupos = 1, Quartas = 2, etc.
            </small>
        </div>

        <!-- RODADAS -->
        <hr class="my-4">
        <h5>Cadastro das Rodadas da 1ª Fase</h5>
        <div id="rodadas-container">
            <div class="row align-items-end mb-3 rodada-item">
                <div class="col-md-2">
                    <label class="form-label">Número</label>
                    <input type="number" class="form-control" name="rodada_numero[]" min="1" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tipo</label>
                    <select class="form-control" name="rodada_tipo[]" required>
                        <option value="Ida">Ida</option>
                        <option value="Volta">Volta</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Descrição</label>
                    <input type="text" class="form-control" name="rodada_desc[]" placeholder="Ex: Rodada Inaugural">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-danger btn-sm" onclick="removerRodada(this)">X</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-outline-primary btn-sm mb-4" onclick="adicionarRodada()">➕ Adicionar Rodada</button>

        <!-- BOTÃO FINAL -->
        <div class="mb-5">
            <button type="submit" class="btn btn-primary">Cadastrar Campeonato</button>
        </div>
    </form>
</div>

<?php include '../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>

<script>
function adicionarRodada() {
    const container = document.getElementById("rodadas-container");
    const nova = document.createElement("div");
    nova.className = "row align-items-end mb-3 rodada-item";
    nova.innerHTML = `
        <div class="col-md-2">
            <input type="number" class="form-control" name="rodada_numero[]" min="1" required>
        </div>
        <div class="col-md-4">
            <select class="form-control" name="rodada_tipo[]" required>
                <option value="Ida">Ida</option>
                <option value="Volta">Volta</option>
            </select>
        </div>
        <div class="col-md-5">
            <input type="text" class="form-control" name="rodada_desc[]" placeholder="Ex: Rodada Extra">
        </div>
        <div class="col-md-1 text-end">
            <button type="button" class="btn btn-danger btn-sm" onclick="removerRodada(this)">X</button>
        </div>
    `;
    container.appendChild(nova);
}

function removerRodada(botao) {
    const bloco = botao.closest(".rodada-item");
    if (bloco) bloco.remove();
}
</script>

</body>
</html>
