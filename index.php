
<!DOCTYPE html>

<html lang="pt-BR">
<head>
<style>
            @media (min-width: 769px) {
                .navbar-container {
                    flex-direction: row !important;
                    align-items: center;
                }
                .nav-links {
                    margin-left: 2rem !important;
                    display: flex !important;
                    gap: 1.5rem;
                }
                .menu-toggle {
                    display: none !important;
                }
            }
        
@media (max-width: 768px) {
    .navbar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .logo {
        margin-right: 1rem;
    }
}
</style>
<meta charset="utf-8"/>
<title>ChampCore | Gestão Esportiva Profissional</title>
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<style>
        :root {
            --primary: #00d4ff;
            --dark-bg: #0a0a0a;
            --light-bg: rgba(255, 255, 255, 0.06);
        }

        * {
            box-sizing: border-box;
        }
        .btn-esporte {
            display: inline-block;
            margin-top: 1rem;
            background: linear-gradient(135deg, #00d4ff, #0088ff);
            color: #fff;
            padding: 0.7rem 1.5rem;
            border-radius: 40px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 3px 10px rgba(0, 212, 255, 0.3);
            transition: all 0.3s ease;
        }
        .btn-esporte:hover {
            background: linear-gradient(135deg, #00aacc, #0077cc);
            box-shadow: 0 5px 16px rgba(0, 212, 255, 0.5);
            transform: translateY(-2px);
        }



        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('assets/img/fundo_estadio.jpg') center/cover no-repeat;
            color: white;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.9);
            padding: 1rem 2rem;
        }

        .navbar-container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
            text-decoration: none;
        }

        .menu-toggle {
        display: none;
        font-size: 2rem;
        background: none;
        color: white;
        border: none;
        cursor: pointer;
        margin-left: auto;
    }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .overlay {
            background: rgba(0, 0, 0, 0.85);
            padding: 4rem 1rem;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 1rem;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 1rem;
        }

        p.lead {
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #ccc;
        }

        .cta {
            text-align: center;
            margin: 2rem 0;
        }

        .cta a {
            background: linear-gradient(135deg, #00d4ff, #0088ff);
            color: #fff;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 212, 255, 0.4);
            transition: all 0.3s ease;
        }

        .cta a:hover {
            background: linear-gradient(135deg, #00aacc, #0077cc);
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.6);
            transform: translateY(-2px);
        }

        section {
            margin-top: 4rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
            width: 100%;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: var(--light-bg);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 1rem;
            padding: 2rem;
            transition: background 0.3s ease;
            min-height: 200px;
            word-wrap: break-word;
        }
        .card:hover {
            background: rgba(255, 255, 255, 0.12);
        }

        .card h3 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .card ul {
            list-style: none;
            padding-left: 0;
        }

        .card ul li {
            padding: 0.3rem 0;
            color: #ddd;
        }

        @media (max-width: 768px) {
        .menu-toggle {
            display: block;
        }
        .navbar-container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
        .nav-links {
            display: none;
            flex-direction: column;
            width: 100%;
            margin-top: 1rem;
        }
        .nav-links.active {
            display: flex;
        }
        .container {
            padding: 0 0.5rem;
        }
        .card {
            padding: 1rem;
        }
    }

            .nav-links {
                display: none;
                flex-direction: column;
                width: 100%;
                margin-top: 1rem;
            }

            .nav-links.active {
                display: flex;
            }

            .navbar-container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

            .container {
                padding: 0 0.5rem;
            }

            .card {
                padding: 1rem;
            }
        
    
footer {
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center;
    color: white;
    padding: 1rem;
    font-size: 0.9rem;
    margin-top: 4rem;
}

</style>
<style>
        :root {
            --primary: #00d4ff;
            --dark-bg: #0a0a0a;
            --light-bg: rgba(255, 255, 255, 0.06);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('assets/img/fundo_estadio.jpg') center/cover no-repeat;
            color: white;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.9);
            padding: 1rem 2rem;
        }

        .navbar-container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
            text-decoration: none;
        }

        .menu-toggle {
        display: none;
        font-size: 2rem;
        background: none;
        color: white;
        border: none;
        cursor: pointer;
        margin-left: auto;
    }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .overlay {
            background: rgba(0, 0, 0, 0.85);
            padding: 4rem 1rem;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 1rem;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 1rem;
        }

        p.lead {
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #ccc;
        }

        .cta {
            text-align: center;
            margin: 2rem 0;
        }

        .cta a {
            background: linear-gradient(135deg, #00d4ff, #0088ff);
            color: #fff;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 212, 255, 0.4);
            transition: all 0.3s ease;
        }

        .cta a:hover {
            background: linear-gradient(135deg, #00aacc, #0077cc);
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.6);
            transform: translateY(-2px);
        }

        section {
            margin-top: 4rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
            width: 100%;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: var(--light-bg);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 1rem;
            padding: 2rem;
            transition: background 0.3s ease;
            min-height: 200px;
            word-wrap: break-word;
        }

        @media (max-width: 768px) {
        .menu-toggle {
            display: block;
        }
        .navbar-container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
        .nav-links {
            display: none;
            flex-direction: column;
            width: 100%;
            margin-top: 1rem;
        }
        .nav-links.active {
            display: flex;
        }
        .container {
            padding: 0 0.5rem;
        }
        .card {
            padding: 1rem;
        }
    }

            .nav-links {
                display: none;
                flex-direction: column;
                width: 100%;
                margin-top: 1rem;
            }

            .nav-links.active {
                display: flex;
            }

            .navbar-container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

            .container {
                padding: 0 0.5rem;
            }

            .card {
                padding: 1rem;
            }
        
    
footer {
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center;
    color: white;
    padding: 1rem;
    font-size: 0.9rem;
    margin-top: 4rem;
}

</style>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.querySelector('.menu-toggle');
    const menu = document.querySelector('.navbar .menu');
    if (toggle && menu) {
      toggle.addEventListener('click', () => {
        menu.classList.toggle('active');
      });
    }
  });
