<?php include_once __DIR__ . '/../../includes/admin_header.php'; ?>


<div class="container-fluid mt-5 px-3 px-md-5">
    <h2 class="text-center mb-4 container-campeonato">Painel Administrativo</h2>

    <div class="row mb-4 ">
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-dark text-center h-100">
                <div class="card-body">
                    <h3 class="card-titletext-white"><?= $dados['estatisticas']['Campeonatos'] ?? 0 ?></h3>
                    <p class="card-text"><i class="bi bi-flag-fill"></i> Campeonatos Cadastrados</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 ">
            <div class="card text-white bg-dark text-center h-100">
                <div class="card-body">
                    <h3 class="card-titletext-white"><?= $dados['estatisticas']['Times'] ?? 0 ?></h3>
                    <p class="card-text"><i class="bi bi-people-fill"></i> Times Vinculados</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-dark text-center h-100">
                <div class="card-body">
                    <h3 class="card-titletext-white"><?= $dados['estatisticas']['Jogadores'] ?? 0 ?></h3>
                    <p class="card-text"><i class="bi bi-person-fill"></i> Jogadores Ativos</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4 g-2">
        <div class="col-12 col-md-auto d-grid">
            <a href="/campeonato_esportivo/public/views/cadastro/cadastro_campeonato.php" class="btn btn-dark">
                <i class="bi bi-plus-circle"></i> Cadastrar Campeonato
            </a>
        </div>
        <div class="col-12 col-md-auto d-grid">
            <a href="/campeonato_esportivo/routes/adms/meus_campeonatos.php" class="btn btn-outline-primary">
                <i class="bi bi-trophy-fill"></i> Meus Campeonatos
            </a>
        </div>
        <div class="col-12 col-md-auto d-grid">
            <a href="/campeonato_esportivo/routes/adms/cadastro_organizador.php" class="btn btn-outline-primary">
                <i class="bi bi-plus"></i> Cadastrar Novo Organizador
            </a>
        </div>
        <div class="col-12 col-md-auto d-grid">
            <a href="/campeonato_esportivo/routes/adms/aovivo/gerenciar_partidas.php" class="btn btn-outline-primary">
                <i class="bi bi-gear-fill"></i> Gerenciar Partidas
            </a>
        </div>
    </div>

    <h3 class="mb-3 container-campeonato">Lista de Campeonatos</h3>
    <div class="row gy-4">
    <?php foreach ($dados['campeonatos'] ?? [] as $camp): ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($camp['nome']) ?></h5>
                    <p class="card-text mb-1">
                        <strong>Temporada:</strong> <?= htmlspecialchars($camp['temporada']) ?>
                    </p>
                    <p class="card-text mb-1">
                        <strong>Formato:</strong> <?= htmlspecialchars($camp['formato']) ?>
                    </p>
                    <p class="card-text mb-3">
                        <strong>Criado em:</strong> <?= date('d/m/Y', strtotime($camp['criado_em'])) ?>
                    </p>
                    <span class="badge bg-secondary">Em Desenvolvimento</span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php include __DIR__ . '../../cabecalho/footer.php'; ?>
