<?require_once __DIR__ . '/../../cabecalho/header.php';?>


<div class="container mt-4">
    <h2>Partida Ao Vivo</h2>
    <h4><?= $partida['nome_casa'] ?> x <?= $partida['nome_fora'] ?></h4>
    <p>
        <strong>Local:</strong> <?= $partida['local'] ?> |
        <strong>Data:</strong> <?= date('d/m/Y', strtotime($partida['data'])) ?> |
        <strong>Horário:</strong> <?= $partida['horario'] ?>
    </p>

    <div class="row mt-4">
        <div class="col-md-6">
            <h5>Registrar Evento</h5>
            <form method="post" action="/campeonato_esportivo/routes/registrar_evento.php">

                <input type="hidden" name="partida_id" value="<?= $partida['id'] ?>">

                <div class="mb-2">
                    <label for="tipo_evento">Tipo de Evento</label>
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

                <div class="mb-2">
                    <label for="minuto">Minuto</label>
                    <input type="text" name="minuto" class="form-control" required placeholder="Ex: 42, 45+2">
                </div>

                <div class="mb-2">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="2" placeholder="Ex: Gol de cabeça de João após escanteio"></textarea>
                </div>
                <div class="mb-2">
        <label for="jogador_id">Jogador</label>
        <select name="jogador_id" class="form-select" required>
            <option value="">Selecione</option>
            <?php foreach ($jogadores as $j): ?>
                <option value="<?= $j['id'] ?>">
                    <?= $j['nome'] ?> (<?= $j['time_nome'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-2">
        <label for="time_id">Time</label>
        <select name="time_id" class="form-select" required>
            <option value="">Selecione</option>
            <option value="<?= $partida['time_casa'] ?>"><?= $partida['nome_casa'] ?></option>
            <option value="<?= $partida['time_fora'] ?>"><?= $partida['nome_fora'] ?></option>
        </select>
    </div>


                <button type="submit" class="btn btn-success">Registrar Evento</button>
            </form>
        </div>
        <a href="/campeonato_esportivo/routes/finalizar_partida.php?id=<?= $partida['id'] ?>" class="btn btn-danger mt-3">
    Finalizar Partida
</a>


        <div class="col-md-6">
            <h5>Eventos Registrados</h5>
            <div class="border p-2" style="max-height: 300px; overflow-y: auto;">
                <?php if (empty($eventos)): ?>
                    <p class="text-muted">Nenhum evento registrado ainda.</p>
                <?php else: ?>
                    <?php foreach ($eventos as $e): ?>
                        <p>
                            <strong><?= ucfirst($e['tipo_evento']) ?> (<?= htmlspecialchars($e['minuto']) ?>')</strong><br>
                            <?= nl2br(htmlspecialchars($e['descricao'])) ?>
                        </p>
                        <hr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?require_once __DIR__ . '/../cabecalho/footer.php'; ?>
