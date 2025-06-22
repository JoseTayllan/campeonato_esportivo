<?php
session_start();

require_once __DIR__ . '/../../app/middleware/verifica_sessao.php';
require_once __DIR__ . '/../../app/middleware/verifica_assinatura.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/controllers/time_contro/TeamController.php';

permite_acesso(['time', 'completo']);

$controller = new TeamController($conn);

// 🔥 Dados do formulário
$jogador_id = $_POST['jogador_id'] ?? '';
$nome = $_POST['nome'] ?? '';
$posicao = $_POST['posicao'] ?? '';
$idade = $_POST['idade'] ?? 0;
$nacionalidade = $_POST['nacionalidade'] ?? '';
$cpf = trim($_POST['cpf'] ?? null);
$data_nascimento = $_POST['data_nascimento'] ?? null;

// 🔥 Pega imagem atual se não enviar nova
$jogador = $controller->buscarJogador($jogador_id);
$imagem = $jogador['imagem'] ?? null;

// 🔥 Upload de imagem (se houver)
if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
    $imagem_nome = uniqid() . "." . $ext;
    $destino = __DIR__ . '/../../public/img/jogadores/' . $imagem_nome;

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
        $imagem = $imagem_nome;
    }
}

// 🔥 Executa atualização
if ($controller->editarJogador($jogador_id, $nome, $posicao, $idade, $nacionalidade, $cpf, $data_nascimento, $imagem)) {
    $_SESSION['mensagem_sucesso'] = "Jogador editado com sucesso!";
} else {
    $_SESSION['mensagem_erro'] = "Erro ao editar jogador.";
}

header("Location: dashboard_time.php");
exit();
?>