</script>
</head>
<body>
<nav class="navbar">
<div class="navbar-container"><div class="navbar-header"><a class="logo" href="#">ChampCore</a><button aria-label="Abrir menu" class="menu-toggle">☰</button></div>


<ul class="nav-links">
<li><a href="#esportes">Esportes</a></li>
<li><a href="#beneficios">Benefícios</a></li>
<li><a href="#planos">Planos</a></li>
<li><a href="#depoimentos">Depoimentos</a></li>
</ul>
</div>
</nav>
<style>
        :root {
            --primary: #00d4ff;
            --dark-bg: #0a0a0a;
            --light-bg: rgba(255, 255, 255, 0.06);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('assets/img/fundo_estadio.jpg') center/cover no-repeat;
            color: white;
        }

        .navbar {
            background: rgba(0, 0, 0, 0.9);
            padding: 1rem 2rem;
        }

        .navbar-container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary);
            text-decoration: none;
        }

        .menu-toggle {
        display: none;
        font-size: 2rem;
        background: none;
        color: white;
        border: none;
        cursor: pointer;
        margin-left: auto;
    }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 1.5rem;
            margin: 0;
            padding: 0;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .overlay {
            background: rgba(0, 0, 0, 0.85);
            padding: 4rem 1rem;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 0 1rem;
        }

        h1, h2 {
            text-align: center;
            margin-bottom: 1rem;
        }

        p.lead {
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #ccc;
        }

        .cta {
            text-align: center;
            margin: 2rem 0;
        }

        .cta a {
            background: linear-gradient(135deg, #00d4ff, #0088ff);
            color: #fff;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 212, 255, 0.4);
            transition: all 0.3s ease;
        }

        .cta a:hover {
            background: linear-gradient(135deg, #00aacc, #0077cc);
            box-shadow: 0 6px 20px rgba(0, 212, 255, 0.6);
            transform: translateY(-2px);
        }

        section {
            margin-top: 4rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
            width: 100%;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: var(--light-bg);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 1rem;
            padding: 2rem;
            transition: background 0.3s ease;
            min-height: 200px;
            word-wrap: break-word;
        }

        @media (max-width: 768px) {
        .menu-toggle {
            display: block;
        }
        .navbar-container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
        .nav-links {
            display: none;
            flex-direction: column;
            width: 100%;
            margin-top: 1rem;
        }
        .nav-links.active {
            display: flex;
        }
        .container {
            padding: 0 0.5rem;
        }
        .card {
            padding: 1rem;
        }
    }

            .nav-links {
                display: none;
                flex-direction: column;
                width: 100%;
                margin-top: 1rem;
            }

            .nav-links.active {
                display: flex;
            }

            .navbar-container {
        max-width: 1200px;
        margin: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

            .container {
                padding: 0 0.5rem;
            }

            .card {
                padding: 1rem;
            }
    
    
footer {
    background-color: rgba(0, 0, 0, 0.9);
    text-align: center;
    color: white;
    padding: 1rem;
    font-size: 0.9rem;
    margin-top: 4rem;
}

</style>
<div class="overlay">
<div class="container">
<h1>ChampCore</h1>
<p class="lead">Gerencie campeonatos, estatísticas e equipes com um sistema moderno e acessível.</p>
<div class="cta">
<a href="/campeonato_esportivo/public">Acessar módulo Futebol</a>
</div>
<section>
<h2 id="esportes">📂 Esportes</h2>
<div class="grid">
<div class="card" style="position: relative; overflow: hidden; height: 100%; border-radius: 1rem;">
<video autoplay="" loop="" muted="" playsinline="" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0; border-radius: 1rem;">
<source src="videos/futebol_intro.mp4" type="video/mp4"/>
</video>
<div style="position: relative; z-index: 1; padding: 2rem; height: 90%;">
<h3>⚽ Futebol</h3>
<p>Controle completo de partidas, escalações e desempenho.</p>
<a class="btn-esporte" href="/campeonato_esportivo/public">Entrar</a>
</div>
</div>
<div class="card" style="opacity:0.5; background: url('images/capa_basquete.jpg') center/cover no-repeat; backdrop-filter: blur(6px);">
<h3>🏀 Basquete</h3>
<p>Em breve</p>
</div>
<div class="card" style="opacity:0.5; background: url('images/capa_volei.jpg') center/cover no-repeat; backdrop-filter: blur(6px);">
<h3>🏐 Vôlei</h3>
<p>Planejado para fase 2</p>
</div>
</div>
</section>
<section>
<h2 id="beneficios">🎯 Benefícios da Plataforma</h2>
<div class="grid">
<div class="card">
<h3>📊 Estatísticas em tempo real</h3>
<ul>
<li>Gols, cartões e substituições</li>
<li>Desempenho por jogador</li>
<li>Classificação automática</li>
</ul>
</div>
<div class="card">
<h3>🛠️ Gestão descomplicada</h3>
<ul>
<li>Cadastro de rodadas, partidas e clubes</li>
<li>Visualização pública dos placares</li>
<li>Interface moderna e limpa</li>
</ul>
</div>
<div class="card">
<h3>👥 Perfis de acesso</h3>
<ul>
<li>Administrador: controle geral.</li>
<li>Time Essencial/Técnic: escalações e estatística.</li>
<li>Olheiro: analise estatística.</li>
<li>Patrocinador: destaque visual.</li>
</ul>
</div>
</div>
</section>
<section>
<h2 id="planos">💼 Planos</h2>
<div class="grid">
<div class="card">
<h3>Administrador – R$49/mês</h3>
<ul>
<li>Campeonatos ilimitados, cadastro de organizadores.</li>
<li>Gestão completa de campeonatos.</li>
<li>Permissões avançadas.</li>
<li>Estatísticas globais.</li>
</ul>
</div>
<div class="card">
<h3>Time Essencial/Técnico – R$14/mês</h3>
<ul>
<li>Gerenciar 1 time.</li>
<li>Controle de elenco e escalações.</li>
<li>Acompanhamento de jogos.</li>
<li>Estatísticas individuais.</li>
</ul>
</div>
<div class="card">
<h3>Olheiro – R$9/mês</h3>
<ul>
<li>Avaliação de futuros talentos.</li>
<li>Analise estátistica.</li>
<li>Relatórios de desempenho.</li>
<li>Acesso a relatorios exclusivos.</li>
</ul>
</div>
<div class="card">
<h3>Patrocinador – R$29/mês</h3>
<ul>
<li>Destaque visual + acesso aos relatórios.</li>
<li>Pagina de exibição dedicada junto ao seu Time.</li>
<li></li>
</ul>
</div>
</div>
</section>
<section>
<h2 id="depoimentos">💬 Depoimentos</h2>
<div class="grid">
<div class="card">
<h3>"Transformou nossa liga!"</h3>
<p>– Rafael, organizador</p>
</div>
<div class="card">
<h3>"Agora escalo pelo celular"</h3>
<p>– Camila, técnica</p>
</div>
<div class="card">
<h3>"Acompanhei todos os jogos do meu filho"</h3>
<p>– João, pai de atleta</p>
</div>
</div>
</section>
</div>
</div>
<footer>
        © 2025 ChampCore – Plataforma Esportiva Oficial
    </footer>
<script>
        const toggleBtn = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        toggleBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
<script>
document.querySelectorAll('a[href^="#"]').forEach(link => {
  link.addEventListener('click', function(e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth' });
    }
  });
});
</script>
</body>
</html>
<style>
    @media (min-width: 769px) {

        .nav-links {
            display: flex !important;
            flex-direction: row;
            margin-left: 2rem;
            gap: 2rem;
        
.nav-links { margin-left: 2rem; }
        }

        .menu-toggle {
            display: none !important;
        }
    

            .menu-toggle {
                display: none !important;
            }
    }
    
 </style>
