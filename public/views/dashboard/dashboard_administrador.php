<?php include_once __DIR__ . '/../../includes/admin_header.php'; ?>

<div class="container-fluid mt-5 px-3 px-md-5">
    <h2 class="text-center mb-4">Painel Administrativo</h2>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-dark text-center h-100">
                <div class="card-body">
                    <h3 class="card-title"><?= $dados['estatisticas']['Campeonatos'] ?? 0 ?></h3>
                    <p class="card-text"><i class="bi bi-flag-fill"></i> Campeonatos Cadastrados</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-dark text-center h-100">
                <div class="card-body">
                    <h3 class="card-title"><?= $dados['estatisticas']['Times'] ?? 0 ?></h3>
                    <p class="card-text"><i class="bi bi-people-fill"></i> Times Vinculados</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-dark text-center h-100">
                <div class="card-body">
                    <h3 class="card-title"><?= $dados['estatisticas']['Jogadores'] ?? 0 ?></h3>
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

    <h3 class="mb-3">Lista de Campeonatos</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Temporada</th>
                    <th>Formato</th>
                    <th>Criado em</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dados['campeonatos'] ?? [] as $campeonato): ?>
                    <tr>
                        <td><?= $campeonato['id'] ?></td>
                        <td><?= $campeonato['nome'] ?></td>
                        <td><?= $campeonato['temporada'] ?></td>
                        <td><?= $campeonato['formato'] ?></td>
                        <td><?= date('d/m/Y', strtotime($campeonato['criado_em'])) ?></td>
                        <td><span class="badge bg-secondary">Em Desenvolvimento</span></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '../../cabecalho/footer.php'; ?>
