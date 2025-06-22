<?php require_once __DIR__ . '/../../includes/assinatura_sec.php'; ?>

<div class="container py-4">
    <div class="card shadow p-4">
        <h2 class="mb-4">Editar Jogador</h2>

        <form action="/campeonato_esportivo/routes/time/salvar_edicao_jogador.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="jogador_id" value="<?= $jogador['id'] ?>">

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($jogador['nome']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Posição</label>
                <input type="text" name="posicao" class="form-control" value="<?= htmlspecialchars($jogador['posicao']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Idade</label>
                <input type="number" name="idade" class="form-control" value="<?= htmlspecialchars($jogador['idade']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nacionalidade</label>
                <input type="text" name="nacionalidade" class="form-control" value="<?= htmlspecialchars($jogador['nacionalidade']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">CPF</label>
                <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($jogador['cpf'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Data de Nascimento</label>
                <input type="date" name="data_nascimento" class="form-control" value="<?= htmlspecialchars($jogador['data_nascimento'] ?? '') ?>">
            </div>



            <div class="mb-3">
                <label class="form-label">Atualizar Imagem</label>
                <input type="file" name="imagem" class="form-control">
                <?php if (!empty($jogador['imagem'])): ?>
                    <div class="mt-2">
                        <img src="/campeonato_esportivo/public/img/jogadores/<?= htmlspecialchars($jogador['imagem']) ?>"
                            width="100"
                            class="rounded-circle">
                    </div>
                <?php endif; ?>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="/campeonato_esportivo/routes/time/dashboard_time.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>