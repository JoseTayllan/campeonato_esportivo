<?php
// Proteção
session_start();
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/controllers/UserController.php';
require_once __DIR__ . '/../../../app/middleware/verifica_sessao.php';

// Permissão apenas para master
if ($_SESSION['usuario_tipo'] !== 'Master') {
    $_SESSION['mensagem_erro'] = "Acesso negado.";
    header("Location: /public/index.php");
    exit;
}

$userController = new UsuarioController($conn);
$usuarios = $userController->listarTodos();

include '../cabecalho/header.php';
?>

<div class="container mt-4">
    <h2 class="mb-4">Usuários do Sistema</h2>

    <?php if (empty($usuarios)): ?>
        <div class="alert alert-info">Nenhum usuário cadastrado.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Assinatura</th>
                        <th>Data de Criação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['id']) ?></td>
                            <td><?= htmlspecialchars($u['nome']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td><?= htmlspecialchars($u['tipo']) ?></td>
                            <td><?= htmlspecialchars($u['tipo_assinatura'] ?? '---') ?></td>
                            <td><?= date('d/m/Y', strtotime($u['criado_em'])) ?></td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary disabled">Editar</a>
                                <a href="/routes/master/excluir_usuario.php?id=<?= $u['id'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Tem certeza que deseja excluir este usuário?');">
                                    Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include '../cabecalho/footer.php'; ?>