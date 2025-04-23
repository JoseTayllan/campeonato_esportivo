<?php require_once __DIR__ . '/../cabecalho/header.php'; ?>
<?php require_once __DIR__ . '/../cabecalho/tabela_administrativa.php'; ?>    

<div class="container mt-4 mb-5">
    <h2 class="mb-1">Partida Ao Vivo</h2>
    <h4 class="text-muted"><?= $partida['nome_casa'] ?> x <?= $partida['nome_fora'] ?></h4>
    <p class="mb-4">
        <strong>Local:</strong> <?= $partida['local'] ?> |
        <strong>Data:</strong> <?= date('d/m/Y', strtotime($partida['data'])) ?> |
        <strong>Horário:</strong> <?= $partida['horario'] ?>
    </p>

    <div class="row g-4">
        <!-- Formulário de Evento -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Registrar Evento</h5>
                    <form method="post" action="/campeonato_esportivo/routes/registrar_evento.php">
                        <input type="hidden" name="partida_id" value="<?= $partida['id'] ?>">

                        <div class="mb-3">
                            <label for="tipo_evento" class="form-label">Tipo de Evento</label>
                            <select name="tipo_evento" class="form-select" required>
                                <option value="gol">Gol</option>
                                <option value="cartao_amarelo">Cartão Amarelo</option>
                                <option value="cartao_vermelho">Cartão Vermelho</option>
                                <option value="substituicao">Substituição</option>
                                <option value="posse_bola">Posse de Bola</option>
                                <option value="finalizacao">Finalização</option>
                                <option value="outro">Outro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="minuto" class="form-label">Minuto</label>
                            <input type="text" name="minuto" class="form-control" placeholder="Ex: 42, 45+2" required>
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea name="descricao" class="form-control" rows="2" placeholder="Ex: Gol de cabeça de João após escanteio"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="jogador_id" class="form-label">Jogador</label>
                            <select name="jogador_id" class="form-select" required>
                                <option value="">Selecione</option>
                                <?php foreach ($jogadores as $j): ?>
                                    <option value="<?= $j['id'] ?>"><?= $j['nome'] ?> (<?= $j['time_nome'] ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="time_id" class="form-label">Time</label>
                            <select name="time_id" class="form-select" required>
                                <option value="">Selecione</option>
                                <option value="<?= $partida['time_casa'] ?>"><?= $partida['nome_casa'] ?></option>
                                <option value="<?= $partida['time_fora'] ?>"><?= $partida['nome_fora'] ?></option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Registrar Evento</button>
                    </form>

                    <a href="/campeonato_esportivo/routes/finalizar_partida.php?id=<?= $partida['id'] ?>" class="btn btn-danger w-100 mt-3">
                        Finalizar Partida
                    </a>
                </div>
            </div>
        </div>

        <!-- Lista de Eventos -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title mb-3">Eventos Registrados</h5>
                    <div class="border rounded p-3" style="max-height: 360px; overflow-y: auto;">
                        <?php if (empty($eventos)): ?>
                            <p class="text-muted mb-0">Nenhum evento registrado ainda.</p>
                        <?php else: ?>
                            <?php foreach ($eventos as $e): ?>
                                <div class="mb-3">
                                    <strong><?= ucfirst($e['tipo_evento']) ?> (<?= htmlspecialchars($e['minuto']) ?>')</strong><br>
                                    <span><?= nl2br(htmlspecialchars($e['descricao'])) ?></span>
                                    <hr class="my-2">
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
