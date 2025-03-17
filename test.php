<?php
require_once 'config/database.php';
require_once 'app/models/Usuario.php';
require_once 'app/models/Campeonato.php';
require_once 'app/models/Time.php';
require_once 'app/models/Jogador.php';

// Criar um novo usuário
$usuarioModel = new Usuario($conn);
$usuarioCriado = $usuarioModel->criar('João Silva', 'joao@email.com', '123456', 'Organizador');

if ($usuarioCriado) {
    echo "Usuário criado com sucesso!<br>";
} else {
    echo "Erro ao criar usuário.<br>";
}

// Criar um novo campeonato
$campeonatoModel = new Campeonato($conn);
$campeonatoCriado = $campeonatoModel->criar('Copa Regional', 'Torneio de futebol amador', 2025, 'Pontos Corridos');

if ($campeonatoCriado) {
    echo "Campeonato criado com sucesso!<br>";
} else {
    echo "Erro ao criar campeonato.<br>";
}

// Criar um time
$timeModel = new Time($conn);
$timeCriado = $timeModel->criar('FC Estrela', 'escudo.png', 'São Paulo', 'Estádio Municipal');

if ($timeCriado) {
    echo "Time criado com sucesso!<br>";
} else {
    echo "Erro ao criar time.<br>";
}

// Criar um jogador
$time_id = 1; // Substitua pelo ID correto
$jogadorModel = new Jogador($conn);
$jogadorCriado = $jogadorModel->criar('Carlos Mendes', 22, 'Brasil', 'Atacante', $time_id);

if ($jogadorCriado) {
    echo "Jogador criado com sucesso!<br>";
} else {
    echo "Erro ao criar jogador.<br>";
}
?>
