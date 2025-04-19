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

<!-- MENU DO JOGADOR no padrão moderno -->
<div class="container-fluid bg-dark py-2 border-bottom shadow-sm">
    <div class="d-flex flex-nowrap justify-content-center px-3 menu-scroll" id="menuScrollJogador">
        <a href="../dashboard/dashboard_jogador.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-house-door-fill me-2"></i>Início
        </a>
        <a href="../campeonatos/visualizar_fases_rodadas.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-diagram-3 me-2"></i>Fases/Rodadas
        </a>
        <a href="../campeonatos/tabela_classificacao.php" class="nav-link px-4 menu-link flex-shrink-0">
            <i class="bi bi-trophy me-2"></i>Classificação
        </a>
    </div>
</div>

<!-- SCRIPT de scroll/drag -->
<script>
    const menuJogador = document.getElementById('menuScrollJogador');

    menuJogador.addEventListener('wheel', (e) => {
        if (e.deltaY !== 0) {
            e.preventDefault();
            menuJogador.scrollLeft += e.deltaY;
        }
    });

    let isDown = false;
    let startX;
    let scrollLeft;

    menuJogador.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - menuJogador.offsetLeft;
        scrollLeft = menuJogador.scrollLeft;
    });

    menuJogador.addEventListener('mouseleave', () => isDown = false);
    menuJogador.addEventListener('mouseup', () => isDown = false);

    menuJogador.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - menuJogador.offsetLeft;
        const walk = (x - startX) * 1.5;
        menuJogador.scrollLeft = scrollLeft - walk;
    });
</script>
