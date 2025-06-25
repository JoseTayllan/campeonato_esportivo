<?php
// Evitar carregar a configuração de produção durante os testes
if (defined('TESTING')) {
    return;
}

$host = 'db';
$dbname = 'campeonato_esportivo';
$user = 'user_php'; 
$pass = '4sus!2024';

// Criar conexão
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
