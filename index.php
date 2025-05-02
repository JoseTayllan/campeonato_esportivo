<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>ChampCore | Gestão Esportiva Profissional</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --primary: #00d4ff;
            --dark-bg: #0a0a0a;
            --light-bg: rgba(255, 255, 255, 0.06);
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: url('assets/img/fundo_estadio.jpg') center/cover no-repeat;
            color: white;
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

        h1,
        h2 {
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
            align-items: stretch;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            background: var(--light-bg);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 1rem;
            padding: 2rem;
            transition: background 0.3s ease;
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

        footer {
            text-align: center;
            font-size: 0.85rem;
            padding: 2rem;
            color: #aaa;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 1.8rem;
            }

            p.lead {
                font-size: 1rem;
            }
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
    
        img {
            max-width: 100%;
            height: auto;
        }

        .flex-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .overlay {
                padding: 4rem 6rem;
            }
        }
    </style>

</head>

<body>

<nav class="navbar">
  <div class="navbar-container">
    <a href="#" class="logo">ChampCore</a>
    <ul class="nav-links">
      <li><a href="#esportes">Esportes</a></li>
      <li><a href="#beneficios">Benefícios</a></li>
      <li><a href="#planos">Planos</a></li>
      <li><a href="#depoimentos">Depoimentos</a></li>
    </ul>
  </div>
</nav>
<style>
  .navbar {
    background: rgba(0, 0, 0, 0.85);
    padding: 1rem;
    position: sticky;
    top: 0;
    z-index: 100;
    border-bottom: 1px solid rgba(255,255,255,0.1);
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
    color: #00d4ff;
    text-decoration: none;
  }
  .nav-links {
    list-style: none;
    display: flex;
    gap: 1.5rem;
  }
  .nav-links a {
    color: white;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
  }
  .nav-links a:hover {
    color: #00d4ff;
  }

        img {
            max-width: 100%;
            height: auto;
        }

        .flex-wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .overlay {
                padding: 4rem 6rem;
            }
        }
    </style>


    <div class="overlay">
        <div class="container">
            <h1>ChampCore</h1>
            <p class="lead">Gerencie campeonatos, estatísticas e equipes com um sistema moderno e acessível.</p>
            <div class="cta">
                <a href="futebol/index.php">Acessar módulo Futebol</a>
            </div>

            <section>
                <h2 id="esportes">📂 Esportes</h2>
                <div class="grid">
                    <div class="card" style="position: relative; overflow: hidden; height: 100%; border-radius: 1rem;">
                        <video autoplay muted loop playsinline style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0; border-radius: 1rem;">
                            <source src="videos/futebol_intro.mp4" type="video/mp4">
                        </video>
                        <div style="position: relative; z-index: 1; padding: 2rem; height: 90%;">
                            <h3>⚽ Futebol</h3>
                            <p>Controle completo de partidas, escalações e desempenho.</p>
                            <a href="/campeonato_esportivo/public" class="btn-esporte">Entrar</a>
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
                            <li>Organizador: controle geral</li>
                            <li>Técnico: escalações e estatísticas</li>
                            <li>Clube/Escola: múltiplos técnicos e categorias</li>
                        </ul>
                    </div>
                </div>
            </section>

            <section>
                <h2 id="planos">💼 Planos</h2>
                <div class="grid">
                    <div class="card">
                        <h3>Organizador – R$29/mês</h3>
                        <ul>
                            <li>Gestão completa de campeonatos</li>
                            <li>Permissões avançadas</li>
                            <li>Estatísticas globais</li>
                        </ul>
                    </div>
                    <div class="card">
                        <h3>Técnico – R$14/mês</h3>
                        <ul>
                            <li>Controle de elenco e escalações</li>
                            <li>Acompanhamento de jogos</li>
                            <li>Estatísticas individuais</li>
                        </ul>
                    </div>
                    <div class="card">
                        <h3>Clube/Escola – R$59/mês</h3>
                        <ul>
                            <li>Multi-técnico e categorias</li>
                            <li>Gestão unificada do clube</li>
                            <li>Suporte a torneios internos</li>
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
        &copy; 2025 ChampCore – Plataforma Esportiva Oficial
    </footer>
</body>

</html>