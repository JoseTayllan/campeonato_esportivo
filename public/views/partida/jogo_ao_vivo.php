<?php 
// Proteger contra acesso direto
if (!isset($_SERVER['HTTP_REFERER']) || empty($_SERVER['HTTP_REFERER'])) {
    echo "<div style='text-align:center; padding:20px; font-family:sans-serif;'>
            <h2 style='color:red;'>Erro: Acesso direto não permitido!</h2>
            <p>Utilize o sistema normalmente para acessar esta página.</p>
          </div>";
    exit();
} 
?>
<div class="container mt-4">
    <h2>Partida Ao Vivo</h2>
    <h4><?= $partida['nome_casa'] ?> x <?= $partida['nome_fora'] ?></h4>
    <p>
        <strong>Local:</strong> <?= $partida['local'] ?> |
        <strong>Data:</strong> <?= date('d/m/Y', strtotime($partida['data'])) ?> |
        <strong>Horário:</strong> <?= $partida['horario'] ?>
    </p>

    <div class="alert alert-<?= $partida['cronometro_status'] === 'rodando' ? 'success' : 'warning' ?>">
        ⏱ Cronômetro está <strong><?= $partida['cronometro_status'] === 'rodando' ? 'EM ANDAMENTO' : 'PAUSADO' ?></strong>
        <?php if ($partida['acrescimos'] > 0): ?> | <strong>Acréscimo:</strong> +<?= $partida['acrescimos'] ?> min<?php endif; ?>
        <?php if (!empty($partida['tempo_atual'])): ?> | <strong>Fase:</strong> <?= $partida['tempo_atual'] ?><?php endif; ?>
    </div>

    <p>
        ⏱ <span id="cronometro">00:00</span>
        <span id="acrescimo" class="badge bg-warning text-dark ms-2"></span>
    </p>

    <div class="row mt-4">
        <div class="col-md-6">
            <h5>Registrar Evento</h5>
            <form method="post" action="/campeonato_esportivo/routes/registrar_evento.php" onsubmit="inserirMinuto();">
                <input type="hidden" name="partida_id" value="<?= $partida['id'] ?>">
                <input type="hidden" name="minuto" id="campoMinuto">

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
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="2"></textarea>
                </div>

                <div class="mb-2">
                    <label for="jogador_id">Jogador</label>
                    <select name="jogador_id" class="form-select" required>
                        <option value="">Selecione</option>
                        <?php foreach ($jogadores as $j): ?>
                            <option value="<?= $j['id'] ?>"> <?= $j['nome'] ?> (<?= $j['time_nome'] ?>) </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-2">
                    <label for="time_id">Time</label>
                    <select name="time_id" class="form-select" required>
                        <option value="">Selecione</option>
                        <option value="<?= $partida['time_casa'] ?>"> <?= $partida['nome_casa'] ?> </option>
                        <option value="<?= $partida['time_fora'] ?>"> <?= $partida['nome_fora'] ?> </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Registrar Evento</button>
            </form>

            <div class="mt-3">
                <button onclick="pausarCronometro()" class="btn btn-outline-warning btn-sm">⏸️ Pausar</button>
                <button onclick="retomarCronometro()" class="btn btn-outline-success btn-sm">▶️ Retomar</button>
                <button onclick="destacarAcrescimo()" class="btn btn-outline-info btn-sm">⚠️ Mostrar Acréscimo</button>
            </div>

            <form method="post" action="/campeonato_esportivo/routes/atualizar_tempo_visual.php" class="mt-3">
                <input type="hidden" name="partida_id" value="<?= $partida['id'] ?>">
                <div class="btn-group">
                    <button type="submit" name="tempo_atual" value="1º Tempo" class="btn btn-outline-primary btn-sm">1º Tempo</button>
                    <button type="submit" name="tempo_atual" value="Intervalo" class="btn btn-outline-secondary btn-sm">Intervalo</button>
                    <button type="submit" name="tempo_atual" value="2º Tempo" class="btn btn-outline-success btn-sm">2º Tempo</button>
                </div>
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

<script>
let status = '<?= $partida['cronometro_status'] ?>';
let acumulado = <?= (int)$partida['tempo_acumulado'] ?>;
let acrescimos = <?= (int)$partida['acrescimos'] ?>;
let inicioPartida = "<?= $partida['inicio_partida'] ?>";

function atualizarCronometro() {
    let minutos = acumulado;
    if (status === 'rodando' && inicioPartida) {
        const inicio = new Date(inicioPartida);
        const agora = new Date();
        if (!isNaN(inicio)) {
            minutos += Math.floor((agora.getTime() - inicio.getTime()) / 60000);
        }
    }
    document.getElementById("cronometro").innerText = minutos.toString().padStart(2, '0') + ':00';
    document.getElementById("acrescimo").innerText = acrescimos > 0 ? "+" + acrescimos : "";
    setTimeout(atualizarCronometro, 1000);
}

function inserirMinuto() {
    const texto = document.getElementById("cronometro").innerText;
    document.getElementById("campoMinuto").value = texto.split(':')[0];
}

function pausarCronometro() {
    fetch('/campeonato_esportivo/routes/cronometro.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'partida_id=<?= $partida['id'] ?>&status=pausado'
    }).then(() => location.reload());
}

function retomarCronometro() {
    fetch('/campeonato_esportivo/routes/cronometro.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'partida_id=<?= $partida['id'] ?>&status=rodando'
    }).then(() => location.reload());
}

function destacarAcrescimo() {
    const novo = prompt("Quantos minutos de acréscimo?");
    if (novo && !isNaN(novo)) {
        fetch('/campeonato_esportivo/routes/cronometro.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'partida_id=<?= $partida['id'] ?>&acrescimos=' + parseInt(novo)
        }).then(() => location.reload());
    }
}

atualizarCronometro();
</script>
