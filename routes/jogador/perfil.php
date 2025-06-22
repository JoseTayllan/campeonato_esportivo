<?php
session_start();

require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';

 // jogador passa direto conforme já configurado

$controller = new TeamController($conn);
$jogador_id = $_SESSION['usuario_id'];

// 🔥 Buscar dados do jogador
$jogador = $controller->buscarJogador($jogador_id);
$conquistas = $controller->listarConquistasJogador($jogador_id);



// 🔥 Buscar estatísticas agregadas
$sqlEstat = "
    SELECT 
        COUNT(DISTINCT partida_id) AS jogos,
        SUM(gols) AS gols,
        SUM(assistencias) AS assistencias,
        SUM(minutos_jogados) AS minutos
    FROM estatisticas_partida
    WHERE jogador_id = ?
";
$stmt = $conn->prepare($sqlEstat);
$stmt->bind_param("i", $jogador_id);
$stmt->execute();
$estatisticas = $stmt->get_result()->fetch_assoc();

// 🔥 Buscar últimas partidas
$sqlUltimas = "
    SELECT 
        p.data,
        CASE 
            WHEN p.time_casa = jt.time_id THEN tf.nome 
            ELSE tc.nome 
        END AS adversario,
        e.gols,
        e.assistencias,
        e.minutos_jogados
    FROM estatisticas_partida e
    JOIN partidas p ON e.partida_id = p.id
    JOIN jogador_time jt ON jt.jogador_id = e.jogador_id
    JOIN times tc ON p.time_casa = tc.id
    JOIN times tf ON p.time_fora = tf.id
    WHERE e.jogador_id = ?
    ORDER BY p.data DESC
    LIMIT 5
";
$stmt2 = $conn->prepare($sqlUltimas);
$stmt2->bind_param("i", $jogador_id);
$stmt2->execute();
$ultimas_partidas = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);

// 🔥 Renderizar view
require_once __DIR__ . '/../../public/views/jogador/perfil.php';
