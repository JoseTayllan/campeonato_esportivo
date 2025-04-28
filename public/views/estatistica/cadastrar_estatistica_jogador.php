<?php 
// Proteger contra acesso direto
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Acesso direto não permitido!</h2>
            <p>Utilize o sistema normalmente para acessar esta página.</p>
          </div>";
    exit();
}
session_start();
$restrito_para = ['Administrador', 'Organizador', 'Treinador'];
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php'; // Conexão com o banco
?>

<?php include '../cabecalho/header.php'; ?>
<?php
$tipo = strtolower($_SESSION['usuario_tipo'] ?? '');

switch ($tipo) {
    case 'administrador':
        include '../cabecalho/tabela_administrativa.php';
        break;
    case 'organizador':
        include '../cabecalho/tabela.php';
        break;
    case 'olheiro':
        include '../cabecalho/tabela_olheiro.php';
        break;
    case 'treinador':
        include '../cabecalho/tabela_treinador.php';
        break;
    case 'jogador':
        include '../cabecalho/tabela_jogador.php';
        break;
    case 'patrocinador':
        include '../cabecalho/tabela_patrocinador.php';
        break;
    default:
        include '../cabecalho/tabela.php';
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Cadastrar Estatísticas de Jogador</h2>

    <?php include '../partials/mensagens.php'; ?>

    <form action="../../../routes/statistics.php" method="POST">

        <div class="mb-3">
            <label for="partida_id" class="form-label">Partida</label>
            <select class="form-control" name="partida_id" required>
                <option value="">Selecione uma partida</option>
                <?php
                $queryPartidas = "SELECT id, data FROM partidas ORDER BY data DESC";
                $resultPartidas = $conn->query($queryPartidas);
                while ($row = $resultPartidas->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>Partida #{$row['id']} - ".date('d/m/Y', strtotime($row['data']))."</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="jogador_id" class="form-label">Jogador</label>
            <select class="form-control" name="jogador_id" required id="jogador_id">
                <option value="">Selecione um jogador</option>
                <?php
                $queryJogadores = "SELECT id, nome, posicao FROM jogadores";
                $resultJogadores = $conn->query($queryJogadores);
                while ($row = $resultJogadores->fetch_assoc()) {
                    echo "<option value='{$row['id']}' data-posicao='{$row['posicao']}'>{$row['nome']} ({$row['posicao']})</option>";
                }
                ?>
            </select>
        </div>

        <div id="campos-estatisticas"></div>

        <button type="submit" class="btn btn-primary mt-3">Salvar Estatística</button>
    </form>
</div>

<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const jogadorSelect = document.getElementById('jogador_id');
    const camposEstatisticas = document.getElementById('campos-estatisticas');

    jogadorSelect.addEventListener('change', function () {
        const selected = jogadorSelect.options[jogadorSelect.selectedIndex];
        const posicao = selected.getAttribute('data-posicao')?.toLowerCase();

        let html = '';

        if (!posicao) {
            camposEstatisticas.innerHTML = '';
            return;
        }

        if (posicao === 'goleiro') {
            html = `
                <div class="mb-3">
                    <label>Defesas</label>
                    <input type="number" class="form-control" name="defesas" min="0">
                </div>
                <div class="mb-3">
                    <label>Gols Sofridos</label>
                    <input type="number" class="form-control" name="gols_sofridos" min="0">
                </div>
                <div class="mb-3">
                    <label>Pênaltis Defendidos</label>
                    <input type="number" class="form-control" name="penaltis_defendidos" min="0">
                </div>
                <div class="mb-3">
                    <label>Partidas sem Sofrer Gol</label>
                    <input type="number" class="form-control" name="clean_sheets" min="0">
                </div>
            `;
        } else {
            html = `
                <div class="mb-3">
                    <label>Gols</label>
                    <input type="number" class="form-control" name="gols" min="0">
                </div>
                <div class="mb-3">
                    <label>Assistências</label>
                    <input type="number" class="form-control" name="assistencias" min="0">
                </div>
                <div class="mb-3">
                    <label>Passes Completos</label>
                    <input type="number" class="form-control" name="passes_completos" min="0">
                </div>
                <div class="mb-3">
                    <label>Finalizações</label>
                    <input type="number" class="form-control" name="finalizacoes" min="0">
                </div>
            `;
        }

        html += `
            <div class="mb-3">
                <label>Faltas Cometidas</label>
                <input type="number" class="form-control" name="faltas_cometidas" min="0">
            </div>
            <div class="mb-3">
                <label>Cartões Amarelos</label>
                <input type="number" class="form-control" name="cartoes_amarelos" min="0">
            </div>
            <div class="mb-3">
                <label>Cartões Vermelhos</label>
                <input type="number" class="form-control" name="cartoes_vermelhos" min="0">
            </div>
            <div class="mb-3">
                <label>Minutos Jogados</label>
                <input type="number" class="form-control" name="minutos_jogados" min="0" max="90">
            </div>
            <div class="mb-3">
                <label>Substituições</label>
                <select class="form-control" name="substituicoes" required>
                    <option value="0">Não foi substituído</option>
                    <option value="1">Foi substituído</option>
                </select>
            </div>
        `;

        camposEstatisticas.innerHTML = html;
    });
});
</script>

<?php include '../cabecalho/footer.php'; ?>
