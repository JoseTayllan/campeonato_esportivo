<?php 
date_default_timezone_set('America/Sao_Paulo');
require_once __DIR__ . '/../cabecalho/header.php'; ?>

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
                                <hr>
                                <h6>Eventos ao Vivo:</h6>
                                ${eventosHtml}
                            </div>
                        </div>
                    </div>
                `;
            });
        });
}

carregarPlacarAoVivo();
setInterval(carregarPlacarAoVivo, 10000);
</script>

<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
