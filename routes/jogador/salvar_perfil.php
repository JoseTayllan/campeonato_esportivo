<?php
session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';

$controller = new TeamController($conn);

// ⚠️ Validação mínima
$jogador_id = $_POST['jogador_id'] ?? null;
$nome = $_POST['nome'] ?? '';
$cpf = $_POST['cpf'] ?? null;
$data_nascimento = $_POST['data_nascimento'] ?? null;
$nacionalidade = $_POST['nacionalidade'] ?? '';
$imagem = null;

if (!$jogador_id || !$nome) {
    $_SESSION['mensagem_erro'] = "Dados incompletos.";
    header("Location: /campeonato_esportivo/routes/jogador/perfil.php");
    exit;
}

// 🔄 Upload de imagem (opcional)
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $imagem_nome = uniqid() . "." . $ext;
    $destino = __DIR__ . '/../../public/img/jogadores/' . $imagem_nome;

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
        $imagem = $imagem_nome;
    }
}

// 🔁 Atualiza os dados
$sucesso = $controller->editarJogador($jogador_id, $nome, '', 0, $nacionalidade, $cpf, $data_nascimento, $imagem);

if ($sucesso) {
    $_SESSION['mensagem_sucesso'] = "Perfil atualizado com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao atualizar perfil.";
}

header("Location: /campeonato_esportivo/routes/jogador/perfil.php");
exit;
