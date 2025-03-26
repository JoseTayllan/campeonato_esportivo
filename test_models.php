<?php
require_once 'config/database.php';
require_once 'app/models/Substituicao.php';
require_once 'app/models/Estatistica.php';

// Criar instância dos modelos
$substituicaoModel = new Substituicao($conn);
$estatisticaModel = new Estatistica($conn);

// Criar uma partida de teste (se não houver partidas)
$conn->query("INSERT INTO partidas (campeonato_id, data, horario, local, time_casa, time_fora, placar_casa, placar_fora) 
              VALUES (1, '2025-03-27', '15:00:00', 'Estádio Municipal', 1, 2, 0, 0)");

$partida_id = $conn->insert_id;

// Criar estatísticas iniciais para dois jogadores
$conn->query("INSERT INTO estatisticas_partida (partida_id, jogador_id, gols, assistencias, passes_completos, finalizacoes, faltas_cometidas, cartoes_amarelos, cartoes_vermelhos, minutos_jogados, substituicoes) 
              VALUES ($partida_id, 1, 0, 0, 10, 2, 1, 0, 0, 45, 0)");

$conn->query("INSERT INTO estatisticas_partida (partida_id, jogador_id, gols, assistencias, passes_completos, finalizacoes, faltas_cometidas, cartoes_amarelos, cartoes_vermelhos, minutos_jogados, substituicoes) 
              VALUES ($partida_id, 2, 0, 0, 8, 1, 0, 0, 0, 45, 0)");

// Simular uma substituição no minuto 60 (Jogador 1 sai, Jogador 3 entra)
$substituicaoCriada = $substituicaoModel->registrarSubstituicao($partida_id, 1, 3, 60);

if ($substituicaoCriada) {
    echo "Substituição registrada com sucesso!<br>";
} else {
    echo "Erro ao registrar substituição.<br>";
}

// Verificar se os minutos jogados foram atualizados corretamente
$estatisticas = $conn->query("SELECT jogador_id, minutos_jogados FROM estatisticas_partida WHERE partida_id = $partida_id");

echo "<pre>";
while ($row = $estatisticas->fetch_assoc()) {
    print_r($row);
}
echo "</pre>";

?>
