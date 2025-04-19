<style>
    .menu-scroll {
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .menu-scroll::-webkit-scrollbar {
        display: none;
    }

    .menu-link {
        color: #e0e0e0 !important;
        font-weight: 500;
        font-size: 1rem;
        display: flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        text-decoration: none;
        transition: background 0.3s, color 0.3s;
        user-select: none;
    }

    .menu-link:hover {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.05);
    }

    .menu-separador {
        border-right: 1px solid #444 !important;
    }

    .menu-container {
        background-color: #343a40;
    }
</style>

<!-- Menu do Admin no mesmo padrão do index -->
<div class="container-fluid py-2 border-bottom shadow-sm menu-container">
    <div class="d-flex flex-row flex-nowrap justify-content-center menu-scroll px-2 gap-2">
        <a href="../cadastro/cadastro_campeonato.php" class="menu-link menu-separador flex-shrink-0">
            <i class="bi bi-flag-fill me-2"></i>Campeonato
        </a>
        <a href="../cadastro/cadastro_time.php" class="menu-link menu-separador flex-shrink-0">
            <i class="bi bi-people-fill me-2"></i>Time
        </a>
        <a href="../cadastro/cadastro_jogador.php" class="menu-link menu-separador flex-shrink-0">
            <i class="bi bi-person-fill me-2"></i>Jogador
        </a>
        <a href="../avaliacao/visualizar_avaliacoes.php" class="menu-link menu-separador flex-shrink-0">
            <i class="bi bi-clipboard-check me-2"></i>Avaliações
        </a>
        <a href="../estatistica/vizualizar_estatistica_jogador.php" class="menu-link menu-separador flex-shrink-0">
            <i class="bi bi-bar-chart-fill me-2"></i>Estatísticas
        </a>
        <a href="../substituicao/listar_substituicOES.php" class="menu-link menu-separador flex-shrink-0">
            <i class="bi bi-arrow-left-right me-2"></i>Substituições
        </a>
        <a href="../campeonatos/visualizar_fases_rodadas.php" class="menu-link menu-separador flex-shrink-0">
            <i class="bi bi-diagram-3-fill me-2"></i>Fases/Rodadas
        </a>
        <a href="../campeonatos/tabela_classificacao.php" class="menu-link menu-separador flex-shrink-0">
            <i class="bi bi-trophy-fill me-2"></i>Classificação
        </a>
        <a href="../dashboard/dashboard_administrador.php" class="menu-link flex-shrink-0">
            <i class="bi bi-house-door-fill me-2"></i>Início Admin
        </a>
    </div>
</div>
