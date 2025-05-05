<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once __DIR__ . '/../cabecalho/header.php'; 
?>

<div class="container mt-4">
    <h2>Partidas em Andamento</h2>
    <div id="placar-container" class="row"></div>
</div>

<script>
function carregarPlacarAoVivo() {
    fetch('/campeonato_esportivo/routes/ajax/placar_atualizado.php')
        .then(res => res.json())
        .then(dados => {
            const container = document.getElementById('placar-container');
            container.innerHTML = '';

            if (dados.length === 0) {
                container.innerHTML = '<div class="alert alert-info">Nenhuma partida em andamento no momento.</div>';
                return;
            }

            dados.forEach(p => {
                const eventosHtml = p.eventos.length > 0 ? `
                    <ul class='list-group list-group-flush'>
                        ${p.eventos.map(e => `
                            <li class='list-group-item small'>
                                <strong>${e.tipo_evento.charAt(0).toUpperCase() + e.tipo_evento.slice(1)} (${e.minuto}'):</strong><br>
                                ${e.descricao}
                            </li>
                        `).join('')}
                    </ul>` : '<p class="text-muted small">Nenhum evento registrado ainda.</p>';

                let tempoJogo = '--:--';
                const acrescimos = parseInt(p.acrescimos) || 0;
                let total = parseInt(p.tempo_acumulado) || 0;

                if (p.cronometro_status === 'rodando' && p.inicio_partida) {
                    const inicioMs = new Date(p.inicio_partida).getTime();
                    const agoraMs = Date.now();
                    const decorridos = Math.floor((agoraMs - inicioMs) / 60000);
                    total += decorridos;
                }

                tempoJogo = `${String(total).padStart(2, '0')}:00`;

                const statusBadge = p.cronometro_status === 'pausado'
                    ? '<span class="badge bg-warning text-dark">⏸️ Pausado</span>'
                    : '<span class="badge bg-success">▶️ Em andamento</span>';

                const acrescimoBadge = acrescimos > 0
                    ? `<span class="badge bg-info text-dark ms-2">+${acrescimos}</span>`
                    : '';

                const tempoVisualBadge = p.tempo_atual && p.tempo_atual.trim() !== ''
                    ? `<span class="badge bg-dark text-light ms-2">${p.tempo_atual}</span>`
                    : '';

                container.innerHTML += `
                    <div class="col-md-6 mb-3">
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="text-center">
                                    <h5>
                                        <img src="/campeonato_esportivo/public/img/times/${p.escudo_casa}" width="30">
                                        ${p.nome_casa}
                                        <strong>${p.placar_casa} x ${p.placar_fora}</strong>
                                        ${p.nome_fora}
                                        <img src="/campeonato_esportivo/public/img/times/${p.escudo_fora}" width="30">
                                    </h5>
                                    <small>
                                        ${p.data} ${p.horario} | ${p.local} <br>
                                        ${statusBadge} ⏱ ${tempoJogo} ${acrescimoBadge} ${tempoVisualBadge}
                                    </small>
                                </div>

                                <hr class="my-3">
                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <button class="btn btn-outline-primary btn-sm" onclick="mostrarMinutoMinuto(${p.id})">Minuto a Minuto</button>
                                    <button class="btn btn-outline-success btn-sm" onclick="mostrarEscalacoes(${p.id}, ${p.time_casa}, ${p.time_fora})">Escalações</button>
                                </div>

                                <div id="minuto-${p.id}" class="mt-2" style="display:none;">
                                    <h6>Minuto a Minuto:</h6>
                                    ${eventosHtml}
                                </div>

                                <div id="escalacoes-${p.id}" class="mt-2 text-start" style="display:none;"></div>
                            </div>
                        </div>
                    </div>
                `;
            });
        });
}

function mostrarMinutoMinuto(partida_id) {
    const boxMinuto = document.getElementById(`minuto-${partida_id}`);
    const boxEscalacao = document.getElementById(`escalacoes-${partida_id}`);
    if (!boxMinuto) return;
    if (boxEscalacao && boxEscalacao.style.display === 'block') {
        boxEscalacao.style.display = 'none';
    }
    boxMinuto.style.display = boxMinuto.style.display === 'block' ? 'none' : 'block';
}

function mostrarEscalacoes(partida_id, timeCasa, timeFora) {
    const box = document.getElementById(`escalacoes-${partida_id}`);
    const boxMinuto = document.getElementById(`minuto-${partida_id}`);
    if (!box) return;
    if (boxMinuto && boxMinuto.style.display === 'block') {
        boxMinuto.style.display = 'none';
    }
    if (box.style.display === 'block') {
        box.style.display = 'none';
        box.innerHTML = '';
        return;
    }

    Promise.all([
        fetch(`/campeonato_esportivo/routes/ajax/escalacao_publica.php?partida_id=${partida_id}&time_id=${timeCasa}`).then(res => res.json()),
        fetch(`/campeonato_esportivo/routes/ajax/escalacao_publica.php?partida_id=${partida_id}&time_id=${timeFora}`).then(res => res.json())
    ])
    .then(([casa, fora]) => {
        let html = "";

        html += `
            <div class="mb-2 d-flex align-items-center">
                ${casa.escudo ? `<img src="/campeonato_esportivo/public/img/times/${casa.escudo}" width="30" class="me-2">` : ''}
                <strong>${casa.time_nome}</strong>
            </div>`;
        html += montarTabelaEscalacao(casa);

        html += `
            <div class="mb-2 d-flex align-items-center">
                ${fora.escudo ? `<img src="/campeonato_esportivo/public/img/times/${fora.escudo}" width="30" class="me-2">` : ''}
                <strong>${fora.time_nome}</strong>
            </div>`;
        html += montarTabelaEscalacao(fora);

        box.innerHTML = html;
        box.style.display = 'block';
    })
    .catch(() => {
        box.innerHTML = "<p class='text-danger'>Erro ao carregar escalação.</p>";
        box.style.display = 'block';
    });
}


function montarTabelaEscalacao(time) {
    let html = "";
    html += "<strong>Titulares:</strong>";
    html += "<table class='table table-bordered table-sm'><thead><tr><th>Imagem</th><th>Nome</th><th>Posição</th></tr></thead><tbody>";
    time.titulares.forEach(j => {
        html += `<tr>
            <td><img src='/campeonato_esportivo/public/img/jogadores/${j.imagem}' onerror="this.src='/campeonato_esportivo/public/img/perfil_padrao/perfil_padrao.png'" style='width:30px;height:30px;border-radius:50%;'></td>
            <td>${j.nome}</td>
            <td>${j.posicao}</td>
        </tr>`;
    });
    html += "</tbody></table><strong>Reservas:</strong>";
    html += "<table class='table table-bordered table-sm'><thead><tr><th>Imagem</th><th>Nome</th><th>Posição</th></tr></thead><tbody>";
    time.reservas.forEach(j => {
        html += `<tr>
            <td><img src='/campeonato_esportivo/public/img/jogadores/${j.imagem}' onerror="this.src='/campeonato_esportivo/public/img/perfil_padrao/perfil_padrao.png'" style='width:30px;height:30px;border-radius:50%;'></td>
            <td>${j.nome}</td>
            <td>${j.posicao}</td>
        </tr>`;
    });
    html += "</tbody></table><hr>";
    return html;
}

carregarPlacarAoVivo();
setInterval(carregarPlacarAoVivo, 10000);
</script>

<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
