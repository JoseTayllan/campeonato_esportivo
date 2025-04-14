<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Você precisa estar logado para acessar.";
    header("Location: /campeonato_esportivo/public/views/login/login.php");
    exit();
}