<?php require_once __DIR__ . '/../../includes/assinatura_time.php'; ?>
<?php
// Proteger contra acesso direto
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Acesso direto não permitido!</h2>
            <p>Utilize o sistema normalmente para acessar esta página.</p>
          </div>";
    exit();
}
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../../app/middleware/verifica_assinatura.php';
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/controllers/TeamController.php';

permite_acesso(['time', 'completo']);

$controller = new TeamController($conn);
$admin_id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("SELECT * FROM times WHERE admin_id = ?");
$stmt->bind_param("i", $admin_id); // tipo "i" para inteiro
$stmt->execute();
$resultado = $stmt->get_result();
$time = $resultado->fetch_assoc();


if (!$time):
?>
    <div class="container py-5">
        <div class="alert alert-warning shadow mb-4">Você ainda não cadastrou um time.</div>

        <div class="card p-4 shadow">
            <h4>Cadastro do Meu Time</h4>
            <form action="../../../routes/team.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="criar_time" value="1">

                <div class="mb-3">
                    <label>Nome do Time</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Cidade</label>
                    <input type="text" name="cidade" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Estádio</label>
                    <input type="text" name="estadio" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Escudo</label>
                    <input type="file" name="escudo" class="form-control">
                </div>

                <button class="btn btn-success">Criar Time</button>
            </form>
        </div>
    </div>
<?php
    exit();
endif;

// ✅ Correto para MySQLi

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard do Time</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="card shadow p-4">
            <h2 class="mb-4">Dashboard - Meu Time</h2>
            <?php if (!empty($time['codigo_publico'])): ?>
                <div class="alert alert-info mt-3">
                    <strong>Seu Código Público:</strong> <?= htmlspecialchars($time['codigo_publico']) ?><br>
                    Copie e envie para o organizador para vincular seu time a campeonatos!
                </div>
            <?php endif; ?>


            <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
                <div class="alert alert-success"><?= $_SESSION['mensagem_sucesso'];
                                                    unset($_SESSION['mensagem_sucesso']); ?></div>
            <?php elseif (isset($_SESSION['mensagem_erro'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['mensagem_erro'];
                                                unset($_SESSION['mensagem_erro']); ?></div>
            <?php endif; ?>

            <form action="../../../routes/team.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="editar_time" value="1">
                <input type="hidden" name="time_id" value="<?= $time['id'] ?>">

                <div class="mb-3">
                    <label class="form-label">Nome do Time</label>
                    <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($time['nome']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cidade</label>
                    <input type="text" name="cidade" class="form-control" value="<?= htmlspecialchars($time['cidade']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Atualizar Escudo</label>
                    <input type="file" name="escudo" class="form-control">
                    <?php if (!empty($time['escudo'])): ?>
                        <div class="mt-3">
                            <strong>Escudo atual:</strong><br>
                            <img src="../../<?= $time['escudo'] ?>" width="100" alt="Escudo do time">
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </form>
            <hr class="my-4">
            <h4>Elenco</h4>

            <?php
            $jogadores = $controller->listarJogadoresDoMeuTime($time['id']);
            ?>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <tr>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Posição</th>
                        <th>Ações</th>
                </tr>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($jogador = $jogadores->fetch_assoc()): ?>
                        <tr>
                        <td class="text-center" style="width: 60px;">
                            <?php if (!empty($jogador['imagem']) && file_exists(__DIR__ . '/../../../public/img/jogadores/' . $jogador['imagem'])): ?>
                                <img src="/campeonato_esportivo/public/img/jogadores/<?= $jogador['imagem'] ?>" alt="Imagem do jogador" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php else: ?>
                                <img src="/campeonato_esportivo/public/img/perfil_padrao/perfil_padrao.png" alt="Imagem padrão" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                            <?php endif; ?>
                        </td>
                        <td style="vertical-align: middle;"><?= htmlspecialchars($jogador['nome']) ?></td>
                        <td style="vertical-align: middle;"><?= htmlspecialchars($jogador['posicao']) ?></td>
                        <td style="vertical-align: middle;">
                            <a href="editar_jogador.php?id=<?= $jogador['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="excluir_jogador.php?id=<?= $jogador['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este jogador?')">Excluir</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <a href="adicionar_jogador.php" class="btn btn-success mt-2">Adicionar Jogador</a>

        </div>
    </div>
    


</body>

</html>

<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>