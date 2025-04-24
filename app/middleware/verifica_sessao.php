<?php
// File: app/middleware/verifica_sessao.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem_erro'] = "Você precisa estar logado para acessar.";
    header("Location: /campeonato_esportivo/public/views/login/login.php");
    exit();
}

// Verifica nível de acesso, se for especificado
if (isset($restrito_para) && is_array($restrito_para)) {
    $tipo_usuario = strtolower(trim($_SESSION['usuario_tipo'] ?? ''));
    $permitidos = array_map('strtolower', $restrito_para);

    if (!in_array($tipo_usuario, $permitidos)) {
        $_SESSION['mensagem_erro'] = "Acesso negado para seu perfil.";
        header("Location: /campeonato_esportivo/public/index.php");
        exit();
    }
}
