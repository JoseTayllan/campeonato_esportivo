<?php
session_start();
$restrito_para = ['Administrador', 'Organizador','Treinador'];
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../config/database.php';

// Buscar partidas
$partidas = $conn->query("SELECT id, data, horario, local FROM partidas ORDER BY data DESC");

// Buscar jogadores
$jogadores = $conn->query("SELECT id, nome FROM jogadores ORDER BY nome ASC");
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
    <h2 class="mb-4">Registrar Substituição</h2>

    <?php include '../partials/mensagens.php'; ?>

    <form method="POST" action="../../../routes/substituicao_store.php">
        <div class="mb-3">
            <label for="partida" class="form-label">Partida</label>
            <select name="partida_id" id="partida" class="form-select" required>
                <option value="">Selecione uma partida</option>
                <?php while ($row = $partidas->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>">
                    Partida #<?= $row['id'] ?> - <?= date('d/m/Y', strtotime($row['data'])) ?> - <?= $row['local'] ?>
                </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="jogador_saiu" class="form-label">Jogador que saiu</label>
            <select name="jogador_saiu" id="jogador_saiu" class="form-select" required>
                <option value="">Selecione o jogador</option>
                <?php mysqli_data_seek($jogadores, 0); while ($row = $jogadores->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['nome'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="jogador_entrou" class="form-label">Jogador que entrou</label>
            <select name="jogador_entrou" id="jogador_entrou" class="form-select" required>
                <option value="">Selecione o jogador</option>
                <?php mysqli_data_seek($jogadores, 0); while ($row = $jogadores->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>"><?= $row['nome'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="minuto_substituicao" class="form-label">Minuto da substituição</label>
            <input type="number" name="minuto_substituicao" id="minuto_substituicao" class="form-control" min="0"
                max="120" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 Registrar Substituição</button>
    </form>
</div>

<?php include '../cabecalho/footer.php'; ?>