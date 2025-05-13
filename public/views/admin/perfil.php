<?php
session_start();
$usuario = $_SESSION['usuario'] ?? null;
include __DIR__ . '/../../includes/admin_sec.php';
?>

<main class="flex-grow-1">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h5><i class="bi bi-person-circle me-2"></i>Editar Perfil - Administrador</h5>
                    </div>
                    <div class="card-body">

                        <?php if (!empty($_SESSION['mensagem_sucesso'])): ?>
                            <div class="alert alert-success">
                                <?= $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($_SESSION['mensagem_erro'])): ?>
                            <div class="alert alert-danger">
                                <?= $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/campeonato_esportivo/routes/adms/atualizar_perfil.php">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome'] ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email'] ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nova Senha</label>
                                <input type="password" name="nova_senha" id="nova_senha" class="form-control" oninput="verificarForcaSenha()">
                                <div class="senha-ajuda">Mínimo 6 caracteres, com letras e números.</div>
                                <div class="progress mt-2">
                                    <div id="barra-forca" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                                <small id="forca-texto" class="text-muted"></small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirmar Nova Senha</label>
                                <input type="password" name="confirmar_senha" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-success w-100">Salvar Alterações</button>
                        </form>

                        <div class="mt-3 text-center">
                            <a href="/campeonato_esportivo/routes/admin_visual/dashboard_administrador.php" class="text-decoration-none">
                                <i class="bi bi-arrow-left"></i> Voltar ao Painel
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include __DIR__ . '/../cabecalho/footer.php'; ?>
<script src="/campeonato_esportivo/assets/js/bootstrap.bundle.min.js"></script>
<script>
function verificarForcaSenha() {
    const senha = document.getElementById('nova_senha').value;
    const barra = document.getElementById('barra-forca');
    const texto = document.getElementById('forca-texto');

    let forca = 0;
    if (senha.length >= 6) forca += 1;
    if (/[A-Z]/.test(senha)) forca += 1;
    if (/[a-z]/.test(senha)) forca += 1;
    if (/[0-9]/.test(senha)) forca += 1;
    if (/[^A-Za-z0-9]/.test(senha)) forca += 1;

    const cores = ['bg-danger', 'bg-warning', 'bg-success'];
    barra.classList.remove(...cores);

    if (forca <= 2) {
        barra.classList.add('bg-danger');
        barra.style.width = '33%';
        texto.innerText = 'Senha fraca';
    } else if (forca <= 4) {
        barra.classList.add('bg-warning');
        barra.style.width = '66%';
        texto.innerText = 'Senha média';
    } else {
        barra.classList.add('bg-success');
        barra.style.width = '100%';
        texto.innerText = 'Senha forte';
    }
}
</script>
</body>
</html>
