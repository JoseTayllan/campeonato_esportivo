
<?php require_once __DIR__ . '../../../includes/admin_sec.php'; ?>
<div class="container-fluid p-4">
    <h2 class="mb-3">⚽ Partida Ao Vivo: <?= $partida['nome_casa'] ?> x <?= $partida['nome_fora'] ?></h2>
    <?php if ($partida['cronometro_status'] === 'rodando'): ?>
    <div class="alert alert-success">
        🟢 Cronômetro em andamento
    </div>
<?php else: ?>
    <div class="alert alert-warning">
        ⏸️ Jogo pausado - cronômetro parado
    </div>
<?php endif; ?>


    <div class="row">
        <!-- Painel de controle -->
        <div class="col-md-5">
            <div class="card shadow mb-3">
                <div class="card-body">
                    <h5 class="card-title">⏱ Cronômetro</h5>
                    <p><span id="cronometro" class="fs-4">00:00</span>
                       <span id="acrescimo" class="badge bg-warning ms-2"></span></p>
                    <div class="d-flex gap-2">
                        <button onclick="pausarCronometro()" class="btn btn-outline-warning btn-sm">⏸️ Pausar</button>
                        <button onclick="retomarCronometro()" class="btn btn-outline-success btn-sm">▶️ Retomar</button>
                        <button onclick="destacarAcrescimo()" class="btn btn-outline-info btn-sm">⚠️ Acréscimo</button>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-3">
                <div class="card-body">
                    <h5 class="card-title">Registrar Evento</h5>
                    <form method="post" action="/routes/adms/aovivo/registrar_evento.php" onsubmit="inserirMinuto(); separarJogadorTime();">
                        <input type="hidden" name="partida_id" value="<?= $partida['id'] ?>">
                        <input type="hidden" name="minuto" id="campoMinuto">
                        <input type="hidden" name="jogador_id" id="jogador_id_hidden">
                        <input type="hidden" name="time_id" id="time_id_hidden">

                        <div class="mb-2">
                            <label>Tipo</label>
                            <select name="tipo_evento" class="form-select" required>
                                <optgroup label="Comuns">
                                    <option value="gol">Gol</option>
                                    <option value="cartao_amarelo">Cartão Amarelo</option>
                                    <option value="cartao_vermelho">Cartão Vermelho</option>
                                    <option value="substituicao">Substituição</option>
                                </optgroup>
                                <optgroup label="Goleiro">
                                    <option value="defesa">Defesa</option>
                                    <option value="penalti_defendido">Pênalti Defendido</option>
                                </optgroup>
                                <option value="outro">Outro</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label>Jogador + Time</label>
                            <select name="jogador_time" id="jogador_time" class="form-select" required>
                                <option value="">Selecione</option>
                                <optgroup label="Time Casa">
                                <?php foreach ($jogadores as $j): if ($j['time_id'] == $partida['time_casa']): ?>
                                    <option value="<?= $j['id'] ?>|<?= $j['time_id'] ?>"> <?= $j['nome'] ?> (<?= $j['posicao'] ?>) - <?= $j['time_nome'] ?> </option>
                                <?php endif; endforeach; ?>
                                </optgroup>
                                <optgroup label="Time Visitante">
                                <?php foreach ($jogadores as $j): if ($j['time_id'] == $partida['time_fora']): ?>
                                    <option value="<?= $j['id'] ?>|<?= $j['time_id'] ?>"> <?= $j['nome'] ?> (<?= $j['posicao'] ?>) - <?= $j['time_nome'] ?> </option>
                                <?php endif; endforeach; ?>
                                </optgroup>
                            </select>
                        </div>

                        <div class="mb-2">
                            <label>Descrição</label>
                            <textarea name="descricao" class="form-control" rows="2" placeholder="Ex: Gol de cabeça, falta etc."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Registrar</button>
                    </form>
                </div>
            </div>

            
<form method="post" action="/routes/adms/aovivo/atualizar_tempo_visual.php" class="mt-2">
    <input type="hidden" name="partida_id" value="<?= $partida['id'] ?>">
    <div class="btn-group w-100">
        <button type="submit" name="tempo_atual" value="1º Tempo" class="btn btn-outline-primary btn-sm">1º Tempo</button>
        <button type="submit" name="tempo_atual" value="Intervalo" class="btn btn-outline-secondary btn-sm">Intervalo</button>
        <button type="submit" name="tempo_atual" value="2º Tempo" class="btn btn-outline-success btn-sm">2º Tempo</button>
    </div>
</form>
<a href="/routes/adms/aovivo/finalizar_partida.php?id=<?= $partida['id'] ?>" class="btn btn-danger w-100 mt-2">
                Finalizar Partida
            </a>
        </div>

        <!-- Eventos registrados -->
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">📝 Eventos Registrados</h5>
                    <div style="max-height: 500px; overflow-y: auto;">
                        <?php if (empty($eventos)): ?>
                            <p class="text-muted">Nenhum evento ainda.</p>
                        <?php else: ?>
                            <?php foreach ($eventos as $e): ?>
                                <div class="border-start border-3 ps-2 mb-2" style="border-color: #ccc;">
                                    <strong><?= ucfirst($e['tipo_evento']) ?> (<?= $e['minuto'] ?>')</strong><br>
                                    <small><?= nl2br(htmlspecialchars($e['descricao'])) ?></small>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function inserirMinuto() {
    const texto = document.getElementById("cronometro").innerText;
    document.getElementById("campoMinuto").value = texto.split(':')[0];
}

function separarJogadorTime() {
    const valor = document.getElementById("jogador_time").value;
    if (valor && valor.includes("|")) {
        const partes = valor.split("|");
        document.getElementById("jogador_id_hidden").value = partes[0];
        document.getElementById("time_id_hidden").value = partes[1];
    }
}

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

function pausarCronometro() {
    fetch('/routes/adms/aovivo/cronometro.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'partida_id=<?= $partida['id'] ?>&status=pausado'
    }).then(() => location.reload());
}

function retomarCronometro() {
    fetch('/routes/adms/aovivo/cronometro.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'partida_id=<?= $partida['id'] ?>&status=rodando'
    }).then(() => location.reload());
}

function destacarAcrescimo() {
    const novo = prompt("Quantos minutos de acréscimo?");
    if (novo && !isNaN(novo)) {
        fetch('/routes/adms/aovivo/cronometro.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'partida_id=<?= $partida['id'] ?>&acrescimos=' + parseInt(novo)
        }).then(() => location.reload());
    }
}

atualizarCronometro();
</script>
