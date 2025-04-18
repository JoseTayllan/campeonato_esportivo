<!-- ESTILO já aplicado anteriormente -->
<style>
    .menu-scroll {
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        -ms-overflow-style: none;
        cursor: grab;
    }

    .menu-scroll::-webkit-scrollbar {
        display: none;
    }

    .menu-scroll:active {
        cursor: grabbing;
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

<!-- MENU DO TREINADOR no padrão moderno -->
<div class="container-fluid bg-dark py-2 border-bottom shadow-sm">
    <div class="d-flex flex-nowrap px-3 menu-scroll" id="menuScrollTreinador">
        <a href="../avaliacao/visualizar_avaliacoes.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-clipboard-check me-2"></i>Avaliações
        </a>
        <a href="../estatistica/vizualizar_estatistica_jogador.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-graph-up me-2"></i>Estatísticas do Jogador
        </a>
        <a href="../substituicao/cadastrar_substituicao.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-person-plus-fill me-2"></i>Cadastrar Substituição
        </a>
        <a href="../substituicao/listar_substituicOES.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-list-check me-2"></i>Visualizar Substituições
        </a>
        <a href="../campeonatos/visualizar_fases_rodadas.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-diagram-3-fill me-2"></i>Fases e Rodadas
        </a>
        <a href="../campeonatos/tabela_classificacao.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-trophy-fill me-2"></i>Classificação
        </a>
        <a href="../dashboard/dashboard_treinador.php" class="nav-link px-4 menu-link flex-shrink-0">
            <i class="bi bi-house-door-fill me-2"></i>Página Inicial
        </a>
        <a href="../escalacao/escalacao_treinador.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-people-fill me-2"></i>Escalação
        </a>

    </div>
</div>

<!-- SCRIPT Scroll e Drag horizontal -->
<script>
    const menuTreinador = document.getElementById('menuScrollTreinador');

    menuTreinador.addEventListener('wheel', (e) => {
        if (e.deltaY !== 0) {
            e.preventDefault();
            menuTreinador.scrollLeft += e.deltaY;
        }
    });

    let isDown = false;
    let startX;
    let scrollLeft;

    menuTreinador.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - menuTreinador.offsetLeft;
        scrollLeft = menuTreinador.scrollLeft;
    });

    menuTreinador.addEventListener('mouseleave', () => isDown = false);
    menuTreinador.addEventListener('mouseup', () => isDown = false);

    menuTreinador.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - menuTreinador.offsetLeft;
        const walk = (x - startX) * 1.5;
        menuTreinador.scrollLeft = scrollLeft - walk;
    });
</script>
