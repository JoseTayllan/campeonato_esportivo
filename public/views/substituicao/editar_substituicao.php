<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['mensagem_erro'] = "ID inválido.";
    header("Location: listar_substituicoes.php");
    exit;
}

$id = intval($_GET['id']);

$query = "SELECT * FROM substituicoes WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['mensagem_erro'] = "Substituição não encontrada.";
    header("Location: listar_substituicoes.php");
    exit;
}

$substituicao = $result->fetch_assoc();

$partidas = $conn->query("SELECT id, data, local FROM partidas ORDER BY data DESC");
$jogadores = $conn->query("SELECT id, nome FROM jogadores ORDER BY nome ASC");
?>

<?php include '../cabecalho/header.php'; ?>
<?php include '../cabecalho/tabela.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Editar Substituição</h2>
    <form method="POST" action="../../../routes/substituicao_update.php">
        <input type="hidden" name="id" value="<?= $substituicao['id'] ?>">

        <div class="mb-3">
            <label class="form-label">Partida</label>
            <select name="partida_id" class="form-select" required>
                <?php while ($p = $partidas->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>" <?= $p['id'] == $substituicao['partida_id'] ? 'selected' : '' ?>>
                        Partida #<?= $p['id'] ?> - <?= date('d/m/Y', strtotime($p['data'])) ?> - <?= $p['local'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jogador que saiu</label>
            <select name="jogador_saiu" class="form-select" required>
                <?php mysqli_data_seek($jogadores, 0); while ($j = $jogadores->fetch_assoc()): ?>
                    <option value="<?= $j['id'] ?>" <?= $j['id'] == $substituicao['jogador_saiu'] ? 'selected' : '' ?>>
                        <?= $j['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Jogador que entrou</label>
            <select name="jogador_entrou" class="form-select" required>
                <?php mysqli_data_seek($jogadores, 0); while ($j = $jogadores->fetch_assoc()): ?>
                    <option value="<?= $j['id'] ?>" <?= $j['id'] == $substituicao['jogador_entrou'] ? 'selected' : '' ?>>
                        <?= $j['nome'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Minuto da Substituição</label>
            <input type="number" name="minuto_substituicao" value="<?= $substituicao['minuto_substituicao'] ?>" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 Salvar Alterações</button>
        <a href="listar_substituicoes.php" class="btn btn-secondary">↩️ Voltar</a>
    </form>
</div>

<?php include '../cabecalho/footer.php'; ?>
