<style>
    .menu-scroll {
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none;  /* IE/Edge */
        cursor: grab;
    }

    .menu-scroll::-webkit-scrollbar {
        display: none; /* Chrome/Safari */
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

<!-- Container do menu -->
<div class="container-fluid bg-dark py-2 border-bottom shadow-sm">
    <div class="d-flex flex-nowrap px-3 menu-scroll" id="menuScroll">
        <a href="#" class="nav-link px-4 menu-link menu-separador flex-shrink-0"><i class="bi bi-plus-square me-2"></i>Campeonato</a>
        <a href="#" class="nav-link px-4 menu-link menu-separador flex-shrink-0"><i class="bi bi-people-fill me-2"></i>Time</a>
        <a href="#" class="nav-link px-4 menu-link menu-separador flex-shrink-0"><i class="bi bi-person-lines-fill me-2"></i>Jogador</a>
        <a href="#" class="nav-link px-4 menu-link menu-separador flex-shrink-0"><i class="bi bi-clipboard-check me-2"></i>Avaliações</a>
        <a href="#" class="nav-link px-4 menu-link menu-separador flex-shrink-0"><i class="bi bi-bar-chart-fill me-2"></i>Est. por Partida</a>
        <a href="#" class="nav-link px-4 menu-link menu-separador flex-shrink-0"><i class="bi bi-graph-up me-2"></i>Est. do Jogador</a>
        <a href="#" class="nav-link px-4 menu-link menu-separador flex-shrink-0"><i class="bi bi-arrow-repeat me-2"></i>Substituição</a>
        <a href="#" class="nav-link px-4 menu-link flex-shrink-0"><i class="bi bi-house-door-fill me-2"></i>Organizador</a>
    </div>
</div>

<script>
    const menu = document.getElementById('menuScroll');

    // Scroll com roda do mouse (horizontal)
    menu.addEventListener('wheel', (e) => {
        if (e.deltaY !== 0) {
            e.preventDefault();
            menu.scrollLeft += e.deltaY;
        }
    });

    // Clique e arraste (drag to scroll)
    let isDown = false;
    let startX;
    let scrollLeft;

    menu.addEventListener('mousedown', (e) => {
        isDown = true;
        menu.classList.add('active');
        startX = e.pageX - menu.offsetLeft;
        scrollLeft = menu.scrollLeft;
    });

    menu.addEventListener('mouseleave', () => {
        isDown = false;
    });

    menu.addEventListener('mouseup', () => {
        isDown = false;
    });

    menu.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - menu.offsetLeft;
        const walk = (x - startX) * 1.5; // Velocidade do arrasto
        menu.scrollLeft = scrollLeft - walk;
    });
</script>
