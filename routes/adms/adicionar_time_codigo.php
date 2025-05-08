<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/TeamController.php';

session_start();

$controller = new TeamController($conn);

$codigo = $_POST['codigo_publico'] ?? '';
$campeonato_id = $_POST['campeonato_id'] ?? '';

$time = $controller->buscarTimePublico($codigo);

if ($time && $campeonato_id) {
    // Evitar duplicidade
    $check = $conn->prepare("SELECT * FROM times_campeonatos WHERE time_id = ? AND campeonato_id = ?");
    $check->bindValue(1, $time['id'], PDO::PARAM_INT);
    $stmt->bindValue(2, $campeonato_id, PDO::PARAM_INT);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows === 0) {
        $stmt = $conn->prepare("INSERT INTO times_campeonatos (time_id, campeonato_id) VALUES (?, ?)");
        $stmt->bindValue(1, $time['id'], PDO::PARAM_INT);
    $stmt->bindValue(2, $campeonato_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['mensagem_sucesso'] = "Time adicionado com sucesso!";
        } else {
            $_SESSION['mensagem_erro'] = "Erro ao vincular o time.";
        }
    } else {
        $_SESSION['mensagem_erro'] = "Este time já está vinculado a este campeonato.";
    }
} else {
    $_SESSION['mensagem_erro'] = "Código inválido ou campeonato não informado.";
}

header("Location: campeonato_editar.php?id=" . $campeonato_id);

exit();
