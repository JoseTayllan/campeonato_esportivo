<!-- ESTILO (se já não estiver incluso) -->
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

<!-- MENU DO PATROCINADOR -->
<div class="container-fluid bg-dark py-2 border-bottom shadow-sm">
    <div class="d-flex flex-nowrap justify-content-center px-3 menu-scroll" id="menuScrollPatrocinador">
        <a href="../dashboard/dashboard_patrocinador.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-house-door-fill me-2"></i>Início
        </a>
        <a href="../campeonatos/visualizar_fases_rodadas.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-diagram-3-fill me-2"></i>Fases e Rodadas
        </a>
        <a href="../campeonatos/tabela_classificacao.php" class="nav-link px-4 menu-link flex-shrink-0">
            <i class="bi bi-trophy-fill me-2"></i>Classificação
        </a>
    </div>
</div>

<!-- SCRIPT scroll e drag horizontal -->
<script>
    const menuPatrocinador = document.getElementById('menuScrollPatrocinador');

    menuPatrocinador.addEventListener('wheel', (e) => {
        if (e.deltaY !== 0) {
            e.preventDefault();
            menuPatrocinador.scrollLeft += e.deltaY;
        }
    });

    let isDown = false;
    let startX;
    let scrollLeft;

    menuPatrocinador.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - menuPatrocinador.offsetLeft;
        scrollLeft = menuPatrocinador.scrollLeft;
    });

    menuPatrocinador.addEventListener('mouseleave', () => isDown = false);
    menuPatrocinador.addEventListener('mouseup', () => isDown = false);

    menuPatrocinador.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - menuPatrocinador.offsetLeft;
        const walk = (x - startX) * 1.5;
        menuPatrocinador.scrollLeft = scrollLeft - walk;
    });
</script>
