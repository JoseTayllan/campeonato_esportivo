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
        border-radius: 8px;
    }

    .menu-link:hover {
        color: #ffffff !important;
        background-color: rgba(255, 255, 255, 0.08);
    }

    .menu-separador {
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .menu-container-modern {
        background: rgba(13, 13, 13, 0.9);
        backdrop-filter: blur(6px);
    }
</style>

<!-- Menu público no padrão moderno -->
<div class="container-fluid py-2 border-bottom shadow-sm menu-container-modern">
    <div class="d-flex flex-row flex-nowrap menu-scroll px-2 gap-2">
        <a href="../cadastro/cadastro_usuario.php" class="menu-link menu-separador flex-shrink-0">
            <i class="bi bi-person-plus-fill me-2"></i>Cadastro de Usuário
        </a>
        <a href="../login/login.php" class="menu-link menu-separador flex-shrink-0">
            <i class="bi bi-box-arrow-in-right me-2"></i>Login
        </a>
        <a href="../campeonatos/visualizar_fases_rodadas.php" class="menu-link menu-separador flex-shrink-0">
            <i class="bi bi-diagram-3 me-2"></i>Fases/Rodadas
        </a>
        <a href="../campeonatos/tabela_classificacao.php" class="menu-link flex-shrink-0">
            <i class="bi bi-trophy me-2"></i>Classificação
        </a>
    </div>
</div>
