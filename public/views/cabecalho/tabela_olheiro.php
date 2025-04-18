<!-- ESTILO (caso ainda não tenha sido incluído no topo da página) -->
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

<!-- MENU DO OLHEIRO no padrão moderno -->
<!-- MENU DO OLHEIRO CENTRALIZADO -->
<div class="container-fluid bg-dark py-2 border-bottom shadow-sm">
    <div class="d-flex flex-nowrap justify-content-center px-3 menu-scroll" id="menuScrollOlheiro">
        <a href="../avaliacao/avaliar_jogador.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-star-fill me-2"></i>Avaliar Jogador
        </a>
        <a href="../avaliacao/visualizar_avaliacoes.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-clipboard-data me-2"></i>Página Inicial
        </a>
        <a href="../campeonatos/visualizar_fases_rodadas.php" class="nav-link px-4 menu-link menu-separador flex-shrink-0">
            <i class="bi bi-diagram-3-fill me-2"></i>Fases e Rodadas
        </a>
        <a href="../campeonatos/tabela_classificacao.php" class="nav-link px-4 menu-link flex-shrink-0">
            <i class="bi bi-trophy-fill me-2"></i>Classificação
        </a>
    </div>
</div>


<!-- SCRIPT para scroll e drag horizontal -->
<script>
    const menuOlheiro = document.getElementById('menuScrollOlheiro');

    menuOlheiro.addEventListener('wheel', (e) => {
        if (e.deltaY !== 0) {
            e.preventDefault();
            menuOlheiro.scrollLeft += e.deltaY;
        }
    });

    let isDown = false;
    let startX;
    let scrollLeft;

    menuOlheiro.addEventListener('mousedown', (e) => {
        isDown = true;
        startX = e.pageX - menuOlheiro.offsetLeft;
        scrollLeft = menuOlheiro.scrollLeft;
    });

    menuOlheiro.addEventListener('mouseleave', () => isDown = false);
    menuOlheiro.addEventListener('mouseup', () => isDown = false);

    menuOlheiro.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - menuOlheiro.offsetLeft;
        const walk = (x - startX) * 1.5;
        menuOlheiro.scrollLeft = scrollLeft - walk;
    });
</script>
