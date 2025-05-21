<?php
date_default_timezone_set('America/Sao_Paulo');
include __DIR__ . '../../../includes/index_sec.php';

// Extrair variáveis do $viewData
$titulo = $viewData['titulo'] ?? "Partidas em Andamento";
$modalidade = $viewData['modalidade'] ?? null;
$partidas = $viewData['partidas'] ?? [];
?>

<body>
<main>
    <div class="container mt-4">
        <h2><?= $titulo ?></h2>
        
        <?php if ($modalidade): ?>
        <div class="mb-3">
            <a href="/campeonato_esportivo/public/index.php?modalidade=<?= $modalidade ?>" class="btn btn-outline-primary btn-sm">
                ← Voltar para campeonatos de <?= ucfirst($modalidade) ?>
            </a>
            <a href="/campeonato_esportivo/public/index.php" class="btn btn-outline-secondary btn-sm">
                ← Todos os Esportes
            </a>
        </div>
        <?php endif; ?>
        
        <div id="placar-container" class="row"></div>
    </div>

    <script>
        const estadoAberto = {
            minuto: new Set(),
            escalacoes: new Set()
        };

        function carregarPlacarAoVivo() {
            // Buscar dados com o parâmetro de modalidade, se existir
            const url = '/campeonato_esportivo/routes/ajax/placar_atualizado.php<?= $modalidade ? "?modalidade=$modalidade" : "" ?>';
            
            fetch(url)
                .then(res => res.json())
                .then(dados => {
                    const container = document.getElementById('placar-container');
                    container.innerHTML = '';

                    if (dados.length === 0) {
                        container.innerHTML = '<div class="alert alert-info">Nenhuma partida em andamento no momento<?= $modalidade ? " para " . $modalidade : "" ?>.</div>';
                        return;
                    }

                    dados.forEach(p => {
                        const tempoJogo = (() => {
                            const acrescimos = parseInt(p.acrescimos) || 0;
                            let total = parseInt(p.tempo_acumulado) || 0;
                            if (p.cronometro_status === 'rodando' && p.inicio_partida) {
                                const inicioMs = new Date(p.inicio_partida).getTime();
                                const agoraMs = Date.now();
                                total += Math.floor((agoraMs - inicioMs) / 60000);
                            }
                            return `${String(total).padStart(2, '0')}:00`;
                        })();

                        const eventosHtml = p.eventos.length > 0 ? `
<ul class='list-group list-group-flush'>
    ${p.eventos.map(e => `
        <li class='list-group-item small'>
            <strong>${e.tipo_evento.charAt(0).toUpperCase() + e.tipo_evento.slice(1)} (${e.minuto}'):</strong><br>
            ${e.nome_jogador ? `<strong>${e.nome_jogador}</strong><br>` : ''}
            ${e.descricao}
        </li>
    `).join('')}
</ul>` : '<p class="text-muted small">Nenhum evento registrado ainda.</p>';

                        const statusBadge = p.cronometro_status === 'pausado'
                            ? '<span class="badge bg-warning text-dark">⏸️ Pausado</span>'
                            : '<span class="badge bg-success">▶️ Em andamento</span>';

                        const acrescimoBadge = p.acrescimos > 0
                            ? `<span class="badge bg-info text-dark ms-2">+${p.acrescimos}</span>` : '';

                        const tempoVisualBadge = p.tempo_atual
                            ? `<span class="badge bg-dark text-light ms-2">${p.tempo_atual}</span>` : '';

                        const transmissaoBtn = p.link_transmissao
                            ? `<div class="text-center mt-3">
                                   <a href="assistir.php?id=${p.id}" target="_blank" class="btn btn-danger btn-sm">
                                       🎥 Assistir Transmissão
                                   </a>
                               </div>`
                            : '';
                            
                        const modalidadeBadge = p.modalidade 
                            ? `<span class="badge bg-primary ms-2">${p.modalidade}</span>` 
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
                    ${p.data} ${p.horario} | ${p.local} ${modalidadeBadge}<br>
                    ${statusBadge} ⏱ ${tempoJogo} ${acrescimoBadge} ${tempoVisualBadge}
                </small>
            </div>

            <hr class="my-3">
            <div class="d-flex justify-content-center gap-2 mt-3">
                <button class="btn btn-outline-primary btn-sm" onclick="mostrarMinutoMinuto(${p.id})">Minuto a Minuto</button>
                <button class="btn btn-outline-success btn-sm" onclick="mostrarEscalacoes(${p.id}, ${p.time_casa}, ${p.time_fora})">Escalações</button>
            </div>

            <div id="minuto-${p.id}" class="mt-2" style="display: ${estadoAberto.minuto.has(String(p.id)) ? 'block' : 'none'};">
                <h6>Minuto a Minuto:</h6>
                ${eventosHtml}
            </div>

            <div id="escalacoes-${p.id}" class="mt-2 text-start" style="display: ${estadoAberto.escalacoes.has(String(p.id)) ? 'block' : 'none'};"></div>

            ${transmissaoBtn}
        </div>
    </div>
</div>`;
                        if (estadoAberto.escalacoes.has(String(p.id))) {
                            mostrarEscalacoes(p.id, p.time_casa, p.time_fora, true);
                        }
                    });
                });
        }

        function mostrarMinutoMinuto(partida_id) {
            const boxMinuto = document.getElementById(`minuto-${partida_id}`);
            const boxEscalacao = document.getElementById(`escalacoes-${partida_id}`);
            if (!boxMinuto) return;

            // Fecha outra
            if (boxEscalacao && boxEscalacao.style.display === 'block') {
                boxEscalacao.style.display = 'none';
                estadoAberto.escalacoes.delete(String(partida_id));
            }

            if (boxMinuto.style.display === 'block') {
                boxMinuto.style.display = 'none';
                estadoAberto.minuto.delete(String(partida_id));
            } else {
                boxMinuto.style.display = 'block';
                estadoAberto.minuto.add(String(partida_id));
            }
        }

        function mostrarEscalacoes(partida_id, timeCasa, timeFora, manterAberto = false) {
            const box = document.getElementById(`escalacoes-${partida_id}`);
            const boxMinuto = document.getElementById(`minuto-${partida_id}`);
            if (!box) return;

            // Fecha outra
            if (boxMinuto && boxMinuto.style.display === 'block') {
                boxMinuto.style.display = 'none';
                estadoAberto.minuto.delete(String(partida_id));
            }

            // Alternar visibilidade
            if (!manterAberto && box.style.display === 'block') {
                box.style.display = 'none';
                box.innerHTML = '';
                estadoAberto.escalacoes.delete(String(partida_id));
                return;
            }

            estadoAberto.escalacoes.add(String(partida_id));

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
</main>
<?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>
</body>
