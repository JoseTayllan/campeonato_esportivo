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
        transition: 0.3s ease;
        user-select: none;
    }

    .menu-link:hover {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.05);
    }

    .menu-separador {
        border-right: 1px solid #444 !important;
    }
</style>

<!-- Linha de botões para jogador no padrão moderno -->
<div class="container-fluid bg-dark py-2 border-bottom shadow-sm">
    <div class="d-flex flex-row flex-nowrap menu-scroll px-3">
        <a href="../dashboard/dashboard_jogador.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-house-door-fill me-2"></i>Início Jogador
        </a>
        <a href="../campeonatos/visualizar_fases_rodadas.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-diagram-3 me-2"></i>Fases/Rodadas
        </a>
        <a href="../campeonatos/tabela_classificacao.php" class="nav-link px-4 menu-link flex-shrink-0">
            <i class="bi bi-trophy me-2"></i>Classificação
        </a>
    </div>
</div>
