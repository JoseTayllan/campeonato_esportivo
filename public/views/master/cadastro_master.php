<?php 
session_start();
include __DIR__ . '/../cabecalho/header.php'; 
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Cadastro de Usuário Master</h4>
                </div>

                <div class="card-body">

                    <?php if (isset($_SESSION['mensagem_erro'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['mensagem_erro']; unset($_SESSION['mensagem_erro']); ?></div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['mensagem_sucesso'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['mensagem_sucesso']; unset($_SESSION['mensagem_sucesso']); ?></div>
                    <?php endif; ?>

                    <form action="/routes/master/registrar_master.php" method="POST">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" name="nome" class="form-control" required placeholder="Digite seu nome completo">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control" required placeholder="Digite seu e-mail">
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" name="senha" class="form-control" required placeholder="Digite uma senha">
                        </div>

                        <button type="submit" class="btn btn-dark w-100">Cadastrar Master</button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../cabecalho/footer.php'; ?>
