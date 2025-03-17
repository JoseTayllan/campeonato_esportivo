<?php
$host = 'localhost';
$dbname = 'campeonato_esportivo';
$user = 'root'; 
$pass = '';

// Criar conexão
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
