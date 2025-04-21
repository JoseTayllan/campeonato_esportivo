<?php include __DIR__ . '/../cabecalho/header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4">Cadastro de Organizador</h2>
    <?php include __DIR__ . '/../partials/mensagens.php'; ?>


    <form action="/campeonato_esportivo/routes/salvar_organizador.php" method="POST">
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>E-mail</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Senha</label>
            <input type="password" name="senha" class="form-control" required>
        </div>

        <input type="hidden" name="tipo" value="Organizador">

        <button class="btn btn-success">Cadastrar</button>
    </form>
</div>

<?php include __DIR__ . '/../cabecalho/footer.php'; ?>
