

<?php include_once __DIR__ . '/../../includes/jogador.php'; ?>


<body class="d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <div class="container py-5">
            <div class="card shadow p-4">
                <h2 class="mb-4 text-center">Meu Perfil</h2>

                <ul class="nav nav-tabs mb-4" id="perfilTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="perfil-tab" data-bs-toggle="tab" data-bs-target="#perfil" type="button" role="tab">Perfil</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="estatisticas-tab" data-bs-toggle="tab" data-bs-target="#estatisticas" type="button" role="tab">Estatísticas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="partidas-tab" data-bs-toggle="tab" data-bs-target="#partidas" type="button" role="tab">Últimas Partidas</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="conquistas-tab" data-bs-toggle="tab" data-bs-target="#conquistas" type="button" role="tab">Conquistas</button>
                    </li>

                </ul>

                <div class="tab-content" id="perfilTabsContent">
                    <!-- Perfil -->
                    <div class="tab-pane fade show active" id="perfil" role="tabpanel">
                        <form action="/campeonato_esportivo/routes/jogador/salvar_perfil.php" method="POST" enctype="multipart/form-data">
                            <div class="text-center mb-4">
                                <img src="/campeonato_esportivo/public/img/jogadores/<?= $jogador['imagem'] ?? 'perfil_padrao.png' ?>"
                                    class="rounded-circle shadow"
                                    style="width: 120px; height: 120px; object-fit: cover;">
                                <div class="mt-2">
                                    <input type="file" name="imagem" class="form-control w-auto d-inline">
                                </div>
                            </div>

                            <input type="hidden" name="jogador_id" value="<?= $jogador['id'] ?>">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nome</label>
                                    <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($jogador['nome']) ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">CPF</label>
                                    <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($jogador['cpf']) ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Data de Nascimento</label>
                                    <input type="date" name="data_nascimento" class="form-control" value="<?= $jogador['data_nascimento'] ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nacionalidade</label>
                                    <input type="text" name="nacionalidade" class="form-control" value="<?= $jogador['nacionalidade'] ?>">
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                                <a href="/campeonato_esportivo/" class="btn btn-secondary">Voltar</a>
                            </div>
                        </form>
                    </div>

                    <!-- Estatísticas -->
                    <div class="tab-pane fade" id="estatisticas" role="tabpanel">
                        <div class="row text-center mt-4">
                            <div class="col-md-3">
                                <i class="bi bi-bar-chart-line fs-2 text-primary"></i>
                                <h5 class="mt-2"><?= $estatisticas['jogos'] ?? 0 ?></h5>
                                <small>Jogos</small>
                            </div>
                            <div class="col-md-3">
                                <i class="bi bi-soccer fs-2 text-success"></i>
                                <h5 class="mt-2"><?= $estatisticas['gols'] ?? 0 ?></h5>
                                <small>Gols</small>
                            </div>
                            <div class="col-md-3">
                                <i class="bi bi-shield-check fs-2 text-warning"></i>
                                <h5 class="mt-2"><?= $estatisticas['assistencias'] ?? 0 ?></h5>
                                <small>Assistências</small>
                            </div>
                            <div class="col-md-3">
                                <i class="bi bi-clock-history fs-2 text-danger"></i>
                                <h5 class="mt-2"><?= $estatisticas['minutos'] ?? 0 ?></h5>
                                <small>Minutos Jogados</small>
                            </div>
                        </div>
                    </div>

                    <!-- Últimas Partidas -->
                    <div class="tab-pane fade" id="partidas" role="tabpanel">
                        <div class="d-flex justify-content-end mb-3">
                            <input type="text" id="filtroPartidas" class="form-control w-50" placeholder="Filtrar por adversário...">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" id="tabelaPartidas">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Adversário</th>
                                        <th>Gols</th>
                                        <th>Assistências</th>
                                        <th>Minutos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ultimas_partidas as $p): ?>
                                        <tr>
                                            <td><?= date('d/m/Y', strtotime($p['data'])) ?></td>
                                            <td><?= htmlspecialchars($p['adversario']) ?></td>
                                            <td><?= $p['gols'] ?></td>
                                            <td><?= $p['assistencias'] ?></td>
                                            <td><?= $p['minutos_jogados'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="conquistas" role="tabpanel">
                        <div class="mt-4">

                            <h5 class="mb-2"><i class="bi bi-trophy text-warning"></i> Campeonatos Vencidos</h5>
                            <?php if (!empty($conquistas['campeao'])): ?>
                                <ul>
                                    <?php foreach ($conquistas['campeao'] as $c): ?>
                                        <li><strong><?= $c['campeonato'] ?></strong> — pelo time <?= $c['time'] ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted">Nenhum título de campeão registrado.</p>
                            <?php endif; ?>

                            <h5 class="mt-4 mb-2"><i class="bi bi-star text-success"></i> Artilharia</h5>
                            <?php if (!empty($conquistas['artilheiro'])): ?>
                                <ul>
                                    <?php foreach ($conquistas['artilheiro'] as $a): ?>
                                        <li><?= $a['gols'] ?> gols no campeonato <strong><?= $a['campeonato'] ?></strong> pelo <?= $a['time'] ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted">Nenhuma artilharia registrada.</p>
                            <?php endif; ?>

                            <h5 class="mt-4 mb-2"><i class="bi bi-shield-lock text-primary"></i> Goleiro Menos Vazado</h5>
                            
                            <?php if (!empty($conquistas['goleiro'])): ?>
                                <ul>
                                    <?php foreach ($conquistas['goleiro'] as $g): ?>
                                        <li><?= $g['gols_sofridos'] ?> gols sofridos no campeonato <strong><?= $g['campeonato'] ?></strong> pelo <?= $g['time'] ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted">Nenhum prêmio de goleiro registrado.</p>
                            <?php endif; ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <small> <? ?> </small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const filtro = document.getElementById('filtroPartidas');
        const tabela = document.getElementById('tabelaPartidas').getElementsByTagName('tbody')[0];

        filtro.addEventListener('keyup', function() {
            const termo = filtro.value.toLowerCase();
            Array.from(tabela.rows).forEach(row => {
                const adversario = row.cells[1].textContent.toLowerCase();
                row.style.display = adversario.includes(termo) ? '' : 'none';
            });
        });
    </script>

    <?php require_once __DIR__ . '/../cabecalho/footer.php'; ?>