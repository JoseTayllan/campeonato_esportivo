<?php require_once __DIR__ . '/../../includes/assinatura_patrocinador_sec.php'; ?>

<div class="container py-5">
    <div class="card p-4 shadow">
        <h4 class="mb-4">Vincular a um Novo Time</h4>

        <?php if (empty($times_disponiveis)): ?>
            <div class="alert alert-info">Nenhum time disponível para vínculo.</div>
        <?php else: ?>
            <form method="POST" action="/campeonato_esportivo/routes/patrocinador/vincular_time.php">
                <input type="hidden" name="vincular_time" value="1">

                <div class="mb-3">
                    <label>Escolha um Time:</label>
                    <select name="time_id" class="form-select" required>
                        <option value="">-- Selecione --</option>
                        <?php foreach ($times_disponiveis as $time): ?>
                            <option value="<?= $time['id'] ?>">
                                <?= htmlspecialchars($time['nome']) ?> (<?= htmlspecialchars($time['cidade']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="valor_investido" class="form-label">Valor do Investimento (R$)</label>
                    <input type="number" name="valor_investido" class="form-control" step="0.01" min="0" required>
                </div>

                

                <button type="submit" class="btn btn-success">Vincular Time</button>
            </form>
        <?php endif; ?>
    </div>
</div>
