<?php
$host = 'localhost';
$dbname = 'campeonato_esportivo';
$user = 'root'; 
$pass = '4sus2024!';

// Criar conexão
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
