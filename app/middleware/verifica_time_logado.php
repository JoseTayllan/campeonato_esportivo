<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/database.php';

// Garante que o usuário esteja logado
if (!isset($_SESSION['usuario_id'])) {
    echo "<div class='alert alert-danger'>Sessão expirada. Faça login novamente.</div>";
    exit;
}

// Se ainda não tiver time_id na sessão, tenta buscar no banco
if (!isset($_SESSION['time_id'])) {
    $stmt = $conn->prepare("SELECT id FROM times WHERE admin_id = ?");
    $stmt->bindValue(1, $_SESSION['usuario_id'], PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $time = $resultado->fetch(PDO::FETCH_ASSOC);

    if ($time) {
        $_SESSION['time_id'] = $time['id'];
    } else {
        echo "<div class='alert alert-warning'>Nenhum time encontrado vinculado à sua conta. Cadastre um time para continuar.</div>";
        exit;
    }
}
