<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/TeamController.php';

session_start();

$controller = new TeamController($conn);

$codigo = $_POST['codigo_publico'] ?? '';
$campeonato_id = $_POST['campeonato_id'] ?? '';

if (empty($codigo) || empty($campeonato_id)) {
    $_SESSION['mensagem_erro'] = "Código do time ou campeonato não informado.";
    header("Location: campeonato_editar_times.php?id=$campeonato_id");
    exit;
}

$time = $controller->buscarTimePublico($codigo);

if ($time) {
    // Evitar duplicidade
    $check = $conn->prepare("SELECT 1 FROM times_campeonatos WHERE time_id = ? AND campeonato_id = ?");
    $check->bind_param("ii", $time['id'], $campeonato_id);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows === 0) {
        $stmt = $conn->prepare("INSERT INTO times_campeonatos (time_id, campeonato_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $time['id'], $campeonato_id);
        if ($stmt->execute()) {
            $_SESSION['mensagem_sucesso'] = "✅ Time vinculado com sucesso via código!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao vincular o time no banco.";
        }
    } else {
        $_SESSION['mensagem_erro'] = "❗ Este time já está vinculado a este campeonato.";
    }
} else {
    $_SESSION['mensagem_erro'] = "❌ Código inválido. Nenhum time encontrado.";
}

header("Location: campeonato_editar_times.php?id=$campeonato_id");
exit;
